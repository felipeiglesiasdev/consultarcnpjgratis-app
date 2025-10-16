<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Cnae;
use App\Models\Estabelecimento;
use App\Models\Municipio;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class ProcessStateCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uf;

    /**
     * Cria uma nova instância do job.
     */
    public function __construct(string $uf)
    {
        $this->uf = $uf;
    }

    /**
     * Executa o job.
     */
    public function handle(): void
    {
        $uf = $this->uf;
        
        // Esta é a sua lógica rápida, agora dentro de um Job.
        $totalCities = Municipio::whereHas('estabelecimentos', fn($q) => $q->where('uf', $uf))->count();
        $totalPages = $totalCities > 0 ? ceil($totalCities / 30) : 1;

        for ($page = 1; $page <= $totalPages; $page++) {
            $cacheKey = "state_page_data_v5_{$uf}_page_{$page}";
            $cacheDuration = now()->addMonths(3);
            Cache::remember($cacheKey, $cacheDuration, function () use ($uf, $page) {
                Paginator::currentPageResolver(fn () => $page);
                $topCidades = Municipio::select('descricao', DB::raw('count(*) as total_empresas'))->join('estabelecimentos', 'municipios.codigo', '=', 'estabelecimentos.municipio')->where('estabelecimentos.uf', $uf)->groupBy('municipios.codigo', 'municipios.descricao')->orderByDesc('total_empresas')->take(5)->get();
                $statusCounts = Estabelecimento::select('situacao_cadastral', DB::raw('count(*) as total'))->where('uf', $uf)->groupBy('situacao_cadastral')->pluck('total', 'situacao_cadastral');
                $topCnaes = Cnae::select('cnaes.codigo', 'cnaes.descricao', DB::raw('count(*) as total'))->join('estabelecimentos', 'cnaes.codigo', '=', 'estabelecimentos.cnae_fiscal_principal')->where('estabelecimentos.uf', $uf)->groupBy('cnaes.codigo', 'cnaes.descricao')->orderByDesc('total')->take(5)->get();
                $municipios = Municipio::withCount(['estabelecimentos' => fn($q) => $q->where('uf', $uf)->where('situacao_cadastral', '2')])->whereHas('estabelecimentos', fn($q) => $q->where('uf', $uf))->orderByDesc('estabelecimentos_count')->paginate(30);
                $totalAtivas = $statusCounts['2'] ?? 0;
                
                $municipios->setPath(route('empresas.state', ['uf' => strtolower($uf)]));
                
                return compact('totalAtivas', 'topCidades', 'statusCounts', 'topCnaes', 'municipios');
            });
        }
    }
}
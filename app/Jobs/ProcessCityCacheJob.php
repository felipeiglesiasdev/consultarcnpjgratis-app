<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Municipio;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator; // <-- Importante
use Illuminate\Pagination\Paginator;

class ProcessCityCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $municipio;

    public function __construct(Municipio $municipio)
    {
        $this->municipio = $municipio;
    }

    public function handle(): void
    {
        $municipio = $this->municipio;

        $firstEstabelecimento = Estabelecimento::where('municipio', $municipio->codigo)->select('uf')->first();
        if (!$firstEstabelecimento) return;

        $uf = $firstEstabelecimento->uf;
        $cidade_slug = Str::slug($municipio->descricao);

        $totalEmpresasAtivas = Estabelecimento::where('uf', $uf)
            ->where('situacao_cadastral', '2')
            ->where('municipio', $municipio->codigo)
            ->count();
        
        if ($totalEmpresasAtivas === 0) return;

        // O total a ser considerado para a paginação é o número real, com um teto de 1000.
        $totalForPaginator = min($totalEmpresasAtivas, 1000);
        $totalPagesToCache = ceil($totalForPaginator / 50);

        for ($page = 1; $page <= $totalPagesToCache; $page++) {
            $cacheKey = "city_page_data_v4_" . strtolower($uf) . "_{$cidade_slug}_page_{$page}";
            
            Cache::remember($cacheKey, now()->addMonths(3), function () use ($uf, $municipio, $totalEmpresasAtivas, $page, $cidade_slug, $totalForPaginator) {
                
                // CORREÇÃO APLICADA AQUI: Construção manual do paginador
                
                // 1. Busca apenas os itens para a página atual
                $itemsForThisPage = Estabelecimento::with('empresa')
                    ->join('empresas', 'estabelecimentos.cnpj_basico', '=', 'empresas.cnpj_basico')
                    ->where('estabelecimentos.uf', $uf)
                    ->where('estabelecimentos.situacao_cadastral', '2')
                    ->where('estabelecimentos.municipio', $municipio->codigo)
                    ->orderByDesc('empresas.capital_social')
                    ->select('estabelecimentos.*')
                    ->forPage($page, 50) // Pega os 50 itens da página correta
                    ->get();
                
                // 2. Cria o objeto de paginação manualmente, forçando o total
                $empresas = new LengthAwarePaginator(
                    $itemsForThisPage,
                    $totalForPaginator, // <--- A MÁGICA ACONTECE AQUI
                    50,
                    $page,
                    ['path' => route('empresas.city', ['uf' => strtolower($uf), 'cidade_slug' => $cidade_slug])]
                );
                
                return compact('municipio', 'empresas', 'totalEmpresasAtivas');
            });
        }
    }
}
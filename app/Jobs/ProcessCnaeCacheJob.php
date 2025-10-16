<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Cnae;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProcessCnaeCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cnae;

    public function __construct(Cnae $cnae)
    {
        $this->cnae = $cnae;
    }

    public function handle(): void
    {
        $cnae = $this->cnae;
        $codigo_cnae = $cnae->codigo;
        $cacheKey = "cnae_show_sample_{$codigo_cnae}";

        Cache::remember($cacheKey, now()->addMonths(3), function () use ($codigo_cnae, $cnae) {
            $empresas = Estabelecimento::with(['empresa', 'municipioRel'])
                ->join('empresas', 'estabelecimentos.cnpj_basico', '=', 'empresas.cnpj_basico')
                ->where('estabelecimentos.cnae_fiscal_principal', $codigo_cnae)
                ->where('estabelecimentos.situacao_cadastral', '2') // Apenas ativas
                ->select('estabelecimentos.*')
                ->orderByDesc('empresas.capital_social')
                ->limit(50)
                ->get();

            $topEstados = Estabelecimento::select('uf', DB::raw('count(*) as total'))
                ->where('cnae_fiscal_principal', $codigo_cnae)
                ->where('uf', '!=', 'EX')
                ->groupBy('uf')
                ->orderByDesc('total')
                ->take(5)
                ->get();

            return compact('cnae', 'empresas', 'topEstados');
        });
    }
}
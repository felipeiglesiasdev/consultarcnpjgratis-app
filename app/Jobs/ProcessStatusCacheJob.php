<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Estabelecimento;
use App\Models\Cnae;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProcessStatusCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $slug;
    public $info;

    public function __construct(string $slug, array $info)
    {
        $this->slug = $slug;
        $this->info = $info;
    }

    public function handle(): void
    {
        $slug = $this->slug;
        $info = $this->info;
        $cacheKey = "status_analysis_page_{$slug}";

        Cache::remember($cacheKey, now()->addMonths(3), function () use ($info) {
            $statusCode = $info['codigo'];
            $stateCounts = DB::connection((new Estabelecimento())->getConnectionName())->table('estabelecimentos')->select('uf', DB::raw('count(*) as total'))->where('situacao_cadastral', $statusCode)->where('uf', '!=', 'EX')->groupBy('uf')->orderBy('uf')->pluck('total', 'uf');
            $topCnaes = Cnae::select('cnaes.codigo', 'cnaes.descricao', DB::raw('count(*) as total'))->join('estabelecimentos', 'cnaes.codigo', '=', 'estabelecimentos.cnae_fiscal_principal')->where('estabelecimentos.situacao_cadastral', $statusCode)->groupBy('cnaes.codigo', 'cnaes.descricao')->orderByDesc('total')->limit(5)->get();
            $randomCompanies = Estabelecimento::with(['empresa', 'municipioRel'])->where('situacao_cadastral', $statusCode)->inRandomOrder()->limit(100)->get();
            return compact('stateCounts', 'topCnaes', 'randomCompanies');
        });
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Estabelecimento;
use App\Models\Cnae;
use App\Models\Municipio;
// Importa todos os "trabalhadores"
use App\Jobs\ProcessCityCacheJob;
use App\Jobs\ProcessCnaeCacheJob;
use App\Jobs\ProcessStateCacheJob;
use App\Jobs\ProcessStatusCacheJob;
use Illuminate\Support\Str;

class GenerateDirectoryCache extends Command
{
    protected $signature = 'cache:generate-directory {--section= : Seção para cachear (index, cnae-index) ou enfileirar (states, cities, cnae-show, status)}';
    protected $description = 'Executa/Dispara processos de cache do diretório.';

    public function handle()
    {
        $section = $this->option('section');
        if (!$section) {
            $this->error('Especifique uma seção. Ex: --section=index (manual) ou --section=cities (enfileirar).');
            return 1;
        }

        $this->info("🚀 Iniciando processo para a seção: {$section}...");
        $this->runSection($section);
        return 0;
    }

    private function runSection(string $section)
    {
        switch ($section) {
            // TAREFAS MANUAIS (rápidas)
            case 'index':
                $this->generateIndexCache();
                $this->info("\nCache para 'index' gerado com sucesso!");
                break;
            case 'cnae-index':
                $this->generateCnaeIndexCache();
                $this->info("\nCache para 'cnae-index' gerado com sucesso!");
                break;
            case 'home':
                $this->generateHomeCache();
                $this->info("\nCache para 'home' gerado com sucesso!");
                break;
            
            // TAREFAS ENFILEIRADAS (lentas)
            case 'states':
                $this->dispatchStateCacheJobs();
                break;
            case 'cities':
                $this->dispatchCityCacheJobs();
                break;
            case 'cnae-show':
                $this->dispatchCnaeShowCacheJobs();
                break;
            case 'status':
                $this->dispatchStatusCacheJobs();
                break;
            
            default:
                $this->error("Seção '{$section}' não reconhecida.");
                break;
        }
    }

    private function generateHomeCache()
    {
        $cacheKey = 'home_page_dashboard_data';
        $cacheDuration = now()->addMonths(3);

        Cache::forget($cacheKey);
        $this->line("Gerando cache para a página principal (home)...");

        Cache::remember($cacheKey, $cacheDuration, function () {
            
            // 1. Contagem de empresas por situação cadastral (rápida com índice)
            $statusCounts = DB::connection((new Estabelecimento())->getConnectionName())
                ->table('estabelecimentos')
                ->select('situacao_cadastral', DB::raw('count(*) as total'))
                ->groupBy('situacao_cadastral')
                ->pluck('total', 'situacao_cadastral');

            // 2. Otimização para Top 5 CNAEs
            $topCodes = DB::connection((new Estabelecimento())->getConnectionName())
                ->table('estabelecimentos')
                ->select('cnae_fiscal_principal', DB::raw('count(*) as total'))
                ->groupBy('cnae_fiscal_principal')
                ->orderByDesc('total')
                ->limit(5)
                ->pluck('cnae_fiscal_principal');

            $topCnaes = Cnae::withCount('estabelecimentos')
                ->whereIn('codigo', $topCodes)
                ->orderByDesc('estabelecimentos_count')
                ->get();

            return compact('statusCounts', 'topCnaes');
        });
    }


    // ===================================================================
    // FUNÇÕES MANUAIS (NÃO USAM JOBS)
    // ===================================================================
    private function generateIndexCache()
    {
        $cacheKey = 'directory_index_data_v3';
        $cacheDuration = now()->addMonths(3);
        Cache::forget($cacheKey);
        $this->line("Gerando cache para a chave: {$cacheKey}");
        Cache::remember($cacheKey, $cacheDuration, function () {
            $this->comment("   > Executando consultas para a página principal...");
            $estados = Estabelecimento::select('uf')->where('uf', '!=', 'EX')->distinct()->orderBy('uf')->get();
            $topCnaes = Cnae::withCount('estabelecimentos')->orderBy('estabelecimentos_count', 'desc')->take(20)->get();
            $status = ['ativas' => '2', 'suspensas' => '3', 'inaptas' => '4', 'baixadas' => '8', 'nulas' => '1'];
            $countsByYear = DB::connection((new Estabelecimento())->getConnectionName())
                ->table('estabelecimentos')
                ->select(DB::raw('YEAR(data_inicio_atividade) as year'), DB::raw('count(*) as total'))
                ->whereIn(DB::raw('YEAR(data_inicio_atividade)'), [2025, 2024, 2023])
                ->groupBy('year')
                ->pluck('total', 'year');
            $newCompaniesCounts = ['2025' => $countsByYear[2025] ?? 0, '2024' => $countsByYear[2024] ?? 0, '2023' => $countsByYear[2023] ?? 0];
            $statusCounts = DB::connection((new Estabelecimento())->getConnectionName())
                ->table('estabelecimentos')
                ->select('situacao_cadastral', DB::raw('count(*) as total'))
                ->groupBy('situacao_cadastral')
                ->pluck('total', 'situacao_cadastral');
            return compact('estados', 'topCnaes', 'status', 'newCompaniesCounts', 'statusCounts');
        });
    }


    // NÃO UTILIZA JOBS - ESTÁ PRONTO, NÃO ALTERAR
    private function generateCnaeIndexCache()
    {
        $cacheKey = "cnae_full_list_and_top_3";
        $cacheDuration = now()->addMonths(3);
        $this->line("Gerando cache para a chave: {$cacheKey}");
        Cache::remember($cacheKey, $cacheDuration, function () {
            $allCnaes = Cnae::orderBy('descricao')->get(['codigo', 'descricao']);
            $topCodes = Estabelecimento::where('situacao_cadastral', '2')
                ->select('cnae_fiscal_principal', DB::raw('count(*) as total'))
                ->groupBy('cnae_fiscal_principal')
                ->orderByDesc('total')
                ->limit(10)
                ->pluck('cnae_fiscal_principal');
            $topCnaes = Cnae::withCount('estabelecimentos')
                ->whereIn('codigo', $topCodes)
                ->orderByDesc('estabelecimentos_count')
                ->get();
            return [
                'allCnaes' => $allCnaes,
                'topCnaes' => $topCnaes,
            ];
        });
    }

    // ===================================================================
    // FUNÇÕES "GERENTES" (APENAS DESPACHAM JOBS PARA A FILA)
    // ===================================================================
    private function dispatchStateCacheJobs()
    {
        $this->line("\n[ENFILEIRANDO] Buscando estados para despachar jobs...");
        $states = Estabelecimento::select('uf')->where('uf', '!=', 'EX')->distinct()->get();
        foreach ($states as $state) {
            ProcessStateCacheJob::dispatch($state->uf);
        }
        $this->info(count($states) . ' tarefas de estado enviadas para a fila.');
    }
    
    private function dispatchCityCacheJobs() {
        $this->line("\n[ENFILEIRANDO] Buscando municípios para despachar jobs...");
        $allCities = Municipio::has('estabelecimentos')->get();
        foreach ($allCities as $municipio) {
            ProcessCityCacheJob::dispatch($municipio);
        }
        $this->info(count($allCities) . ' tarefas de cidade enviadas para a fila.');
    }

    private function dispatchCnaeShowCacheJobs() {
        $this->line("\n[ENFILEIRANDO] Buscando CNAEs para despachar jobs...");
        $allCnaes = Cnae::all();
        foreach ($allCnaes as $cnae) {
            ProcessCnaeCacheJob::dispatch($cnae);
        }
        $this->info(count($allCnaes) . ' tarefas de CNAE enviadas para a fila.');
    }
    
    private function dispatchStatusCacheJobs() {
        $this->line("\n[ENFILEIRANDO] Despachando jobs para as páginas de Status...");
        $statusMap = [
            'ativas' => ['codigo' => '2'], 'suspensas' => ['codigo' => '3'],
            'inaptas' => ['codigo' => '4'], 'baixadas' => ['codigo' => '8'],
            'nulas' => ['codigo' => '1'],
        ];
        foreach ($statusMap as $slug => $info) {
            ProcessStatusCacheJob::dispatch($slug, $info);
        }
        $this->info(count($statusMap) . ' tarefas de status enviadas para a fila.');
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\Estabelecimento;
use App\Models\Cnae;
use App\Models\Municipio;
use Illuminate\Support\Str;

class GenerateDirectoryCache extends Command
{
    // ... (assinatura, descrição, handle(), runSection(), runAllSections() - sem alterações)
    protected $signature = 'cache:generate-directory {--section= : A seção específica para gerar o cache (index, cnae-index, states, cities, cnae-show, status)}';
    protected $description = 'Gera e armazena em cache os dados para as páginas do diretório, tudo ou por seção.';

    public function handle()
    {
        $section = $this->option('section');
        if ($section) {
            $this->info("🚀 Iniciando a geração do cache para a seção: {$section}...");
            Cache::flush();
            $this->info('Cache antigo limpo com sucesso.');
            $this->runSection($section);
        } else {
            $this->info('🚀 Iniciando a geração completa do cache do diretório...');
            $this->warn('Este processo pode demorar. É a hora perfeita para um café! ☕');
            Cache::flush();
            $this->info('Cache antigo limpo com sucesso.');
            $this->runAllSections();
        }
        $this->info("\n✅ Processo de cache finalizado com sucesso!");
        return 0;
    }

    private function runSection(string $section)
    {
        switch ($section) {
            case 'index': $this->generateIndexCache(); break;
            case 'cnae-index': $this->generateCnaeIndexCache(); break;
            case 'states': $this->generateAllStatePages(); break;
            case 'cities': $this->generateCityPagesCache(); break;
            case 'cnae-show': $this->generateCnaeShowPagesCache(); break;
            case 'status': $this->generateStatusPagesCache(); break;
            default: $this->error("Seção '{$section}' não reconhecida."); break;
        }
    }

    private function runAllSections()
    {
        $this->line("\n[1/6] Gerando cache para a página principal...");
        $this->generateIndexCache();
        $this->line("\n[2/6] Gerando cache para a busca de atividades...");
        $this->generateCnaeIndexCache();
        $this->line("\n[3/6] Gerando cache para todas as páginas de ESTADO...");
        $this->generateAllStatePages();
        $this->line("\n[4/6] Gerando cache para TODAS as páginas de MUNICÍPIO...");
        $this->generateCityPagesCache();
        $this->line("\n[5/6] Gerando cache para as páginas dos 200 CNAEs mais relevantes...");
        $this->generateCnaeShowPagesCache();
        $this->line("\n[6/6] Gerando cache para as páginas de STATUS...");
        $this->generateStatusPagesCache();
    }


    // --- MÉTODO generateIndexCache CORRIGIDO (VERSÃO SEQUENCIAL OTIMIZADA) ---
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

    // Orquestra a geração de cache para todas as páginas de estado.
    private function generateAllStatePages()
    {
        $this->line('Buscando a lista de todos os estados...');
        $states = Estabelecimento::select('uf')->where('uf', '!=', 'EX')->distinct()->get();
        $this->info(count($states) . ' estados encontrados.');
        $stateBar = $this->output->createProgressBar(count($states));
        $stateBar->start();
        foreach ($states as $state) {
            $this->generateStatePagesCache($state->uf);
            $stateBar->advance();
        }
        $stateBar->finish();
    }

    // Gera o cache para todas as páginas de um estado específico.
    private function generateStatePagesCache(string $uf)
    {
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

    private function generateCityPagesCache()
    {
        $this->line('Buscando todas as combinações de município/UF com empresas...');
        $combinations = DB::connection((new Estabelecimento())->getConnectionName())
            ->table('estabelecimentos')
            ->select('municipio as municipio_codigo', 'uf')
            ->distinct()
            ->get();
        $this->info(count($combinations) . ' combinações únicas de município/UF encontradas.');
        $cityBar = $this->output->createProgressBar(count($combinations));
        $cityBar->start();
        foreach ($combinations as $combo) {
            $municipio = Municipio::find($combo->municipio_codigo);
            if (!$municipio) continue; 
            $uf = $combo->uf;
            $totalEmpresasAtivas = Estabelecimento::where('municipio', $municipio->codigo)
                ->where('uf', $uf)
                ->where('situacao_cadastral', '2')
                ->count();
            if ($totalEmpresasAtivas === 0) continue;
            $totalPages = ceil($totalEmpresasAtivas / 50);
            for ($page = 1; $page <= $totalPages; $page++) {
                $cidade_slug = Str::slug($municipio->descricao);
                $cacheKey = "city_page_data_v3_" . strtolower($uf) . "_{$cidade_slug}_page_{$page}";
                Cache::remember($cacheKey, now()->addMonths(3), function () use ($uf, $municipio, $totalEmpresasAtivas, $page, $cidade_slug) {
                    Paginator::currentPageResolver(fn () => $page);
                    $empresas = Estabelecimento::with('empresa')
                        ->join('empresas', 'estabelecimentos.cnpj_basico', '=', 'empresas.cnpj_basico')
                        ->where('estabelecimentos.municipio', $municipio->codigo)
                        ->where('estabelecimentos.uf', $uf)
                        ->where('estabelecimentos.situacao_cadastral', '2')
                        ->orderByDesc('empresas.capital_social')
                        ->select('estabelecimentos.*')
                        ->paginate(50);
                    $empresas->setPath(route('empresas.city', ['uf' => strtolower($uf), 'cidade_slug' => $cidade_slug]));
                    return compact('municipio', 'empresas', 'totalEmpresasAtivas');
                });
            }
            $cityBar->advance();
        }
        $cityBar->finish();
    }

    private function generateCnaeIndexCache()
    {
        $cacheKey = "cnae_full_list_and_top_3";
        $cacheDuration = now()->addMonths(3);

        $this->line("Gerando cache para a chave: {$cacheKey}");

        // Usa a sua lógica original para buscar os dados
        Cache::remember($cacheKey, $cacheDuration, function () {
            // Pega TODOS os CNAEs para a busca em tempo real.
            $allCnaes = Cnae::orderBy('descricao')->get(['codigo', 'descricao']);

            // Pega os 10 CNAEs de destaque
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

    private function generateCnaeShowPagesCache()
    {
        $this->line('Buscando TODOS os CNAEs para cachear...');
        $allCnaes = Cnae::all();
        $this->info(count($allCnaes) . ' CNAEs encontrados. O processo será iniciado.');
        $cnaeBar = $this->output->createProgressBar(count($allCnaes));
        $cnaeBar->start();
        foreach ($allCnaes as $cnae) {
            $codigo_cnae = $cnae->codigo;
            $cacheKey = "cnae_show_sample_{$codigo_cnae}";
            Cache::forget($cacheKey);
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
            $cnaeBar->advance();
        }
        $cnaeBar->finish();
    }

    private function generateStatusPagesCache()
    {
        $statusMap = [
            'ativas'    => ['codigo' => '2', 'nome' => 'Ativas'],
            'suspensas' => ['codigo' => '3', 'nome' => 'Suspensas'],
            'inaptas'   => ['codigo' => '4', 'nome' => 'Inaptas'],
            'baixadas'  => ['codigo' => '8', 'nome' => 'Baixadas'],
            'nulas'     => ['codigo' => '1', 'nome' => 'Nulas'],
        ];

        $statusBar = $this->output->createProgressBar(count($statusMap));
        $statusBar->start();

        foreach ($statusMap as $slug => $info) {
            // Como não há paginação, a chave é mais simples
            $cacheKey = "status_analysis_page_{$slug}";
            $cacheDuration = now()->addMonths(3);

            Cache::remember($cacheKey, $cacheDuration, function () use ($info) {
                $statusCode = $info['codigo'];

                $stateCounts = DB::connection((new Estabelecimento())->getConnectionName())->table('estabelecimentos')->select('uf', DB::raw('count(*) as total'))->where('situacao_cadastral', $statusCode)->where('uf', '!=', 'EX')->groupBy('uf')->orderBy('uf')->pluck('total', 'uf');
                $topCnaes = Cnae::select('cnaes.codigo', 'cnaes.descricao', DB::raw('count(*) as total'))->join('estabelecimentos', 'cnaes.codigo', '=', 'estabelecimentos.cnae_fiscal_principal')->where('estabelecimentos.situacao_cadastral', $statusCode)->groupBy('cnaes.codigo', 'cnaes.descricao')->orderByDesc('total')->limit(5)->get();
                $randomCompanies = Estabelecimento::with(['empresa', 'municipioRel'])->where('situacao_cadastral', $statusCode)->inRandomOrder()->limit(100)->get();
                
                return compact('stateCounts', 'topCnaes', 'randomCompanies');
            });
            $statusBar->advance();
        }
        $statusBar->finish();
    }
}
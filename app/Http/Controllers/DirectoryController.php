<?php

namespace App\Http\Controllers;
use App\Models\Empresa;
use App\Models\Estabelecimento; 
use App\Models\Municipio; 
use App\Models\Cnae;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // Importar o Facade de Cache
use Illuminate\Support\Facades\DB; // <-- ADICIONE ESTA LINHA
use Illuminate\Support\Str;

class DirectoryController extends Controller
{
    public function index()
    {
        $cacheKey = 'directory_index_data_simplified'; // Nova chave de cache para a versão simples
        $cacheDuration = 60 * 24;

        $data = Cache::remember($cacheKey, $cacheDuration, function () {
            // 1. Estados (sem 'EX')
            $estados = Estabelecimento::select('uf')
                ->where('uf', '!=', 'EX')
                ->distinct()
                ->orderBy('uf')
                ->get();

            // 2. Top CNAEs
            $topCnaes = Cnae::withCount('estabelecimentos')
                ->orderBy('estabelecimentos_count', 'desc')
                ->take(20)
                ->get();
            
            // 3. Status
            $status = [
                'ativas'    => '2',
                'suspensas' => '3',
                'inaptas'   => '4',
                'baixadas'  => '8',
                'nulas'     => '1',
            ];

            // A consulta pesada foi removida daqui

            return [
                'estados'             => $estados,
                'topCnaes'            => $topCnaes,
                'status'              => $status,
            ];
        });

        return view('pages.directory.index', $data);
    }

   
    public function byState(Request $request, string $uf)
    {
        $uf = strtoupper($uf);
        $currentPage = $request->input('page', 1); 
        $cacheKey = "state_page_data_v5_{$uf}_page_{$currentPage}"; // Nova chave de cache para a v5
        $cacheDuration = 60 * 24;

        $data = Cache::remember($cacheKey, $cacheDuration, function () use ($uf) {
            
            // 1. Top 5 cidades com mais empresas (mantido)
            $topCidades = Municipio::select('descricao', DB::raw('count(*) as total_empresas'))
                ->join('estabelecimentos', 'municipios.codigo', '=', 'estabelecimentos.municipio')
                ->where('estabelecimentos.uf', $uf)
                ->groupBy('municipios.codigo', 'municipios.descricao')
                ->orderByDesc('total_empresas')
                ->take(5)
                ->get();
            
            // 2. NOVA LÓGICA: Contagem de empresas por situação cadastral
            $statusCounts = Estabelecimento::select('situacao_cadastral', DB::raw('count(*) as total'))
                ->where('uf', $uf)
                ->groupBy('situacao_cadastral')
                ->pluck('total', 'situacao_cadastral'); // Gera um array [codigo => total]

            // 3. Top 5 CNAEs com código para a nova seção (mantido, mas agora usado em outro lugar)
            $topCnaes = Cnae::select('cnaes.codigo', 'cnaes.descricao', DB::raw('count(*) as total'))
                ->join('estabelecimentos', 'cnaes.codigo', '=', 'estabelecimentos.cnae_fiscal_principal')
                ->where('estabelecimentos.uf', $uf)
                ->groupBy('cnaes.codigo', 'cnaes.descricao')
                ->orderByDesc('total')
                ->take(5)
                ->get();

            // 4. Lista paginada de municípios com contagem de empresas ativas (mantido)
            $municipiosPaginados = Municipio::withCount(['estabelecimentos' => function ($query) use ($uf) {
                $query->where('uf', $uf)->where('situacao_cadastral', '2'); // Apenas ativas
            }])
            ->whereHas('estabelecimentos', function ($query) use ($uf) {
                $query->where('uf', $uf);
            })
            ->orderByDesc('estabelecimentos_count')
            ->paginate(30);

            // Total de empresas ativas para o card principal (calculado a partir da contagem de status)
            $totalAtivas = $statusCounts['2'] ?? 0;

            return [
                'totalAtivas' => $totalAtivas,
                'topCidades' => $topCidades,
                'statusCounts' => $statusCounts, // Novo dado para a view
                'topCnaes' => $topCnaes,
                'municipios' => $municipiosPaginados,
            ];
        });

        $data['uf'] = $uf;

        return view('pages.directory.state', $data);
    }

    
    public function byCity(Request $request, string $uf, string $cidade_slug)
    {
        $uf = strtoupper($uf);
        $currentPage = $request->input('page', 1);
        $cacheKey = "city_page_data_v2_{$uf}_{$cidade_slug}_page_{$currentPage}"; // Nova chave de cache
        $cacheDuration = 60 * 24;

        $data = Cache::remember($cacheKey, $cacheDuration, function () use ($uf, $cidade_slug) {
            // Encontra o município pelo slug
            $municipio = Municipio::where('descricao', 'LIKE', str_replace('-', ' ', $cidade_slug))
                                  ->whereHas('estabelecimentos', fn($q) => $q->where('uf', $uf))
                                  ->firstOrFail();

            // CORREÇÃO AQUI: Adicionado o join() e o select()
            $empresas = Estabelecimento::with('empresa')
                ->join('empresas', 'estabelecimentos.cnpj_basico', '=', 'empresas.cnpj_basico')
                ->where('estabelecimentos.municipio', $municipio->codigo)
                ->where('estabelecimentos.uf', $uf)
                ->where('estabelecimentos.situacao_cadastral', '2') // Apenas ativas
                ->orderByDesc('empresas.capital_social')
                ->select('estabelecimentos.*') // Crucial para evitar conflitos de colunas
                ->paginate(50);
            
            return [
                'municipio' => $municipio,
                'empresas' => $empresas,
            ];
        });

        $data['uf'] = $uf;

        return view('pages.directory.city', $data);
    }

    /**
     * Página de listagem de CNAEs: /empresas/atividades
     */
    public function cnaeIndex()
    {
        // Lista paginada de todas as atividades
        $cnaes = Cnae::withCount('estabelecimentos')
                        ->orderBy('estabelecimentos_count', 'desc')
                        ->paginate(100);

        return view('pages.directory.cnae_list', compact('cnaes'));
    }

    /**
     * Página de empresas por CNAE: /empresas/atividades/restaurantes
     */
    public function byCnae(string $cnae_slug)
    {
        $cnae = Cnae::where('descricao', 'LIKE', str_replace('-', ' ', $cnae_slug))->firstOrFail();

        $empresas = Estabelecimento::where('cnae_fiscal_principal', $cnae->id)
                                    ->with('empresa')
                                    ->orderBy('data_inicio_atividade', 'desc')
                                    ->paginate(50);
        
        return view('pages.directory.cnae_show', compact('empresas', 'cnae'));
    }

    /**
     * Página de empresas por Status: /empresas/status/ativas
     */
    public function byStatus(string $status_slug)
    {
        $map = [
            'ativas' => ['codigo' => '2', 'nome' => 'Ativas'],
            'suspensas' => ['codigo' => '3', 'nome' => 'Suspensas'],
            'inaptas' => ['codigo' => '4', 'nome' => 'Inaptas'],
            'baixadas' => ['codigo' => '8', 'nome' => 'Baixadas'],
            'nulas' => ['codigo' => '1', 'nome' => 'Nulas'],
        ];

        if (!array_key_exists($status_slug, $map)) {
            abort(404);
        }

        $status = $map[$status_slug];
        $empresas = Estabelecimento::where('situacao_cadastral', $status['codigo'])
                                    ->with('empresa')
                                    ->orderBy('data_inicio_atividade', 'desc') // Mais recentes primeiro
                                    ->paginate(50);
        
        return view('pages.directory.status_show', compact('empresas', 'status'));
    }

    /**
     * Página de empresas recentes: /empresas/recentes
     */
    public function byRecent()
    {
        $empresas = Estabelecimento::where('data_inicio_atividade', '>=', now()->subYear())
                                    ->with('empresa')
                                    ->orderBy('data_inicio_atividade', 'desc')
                                    ->paginate(50);

        return view('pages.directory.recent', compact('empresas'));
    }
}

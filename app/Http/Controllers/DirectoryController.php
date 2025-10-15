<?php

namespace App\Http\Controllers;
use App\Models\Empresa;
use App\Models\Estabelecimento; 
use App\Models\Municipio; 
use App\Models\Cnae;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;

class DirectoryController extends Controller
{
    
    public function index()
    {
        $cacheKey = 'directory_index_data_v3';
        $data = Cache::get($cacheKey, []);
        return view('pages.directory.empresas.index', $data);
    }

    public function byState(Request $request, string $uf)
    {
        $uf = strtoupper($uf);
        $currentPage = $request->input('page', 1);
        $cacheKey = "state_page_data_v5_{$uf}_page_{$currentPage}";
        $data = Cache::get($cacheKey);
        if (!$data) {
            abort(404, 'Página não encontrada ou não pré-cacheada.');
        }
        $data['uf'] = $uf;
        return view('pages.directory.estados.state', $data);
    }

     public function byCity(Request $request, string $uf, string $cidade_slug)
    {
        // A variável $uf já vem minúscula da URL
        $currentPage = $request->input('page', 1);
        // A chave de cache deve ser exatamente a mesma que o robô usa
        $cacheKey = "city_page_data_v3_{$uf}_{$cidade_slug}_page_{$currentPage}";
        $data = Cache::get($cacheKey);
        if (!$data) {
            abort(404, 'Página não encontrada ou não pré-cacheada.');
        }
        // Adiciona a UF em maiúsculas, que a view precisa para os títulos e lógicas
        $data['uf'] = strtoupper($uf);
        return view('pages.directory.municipios.city', $data);
    }

    public function cnaeIndex(Request $request)
    {
        $cacheKey = "cnae_full_list_and_top_3";
        $data = Cache::get($cacheKey);
        if (!$data) {
            $data = [
                'allCnaes' => collect(), 
                'topCnaes' => collect(), 
            ];
        }
        $data['searchTerm'] = $request->input('q');
        return view('pages.directory.atividades.cnae_list', $data);
    }


    public function byCnae(Request $request, int $codigo_cnae)
    {
        $cacheKey = "cnae_show_sample_{$codigo_cnae}";
        $data = Cache::get($cacheKey);
        if (!$data) {
            abort(404, 'Página não encontrada ou não pré-cacheada.');
        }
        return view('pages.directory.atividades.cnae_show', $data);
    }


    public function byStatus(Request $request, string $status_slug)
    {
        $statusMap = [
            'ativas'    => ['codigo' => '2', 'nome' => 'Ativas', 'color' => 'green'],
            'suspensas' => ['codigo' => '3', 'nome' => 'Suspensas', 'color' => 'yellow'],
            'inaptas'   => ['codigo' => '4', 'nome' => 'Inaptas', 'color' => 'orange'],
            'baixadas'  => ['codigo' => '8', 'nome' => 'Baixadas', 'color' => 'red'],
            'nulas'     => ['codigo' => '1', 'nome' => 'Nulas', 'color' => 'gray'],
        ];
        if (!array_key_exists($status_slug, $statusMap)) {
            abort(404);
        }
        $cacheKey = "status_analysis_page_{$status_slug}";
        $data = Cache::get($cacheKey);
        if (!$data) {
            abort(404, 'Página não encontrada ou não pré-cacheada.');
        }
        // Adiciona os dados que a view precisa para os títulos e botões
        $data['statusInfo'] = $statusMap[$status_slug];
        $data['statusMap'] = $statusMap;
        $data['currentStatusSlug'] = $status_slug;
        return view('pages.directory.status.status_show', $data);
    }


}

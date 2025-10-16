<?php

namespace App\Http\Controllers;

use App\Models\Cnae;
use App\Models\Estabelecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial com dados agregados.
     */
    public function index()
    {
        // A chave de cache deve ser a mesma que o robô usa
        $cacheKey = 'home_page_dashboard_data';
        // Pega os dados do cache. Se não existirem, envia arrays vazios para a view.
        $data = Cache::get($cacheKey, [
            'statusCounts' => [],
            'topCnaes' => collect(), // Envia uma coleção vazia para o @foreach não quebrar
        ]);
        // Se o cache estiver vazio, a página carregará sem os dados, mas não dará erro 500.
        // Isso te avisa que você precisa rodar o robô de cache.
        return view('pages.home', $data);
    }
}
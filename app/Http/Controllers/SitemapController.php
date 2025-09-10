<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    // Limite de URLs por sitemap (o Google recomenda no máximo 50.000, vamos usar um valor seguro)
    private $limit = 20000;

    public function index()
    {
        // Conta o total de empresas para saber quantos sitemaps de CNPJ precisaremos criar.
        $totalCnpjs = Estabelecimento::count();
        $pages = ceil($totalCnpjs / $this->limit);

        // Retorna a view 'index' do sitemap, passando a quantidade de páginas de CNPJ.
        return response()->view('sitemaps.index', [
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml');
    }

    public function pages()
    {
        $pages = [
            ['url' => URL::to('/'), 'lastmod' => '2025-09-10'], // Data de última modificação
            ['url' => route('privacy.policy'), 'lastmod' => '2025-09-10'],
        ];

        // Retorna a view 'pages' do sitemap.
        return response()->view('sitemaps.pages', [
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml');
    }

    public function cnpjs(Request $request)
    {
        // Pega o número da página da URL (ex: /sitemaps/cnpjs.xml?page=1)
        $page = $request->input('page', 1);

        // Busca no banco de dados apenas os CNPJs para a página atual.
        $estabelecimentos = Estabelecimento::select(['cnpj', 'updated_at'])
            ->forPage($page, $this->limit)
            ->get();
            
        // Retorna a view 'cnpjs' do sitemap com os dados encontrados.
        return response()->view('sitemaps.cnpjs', [
            'estabelecimentos' => $estabelecimentos,
        ])->header('Content-Type', 'text/xml');
    }
}

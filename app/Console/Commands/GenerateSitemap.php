<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use App\Models\Estabelecimento;
use App\Models\Municipio;
use App\Models\Cnae;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Gera o sitemap completo do site, incluindo páginas estáticas, diretórios e CNPJs.';

    public function handle()
    {
        $this->info('🚀 Iniciando a geração completa do sitemap...');

        $sitemapIndexPath = public_path('sitemap_index.xml');
        $sitemapIndex = SitemapIndex::create();


        // --- 2. SITEMAP DAS PÁGINAS DE ESTADO E STATUS (poucas páginas, cabem em um arquivo) ---
        $this->line("\n[2/5] Gerando sitemap para estados e status...");
        $directorySitemap = Sitemap::create();
        // Adiciona todos os estados
        $states = Estabelecimento::select('uf')->where('uf', '!=', 'EX')->distinct()->get();
        foreach ($states as $state) {
            $directorySitemap->add(Url::create(route('empresas.state', ['uf' => strtolower($state->uf)]))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        }
        // Adiciona todos os status
        $statusSlugs = ['ativas', 'suspensas', 'inaptas', 'baixadas', 'nulas'];
        foreach ($statusSlugs as $slug) {
            $directorySitemap->add(Url::create(route('empresas.status', ['status_slug' => $slug]))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        }
        $directorySitemap->writeToFile(public_path('sitemaps/directory.xml'));
        $sitemapIndex->add('/sitemaps/directory.xml');
        $this->info('Sitemap de estados e status gerado.');

        // --- 3. SITEMAPS DAS PÁGINAS DE MUNICÍPIO (dividido em chunks) ---
        $this->line("\n[3/5] Gerando sitemaps para municípios...");
        Municipio::has('estabelecimentos')->select('id', 'descricao')->chunk(20000, function ($municipios, $index) use ($sitemapIndex) {
            $municipioSitemap = Sitemap::create();
            foreach ($municipios as $municipio) {
                // Descobre a UF associada para montar a URL correta
                $ufResult = Estabelecimento::where('municipio', $municipio->codigo)->select('uf')->first();
                if ($ufResult) {
                    $municipioSitemap->add(Url::create(route('empresas.city', ['uf' => strtolower($ufResult->uf), 'cidade_slug' => Str::slug($municipio->descricao)]))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
                }
            }
            $fileName = "sitemaps/cities-{$index}.xml";
            $municipioSitemap->writeToFile(public_path($fileName));
            $sitemapIndex->add($fileName);
        });
        $this->info('Sitemaps de municípios gerados.');

        // --- 4. SITEMAPS DAS PÁGINAS DE CNAE (dividido em chunks) ---
        $this->line("\n[4/5] Gerando sitemaps para CNAEs...");
        Cnae::select('codigo')->chunk(20000, function ($cnaes, $index) use ($sitemapIndex) {
            $cnaeSitemap = Sitemap::create();
            foreach ($cnaes as $cnae) {
                $cnaeSitemap->add(Url::create(route('empresas.cnae.show', ['codigo_cnae' => $cnae->codigo]))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
            }
            $fileName = "sitemaps/cnaes-{$index}.xml";
            $cnaeSitemap->writeToFile(public_path($fileName));
            $sitemapIndex->add($fileName);
        });
        $this->info('Sitemaps de CNAEs gerados.');

        
        // --- FINALIZAÇÃO: Escreve o arquivo de índice principal ---
        $sitemapIndex->writeToFile($sitemapIndexPath);

        $this->info("\n✅ Sitemap Index gerado com sucesso em {$sitemapIndexPath}");
        return 0;
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex; // <-- Garante que a classe está importada
use Spatie\Sitemap\Tags\Url;
use App\Models\Estabelecimento;
use App\Models\Municipio;
use App\Models\Cnae;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateSitemap extends Command
{
    // Mantendo o nome original se preferir, ou pode usar sitemap:generate-directory
    protected $signature = 'sitemap:generate-directory';
    protected $description = 'Gera os sitemaps focados na estrutura do diretório (estados, municípios, CNAEs, status).';

    public function handle()
    {
        $this->info('🚀 Iniciando a geração dos sitemaps do diretório...');

        // Cria a pasta sitemaps se não existir
        $sitemapsPath = public_path('sitemaps');
        if (!file_exists($sitemapsPath)) {
            mkdir($sitemapsPath, 0755, true);
        }

        $sitemapIndexPath = public_path('sitemap_index.xml');
        $sitemapIndex = SitemapIndex::create();

        // --- 1. SITEMAP DE PÁGINAS PRINCIPAIS DO DIRETÓRIO ---
        $this->line("\n[1/4] Gerando sitemap para páginas principais do diretório...");
        Sitemap::create()
            ->add(Url::create(route('empresas.index'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create(route('empresas.cnae.index'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->writeToFile(public_path('sitemaps/diretorio-principal.xml')); // Nome mais claro

        $sitemapIndex->add('/sitemaps/diretorio-principal.xml');
        $this->info('Sitemap de páginas principais do diretório gerado.');


        // --- 2. SITEMAP DE ESTADOS E STATUS ---
        $this->line("\n[2/4] Gerando sitemap para estados e status...");
        $statesAndStatusSitemap = Sitemap::create();
        // Adiciona todos os estados
        $states = Estabelecimento::select('uf')->where('uf', '!=', 'EX')->distinct()->get();
        foreach ($states as $state) {
            $statesAndStatusSitemap->add(Url::create(route('empresas.state', ['uf' => strtolower($state->uf)]))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        }
        // Adiciona todos os status
        $statusSlugs = ['ativas', 'suspensas', 'inaptas', 'baixadas', 'nulas'];
        foreach ($statusSlugs as $slug) {
            $statesAndStatusSitemap->add(Url::create(route('empresas.status', ['status_slug' => $slug]))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        }
        $statesAndStatusSitemap->writeToFile(public_path('sitemaps/estados-status.xml')); // Nome mais claro
        $sitemapIndex->add('/sitemaps/estados-status.xml');
        $this->info('Sitemap de estados e status gerado.');


        // --- 3. SITEMAPS DE MUNICÍPIOS ---
        $this->line("\n[3/4] Gerando sitemaps para Municípios (/empresas/{uf}/{municipio})...");
        // Otimização: Busca todas as combinações UF/Município de uma vez
        $combinations = DB::connection((new Estabelecimento())->getConnectionName())
            ->table('estabelecimentos')
            ->select('municipio as municipio_codigo', 'uf')
            ->where('uf', '!=', 'EX') // Garante que não pega 'EX'
            ->distinct()
            ->get();

        // Pré-carrega os nomes dos municípios
        $municipiosMap = Municipio::findMany($combinations->pluck('municipio_codigo'))->keyBy('codigo');

        $cityBar = $this->output->createProgressBar($combinations->count());
        $cityBar->start();

        // Divide em chunks de 50000 URLs por arquivo
        $combinations->chunk(50000)->each(function ($chunk, $index) use ($sitemapIndex, $municipiosMap, $cityBar) {
            $municipioSitemap = Sitemap::create();
            $chunkIndex = $index + 1;

            foreach ($chunk as $combo) {
                $municipio = $municipiosMap->get($combo->municipio_codigo);
                if ($municipio) {
                    $municipioSitemap->add(Url::create(route('empresas.city', [
                        'uf' => strtolower($combo->uf),
                        'cidade_slug' => Str::slug($municipio->descricao)
                    ]))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
                }
                 $cityBar->advance(); // Avança a barra para cada combinação
            }
            $fileName = "sitemaps/municipios-{$chunkIndex}.xml";
            $municipioSitemap->writeToFile(public_path($fileName));
            $sitemapIndex->add($fileName);
        });
        $cityBar->finish();
        $this->info("\nSitemaps de Municípios gerados.");


        // --- 4. SITEMAP DE ATIVIDADES (CNAEs) ---
        $this->line("\n[4/4] Gerando sitemap para Atividades (/empresas/atividades/{codigo})...");
        $activitiesSitemap = Sitemap::create();
        $allCnaes = Cnae::all(['codigo']);
        foreach ($allCnaes as $cnae) {
            $activitiesSitemap->add(Url::create(route('empresas.cnae.show', ['codigo_cnae' => $cnae->codigo]))
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        }
        $activitiesSitemap->writeToFile(public_path('sitemaps/atividades.xml'));
        $sitemapIndex->add('/sitemaps/atividades.xml');
        $this->info('Sitemap de Atividades gerado.');

        
        // --- FINALIZAÇÃO: Escreve o arquivo de índice principal ---
        $sitemapIndex->writeToFile($sitemapIndexPath);

        $this->info("\n✅ Sitemap Index gerado com sucesso em {$sitemapIndexPath}");
        return 0;
    }
}
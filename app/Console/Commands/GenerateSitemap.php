<?php

namespace App\Console\Commands;

use App\Models\Estabelecimento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--limit=0 : Limita o número total de CNPJs a serem incluídos. 0 para todos.}';
    protected $description = 'Gera os arquivos de sitemap estáticos na pasta /public';
    private $limitPerFile = 50000; // Máximo de URLs por arquivo XML

    public function handle()
    {
        $this->info('Iniciando a geração do sitemap...');
        $publicPath = public_path();
        $sitemapsPath = $publicPath . '/sitemaps';

        if (!File::isDirectory($sitemapsPath)) {
            File::makeDirectory($sitemapsPath, 0755, true);
        }

        $totalLimit = (int) $this->option('limit');
        if ($totalLimit > 0) {
            $this->warn("AVISO: O sitemap será gerado com um limite de {$totalLimit} empresas.");
        }

        //$this->generatePagesSitemap($sitemapsPath);
        $cnpjSitemapFiles = $this->generateCnpjsSitemaps($sitemapsPath, $totalLimit);
        $this->generateSitemapIndex($publicPath, $cnpjSitemapFiles);

        $this->info('Geração do sitemap concluída com sucesso!');
        $this->comment("Os arquivos foram salvos na sua pasta 'public'.");
        return 0;
    }

    private function generatePagesSitemap($path)
    {

    }

    private function generateCnpjsSitemaps($path, int $totalLimit)
    {
        $this->line('Iniciando geração dos sitemaps de CNPJs...');
        $files = [];
        $recordCount = 0;
        $page = 1;

        // **CORREÇÃO APLICADA AQUI**
        // Removida a seleção da coluna 'updated_at' que não existe.
        $query = Estabelecimento::select('cnpj_basico', 'cnpj_ordem', 'cnpj_dv');

        if ($totalLimit > 0) {
            $query->limit($totalLimit);
        }

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        
        $lastmod = now()->format('Y-m-d');

        foreach ($query->cursor() as $estabelecimento) {
            // Monta o CNPJ completo
            $cnpjCompleto = $estabelecimento->cnpj_basico . $estabelecimento->cnpj_ordem . $estabelecimento->cnpj_dv;
            
            // **CORREÇÃO APLICADA AQUI**
            // Usa a data atual como fallback seguro para o lastmod.
            $this->addUrl($xml, route('cnpj.show', ['cnpj' => $cnpjCompleto]), $lastmod, 'monthly', '0.5');
            $recordCount++;

            // Se atingir o limite por arquivo, salva o arquivo e começa um novo
            if ($recordCount % $this->limitPerFile === 0) {
                $fileName = "cnpjs-{$page}.xml";
                file_put_contents($path . '/' . $fileName, $xml->asXML());
                $files[] = 'sitemaps/' . $fileName;
                
                $this->info("Arquivo {$fileName} gerado com {$this->limitPerFile} URLs.");
                
                $page++;
                // Reseta o XML para o próximo arquivo
                $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
            }
        }

        // Salva o último arquivo se ele tiver algum registro
        if ($recordCount % $this->limitPerFile !== 0 && $recordCount > 0) {
            $fileName = "cnpjs-{$page}.xml";
            file_put_contents($path . '/' . $fileName, $xml->asXML());
            $files[] = 'sitemaps/' . $fileName;
            $this->info("Arquivo final {$fileName} gerado com " . ($recordCount % $this->limitPerFile) . " URLs.");
        }

        $this->info('Sitemaps de CNPJs gerados.');
        return $files;
    }

    private function generateSitemapIndex($path, $cnpjSitemapFiles)
    {
        $this->line('Gerando o sitemap index principal...');
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>');

        //$this->addSitemap($xml, url('sitemaps/paginas.xml'));

        foreach ($cnpjSitemapFiles as $file) {
            $this->addSitemap($xml, url($file));
        }
        
        file_put_contents($path . '/sitemap.xml', $xml->asXML());
        $this->info('Sitemap index gerado.');
    }

    private function addSitemap(\SimpleXMLElement $xml, string $url)
    {
        $sitemapNode = $xml->addChild('sitemap');
        $sitemapNode->addChild('loc', $url);
        $sitemapNode->addChild('lastmod', now()->format('Y-m-d'));
    }

    private function addUrl(\SimpleXMLElement $xml, string $url, string $lastmod, string $changefreq, string $priority)
    {
        $urlNode = $xml->addChild('url');
        $urlNode->addChild('loc', $url);
        $urlNode->addChild('lastmod', $lastmod);
        $urlNode->addChild('changefreq', $changefreq);
        $urlNode->addChild('priority', $priority);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Estabelecimento; 
use App\Models\Cnae;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CnpjController extends Controller
{
    /**
     * Processa o formulário de consulta.
     * Se encontrar, redireciona. Se não, volta com erro para o popup.
     */
    public function consultar(Request $request): RedirectResponse
    {
        // 1. Validação do formato do CNPJ
        $cnpjApenasNumeros = preg_replace('/[^0-9]/', '', $request->input('cnpj'));
        $validator = Validator::make(['cnpj' => $cnpjApenasNumeros], [
            'cnpj' => ['required', 'string', 'size:14']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 2. Verifica se o CNPJ é válido de acordo com as novas regras
        $empresa = $this->findValidEstabelecimento($cnpjApenasNumeros);

        // 3. Lógica de redirecionamento
        if ($empresa) {
            // SE EXISTE E É VÁLIDO: Redireciona para a página de exibição
            return redirect()->route('cnpj.show', ['cnpj' => $cnpjApenasNumeros]);
        } else {
            // SE NÃO EXISTE OU NÃO É VÁLIDO: Volta com erro para o popup
            return back()->with('error', 'CNPJ não encontrado ou não é matriz.')->withInput();
        }
    }

    /**
     * Exibe os dados de um CNPJ a partir da URL (SEO-friendly).
     */
    public function show(string $cnpj): View
    {
        $cnpjApenasNumeros = preg_replace('/[^0-9]/', '', $cnpj);
        if (strlen($cnpjApenasNumeros) !== 14) {
            abort(404, 'Formato de CNPJ inválido.');
        }

        $empresa = $this->findValidEstabelecimento($cnpjApenasNumeros)->load('socios.qualificacao');
        if (!$empresa) {
            abort(404, 'CNPJ não encontrado ou não é matriz.');
        }

        $estabelecimento = $empresa->estabelecimentos->first();
        $situacao = $this->traduzirSituacaoCadastral($estabelecimento->situacao_cadastral);

        
        // --- LÓGICA ATUALIZADA PARA BUSCAR CNAEs ---
        $cnaePrincipal = Cnae::find($estabelecimento->cnae_fiscal_principal);

        $cnaesSecundarios = [];
        if (!empty($estabelecimento->cnae_fiscal_secundaria)) {
            $codigosSecundarios = explode(',', $estabelecimento->cnae_fiscal_secundaria);
            
            // Busca a coleção completa de objetos Cnae
            $cnaeObjects = Cnae::whereIn('codigo', $codigosSecundarios)->get();

            // Mapeia para um array com código e descrição
            $cnaesSecundarios = $cnaeObjects->map(function ($cnae) {
                return [
                    'codigo' => $this->formatarCnae($cnae->codigo),
                    'descricao' => $cnae->descricao
                ];
            })->toArray();
        }
        // --- FIM DA LÓGICA ---


        // --- LÓGICA PARA BUSCAR ENDEREÇO (CORRIGIDA) ---
        $logradouroCompleto = trim(implode(' ', [
            $estabelecimento->tipo_logradouro,
            $estabelecimento->logradouro,
            $estabelecimento->numero
        ]));

        // Acessa a descrição do município através da propriedade dinâmica da relação
        $nomeMunicipio = $estabelecimento->municipioRel->descricao ?? 'Não informado';

        $cidadeUf = trim($nomeMunicipio . ' / ' . $estabelecimento->uf);
        
        $enderecoCompletoQuery = urlencode(implode(', ', [
            $logradouroCompleto,
            $estabelecimento->bairro,
            $cidadeUf
        ]));

        // ATUALIZE SUA_API_KEY com sua chave do Google Cloud Platform
        $googleMapsUrl = "https://www.google.com/maps/embed/v1/place?key=SUA_API_KEY&q={$enderecoCompletoQuery}";
        // --- FIM DA LÓGICA ---


        // --- LÓGICA PARA BUSCAR CONTATOS (COM VERIFICAÇÃO) ---
        $telefone1 = null;
        if (!empty($estabelecimento->ddd1) && !empty($estabelecimento->telefone1)) {
            $telefone1 = '(' . $estabelecimento->ddd1 . ') ' . $estabelecimento->telefone1;
        }

        $telefone2 = null;
        if (!empty($estabelecimento->ddd2) && !empty($estabelecimento->telefone2)) {
            $telefone2 = '(' . $estabelecimento->ddd2 . ') ' . $estabelecimento->telefone2;
        }

        $email = $estabelecimento->correio_eletronico ?? null;
        // --- FIM DA LÓGICA ---

        // --- LÓGICA PARA PROCESSAR SÓCIOS ---
        $quadroSocietario = [];
        if ($empresa->socios->isNotEmpty()) {
            $quadroSocietario = $empresa->socios->map(function ($socio) {
                return [
                    'nome' => $socio->nome_socio,
                    'qualificacao' => $socio->qualificacao->descricao ?? 'Não informada', // Usa a relação aninhada
                    'data_entrada' => date('d/m/Y', strtotime($socio->data_entrada_sociedade)),
                ];
            })->toArray();
        }
        // --- FIM DA LÓGICA ---

        // --- LÓGICA PARA EMPRESAS SEMELHANTES ---
        $empresasSemelhantes = $this->findSimilarCompanies($estabelecimento);
        // --- FIM DA LÓGICA ---


        // --- PREPARAÇÃO DOS DADOS ESTRUTURADOS (JSON-LD) ---
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $empresa->razao_social,
            'foundingDate' => $estabelecimento->data_inicio_atividade,
            'legalName' => $empresa->razao_social,
            'url' => url()->current(),
            'vatID' => $cnpjApenasNumeros,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $estabelecimento->tipo_logradouro . ' ' . ($estabelecimento->logradouro ?? '') . ', ' . ($estabelecimento->numero ?? 'S/N'),
                'addressLocality' => $estabelecimento->municipioRel->descricao ?? '',
                'addressRegion' => $estabelecimento->uf ?? '',
                'postalCode' => $estabelecimento->cep,
                'addressCountry' => 'BR',
            ],
        ];

        // Adiciona o telefone de forma condicional e segura
        if (!empty($estabelecimento->ddd1) && !empty($estabelecimento->telefone1)) {
            $structuredData['telephone'] = '+55' . $estabelecimento->ddd1 . $estabelecimento->telefone1;
        }

        if (!empty($estabelecimento->correio_eletronico)) {
            $structuredData['email'] = $estabelecimento->correio_eletronico;
        }


        // --- NOVO: PREPARAÇÃO DOS DADOS OPEN GRAPH (OG Tags) ---
        $ogData = [
            'og:title' => $empresa->razao_social . ' - CNPJ ' . $this->formatarCnpj($cnpjApenasNumeros),
            'og:description' => 'Consulte gratuitamente os dados cadastrais da empresa ' . $empresa->razao_social . ', incluindo CNPJ, endereço, atividades e situação cadastral.',
            'og:url' => url()->current(),
            'og:type' => 'website',
            'og:site_name' => 'CNPJ Total', // Ou o nome do seu site
            'og:locale' => 'pt_BR',
            'og:image' => asset('images/logo/logo-preto-vermelho.webp'),
            'og:image:type' => 'image/png', 
            'og:image:width' => '1080',      
            'og:image:height' => '1080',     
        ];
        // --- FIM DA PREPARAÇÃO OG ---

        $metaData = [
            'description' => 'Consulte informações completas sobre a empresa' . $empresa->razao_social
                        . ', CNPJ ' . $this->formatarCnpj($cnpjApenasNumeros)
                        . '.',
            
            'keywords' => implode(', ', array_filter([
                $empresa->razao_social,
                $estabelecimento->nome_fantasia,
                'cnpj ' . $this->formatarCnpj($cnpjApenasNumeros),
                'consulta cnpj',
                $cnpjApenasNumeros,
                $this->formatarCnpj($cnpjApenasNumeros)
            ]))
        ];

        // Prepara os dados para os cards
        $dadosParaExibir = [
            // Card: Informações do CNPJ (dados existentes)
            'cnpj_completo' => $this->formatarCnpj($cnpjApenasNumeros),
            'razao_social' => $empresa->razao_social,
            'nome_fantasia' => $estabelecimento->nome_fantasia,
            'natureza_juridica' => $empresa->naturezaJuridica->descricao ?? 'Não informado',
            'capital_social' => number_format($empresa->capital_social, 2, ',', '.'),
            'porte' => $this->traduzirPorte($empresa->porte_empresa),
            'matriz_ou_filial' => $estabelecimento->identificador_matriz_filial == 1 ? 'Matriz' : 'Filial',
            'data_abertura' => date('d/m/Y', strtotime($estabelecimento->data_inicio_atividade)),

            // Card: Situação Cadastral (NOVOS DADOS)
            'situacao_cadastral' => $situacao['texto'],
            'situacao_cadastral_classe' => $situacao['classe'],
            'data_situacao_cadastral' => date('d/m/Y', strtotime($estabelecimento->data_situacao_cadastral)),

            // Card: Atividades Econômicas (DADOS ATUALIZADOS)
            'cnae_principal' => [
                'codigo' => $cnaePrincipal ? $this->formatarCnae($cnaePrincipal->codigo) : 'Não informado',
                'descricao' => $cnaePrincipal->descricao ?? 'Não informado'
            ],
            'cnaes_secundarios' => $cnaesSecundarios,

            // Card: Endereço (NOVOS DADOS)
            'logradouro' => $logradouroCompleto,
            'complemento' => $estabelecimento->complemento,
            'bairro' => $estabelecimento->bairro,
            'cidade_uf' => $cidadeUf,
            'cidade' => $nomeMunicipio,
            'cep' => $estabelecimento->cep,
            'google_maps_url' => $googleMapsUrl,

            // Card: Contato (NOVOS DADOS)
            'telefone_1' => $telefone1,
            'telefone_2' => $telefone2,
            'email' => $email,

            // Card: Quadro Societário (NOVOS DADOS)
            'quadro_societario' => $quadroSocietario,

            'empresas_semelhantes' => $empresasSemelhantes,

            // DADOS DE CONTEXTO PARA O SUBTÍTULO (NOVO)
            'similar_context' => [
                'cnae_descricao' => $cnaePrincipal->descricao ?? 'Não informado',
                'cidade' => $estabelecimento->municipioRel->descricao ?? 'região'
            ],

            'structured_data' => $structuredData,

            'og_data' => $ogData,

            'meta_data' => $metaData
        ];

        return view('cnpj.show', ['data' => $dadosParaExibir]);
    }

    /**
     * Formata o código CNAE.
     */
    private function formatarCnae(string $codigo): string
    {
        return vsprintf('%s%s%s%s-%s/%s%s', str_split($codigo));
    }

    private function traduzirPorte(int $codigoPorte): string
    {
        switch ($codigoPorte) {
            case 1:
                return 'Micro Empresa';
            case 3:
                return 'Empresa de Pequeno Porte';
            case 5:
                return 'Demais';
            default:
                return 'Não Informado';
        }
    }

    /**
     * Traduz o código da situação cadastral e retorna o texto e uma classe CSS.
     */
    private function traduzirSituacaoCadastral(int $codigo): array
    {
        switch ($codigo) {
            case 2:
                return ['texto' => 'ATIVA', 'classe' => 'status-active'];
            case 3:
                return ['texto' => 'SUSPENSA', 'classe' => 'status-suspended'];
            case 4:
                return ['texto' => 'BAIXADA', 'classe' => 'status-inactive'];
            case 8:
                return ['texto' => 'NULA', 'classe' => 'status-inactive'];
            default:
                return ['texto' => 'NÃO INFORMADO', 'classe' => 'status-inactive'];
        }
    }

    /**
     * Função central que aplica as novas regras de negócio para encontrar um CNPJ válido.
     *
     * @param string $cnpj
     * @return Empresa|null
     */
    private function findValidEstabelecimento(string $cnpj): ?Empresa
    {
        // 1. Desmonta o CNPJ em suas partes
        $cnpjBase = substr($cnpj, 0, 8);
        $cnpjOrdem = substr($cnpj, 8, 4);
        $cnpjDv = substr($cnpj, 12, 2);

        // 2. Regra das Filiais: Verifica quantos estabelecimentos existem para a raiz (CNPJ base).
        // Se for mais de 1, significa que tem filiais, então consideramos "não encontrado".
        $countFiliais = Estabelecimento::where('cnpj_basico', $cnpjBase)->count();
        if ($countFiliais > 1) {
            return null; // Rejeita CNPJs com filiais para evitar conteúdo duplicado.
        }

        // 3. Regra de Existência: Procura pelo estabelecimento exato.
        // Isso garante que o cnpj_ordem e cnpj_dv também correspondem.
        $estabelecimento = Estabelecimento::where('cnpj_basico', $cnpjBase)
            ->where('cnpj_ordem', $cnpjOrdem)
            ->where('cnpj_dv', $cnpjDv)
            ->first(); // Pega o primeiro (e único) resultado

        // 4. Se encontrou o estabelecimento e ele é único (passou na regra 2),
        // busca a Razão Social na tabela de empresas através da relação.
        if ($estabelecimento) {
            // O Laravel carrega a relação automaticamente se estiver definida no Model.
            // Se a relação não estiver definida, usamos a busca manual.
            return Empresa::find($estabelecimento->cnpj_basico);
        }

        return null; // Retorna nulo se não encontrar o estabelecimento exato.
    }


    /**
     * Função auxiliar para formatar o CNPJ.
     */
    private function formatarCnpj(string $cnpj): string
    {
        return vsprintf('%s.%s.%s/%s-%s', [
            substr($cnpj, 0, 2), substr($cnpj, 2, 3), substr($cnpj, 5, 3),
            substr($cnpj, 8, 4), substr($cnpj, 12, 2)
        ]);
    }

    /**
     * Encontra empresas semelhantes com base no CNAE e localização,
     * garantindo que as semelhantes também sejam matrizes sem filiais.
     *
     * @param \App\Models\Estabelecimento $estabelecimento
     * @return array
     */
    private function findSimilarCompanies(Estabelecimento $estabelecimento): array
    {
        $cnaePrincipal = $estabelecimento->cnae_fiscal_principal;
        $municipio = $estabelecimento->municipio;
        $uf = $estabelecimento->uf;
        $cnpjBaseAtual = $estabelecimento->cnpj_basico;
        $limit = 8;

        // VALIDAÇÃO ADICIONADA: Só busca empresas que tenham exatamente 1 estabelecimento.
        $validationRule = function ($query) {
            $query->has('estabelecimentos', '=', 1);
        };

        // ETAPA 1: Busca na mesma CIDADE
        $semelhantesNaCidade = Estabelecimento::where('cnae_fiscal_principal', $cnaePrincipal)
            ->where('municipio', $municipio)
            ->where('cnpj_basico', '!=', $cnpjBaseAtual)
            // APLICA A REGRA DE VALIDAÇÃO:
            ->whereHas('empresa', $validationRule)
            ->with('empresa:cnpj_basico,razao_social')
            ->limit($limit)
            ->get();
            
        if ($semelhantesNaCidade->count() >= $limit) {
            return $this->formatSimilarCompanies($semelhantesNaCidade);
        }

        // ETAPA 2: Busca no ESTADO para completar
        $necessarios = $limit - $semelhantesNaCidade->count();
        $cnpjsJaEncontrados = $semelhantesNaCidade->pluck('cnpj_basico')->push($cnpjBaseAtual);
        
        $semelhantesNoEstado = Estabelecimento::where('cnae_fiscal_principal', $cnaePrincipal)
            ->where('uf', $uf)
            ->whereNotIn('cnpj_basico', $cnpjsJaEncontrados)
            // APLICA A REGRA DE VALIDAÇÃO AQUI TAMBÉM:
            ->whereHas('empresa', $validationRule)
            ->with('empresa:cnpj_basico,razao_social')
            ->limit($necessarios)
            ->get();
        
        $empresasSemelhantes = $semelhantesNaCidade->merge($semelhantesNoEstado);

        return $this->formatSimilarCompanies($empresasSemelhantes);
    }

     

    /**
     * Formata a coleção de empresas semelhantes para a view.
     */
    private function formatSimilarCompanies($collection): array
    {
        return $collection->map(function ($est) {
            $cnpjCompleto = $est->cnpj_basico . $est->cnpj_ordem . $est->cnpj_dv;
            return [
                'razao_social' => $est->empresa->razao_social,
                'cidade_uf' => ($est->municipioRel->descricao ?? '') . ' / ' . $est->uf,
                'url' => route('cnpj.show', ['cnpj' => $cnpjCompleto]),
            ];
        })->toArray();
    }

}
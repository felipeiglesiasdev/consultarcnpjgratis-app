@props(['data'])

<section id="informacoes-gerais" class="bg-white border border-gray-200 rounded-lg p-6 md:p-8">
    {{-- Conteúdo de Texto --}}
    <div>
        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900">
            {{ $data['razao_social'] }}
        </h1>
        
        @if($data['nome_fantasia'] && $data['nome_fantasia'] !== $data['razao_social'])
            <h2 class="text-lg text-gray-500 mt-1">
                {{ $data['nome_fantasia'] }}
            </h2>
        @endif

        {{-- Parágrafo corrigido para usar os dados já formatados do controller --}}
        <p class="mt-4 text-gray-700 leading-relaxed">
            A empresa <strong class="font-semibold">{{ $data['razao_social'] }}</strong>, com o CNPJ <strong class="font-semibold">{{ $data['cnpj_completo'] }}</strong>, iniciou suas operações em <strong class="font-semibold">{{ $data['data_abertura'] }}</strong>. Localizada em <strong class="font-semibold">{{ $data['cidade_uf'] }}</strong>, sua atividade principal é <strong class="font-semibold">{{ $data['cnae_principal']['descricao'] }}</strong>.
        </p>
    </div>
</section>


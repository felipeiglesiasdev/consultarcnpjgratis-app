@props(['estados'])

@php
    // Mapeamento de siglas para nomes completos dos estados
    $nomesEstados = [
        'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará',
        'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
        'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo',
        'SE' => 'Sergipe', 'TO' => 'Tocantins'
    ];
@endphp

{{-- A seção agora não tem o fundo de card, apenas o cabeçalho e a lista --}}
<section class="mb-16">
    
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">
            Navegue por Estado
        </h2>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Selecione um estado abaixo para explorar as empresas registradas em suas cidades.
        </p>
    </div>

    {{-- 
        Grid responsivo:
        - Padrão (mobile): 2 colunas
        - Telas grandes (lg): 9 colunas (conforme solicitado)
    --}}
    <ul class="grid grid-cols-2 lg:grid-cols-9 gap-4">
        @foreach($estados as $estado)
            @php
                $nomeCompleto = $nomesEstados[$estado->uf] ?? $estado->uf;
            @endphp
            <li>
                <a href="{{ route('empresas.state', ['uf' => strtolower($estado->uf)]) }}" 
                   class="block p-3 border border-gray-200 rounded-lg text-center 
                          transition-all duration-200 shadow-sm bg-white
                          hover:bg-[#7fdea0] hover:border-green-400 hover:text-gray-900 
                          hover:scale-105 hover:shadow-lg group">
                    
                    {{-- Sigla do Estado em destaque --}}
                    <span class="block font-bold text-base text-gray-800 group-hover:text-black">
                        {{ $estado->uf }}
                    </span>
                    {{-- Nome completo do Estado (menor) --}}
                    <span class="block text-xs text-gray-500 group-hover:text-black truncate" title="{{ $nomeCompleto }}">
                        {{ $nomeCompleto }}
                    </span>
                </a>
            </li>
        @endforeach
    </ul>

</section>
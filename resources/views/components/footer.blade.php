@php
    // Mapeamento de dados para os links do rodapé
    $footerStates = [
        'SP' => 'São Paulo',
        'RJ' => 'Rio de Janeiro',
        'MG' => 'Minas Gerais',
        'BA' => 'Bahia',
        'RS' => 'Rio Grande do Sul',
    ];

    $footerCnaes = [
        '5611201' => 'Restaurantes',
        '4781400' => 'Comércio de Vestuário',
        '4120400' => 'Construção de Edifícios',
        '8610101' => 'Atividades de Atendimento Hospitalar',
        '4930202' => 'Transporte de Carga',
    ];

    $footerStatus = [
        'ativas'    => 'Ativas',
        'suspensas' => 'Suspensas',
        'inaptas'   => 'Inaptas',
        'baixadas'  => 'Baixadas',
        'nulas'     => 'Nulas',
    ];
@endphp

<footer class="bg-[#171717] text-white">
    <div class="container mx-auto px-4 py-12 md:py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-12 gap-8">
            
            {{-- Coluna 1: Logo e Descrição --}}
            <div class="col-span-2 md:col-span-4 lg:col-span-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 mb-4">
                    <div class="bg-gray-700 p-2 rounded-full">
                        <svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-white">
                        Consultar CNPJ <span class="text-green-400">Grátis</span>
                    </span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Ferramenta gratuita para consulta de dados públicos de empresas brasileiras, em conformidade com a Lei de Acesso à Informação.
                </p>
            </div>

            {{-- Coluna 2: Por Estado --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-2">
                <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Por Estado</h3>
                <ul class="mt-4 space-y-3">
                    @foreach ($footerStates as $uf => $nome)
                        <li><a href="{{ route('empresas.state', ['uf' => strtolower($uf)]) }}" class="text-gray-400 hover:text-white transition">{{ $nome }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Coluna 3: Por Atividade (CNAE) --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Principais Atividades</h3>
                <ul class="mt-4 space-y-3">
                     @foreach ($footerCnaes as $codigo => $nome)
                        <li><a href="{{ route('empresas.cnae.show', ['codigo_cnae' => $codigo]) }}" class="text-gray-400 hover:text-white transition">{{ $nome }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Coluna 4: Por Situação --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-2">
                <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Por Situação</h3>
                <ul class="mt-4 space-y-3">
                    @foreach ($footerStatus as $slug => $nome)
                        <li><a href="{{ route('empresas.status', ['status_slug' => $slug]) }}" class="text-gray-400 hover:text-white transition">{{ $nome }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Coluna 5: Legal --}}
            <div class="col-span-1 md:col-span-2 lg:col-span-2">
                <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Legal</h3>
                <ul class="mt-4 space-y-3">
                    {{-- Links legais continuam com nofollow --}}
                    <li><a href="{{ route('privacy.policy') }}" class="text-gray-400 hover:text-white transition" rel="nofollow">Privacidade</a></li>
                    <li><a href="{{ route('privacy.policy') }}#termos-de-uso" class="text-gray-400 hover:text-white transition" rel="nofollow">Termos de Uso</a></li>
                </ul>
            </div>
        </div>

        {{-- Barra Inferior: Copyright e Aviso --}}
        <div class="mt-12 pt-8 border-t border-gray-700 text-center text-gray-500 text-xs">
            <p class="mb-2">
                &copy; {{ date('Y') }} Consultar CNPJ Grátis. Todos os direitos reservados.
            </p>
            <p>
                As informações exibidas são dados públicos, em conformidade com a 
                <a href="https://www.planalto.gov.br/ccivil_03/_ato2011-2014/2011/lei/l12527.htm" target="_blank" rel="nofollow noopener" class="hover:text-gray-300 underline">Lei de Acesso à Informação (Nº 12.527/2011)</a>.
            </p>
        </div>
    </div>
</footer>
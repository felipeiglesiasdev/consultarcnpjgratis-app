@props(['status', 'newCompaniesCounts', 'statusCounts'])

@php
    // CORREÇÃO APLICADA AQUI:
    // Garantindo que cada status tenha a chave 'code' correspondente ao ID do banco.
    $statusMap = [
        'ativas'    => ['nome' => 'Ativas',    'slug' => 'ativas',    'color' => 'green',  'code' => '2'],
        'suspensas' => ['nome' => 'Suspensas', 'slug' => 'suspensas', 'color' => 'yellow', 'code' => '3'],
        'inaptas'   => ['nome' => 'Inaptas',   'slug' => 'inaptas',   'color' => 'orange', 'code' => '4'],
        'baixadas'  => ['nome' => 'Baixadas',  'slug' => 'baixadas',  'color' => 'red',    'code' => '8'],
        'nulas'     => ['nome' => 'Nulas',     'slug' => 'nulas',     'color' => 'gray',   'code' => '1'],
    ];
@endphp

<section>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
        
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-5">
                Por Situação Cadastral
            </h3>
            <p class="text-gray-600 mb-6">
                Filtre empresas pela sua situação na Receita Federal.
            </p>
            <ul class="space-y-2">
                @foreach($statusMap as $info)
                    {{-- A condição agora usa a chave 'code' para encontrar a contagem correta --}}
                    @if(isset($statusCounts[$info['code']]) && $statusCounts[$info['code']] > 0)
                    <li class="group">
                        <a href="{{ route('empresas.status', ['status_slug' => $info['slug']]) }}" 
                           class="flex items-center justify-between p-1.5 rounded-md transition-colors hover:bg-gray-50">
                            
                            <span class="flex items-center">
                                <span @class(['w-2.5 h-2.5 rounded-full mr-3',
                                    'bg-green-500' => $info['color'] === 'green',
                                    'bg-yellow-500' => $info['color'] === 'yellow',
                                    'bg-orange-500' => $info['color'] === 'orange',
                                    'bg-red-500' => $info['color'] === 'red',
                                    'bg-gray-400' => $info['color'] === 'gray',
                                ])></span>
                                <span class="text-sm text-gray-700 font-medium group-hover:text-black">{{ $info['nome'] }}</span>
                            </span>

                            <span class="text-xs font-bold text-gray-500 bg-gray-100 group-hover:bg-gray-200 px-2 py-0.5 rounded-full transition-colors">
                                {{ number_format($statusCounts[$info['code']], 0, ',', '.') }}
                            </span>
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200 flex flex-col">
             <h3 class="text-2xl font-bold text-gray-800 mb-2">
                Novas Empresas por Ano
            </h3>
            <p class="text-sm text-gray-500 mb-6">
                Contagem de empresas abertas nos últimos anos.
                <span class="block text-xs mt-1">*Última atualização dos dados em Setembro de 2025.</span>
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 flex-grow content-center">
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <p class="font-bold text-2xl text-green-700">{{ number_format($newCompaniesCounts['2025'], 0, ',', '.') }}</p>
                    <p class="text-xs font-semibold text-green-800/80">Abertas em 2025</p>
                </div>
                <div class="bg-gray-100/80 rounded-lg p-4 text-center">
                    <p class="font-bold text-2xl text-gray-700">{{ number_format($newCompaniesCounts['2024'], 0, ',', '.') }}</p>
                    <p class="text-xs font-semibold text-gray-600">Abertas em 2024</p>
                </div>
                <div class="bg-gray-100/80 rounded-lg p-4 text-center">
                    <p class="font-bold text-2xl text-gray-700">{{ number_format($newCompaniesCounts['2023'], 0, ',', '.') }}</p>
                    <p class="text-xs font-semibold text-gray-600">Abertas em 2023</p>
                </div>
            </div>

        </div>

    </div>
</section>
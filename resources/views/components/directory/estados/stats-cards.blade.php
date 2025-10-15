@props(['totalAtivas', 'topCidades', 'statusCounts'])

@php
    // Mapeamento de status com a cor laranja corrigida
    $statusMap = [
        '2' => ['nome' => 'Ativas', 'slug' => 'ativas', 'color' => 'green'],
        '3' => ['nome' => 'Suspensas', 'slug' => 'suspensas', 'color' => 'yellow'],
        '4' => ['nome' => 'Inaptas', 'slug' => 'inaptas', 'color' => 'orange'], // Cor Laranja
        '8' => ['nome' => 'Baixadas', 'slug' => 'baixadas', 'color' => 'red'],
        '1' => ['nome' => 'Nulas', 'slug' => 'nulas', 'color' => 'gray'],
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 text-center flex flex-col justify-center">
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Empresas Ativas</p>
        <p class="text-5xl font-bold text-gray-800 mt-2">{{ number_format($totalAtivas, 0, ',', '.') }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200">
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider text-center mb-4">Cidades com Maior Atividade</p>
        <ul class="space-y-3">
            @foreach($topCidades as $cidade)
            <li class="flex justify-between items-center text-sm border-b border-gray-100 pb-2">
                <span class="text-gray-700 font-medium">{{ $loop->iteration }}. {{ $cidade->descricao }}</span>
                <span class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded-md">{{ number_format($cidade->total_empresas, 0, ',', '.') }}</span>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200">
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider text-center mb-4">Situação Cadastral</p>
        <ul class="space-y-2">
            @foreach($statusMap as $codigo => $info)
                @if(isset($statusCounts[$codigo]) && $statusCounts[$codigo] > 0)
                <li class="group">
                    <a href="{{ route('empresas.status', ['status_slug' => $info['slug']]) }}" class="flex items-center justify-between p-1.5 rounded-md transition-colors hover:bg-gray-50">
                        <span class="flex items-center">
                            <span @class(['w-2.5 h-2.5 rounded-full mr-3',
                                'bg-green-500' => $info['color'] === 'green',
                                'bg-yellow-500' => $info['color'] === 'yellow',
                                'bg-orange-500' => $info['color'] === 'orange', // Classe para Laranja
                                'bg-red-500' => $info['color'] === 'red',
                                'bg-gray-400' => $info['color'] === 'gray',
                            ])></span>
                            <span class="text-sm text-gray-700 font-medium group-hover:text-black">{{ $info['nome'] }}</span>
                        </span>
                        <span class="text-xs font-bold text-gray-500 bg-gray-100 group-hover:bg-gray-200 px-2 py-0.5 rounded-full transition-colors">
                            {{ number_format($statusCounts[$codigo], 0, ',', '.') }}
                        </span>
                    </a>
                </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
@props(['status'])

@php
    $statusMap = [
        'ativas' => ['nome' => 'Ativas', 'slug' => 'ativas', 'color' => 'green'],
        'suspensas' => ['nome' => 'Suspensas', 'slug' => 'suspensas', 'color' => 'yellow'],
        'inaptas' => ['nome' => 'Inaptas', 'slug' => 'inaptas', 'color' => 'yellow'],
        'baixadas' => ['nome' => 'Baixadas', 'slug' => 'baixadas', 'color' => 'red'],
        'nulas' => ['nome' => 'Nulas', 'slug' => 'nulas', 'color' => 'gray'],
    ];
@endphp

<section>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800 mb-5">
                Por Situação Cadastral
            </h3>
            <p class="text-gray-600 mb-6">
                Filtre empresas pela sua situação na Receita Federal.
            </p>
            <ul class="space-y-3">
                @foreach($statusMap as $statusInfo)
                    @if(in_array($statusInfo['slug'], array_keys($status)))
                    <li>
                        <a href="{{ route('empresas.status', ['status_slug' => $statusInfo['slug']]) }}" 
                           class="flex items-center text-gray-700 hover:text-blue-600 transition-colors group font-medium p-2.5 rounded-md hover:bg-gray-50">
                            <span @class([
                                'w-2.5 h-2.5 rounded-full mr-3',
                                'bg-green-500' => $statusInfo['color'] === 'green',
                                'bg-yellow-500' => $statusInfo['color'] === 'yellow',
                                'bg-red-500' => $statusInfo['color'] === 'red',
                                'bg-gray-400' => $statusInfo['color'] === 'gray',
                            ])></span>
                            <span class="group-hover:underline">Empresas {{ $statusInfo['nome'] }}</span>
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200">
             <h3 class="text-2xl font-bold text-gray-800 mb-5">
                Empresas Recentes
            </h3>
            <p class="text-gray-600 mb-6">
                Veja os negócios que foram abertos ou registrados no último ano.
            </p>
            <a href="{{ route('empresas.recent') }}" 
               class="inline-block bg-green-500 text-white font-bold py-3 px-5 rounded-lg hover:bg-green-600 transition-colors shadow-md hover:shadow-lg text-center">
                Ver novas empresas &rarr;
            </a>
        </div>
    </div>
</section>
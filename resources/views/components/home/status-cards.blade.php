@props(['statusCounts'])

@php
    $statusMap = [
        '2' => ['nome' => 'Ativas', 'color' => 'green'],
        '8' => ['nome' => 'Baixadas', 'color' => 'red'],
        '3' => ['nome' => 'Suspensas', 'color' => 'yellow'],
        '4' => ['nome' => 'Inaptas', 'color' => 'orange'],
        '1' => ['nome' => 'Nulas', 'color' => 'gray'],
    ];
@endphp

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 text-center">
    @foreach ($statusMap as $code => $info)
        <div @class([
            'bg-white p-6 rounded-xl shadow-lg border border-gray-200 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-xl',
            'border-t-4',
            'border-t-green-500' => $info['color'] === 'green',
            'border-t-red-500' => $info['color'] === 'red',
            'border-t-yellow-500' => $info['color'] === 'yellow',
            'border-t-orange-500' => $info['color'] === 'orange',
            'border-t-gray-400' => $info['color'] === 'gray',
        ])>
            <p @class([
                // CORREÇÃO APLICADA AQUI:
                // text-3xl para mobile, text-4xl para desktop (md:)
                'text-2xl md:text-4xl font-bold mt-2',
                'text-green-600' => $info['color'] === 'green',
                'text-red-600' => $info['color'] === 'red',
                'text-yellow-600' => $info['color'] === 'yellow',
                'text-orange-600' => $info['color'] === 'orange',
                'text-gray-600' => $info['color'] === 'gray',
            ])>
                {{ number_format($statusCounts[$code] ?? 0, 0, ',', '.') }}
            </p>
            <p class="text-sm font-semibold text-gray-500 mt-1">{{ $info['nome'] }}</p>
        </div>
    @endforeach
</div>
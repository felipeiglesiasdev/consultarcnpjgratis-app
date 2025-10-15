@props(['stateCounts', 'statusName'])

@php
    $allStates = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
@endphp

<div class="mb-16">
    <h3 class="text-3xl font-bold text-gray-800 mb-2 text-center">Distribuição de Empresas {{ $statusName }} por Estado</h3>
    <p class="text-gray-600 text-center mb-8">Contagem de empresas com esta situação cadastral em cada estado do Brasil.</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-9 gap-4">
        @foreach ($allStates as $uf)
            <div class="bg-white border border-gray-200 rounded-lg p-4 text-center shadow-sm">
                <p class="font-bold text-lg text-gray-800">{{ $uf }}</p>
                <p class="font-semibold text-green-600 text-xl">{{ number_format($stateCounts[$uf] ?? 0, 0, ',', '.') }}</p>
            </div>
        @endforeach
    </div>
</div>
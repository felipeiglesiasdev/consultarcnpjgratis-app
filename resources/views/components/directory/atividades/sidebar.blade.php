@props(['topEstados'])

<div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 sticky top-8">
    <h3 class="text-lg font-bold text-gray-800 mb-1">Análise do Setor</h3>
    <p class="text-sm text-gray-500 mb-6">Distribuição geográfica</p>
    
    <div class="border-t border-gray-200 pt-6">
        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Estados com mais empresas</p>
        <ul class="mt-4 space-y-3">
            @foreach($topEstados as $estado)
            <li class="flex justify-between items-center text-sm border-b border-gray-100 pb-2">
                <span class="text-gray-700 font-medium">{{ $estado->uf }}</span>
                <span class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded-md">{{ number_format($estado->total, 0, ',', '.') }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>
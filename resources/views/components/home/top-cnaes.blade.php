@props(['topCnaes'])

<div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Top 5 Atividades Mais Comuns</h3>
    <div class="space-y-4">
        @foreach ($topCnaes as $cnae)
            <a href="{{ route('empresas.cnae.show', ['codigo_cnae' => $cnae->codigo]) }}" class="block p-4 border border-gray-200 rounded-lg hover:border-[#7fdea0] hover:bg-green-50/30 group">
                <div class="flex flex-col sm:flex-row sm:justify-between">
                    <div class="flex-1 pr-4">
                        <p class="text-base text-gray-800 font-medium group-hover:text-black">{{ $cnae->descricao }}</p>
                        <span class="text-sm font-semibold text-gray-500">CNAE {{ $cnae->codigo_formatado }}</span>
                    </div>
                    <div class="mt-3 sm:mt-0 text-left sm:text-right">
                        <p class="text-lg font-bold text-gray-700">{{ number_format($cnae->estabelecimentos_count, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 uppercase">empresas</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
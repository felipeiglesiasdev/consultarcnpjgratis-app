@props(['topCnaes', 'statusName'])

<div class="mb-16">
    <h3 class="text-3xl font-bold text-gray-800 mb-2 text-center">Principais Atividades (CNAEs) de Empresas {{ $statusName }}</h3>
    <p class="text-gray-600 text-center mb-8">Os 5 setores com o maior número de empresas nesta situação cadastral.</p>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 max-w-4xl mx-auto">
        <div class="space-y-4">
            @foreach($topCnaes as $cnae)
                <a href="{{ route('empresas.cnae.show', ['codigo_cnae' => $cnae->codigo]) }}" class="block p-4 border border-gray-200 rounded-lg hover:border-[#7fdea0] hover:bg-green-50/30 group">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 pr-4">
                            <p class="text-base text-gray-800 font-medium group-hover:text-black">{{ $cnae->descricao }}</p>
                            <span class="text-sm font-semibold text-gray-500">CNAE {{ (new \App\Models\Cnae(['codigo' => $cnae->codigo]))->codigo_formatado }}</span>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-gray-700">{{ number_format($cnae->total, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">empresas</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@props(['topCnaes'])

<div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
    <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">
        Principais Atividades Econômicas (CNAE) no Estado
    </h3>
    
    <div class="space-y-4">
        @foreach($topCnaes as $cnae)
            <div class="block p-4 border border-gray-200 rounded-lg transition-all duration-200 hover:border-[#7fdea0] hover:bg-green-50/30 hover:shadow-md">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex-1 pr-4">
                        <div class="flex items-center mb-2">
                            <span class="text-sm font-semibold text-green-800 bg-green-100 rounded-md px-2 py-0.5">
                                CNAE {{ (new \App\Models\Cnae(['codigo' => $cnae->codigo]))->codigo_formatado }}
                            </span>
                        </div>
                        <p class="text-base text-gray-800 font-medium leading-tight">
                            {{ $cnae->descricao }}
                        </p>
                    </div>
                    <div class="mt-3 sm:mt-0 text-left sm:text-right">
                        <div class="text-lg font-bold text-gray-700">
                            {{ number_format($cnae->total, 0, ',', '.') }}
                        </div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider">
                            empresas
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
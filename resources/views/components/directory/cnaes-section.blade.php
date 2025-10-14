@props(['topCnaes'])

<section class="mb-16">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">
            Empresas por Atividade Econômica (CNAE)
        </h3>
        <p class="text-gray-600 mb-8">
            Explore as atividades mais comuns entre as empresas registradas no Brasil.
        </p>
        
        <div class="space-y-4">
            @foreach($topCnaes as $cnae)
                <a href="{{ route('empresas.cnae.show', ['cnae_slug' => Str::slug($cnae->descricao)]) }}"
                   class="block p-4 border border-gray-200 rounded-lg transition-all duration-200 
                          hover:border-[#7fdea0] hover:bg-green-50/50 hover:shadow-md group">
                    
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                        
                        {{-- Lado Esquerdo: Código e Descrição --}}
                        <div class="flex-1 pr-4">
                            {{-- Código do CNAE em destaque com a nova cor --}}
                            <div class="flex items-center mb-2">
                                <span class="text-sm font-semibold text-green-800 bg-green-100 rounded-md px-2 py-0.5">
                                    CNAE {{ $cnae->codigo_formatado }}
                                </span>
                            </div>
                            
                            {{-- Descrição completa --}}
                            <p class="text-base text-gray-800 font-medium leading-tight group-hover:text-black">
                                {{ $cnae->descricao }}
                            </p>
                        </div>
                        
                        {{-- Lado Direito: Contagem --}}
                        <div class="mt-3 sm:mt-0 text-left sm:text-right">
                            <div class="text-lg font-bold text-gray-700">
                                {{ number_format($cnae->estabelecimentos_count, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                empresas
                            </div>
                        </div>
                        
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Rodapé com o link para ver tudo --}}
        <div class="mt-8 pt-6 border-t border-gray-200">
            {{-- Usando a cor #94f4a6 no hover, que já está no seu CSS --}}
            <a href="{{ route('empresas.cnae.index') }}" 
               class="font-semibold text-green-600 hover:text-green-700 transition-colors">
                Ver todas as atividades &rarr;
            </a>
        </div>
    </div>
</section>
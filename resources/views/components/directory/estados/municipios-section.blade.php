@props(['municipios', 'uf'])

<div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 mb-16">
    <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">
        Explore as Empresas por Cidade
    </h3>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($municipios as $municipio)
            <a href="{{ route('empresas.city', ['uf' => strtolower($uf), 'cidade_slug' => Str::slug($municipio->descricao)]) }}"
               class="block bg-gray-50/80 border border-gray-200 rounded-lg p-4 text-center
                      transition-all duration-300 shadow-sm
                      hover:border-[#7fdea0] hover:shadow-xl hover:-translate-y-1 group">
                
                <h4 class="font-bold text-gray-800 truncate group-hover:text-black" title="{{ $municipio->descricao }}">
                    {{ $municipio->descricao }}
                </h4>
                <p class="text-sm text-gray-500 mt-1">
                    <span class="font-semibold text-green-600">{{ number_format($municipio->estabelecimentos_count, 0, ',', '.') }}</span>
                    empresas ativas
                </p>
            </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $municipios->links() }}
    </div>
</div>
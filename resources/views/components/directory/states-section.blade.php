@props(['estados'])

<section class="mb-16 bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200">
    
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">
            Navegue por Estado
        </h2>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Selecione um estado abaixo para explorar as empresas registradas em suas cidades.
        </p>
    </div>

    <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($estados as $estado)
            <li>
                {{-- MUDANÇA AQUI: strtolower() na UF para o link --}}
                <a href="{{ route('empresas.state', ['uf' => strtolower($estado->uf)]) }}" 
                   class="block p-4 border border-gray-200 rounded-lg text-gray-800 font-semibold text-center 
                          transition-all duration-200 shadow-sm
                          hover:bg-[#7fdea0] hover:border-[#7fdea0] hover:text-gray-900 
                          hover:scale-105 hover:shadow-lg">
                    {{ $estado->uf }}
                </a>
            </li>
        @endforeach
    </ul>

</section>
@props(['data'])

{{-- 
    'sticky' faz a barra lateral "flutuar" e acompanhar o scroll da página.
    'top-24' (20 do header + 4 de margem) garante que ela pare abaixo do cabeçalho.
--}}
<div>
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Realizar Nova Consulta</h3>
        
        <form action="{{ route('cnpj.consultar') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="cnpj_sidebar" class="sr-only">CNPJ</label>
                <input 
                    type="search" 
                    name="cnpj" 
                    id="cnpj_sidebar"
                    data-mask="cnpj"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#94f4a6] focus:border-transparent sm:text-sm"
                    placeholder="Digite um novo CNPJ"
                    required
                >
            </div>
            <button 
                type="submit"
                class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-[#171717] bg-[#7fdea0]  hover:bg-green-600 transition cursor-pointer"
                title="Consultar novo CNPJ"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Consultar
            </button>
        </form>
    </div>
</div>


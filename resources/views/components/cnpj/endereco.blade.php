@props(['data'])

<div id="endereco" class="bg-white border border-gray-200 rounded-lg shadow-sm mt-8">
    {{-- Cabeçalho do Card --}}
    <div class="flex items-center p-4 border-b border-gray-200">
        <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </span>
        <h2 class="text-lg font-semibold text-gray-800">Endereço</h2>
    </div>

    {{-- Corpo do Card --}}
    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
            {{-- Logradouro --}}
            <div class="flex flex-col sm:col-span-2">
                <span class="text-sm font-medium text-gray-500">Logradouro</span>
                <span class="text-base text-gray-800">{{ $data['logradouro'] }}</span>
            </div>
            {{-- Bairro --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Bairro</span>
                <span class="text-base text-gray-800">{{ $data['bairro'] }}</span>
            </div>
             {{-- Complemento --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Complemento</span>
                <span class="text-base text-gray-800">{{ $data['complemento'] ?? 'N/A' }}</span>
            </div>
            {{-- Cidade/UF --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">Cidade / UF</span>
                <span class="text-base text-gray-800">{{ $data['cidade_uf'] }}</span>
            </div>
            {{-- CEP --}}
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">CEP</span>
                <span class="text-base text-gray-800">{{ $data['cep'] }}</span>
            </div>
        </div>
    </div>
</div>

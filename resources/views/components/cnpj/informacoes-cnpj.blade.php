@props(['data'])

<div class="bg-white border border-gray-200 rounded-lg shadow-sm mt-8">
    {{-- Cabeçalho do Card --}}
    <div class="flex items-center p-4 border-b border-gray-200">
        <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 4h5m-5 4h5"></path></svg>
        </span>
        <h2 class="text-lg font-semibold text-gray-800">Informações do CNPJ</h2>
    </div>

    {{-- Corpo do Card com as informações em Grid --}}
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
        {{-- CNPJ --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">CNPJ</span>
            <span class="text-base text-gray-800">{{ $data['cnpj_completo'] }}</span>
        </div>

        {{-- Razão Social --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Razão Social</span>
            <span class="text-base text-gray-800">{{ $data['razao_social'] }}</span>
        </div>

        {{-- Nome Fantasia --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Nome Fantasia</span>
            <span class="text-base text-gray-800">{{ $data['nome_fantasia'] ?? 'Não informado' }}</span>
        </div>

        {{-- Natureza Jurídica --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Natureza Jurídica</span>
            <span class="text-base text-gray-800">{{ $data['natureza_juridica'] }}</span>
        </div>

        {{-- Capital Social --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Capital Social</span>
            <span class="text-base text-gray-800">R$ {{ $data['capital_social'] }}</span>
        </div>

        {{-- Porte da Empresa --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Porte da Empresa</span>
            <span class="text-base text-gray-800">{{ $data['porte'] ?? 'Não informado' }}</span>
        </div>

        {{-- Matriz ou Filial --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Tipo</span>
            <span class="text-base text-gray-800">{{ $data['matriz_ou_filial'] }}</span>
        </div>
        
        {{-- Data de Abertura --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Data de Abertura</span>
            <span class="text-base text-gray-800">{{ $data['data_abertura'] }}</span>
        </div>
    </div>
</div>

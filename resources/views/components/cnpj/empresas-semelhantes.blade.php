@props(['data'])
    
@if (!empty($data['empresas_semelhantes']))
<div id="empresas-semelhantes" class="bg-white border border-gray-200 rounded-lg shadow-sm mt-8">
    {{-- Cabeçalho do Card --}}
    <div class="flex items-center p-4 border-b border-gray-200">
        <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h4a2 2 0 012 2v2m-6 0h6"></path></svg>
        </span>
        <h2 class="text-lg font-semibold text-gray-800">Empresas Semelhantes</h2>
    </div>

    {{-- Corpo do Card --}}
    <div class="p-6">
        <p class="text-sm text-gray-600 mb-6">
            Listando empresas com a mesma atividade principal (<strong class="font-medium">{{ $data['similar_context']['cnae_descricao'] }}</strong>), localizadas em <strong class="font-medium">{{ $data['similar_context']['cidade'] }}</strong>.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($data['empresas_semelhantes'] as $semelhante)
                <a href="{{ $semelhante['url'] }}" title="Consultar CNPJ de {{ $semelhante['razao_social'] }}" class="block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-green-300 transition-all duration-200">
                    <p class="font-semibold text-base text-gray-800 truncate">{{ $semelhante['razao_social'] }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $semelhante['cidade_uf'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

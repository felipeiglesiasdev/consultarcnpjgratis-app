@props(['data'])

<div id="atividades-economicas" class="bg-white border border-gray-200 rounded-lg shadow-sm mt-8">
    {{-- Cabeçalho do Card --}}
    <div class="flex items-center p-4 border-b border-gray-200">
        <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </span>
        <h2 class="text-lg font-semibold text-gray-800">Atividades Econômicas (CNAE)</h2>
    </div>

    {{-- Corpo do Card --}}
    <div class="p-6">
        <h3 class="text-md font-semibold text-gray-700">Atividade Principal</h3>
        <div class="mt-2 p-4 bg-gray-50 rounded-md border border-gray-200">
            <p class="font-mono text-sm text-gray-500">{{ $data['cnae_principal']['codigo'] }}</p>
            <p class="mt-1 text-base text-gray-800">{{ $data['cnae_principal']['descricao'] }}</p>
        </div>

        @if (!empty($data['cnaes_secundarios']))
            <h3 class="text-md font-semibold text-gray-700 mt-6">Atividades Secundárias</h3>
            <ul class="mt-2 space-y-3">
                @foreach ($data['cnaes_secundarios'] as $cnae)
                    <li class="p-4 border border-gray-200 rounded-md">
                        <p class="font-mono text-sm text-gray-500">{{ $cnae['codigo'] }}</p>
                        <p class="mt-1 text-base text-gray-800">{{ $cnae['descricao'] }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

@props(['data'])

{{-- Define as classes de cor do Tailwind para cada status --}}
@php
    $statusClasses = [
        'green' => 'bg-green-100 text-green-800',
        'red' => 'bg-red-100 text-red-800',
        'yellow' => 'bg-yellow-100 text-yellow-800',
        'gray' => 'bg-gray-100 text-gray-800',
    ];
    $badgeClass = $statusClasses[$data['situacao_cadastral_classe']] ?? $statusClasses['gray'];
@endphp

<div id="situacao-cadastral" class="bg-white border border-gray-200 rounded-lg shadow-sm mt-8">
    {{-- Cabeçalho do Card --}}
    <div class="flex items-center p-4 border-b border-gray-200">
        <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </span>
        <h2 class="text-lg font-semibold text-gray-800">Situação Cadastral</h2>
    </div>

    {{-- Corpo do Card --}}
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
        {{-- Situação --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Status</span>
            <span class="text-base text-gray-800">
                <span class="px-2.5 py-0.5 rounded-full text-sm font-medium {{ $badgeClass }}">
                    {{ $data['situacao_cadastral'] }}
                </span>
            </span>
        </div>

        {{-- Data da Situação --}}
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Data da Situação</span>
            <span class="text-base text-gray-800">{{ $data['data_situacao_cadastral'] }}</span>
        </div>
    </div>
</div>

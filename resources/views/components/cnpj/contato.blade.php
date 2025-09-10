@props(['data'])

@if (!empty($data['telefone_1']) || !empty($data['telefone_2']) || !empty($data['email']))
<div id="contato" class="bg-white border border-gray-200 rounded-lg shadow-sm mt-8">
    {{-- Cabeçalho do Card --}}
    <div class="flex items-center p-4 border-b border-gray-200">
        <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100 text-gray-600 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
        </span>
        <h2 class="text-lg font-semibold text-gray-800">Contato</h2>
    </div>

    {{-- Corpo do Card --}}
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
        @if($data['telefone_1'])
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Telefone 1</span>
            <a href="tel:{{ preg_replace('/\\D/', '', $data['telefone_1']) }}" rel="nofollow" class="text-base text-green-600 hover:underline">{{ $data['telefone_1'] }}</a>
        </div>
        @endif

        @if($data['telefone_2'])
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500">Telefone 2</span>
            <a href="tel:{{ preg_replace('/\\D/', '', $data['telefone_2']) }}" rel="nofollow" class="text-base text-green-600 hover:underline">{{ $data['telefone_2'] }}</a>
        </div>
        @endif
        
        @if($data['email'])
        <div class="flex flex-col md:col-span-2">
            <span class="text-sm font-medium text-gray-500">E-mail</span>
            <a href="mailto:{{ strtolower($data['email']) }}" rel="nofollow" class="text-base text-green-600 hover:underline break-all">{{ strtolower($data['email']) }}</a>
        </div>
        @endif
    </div>
</div>
@endif

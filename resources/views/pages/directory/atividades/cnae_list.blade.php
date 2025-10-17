@extends('layouts.app')

@php
    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => 'Atividades Econômicas', 'url' => ''],
    ];
@endphp

@section('title', 'Pesquisar Atividades Econômicas (CNAE)')
@section('description', 'Pesquise em tempo real por código ou descrição da atividade econômica (CNAE) para encontrar empresas por setor.')

@section('content')
<div class="bg-gray-50/50 mt-16">
    <div class="container mx-auto px-4 py-12 md:py-16"
         {{-- Início do componente Alpine.js --}}
         x-data='{
             searchTerm: "",
             allCnaes: {{ $allCnaes }},
             get filteredCnaes() {
                 if (this.searchTerm.length < 2) {
                     return [];
                 }
                 return this.allCnaes.filter(
                     cnae => cnae.descricao.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                             cnae.codigo.toString().includes(this.searchTerm)
                 );
             }
         }'>

        <x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

        {{-- Cabeçalho e Input de Busca --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800">
                Explore por Atividade Econômica
            </h1>
            <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                Digite um código ou palavra-chave para encontrar o CNAE em tempo real.
            </p>

            <div class="mt-8 max-w-2xl mx-auto relative">
                {{-- Ícone de Lupa --}}
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                {{-- Input controlado pelo Alpine.js --}}
                <input type="search" x-model.debounce.300ms="searchTerm"
                       placeholder="Pesquise por código ou descrição (Ex: Restaurante)"
                       class="w-full py-4 pl-14 pr-6 text-lg text-gray-800 placeholder-gray-500 bg-white border-2 border-gray-300 rounded-full shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all">
            </div>
        </div>
        
        {{-- SEÇÃO DE RESULTADOS DA BUSCA (aparece quando o usuário digita) --}}
        <div x-show="searchTerm.length >= 2" x-transition class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Resultados para: <span class="text-green-600" x-text="searchTerm"></span>
            </h2>
            <div class="space-y-4">
                {{-- Loop através dos resultados filtrados pelo Alpine.js --}}
                <template x-for="cnae in filteredCnaes.slice(0, 50)" :key="cnae.codigo">
                    <a :href="`{{ route('empresas.cnae.index') }}/${cnae.codigo}`" class="block p-4 border border-gray-200 rounded-lg hover:border-[#7fdea0] hover:bg-green-50/30 group">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 pr-4">
                                <p class="text-base text-gray-800 font-medium" x-html="cnae.descricao.replace(new RegExp(searchTerm, 'gi'), `<span class='bg-yellow-200'>${searchTerm}</span>`)"></p>
                                <span class="text-sm font-semibold text-gray-500" x-text="`CNAE: ${cnae.codigo}`"></span>
                            </div>
                        </div>
                    </a>
                </template>
                {{-- Mensagem se não houver resultados --}}
                <div x-show="filteredCnaes.length === 0" class="text-center text-gray-500 py-12">
                    <p>Nenhuma atividade encontrada com este termo.</p>
                </div>
            </div>
        </div>

        {{-- SEÇÃO DE DESTAQUES (aparece quando a busca está vazia) --}}
        <div x-show="searchTerm.length < 2" x-transition>
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Principais Setores em Atividade no Brasil</h2>
                <p class="mt-2 text-gray-600">As 3 atividades econômicas com o maior número de empresas ativas no país.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @foreach($topCnaes as $cnae)
                    <a href="{{ route('empresas.cnae.show', ['codigo_cnae' => $cnae->codigo]) }}" 
                       class="block bg-white rounded-2xl shadow-lg p-8 border border-gray-200 text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group">
                        <span class="text-sm font-semibold text-green-800 bg-green-100 rounded-full px-4 py-1">CNAE {{ $cnae->codigo_formatado }}</span>
                        <h3 class="mt-4 text-xl font-bold text-gray-900 group-hover:text-green-600 transition-colors h-24 flex items-center justify-center">{{ $cnae->descricao }}</h3>
                        <div class="mt-6">
                            <p class="text-4xl font-extrabold text-gray-800">{{ number_format($cnae->estabelecimentos_count, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500 uppercase tracking-wider mt-1">Empresas Ativas</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
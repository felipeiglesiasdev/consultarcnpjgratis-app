@extends('layouts.app')

@php
    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => 'Atividades Econômicas', 'url' => ''],
    ];
@endphp

@section('title', 'Lista de Atividades Econômicas (CNAE)')
@section('description', 'Navegue por todas as atividades econômicas (CNAE) e encontre empresas por setor de atuação em todo o Brasil.')

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-16">

        <x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

        {{-- Cabeçalho --}}
        <div class="mb-12">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800">
                Atividades Econômicas (CNAE)
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                Índice completo de setores empresariais. Clique em uma atividade para ver as empresas relacionadas.
            </p>
        </div>
        
        {{-- Lista de CNAEs --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
            <div class="space-y-4">
                @foreach($cnaes as $cnae)
                    <a href="{{ route('empresas.cnae.show', ['codigo_cnae' => $cnae->codigo]) }}"
                       class="block p-4 border border-gray-200 rounded-lg transition-all duration-200 
                              hover:border-[#7fdea0] hover:bg-green-50/30 hover:shadow-md group">
                        
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex-1 pr-4">
                                <span class="text-sm font-semibold text-green-800 bg-green-100 rounded-md px-2 py-0.5">
                                    CNAE {{ $cnae->codigo_formatado }}
                                </span>
                                <p class="mt-2 text-base text-gray-800 font-medium leading-tight group-hover:text-black">
                                    {{ $cnae->descricao }}
                                </p>
                            </div>
                            <div class="mt-3 sm:mt-0 text-left sm:text-right">
                                <div class="text-lg font-bold text-gray-700">
                                    {{ number_format($cnae->estabelecimentos_count, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">
                                    empresas
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Paginação --}}
            <div class="mt-8">
                {{ $cnaes->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
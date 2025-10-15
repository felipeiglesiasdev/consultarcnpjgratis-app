@extends('layouts.app')

@php
    // Define as variáveis de SEO
    $title = "Empresas de {$cnae->descricao} | Consultar CNPJ Grátis";
    $description = "Veja uma amostra de empresas do setor de {$cnae->descricao}. Encontre CNPJs, dados e informações de contato.";
    $keywords = "cnae {$cnae->codigo_formatado}, {$cnae->descricao}, empresas de {$cnae->descricao}, setor de {$cnae->descricao}, cnpj";

    // Define os breadcrumbs
    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => 'Atividades', 'url' => route('empresas.cnae.index')],
        ['title' => Str::limit($cnae->descricao, 30), 'url' => ''],
    ];
@endphp

{{-- Empurra o componente de tags para o stack 'seo' --}}
@push('seo')
    @include('components.directory.atividades.tags', compact('title', 'description', 'keywords'))
@endpush

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-16">

        <x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

        {{-- Cabeçalho da página --}}
        <div class="mb-12 border-b border-gray-200 pb-8">
            <span class="text-sm font-semibold text-green-800 bg-green-100 rounded-full px-4 py-1">
                CNAE {{ $cnae->codigo_formatado }}
            </span>
            <h1 class="mt-4 text-4xl lg:text-5xl font-extrabold text-gray-800 tracking-tight">
                {{ $cnae->descricao }}
            </h1>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl">
                Análise do setor: veja os estados com maior concentração e uma amostra de 50 empresas ativas nesta atividade.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Componente da Sidebar de Estatísticas --}}
            <div class="lg:col-span-4 xl:col-span-3">
                <x-directory.atividades.sidebar :topEstados="$topEstados" />
            </div>

            {{-- Componente da Amostra de Empresas --}}
            <div class="lg:col-span-8 xl:col-span-9">
                <x-directory.atividades.company-sample :empresas="$empresas" />
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@php
    $title = 'Explorar Empresas por Estado, Atividade e Status | Consultar CNPJ Grátis';
    $description = 'Navegue por todas as empresas do Brasil. Encontre CNPJs por estado, cidade, atividade econômica (CNAE) ou situação cadastral de forma fácil.';
    $keywords = 'consultar cnpj, empresas por estado, empresas por cnae, lista de empresas, dados de empresas, cnpj grátis, diretório de empresas, busca por cnpj';
@endphp

@push('seo')
    @include('components.directory.empresas.tags', [
        'title' => $title, 
        'description' => $description,
        'keywords' => $keywords
    ])
@endpush

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-20">
        <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800 text-center mb-16">
            Explore o Mapa de Empresas do Brasil
        </h1>
        <x-directory.empresas.states-section :estados="$estados" />
        <x-directory.empresas.cnaes-section :topCnaes="$topCnaes" />
        <x-directory.empresas.other-explorations :status="$status" :newCompaniesCounts="$newCompaniesCounts" :statusCounts="$statusCounts" />
        <x-public-data-notice />
    </div>
    
</div>
@endsection
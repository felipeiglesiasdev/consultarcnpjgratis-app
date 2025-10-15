@extends('layouts.app')

@php
    $nomesEstados = [
        'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará',
        'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
        'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo',
        'SE' => 'Sergipe', 'TO' => 'Tocantins'
    ];
    $nomeEstado = $nomesEstados[$uf] ?? $uf;

    // Define as variáveis de SEO para esta página
    $title = "Empresas em {$nomeEstado} ({$uf}) - Cidades, Status e CNAEs";
    $description = "Análise de empresas em {$nomeEstado}. Navegue por cidade, filtre por situação cadastral e veja as principais atividades econômicas (CNAEs).";
    $keywords = "empresas em {$nomeEstado}, empresas em {$uf}, lista de empresas {$nomeEstado}, cnae {$nomeEstado}, cnpj {$nomeEstado}";

    // Define os breadcrumbs
    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => $nomeEstado, 'url' => ''],
    ];
@endphp

{{-- Empurra o componente de tags para o stack 'seo' --}}
@push('seo')
    @include('components.directory.estados.tags', [
        'title' => $title, 
        'description' => $description,
        'keywords' => $keywords
    ])
@endpush

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-16">

        <x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />
        <div class="text-center mb-16">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800">
                Análise de Empresas em {{ $nomeEstado }}
            </h1>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                Explore dados sobre o ambiente de negócios no estado, navegue por cidades ou filtre por situação cadastral.
            </p>
        </div>
        <x-directory.estados.stats-cards :totalAtivas="$totalAtivas" :topCidades="$topCidades" :statusCounts="$statusCounts" />
        <x-directory.estados.municipios-section :municipios="$municipios" :uf="$uf"/>
        <x-directory.estados.top-cnaes-section :topCnaes="$topCnaes" />

    </div>
</div>
@endsection
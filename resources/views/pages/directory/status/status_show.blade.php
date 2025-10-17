@extends('layouts.app')

@php
    $nomeStatus = $statusInfo['nome'];

    $title = "Empresas {$nomeStatus}: Análise, Estatísticas e Dados";
    $description = "Veja a análise completa de empresas com situação cadastral '{$nomeStatus}'. Dados por estado, principais atividades e uma lista de CNPJs.";
    $keywords = "empresas {$nomeStatus}, cnpj {$nomeStatus}, lista de empresas {$nomeStatus}, situação cadastral {$nomeStatus}";

    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => 'Situação Cadastral', 'url' => ''],
        ['title' => $nomeStatus, 'url' => ''],
    ];
@endphp

@push('seo')
    @include('components.directory.status.tags', compact('title', 'description', 'keywords'))
@endpush

@section('content')
<div class="bg-gray-50/50 mt-16">
    <div class="container mx-auto px-4 py-12 md:py-16">

        <x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

        <div class="text-center mb-8">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800">
                Análise de Empresas {{ $nomeStatus }}
            </h1>
        </div>

        {{-- 1. Botões de Navegação (usando a variável correta) --}}
        {{-- A variável $currentStatusSlug agora vem direto do controller --}}
        <x-directory.status.nav-buttons :statusMap="$statusMap" :currentStatusSlug="$currentStatusSlug" />

        {{-- 2. Cards por Estado --}}
        <x-directory.status.state-cards :stateCounts="$stateCounts" :statusName="$nomeStatus" />

        {{-- 3. CNAEs Dominantes --}}
        <x-directory.status.top-cnaes :topCnaes="$topCnaes" :statusName="$nomeStatus" />

        {{-- 4. Lista de Empresas Aleatórias --}}
        <x-directory.status.random-companies :randomCompanies="$randomCompanies" :statusName="$nomeStatus" />
        
    </div>
</div>
@endsection
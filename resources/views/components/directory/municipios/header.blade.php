@props(['uf', 'nomeEstado', 'municipio', 'totalEmpresasAtivas'])

@php
    $nomeCidade = $municipio->descricao;

    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => $nomeEstado, 'url' => route('empresas.state', ['uf' => strtolower($uf)])],
        // CORREÇÃO: Deixa apenas a primeira letra maiúscula
        ['title' => Str::ucfirst(Str::lower($nomeCidade)), 'url' => ''],
    ];
@endphp

<x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

<div class="mb-12">
    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800">
        Empresas em {{ $nomeCidade }} - {{ $uf }}
    </h1>
    {{-- TEXTO OTIMIZADO PARA SEO --}}
    <p class="mt-4 text-lg text-gray-600">
        Veja a lista completa com as <strong>{{ number_format($totalEmpresasAtivas, 0, ',', '.') }}</strong> empresas ativas no município de {{ $nomeCidade }}, ordenadas pelo maior capital social.
    </p>
</div>
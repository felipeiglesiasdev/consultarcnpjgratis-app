@props(['uf', 'nomeEstado', 'municipio', 'totalEmpresasAtivas'])

@php
    $nomeCidade = $municipio->descricao;

    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => $nomeEstado, 'url' => route('empresas.state', ['uf' => strtolower($uf)])],
        ['title' => Str::ucfirst(Str::lower($nomeCidade)), 'url' => ''],
    ];
@endphp

<x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

<div class="mb-12">
    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800">
        Empresas em {{ $nomeCidade }} - {{ $uf }}
    </h1>
    
    {{-- TEXTO OTIMIZADO COM A NOVA LÓGICA --}}
    <p class="mt-4 text-lg text-gray-600">
        O município de {{ $nomeCidade }} possui <strong>{{ number_format($totalEmpresasAtivas, 0, ',', '.') }}</strong> empresas ativas. 
        
        {{-- Adiciona a clarificação apenas se houver mais de 1000 empresas --}}
        @if ($totalEmpresasAtivas > 1000)
            Abaixo, apresentamos uma amostra com as 1.000 maiores empresas, ordenadas por capital social.
        @else
            Veja abaixo a lista completa, ordenada pelo maior capital social.
        @endif
    </p>
</div>
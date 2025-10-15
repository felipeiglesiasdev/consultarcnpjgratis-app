@extends('layouts.app')

@php
    // Mapeamento de UFs para nomes de estados
    $nomesEstados = [
        'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará',
        'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
        'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo',
        'SE' => 'Sergipe', 'TO' => 'Tocantins'
    ];
    $nomeEstado = $nomesEstados[$uf] ?? $uf;
    $nomeCidade = $municipio->descricao;

    // Define as variáveis de SEO para esta página
    $title = "Empresas em {$nomeCidade} - {$uf} | Consultar CNPJ Grátis";
    $description = "Lista de empresas na cidade de {$nomeCidade}, {$nomeEstado}. Encontre informações de CNPJ e dados cadastrais das {$totalEmpresasAtivas} empresas ativas.";
    $keywords = "empresas em {$nomeCidade}, cnpj {$nomeCidade}, lista de empresas {$nomeCidade}, empresas {$uf}, consulta cnpj {$nomeCidade}";
@endphp

{{-- Empurra o novo componente de tags para o stack 'seo' --}}
@push('seo')
    @include('components.directory.municipios.tags', [
        'title' => $title, 
        'description' => $description,
        'keywords' => $keywords
    ])
@endpush

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-16">

        {{-- Chama o componente de cabeçalho --}}
        <x-directory.municipios.header 
            :uf="$uf"
            :nomeEstado="$nomeEstado"
            :municipio="$municipio"
            :totalEmpresasAtivas="$totalEmpresasAtivas"
        />

        {{-- Chama o componente da lista de empresas --}}
        <x-directory.municipios.company-list :empresas="$empresas" />
        
    </div>
</div>
@endsection
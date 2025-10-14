@extends('layouts.app')

@php
    // Mapping de UFs para nomes de estados
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

    // Breadcrumbs
    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => $nomeEstado, 'url' => route('empresas.state', ['uf' => strtolower($uf)])],
        ['title' => $nomeCidade, 'url' => ''],
    ];
@endphp

@section('title', "Empresas em {$nomeCidade} - {$uf}")
@section('description', "Lista das maiores empresas na cidade de {$nomeCidade}, {$nomeEstado}, por capital social. Encontre informações de CNPJ e dados cadastrais.")

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-16">

        <x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

        {{-- Cabeçalho --}}
        <div class="mb-12">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800">
                Empresas em {{ $nomeCidade }} - {{ $uf }}
            </h1>
            <p class="mt-4 text-lg text-gray-600">
                Ranking das empresas ativas na cidade, ordenadas pelo maior capital social.
            </p>
        </div>

        {{-- Tabela de Empresas --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razão Social</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Capital Social</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($empresas as $estabelecimento)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('cnpj.show', ['cnpj' => $estabelecimento->cnpj_completo]) }}" 
                                       class="text-sm font-medium text-green-600 hover:text-green-800 hover:underline">
                                        {{ Str::limit($estabelecimento->empresa->razao_social, 60) }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{-- CORREÇÃO AQUI --}}
                                    {{ $estabelecimento->cnpj_completo_formatado }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold text-right">
                                    R$ {{ number_format($estabelecimento->empresa->capital_social ?? 0, 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                    Nenhuma empresa ativa encontrada para esta cidade.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

             {{-- Paginação --}}
            <div class="mt-8">
                {{ $empresas->links() }}
            </div>
        </div>
        
    </div>
</div>
@endsection
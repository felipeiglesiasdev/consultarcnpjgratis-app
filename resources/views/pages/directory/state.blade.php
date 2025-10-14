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

    // Mapeamento de status para usar na view
    $statusMap = [
        '2' => ['nome' => 'Ativas', 'slug' => 'ativas', 'color' => 'green'],
        '3' => ['nome' => 'Suspensas', 'slug' => 'suspensas', 'color' => 'yellow'],
        '4' => ['nome' => 'Inaptas', 'slug' => 'inaptas', 'color' => 'yellow'],
        '8' => ['nome' => 'Baixadas', 'slug' => 'baixadas', 'color' => 'red'],
        '1' => ['nome' => 'Nulas', 'slug' => 'nulas', 'color' => 'gray'],
    ];

    // NOVO BLOCO para os breadcrumbs
    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => $nomeEstado, 'url' => ''], // O último item não tem URL
    ];
@endphp

@section('title', "Empresas em {$nomeEstado} ({$uf}) - Cidades, Status e CNAEs")
@section('description', "Análise de empresas em {$nomeEstado}. Navegue por cidade, filtre por situação cadastral e veja as principais atividades econômicas (CNAEs).")

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-16">

        <x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

        {{-- Cabeçalho da Página --}}
        <div class="text-center mb-16">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800">
                Análise de Empresas em {{ $nomeEstado }}
            </h1>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                Explore dados sobre o ambiente de negócios no estado, navegue por cidades ou filtre por situação cadastral.
            </p>
        </div>

        {{-- Seção de Estatísticas com a troca de CNAE por Status --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 text-center flex flex-col justify-center">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Empresas Ativas</p>
                <p class="text-5xl font-bold text-gray-800 mt-2">{{ number_format($totalAtivas, 0, ',', '.') }}</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider text-center mb-4">Cidades com Maior Atividade</p>
                <ul class="space-y-3">
                    @foreach($topCidades as $cidade)
                    <li class="flex justify-between items-center text-sm border-b border-gray-100 pb-2">
                        <span class="text-gray-700 font-medium">{{ $loop->iteration }}. {{ $cidade->descricao }}</span>
                        <span class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded-md">{{ number_format($cidade->total_empresas, 0, ',', '.') }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider text-center mb-4">Situação Cadastral</p>
                <ul class="space-y-2">
                    @foreach($statusMap as $codigo => $info)
                        @if(isset($statusCounts[$codigo]))
                        <li class="group">
                            <a href="{{ route('empresas.status', ['status_slug' => $info['slug']]) }}" class="flex items-center justify-between p-1.5 rounded-md transition-colors hover:bg-gray-50">
                                <span class="flex items-center">
                                    <span @class(['w-2.5 h-2.5 rounded-full mr-3',
                                        'bg-green-500' => $info['color'] === 'green',
                                        'bg-yellow-500' => $info['color'] === 'yellow',
                                        'bg-red-500' => $info['color'] === 'red',
                                        'bg-gray-400' => $info['color'] === 'gray',
                                    ])></span>
                                    <span class="text-sm text-gray-700 font-medium group-hover:text-black">{{ $info['nome'] }}</span>
                                </span>
                                <span class="text-sm font-bold text-gray-500 group-hover:text-black">{{ number_format($statusCounts[$codigo], 0, ',', '.') }}</span>
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Seção de Municípios com cards --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200 mb-16">
            <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                Explore as Empresas por Cidade
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($municipios as $municipio)
                    <a href="{{ route('empresas.city', ['uf' => strtolower($uf), 'cidade_slug' => Str::slug($municipio->descricao)]) }}"
                       class="block bg-gray-50/80 border border-gray-200 rounded-lg p-4 text-center
                              transition-all duration-300 shadow-sm
                              hover:border-[#7fdea0] hover:shadow-xl hover:-translate-y-1 group">
                        
                        <h4 class="font-bold text-gray-800 truncate group-hover:text-black" title="{{ $municipio->descricao }}">
                            {{ $municipio->descricao }}
                        </h4>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="font-semibold text-green-600">{{ number_format($municipio->estabelecimentos_count, 0, ',', '.') }}</span>
                            empresas ativas
                        </p>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $municipios->links() }}
            </div>
        </div>
        
        {{-- NOVA SEÇÃO SOFISTICADA: CNAEs --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
            <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                Principais Atividades Econômicas (CNAE) no Estado
            </h3>
            
            <div class="space-y-4">
                @foreach($topCnaes as $cnae)
                    <div class="block p-4 border border-gray-200 rounded-lg transition-all duration-200 hover:border-[#7fdea0] hover:bg-green-50/30 hover:shadow-md">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex-1 pr-4">
                                <div class="flex items-center mb-2">
                                    <span class="text-sm font-semibold text-green-800 bg-green-100 rounded-md px-2 py-0.5">
                                        CNAE {{ (new \App\Models\Cnae(['codigo' => $cnae->codigo]))->codigo_formatado }}
                                    </span>
                                </div>
                                <p class="text-base text-gray-800 font-medium leading-tight">
                                    {{ $cnae->descricao }}
                                </p>
                            </div>
                            <div class="mt-3 sm:mt-0 text-left sm:text-right">
                                <div class="text-lg font-bold text-gray-700">
                                    {{ number_format($cnae->total, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">
                                    empresas
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
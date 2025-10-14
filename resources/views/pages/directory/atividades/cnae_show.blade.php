@extends('layouts.app')

@php
    $breadcrumbs = [
        ['title' => 'Empresas', 'url' => route('empresas.index')],
        ['title' => 'Atividades', 'url' => route('empresas.cnae.index')],
        ['title' => Str::limit($cnae->descricao, 30), 'url' => ''],
    ];
@endphp

@section('title', "Empresas de {$cnae->descricao}")
@section('description', "Lista de empresas do setor de {$cnae->descricao}. Encontre CNPJs, dados e informações de contato.")

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-16">

        <x-directory.breadcrumbs :breadcrumbs="$breadcrumbs" />

        <div class="mb-12">
            <span class="text-sm font-semibold text-green-800 bg-green-100 rounded-md px-3 py-1">
                CNAE {{ $cnae->codigo_formatado }}
            </span>
            <h1 class="mt-4 text-4xl lg:text-5xl font-extrabold text-gray-800">
                {{ $cnae->descricao }}
            </h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Estatísticas do Setor</h3>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Estados com mais empresas</p>
                    <ul class="mt-3 space-y-3">
                        @foreach($topEstados as $estado)
                        <li class="flex justify-between items-center text-sm border-b border-gray-100 pb-2">
                            <span class="text-gray-700 font-medium">{{ $estado->uf }}</span>
                            <span class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded-md">{{ number_format($estado->total, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">
                        Empresas do Setor (Maiores por Capital Social)
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razão Social / Local</th>
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
                                            {{-- CORREÇÃO AQUI: Acessando o município através do estabelecimento --}}
                                            <span class="block text-xs text-gray-500">{{ $estabelecimento->municipio->descricao ?? 'N/A' }} - {{ $estabelecimento->uf }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold text-right">
                                            R$ {{ number_format($estabelecimento->empresa->capital_social ?? 0, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                                            Nenhuma empresa ativa encontrada para esta atividade.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8">
                        {{ $empresas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
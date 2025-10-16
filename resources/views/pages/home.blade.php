@extends('layouts.app')

{{-- Injetando as tags de SEO --}}
@push('seo')
    <title>Consultar CNPJ Grátis - Dados de Empresas, Estados e CNAEs</title>
    <meta name="description" content="Consulte gratuitamente dados de CNPJ de qualquer empresa do Brasil. Navegue por empresas por estado, cidade ou atividade (CNAE) de forma fácil e rápida.">
    <meta name="keywords" content="consultar cnpj gratis, consulta cnpj, dados de empresas, empresas por estado, consultar cnaes, cnpjs receita federal, lista de empresas no brasil, lista de empresas brasileiras, lista de empresas por municipio">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ route('home') }}" />
@endpush

@section('content')
<div class="bg-[#171717] text-white">

    {{-- Seção 1: Herói com a Busca Principal e mais padding --}}
    {{-- CORREÇÃO APLICADA AQUI: Aumentado o padding vertical de pt-32 pb-24 para pt-40 pb-32 --}}
    <section id="consultar" class="relative pt-50 pb-50 text-center overflow-hidden">
        <div class="container mx-auto px-4 z-10 relative">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight animate-fade-in-down">
                A ferramenta definitiva para <span class="text-green-400">consultar CNPJ grátis</span>.
            </h1>
            <p class="mt-6 text-lg text-gray-300 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.3s;">
                Acesse dados públicos e atualizados da Receita Federal. Simples, rápido e sem limites.
            </p>
            
            <form action="{{ route('cnpj.consultar') }}" method="POST" class="mt-10 max-w-xl mx-auto animate-fade-in-up" style="animation-delay: 0.6s;">
                @csrf
                <div class="flex items-center bg-white/5 border-2 border-white/20 rounded-full shadow-2xl shadow-black/50 overflow-hidden focus-within:border-green-400/80 transition-colors">
                    {{-- Input com a máscara correta --}}
                    <input type="text" name="cnpj" data-mask="cnpj"
                           class="w-full py-4 px-6 text-white bg-transparent placeholder-gray-400 focus:outline-none"
                           placeholder="CNPJ 00.000.000/0000-00"
                           required>
                    <button type="submit" class="cursor-pointer bg-green-500 text-white font-bold py-4 px-8 hover:bg-green-600 transition-all duration-300 transform hover:scale-110">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

{{-- Seção 2: Cards de Benefícios com FUNDO BRANCO e DESIGN SOFISTICADO --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800">Uma Plataforma Completa</h2>
            <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                Não é apenas uma consulta. É uma central de inteligência de dados empresariais, gratuita e acessível.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
            {{-- Card 1: Gratuito --}}
            <div class="relative p-8 bg-gray-50 rounded-2xl border border-gray-200 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-green-500 text-white rounded-full h-14 w-14 flex items-center justify-center border-4 border-white shadow-xl">
                    <i class="bi bi-cash-coin text-3xl"></i>
                </div>
                <h3 class="mt-8 text-xl font-bold text-gray-800 text-center">Totalmente Gratuito</h3>
                <p class="mt-2 text-gray-600 text-center">
                    Consulte quantos CNPJs precisar, sem custos, pegadinhas ou limites diários. A informação é um direito seu.
                </p>
            </div>

            {{-- Card 2: Rápido e Abrangente --}}
            <div class="relative p-8 bg-gray-50 rounded-2xl border border-gray-200 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-green-500 text-white rounded-full h-14 w-14 flex items-center justify-center border-4 border-white shadow-xl">
                    <i class="bi bi-lightning-charge-fill text-3xl"></i>
                </div>
                <h3 class="mt-8 text-xl font-bold text-gray-800 text-center">Rápido e Abrangente</h3>
                <p class="mt-2 text-gray-600 text-center">
                    Obtenha dados completos em segundos, incluindo QSA, atividades, situação cadastral e muito mais.
                </p>
            </div>

            {{-- Card 3: Dados Confiáveis --}}
            <div class="relative p-8 bg-gray-50 rounded-2xl border border-gray-200 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-green-500 text-white rounded-full h-14 w-14 flex items-center justify-center border-4 border-white shadow-xl">
                    <i class="bi bi-shield-check text-3xl"></i>
                </div>
                <h3 class="mt-8 text-xl font-bold text-gray-800 text-center">Dados Públicos e Confiáveis</h3>
                <p class="mt-2 text-gray-600 text-center">
                    Todas as informações vêm diretamente da Receita Federal, garantindo precisão e dados atualizados.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Seção 3: Dashboard (fundo cinza claro) --}}
<section class="py-16 md:py-20 bg-gray-50/70 border-t border-b border-gray-200">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800">O Cenário Empresarial Brasileiro em Números</h2>
            <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                Confira dados atualizados sobre a distribuição e as principais atividades das empresas no país.
            </p>
        </div>
        <div class="mb-16">
            <x-home.status-cards :statusCounts="$statusCounts" />
        </div>
        <div class="max-w-4xl mx-auto">
            <x-home.top-cnaes :topCnaes="$topCnaes" />
        </div>
    </div>
</section>

{{-- Seção 3: Apresentação do Mapa do Site com FUNDO ESCURO #171717 --}}
<div class="bg-[#171717] text-white">
    <section class="py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-white">Explore o Universo de Empresas</h2>
            <p class="mt-3 text-gray-400 max-w-2xl mx-auto">
                Não tem um CNPJ? Use nossas ferramentas de exploração para encontrar empresas por localização ou setor.
            </p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                {{-- Card de Exploração 1 com efeito de vidro --}}
                <a href="{{ route('empresas.index') }}" class="block bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 text-center transition-all duration-300 hover:border-green-400/50 hover:shadow-2xl hover:shadow-green-500/10 hover:-translate-y-2">
                    <h3 class="text-2xl font-bold text-white">Consultar por Estado</h3>
                    <p class="mt-2 text-gray-400">Navegue por todos os estados e municípios do Brasil.</p>
                    <span class="mt-6 inline-block font-semibold text-green-400">Começar a explorar &rarr;</span>
                </a>

                {{-- Card de Exploração 2 com efeito de vidro --}}
                <a href="{{ route('empresas.cnae.index') }}" class="block bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8 text-center transition-all duration-300 hover:border-green-400/50 hover:shadow-2xl hover:shadow-green-500/10 hover:-translate-y-2">
                    <h3 class="text-2xl font-bold text-white">Consultar por Atividade</h3>
                    <p class="mt-2 text-gray-400">Pesquise por um setor e analise as principais empresas.</p>
                    <span class="mt-6 inline-block font-semibold text-green-400">Pesquisar por Atividade &rarr;</span>
                </a>
            </div>
        </div>
    </section>
</div>

{{-- Seção 4: Aviso de Dados Públicos (LGPD) --}}
<section class="py-16 md:py-20 px-4">
<x-public-data-notice />
</section>
@endsection
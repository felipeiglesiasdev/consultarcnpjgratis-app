@extends('layouts.app')

@push('seo')
<title>Consultar CNPJ Grátis - Rápido, Online e Confiável</title>
<meta name="robots" content="index, follow">
@endpush

@section('content')

<section class="bg-white w-full py-20 md:py-32 flex items-center justify-center">
    <div class="text-center px-4">
        {{-- Título com as palavras-chave em destaque --}}
        <h1 class="text-4xl md:text-6xl font-bold mb-4 text-[#171717]">
            Consulte qualquer <span class="text-[#94f4a6]">CNPJ</span> <span class="text-[#94f4a6]">Grátis</span>
        </h1>
        <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto text-gray-600">
            Obtenha informações completas e atualizadas de empresas, direto da base de dados da Receita Federal.
        </p>
        
        <form action="{{ route('cnpj.consultar') }}" method="POST" class="max-w-xl mx-auto">
            @csrf
            <div class="flex flex-col sm:flex-row items-center gap-2">
                <input 
                    type="search" 
                    name="cnpj" 
                    data-mask="cnpj"
                    class="w-full px-5 py-4 text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#94f4a6] focus:border-transparent"
                    placeholder="Digite o CNPJ (apenas números)"
                    required
                >
                <button 
                    type="submit"
                    class="w-full sm:w-auto px-8 py-4 border border-transparent text-base font-semibold rounded-md text-[#171717] bg-[#94f4a6] hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#94f4a6] cursor-pointer transform transition-all duration-200 hover:-translate-y-0.5"
                >
                    Consultar
                </button>
            </div>
        </form>
    </div>
</section>

{{-- Seção 2: Cards de Benefícios com Fundo Branco --}}
<section class="bg-white py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#171717]">A ferramenta definitiva para suas consultas</h2>
            <p class="text-[#171717] mt-2">Simples, rápido e sem custo algum.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Card 1 --}}
            <div class="bg-white p-8 rounded-lg border border-gray-200 shadow-md text-center transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center justify-center h-16 w-16 rounded-full bg-[#EAFBF0] mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-[#171717] mb-2">Consulte em Segundos</h3>
                <p class="text-gray-600">
                    Nossa interface limpa e otimizada permite que você encontre as informações que precisa sem complicação.
                </p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white p-8 rounded-lg border border-gray-200 shadow-md text-center transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                 <div class="flex items-center justify-center h-16 w-16 rounded-full bg-[#EAFBF0] mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M4 20h5v-5M20 4h-5v5"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-[#171717] mb-2">Informações Atualizadas</h3>
                <p class="text-gray-600">
                    Acesso direto à base de dados oficial, garantindo que você tenha sempre os dados mais recentes e confiáveis.
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white p-8 rounded-lg border border-gray-200 shadow-md text-center transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center justify-center h-16 w-16 rounded-full bg-[#EAFBF0] mx-auto mb-6">
                   <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-[#171717] mb-2">Fonte Direta da Receita</h3>
                <p class="text-gray-600">
                    Sem intermediários. Nossos dados são obtidos diretamente da Receita Federal, garantindo total transparência.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
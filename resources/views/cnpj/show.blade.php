@extends('layouts.app')
{{-- Adiciona todas as tags de SEO dinâmicas usando o novo componente --}}
<x-cnpj.tags :data="$data" />
@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Layout de Grid com 12 colunas --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">

            {{-- Coluna da Esquerda: Barra Lateral (Sidebar) --}}
            <aside class="md:col-span-3">
                {{-- Chamando o nosso primeiro componente adaptado --}}
                 <x-cnpj.sidebar />
            </aside>

            {{-- Coluna da Direita: Conteúdo Principal --}}
            <main class="md:col-span-9">
                {{-- TEXTO DE INTRODUÇÃO --}}
                <x-cnpj.intro-text :data="$data" />
                {{-- CARD 1: INFORMAÇÕES DO CNPJ --}}
                <x-cnpj.informacoes-cnpj :data="$data" />
                {{-- CARD 2: SITUAÇÃO CADASTRAL --}}
                <x-cnpj.situacao-cadastral :data="$data" />
                {{-- CARD 3: ATIVIDADES ECONÔMICAS --}}
                <x-cnpj.atividades-economicas :data="$data" />
                {{-- CARD 4: ENDEREÇO --}}
                <x-cnpj.endereco :data="$data" />
                {{-- CARD 5: CONTATO --}}
                <x-cnpj.contato :data="$data" />
                {{-- CARD 6: QUADRO SOCIETÁRIO --}}
                <x-cnpj.qsa :data="$data" />
                {{-- CARD 7: EMPRESAS SEMELHANTES --}}
                <x-cnpj.empresas-semelhantes :data="$data" />
            </main>

        </div>
    </div>
</div>
@endsection
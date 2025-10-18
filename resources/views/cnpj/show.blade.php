
@extends('layouts.app')
{{-- Adiciona as tags de SEO dinâmicas --}}
@section('seo')
    <x-cnpj.tags :data="$data" />
@endsection

@section('content')
<div class="bg-gray-50 py-12 mt-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Layout de Grid com espaçamento --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-8">

            {{-- Coluna da Esquerda: Barra Lateral (Sidebar) --}}
            {{-- ALTERADO: de lg:col-span-3 para lg:col-span-4 para aumentar a largura --}}
            <aside class="lg:col-span-4 mb-8 lg:mb-0">
                <x-cnpj.sidebar :data="$data" />
                

            </aside>

            {{-- Coluna da Direita: Conteúdo Principal --}}
            {{-- ALTERADO: de lg:col-span-9 para lg:col-span-8 para diminuir a largura --}}
            <main class="lg:col-span-8">
                <div class="space-y-8">
                    {{-- Todos os seus componentes de conteúdo --}}
                    <x-cnpj.intro-text :data="$data" />
                    <x-cnpj.informacoes-cnpj :data="$data" />
                    <x-cnpj.situacao-cadastral :data="$data" />
                    <x-cnpj.atividades-economicas :data="$data" />
                    <x-cnpj.endereco :data="$data" />
                    <x-cnpj.contato :data="$data" />
                    <x-cnpj.qsa :data="$data" />
                    <x-cnpj.empresas-semelhantes :data="$data" />
                    {{-- <x-cnpj.removal-section :data="$data" /> --}}
                </div>
            </main>

        </div>
    </div>
</div>
@endsection


@extends('layouts.app')

@section('title', 'Explorar Empresas por Estado, Atividade e Status')
@section('description', 'Navegue por todas as empresas do Brasil. Encontre CNPJs por estado, cidade, atividade econômica (CNAE) ou situação cadastral de forma fácil.')

@section('content')
<div class="bg-gray-50/50">
    <div class="container mx-auto px-4 py-12 md:py-20">

        <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-800 text-center mb-16">
            Explore o Mapa de Empresas do Brasil
        </h1>

        <x-directory.states-section :estados="$estados" />

        <x-directory.cnaes-section :topCnaes="$topCnaes" />

        <x-directory.other-explorations :status="$status" />


    </div>
</div>
@endsection
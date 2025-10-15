@props(['title', 'description', 'keywords'])

{{-- Título da Página e Meta Description --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">

{{-- Meta Keywords --}}
<meta name="keywords" content="{{ $keywords }}">

{{-- Instruções para Robôs de Busca --}}
<meta name="robots" content="index, follow">

{{-- Tags Open Graph para Redes Sociais --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ asset('images/social-tag-og.png') }}">
<meta property="og:site_name" content="Consultar CNPJ Grátis">
<meta property="og:locale" content="pt_BR">

{{-- Tags para o Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ asset('images/social-tag-og.png') }}">

{{-- Tag Canônica --}}
<link rel="canonical" href="{{ url()->current() }}" />
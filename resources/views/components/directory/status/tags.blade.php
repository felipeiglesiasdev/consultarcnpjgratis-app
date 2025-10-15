@props(['title', 'description', 'keywords'])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="robots" content="index, follow">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
{{-- Adicione outras tags og e twitter se desejar --}}
<link rel="canonical" href="{{ url()->current() }}" />
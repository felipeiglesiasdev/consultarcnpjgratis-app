@props(['data'])

@push('seo')
{{-- Este bloco inteiro será "empurrado" para o @stack('seo') no <head> --}}

<title>{{ $data['og_data']['og:title'] }}</title>
<meta name="description" content="{{ $data['meta_data']['description'] }}">
<meta name="keywords" content="{{ $data['meta_data']['keywords'] }}">

<link rel="canonical" href="{{ url()->current() }}" />

@foreach($data['og_data'] as $property => $content)
<meta property="{{ $property }}" content="{{ $content }}">
@endforeach

<script type="application/ld+json">
@json($data['structured_data'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
</script>

@endpush
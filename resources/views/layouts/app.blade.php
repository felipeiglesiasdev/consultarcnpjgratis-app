<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Consultar CNPJ Grátis')</title>

    {{-- Adicionando o script do Alpine.js via CDN --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b18] dark:text-white/90 antialiased pt-20">
    <div class="flex flex-col min-h-screen">
        
        @include('components.header')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('components.footer')

    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('seo')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased pt-20">
    <div class="flex flex-col min-h-screen">
        @include('components.header')
        <main class="flex-grow">
            @yield('content')
        </main>
        @include('components.footer')
    </div>
    <x-error-popup />
</body>
</html>
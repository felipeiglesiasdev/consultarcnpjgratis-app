<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('seo')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="google-adsense-account" content="ca-pub-3006074386164387">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KP412M62C7"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-KP412M62C7');
    </script>
</head>
<body class="font-sans antialiased">
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
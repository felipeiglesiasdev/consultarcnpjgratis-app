<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste de Fonte - Montserrat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
            <h1 class="text-4xl font-semibold mb-4 text-gray-800">Teste da Fonte Montserrat</h1>
            <p class="text-lg mb-4 text-gray-700">
                Este é um parágrafo com a fonte Montserrat aplicada. O peso padrão do texto deve ser o normal (regular, font-weight 400).
            </p>
            <p class="font-medium text-lg mb-4 text-gray-700">
                Este parágrafo está usando o peso <span class="bg-yellow-200 px-1 rounded">medium (font-weight 500)</span> para teste.
            </p>
            <p class="font-semibold text-lg text-gray-700">
                E finalmente, este parágrafo usa o peso <span class="bg-green-200 px-1 rounded">semibold (font-weight 600)</span>.
            </p>
            <div class="mt-6 border-t pt-4">
                <p class="text-sm text-gray-600">Se você consegue ler isso na fonte correta e com os pesos diferentes, a configuração foi um sucesso!</p>
            </div>
        </div>
    </div>
</body>
</html>
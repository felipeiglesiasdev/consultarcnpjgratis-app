<footer class="bg-[#171717] text-white">
    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-center md:text-left mb-4 md:mb-0">
                <p class="text-sm text-gray-300">
                    &copy; {{ date('Y') }} Consultar CNPJ Grátis. Todos os direitos reservados.
                </p>
            </div>
            <div class="flex space-x-6">
                {{-- SEO: Adicionado rel="nofollow" para não passar relevância para páginas legais --}}
                <a href="{{ route('privacy.policy') }}" class="text-sm text-gray-400 hover:text-white transition" rel="nofollow">Política de Privacidade</a>
                <a href="{{ route('privacy.policy') }}#termos-de-uso" class="text-sm text-gray-400 hover:text-white transition" rel="nofollow">Termos de Uso</a>
            </div>
        </div>
    </div>
</footer>
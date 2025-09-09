
<header x-data="{ isOpen: false }" 
        id="main-header" 
        class="fixed top-0 w-full z-50 transition-colors duration-300 ease-in-out bg-white shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center space-x-6">
                 <a href="{{ route('home') }}" title="Página Inicial - Consultar CNPJ Grátis" class="flex-shrink-0">
                    <img id="logo-light" class="h-15 w-75 transition-opacity duration-300" src="{{ asset('images/logos/logo-verde-preto.webp') }}" alt="Logo do Consultar CNPJ Grátis">
                    <img id="logo-dark" class="h-15 w-75 hidden transition-opacity duration-300" src="{{ asset('images/logos/logo-verde-branco.webp') }}" alt="Logo do Consultar CNPJ Grátis">
                </a>
                <nav class="hidden sm:block" aria-label="Navegação Principal">
                    <a id="nav-link" href="{{ route('home') }}" title="Realizar uma nova Consulta de CNPJ Grátis" class="text-gray-800 font-semibold hover:text-[#94f4a6] transition-colors duration-300">
                        Consultar CNPJ
                    </a>
                </nav>
            </div>
            <div class="flex items-center">
                <div class="hidden md:block">
                    <form action="#" method="POST" class="flex items-center space-x-2">
                        @csrf
                        <input type="search" name="cnpj" data-mask="cnpj" id="cnpj-header-input" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#94f4a6] focus:border-[#94f4a6] sm:text-sm transition-colors duration-300 text-gray-900" placeholder="00.000.000/0000-00">
                        <button type="submit" class="px-5 py-2 border border-transparent text-sm font-medium rounded-md text-[#171717] bg-[#94f4a6] hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#94f4a6] cursor-pointer transform transition-all duration-200 hover:-translate-y-0.5" title="Buscar CNPJ">
                            Buscar
                        </button>
                    </form>
                </div>
                <div class="md:hidden">
                    <button @click="isOpen = !isOpen" class="text-gray-800 dark:text-gray-200 focus:outline-none" aria-label="Abrir menu" :aria-expanded="isOpen.toString()" aria-controls="mobile-menu">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path :class="{'hidden': isOpen, 'block': !isOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path :class="{'block': isOpen, 'hidden': !isOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div x-show="isOpen" 
         @click.away="isOpen = false" 
         id="mobile-menu" 
         class="md:hidden bg-white border-t border-gray-200" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2">
        <div class="px-4 pt-4 pb-6 space-y-4">
            <form action="#" method="POST" class="flex items-center space-x-2">
                @csrf
                <input type="search" id="cnpj-header-input" data-mask="cnpj" name="cnpj_mobile" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#94f4a6] focus:border-[#94f4a6] text-gray-900" placeholder="Digite o CNPJ">
                <button type="submit" class="px-5 py-2 border border-transparent text-sm font-medium rounded-md text-[#171717] bg-[#94f4a6] hover:bg-opacity-80">
                    Buscar
                </button>
            </form>
            <nav class="flex flex-col space-y-2" aria-label="Navegação móvel">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Início</a>
            </nav>
        </div>
    </div>
</header>



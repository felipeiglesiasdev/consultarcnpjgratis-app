{{-- O x-data agora controla o menu mobile e os dropdowns de desktop/mobile separadamente --}}
<header x-data="{ mobileMenuOpen: false, desktopDropdownOpen: false, mobileDropdownOpen: false }" 
        id="header" class="bg-white shadow-md fixed w-full z-50 transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                {{-- CORREÇÃO: Fundo da lupa removido para um visual mais limpo --}}
                <div class="p-2">
                    <i class="bi bi-search text-xl text-green-600"></i>
                </div>
                <span class="font-bold text-xl text-gray-800">
                    Consultar CNPJ <span class="text-green-600">Grátis</span>
                </span>
            </a>

            {{-- Menu de Navegação (Desktop) --}}
            <nav class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="{{ route('empresas.index') }}" class="text-gray-600 font-semibold hover:text-green-600 transition-colors">
                    Empresas por Estado
                </a>
                <a href="{{ route('empresas.cnae.index') }}" class="text-gray-600 font-semibold hover:text-green-600 transition-colors">
                    Consultar Cnae
                </a>
                
                {{-- CORREÇÃO: Dropdown para Situação agora funciona com hover no desktop --}}
                <div class="relative" @mouseenter="desktopDropdownOpen = true" @mouseleave="desktopDropdownOpen = false">
                    <button class="flex items-center text-gray-600 font-semibold hover:text-green-600 transition-colors">
                        <span>Empresas por Situação</span>
                        <i class="bi bi-chevron-down text-xs ml-1"></i>
                    </button>
                    <div x-show="desktopDropdownOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="absolute mt-3 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50" style="display: none;">
                        <a href="{{ route('empresas.status', ['status_slug' => 'ativas']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Ativas</a>
                        <a href="{{ route('empresas.status', ['status_slug' => 'suspensas']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Suspensas</a>
                        <a href="{{ route('empresas.status', ['status_slug' => 'inaptas']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Inaptas</a>
                        <a href="{{ route('empresas.status', ['status_slug' => 'baixadas']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Baixadas</a>
                        <a href="{{ route('empresas.status', ['status_slug' => 'nulas']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Nulas</a>
                    </div>
                </div>
            </nav>

            {{-- CORREÇÃO: Botão de Ação "Consultar CNPJ" de volta --}}
            <div class="hidden md:block">
                 <a href="{{ route('home') }}#consultar" class="bg-green-500 text-white font-bold py-2 px-5 rounded-full hover:bg-green-600 transition-transform hover:scale-105 shadow-sm">
                    Consultar CNPJ
                </a>
            </div>

            {{-- Ícone do Menu Mobile (Hamburger) --}}
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-800">
                    <i class="bi bi-list text-3xl"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Painel do Menu Mobile --}}
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300" 
         x-transition:enter-start="-translate-y-full" 
         x-transition:enter-end="translate-y-0" 
         x-transition:leave="transition ease-in duration-300" 
         x-transition:leave-start="translate-y-0" 
         x-transition:leave-end="-translate-y-full"
         class="md:hidden bg-white absolute w-full shadow-lg border-t border-gray-200" style="display: none;">
        <div class="px-4 py-6 space-y-4">
            <a href="{{ route('empresas.index') }}" @click="mobileMenuOpen = false" class="block text-lg text-gray-700 font-semibold hover:text-green-600">Empresas por Estado</a>
            <a href="{{ route('empresas.cnae.index') }}" @click="mobileMenuOpen = false" class="block text-lg text-gray-700 font-semibold hover:text-green-600">Consultar Cnae</a>
            <div>
                {{-- Dropdown do mobile continua com clique, o que é o correto para touch --}}
                <button @click="mobileDropdownOpen = !mobileDropdownOpen" class="w-full flex justify-between items-center text-lg text-gray-700 font-semibold hover:text-green-600">
                    <span>Empresas por Situação</span>
                    <i class="bi bi-chevron-down text-sm"></i>
                </button>
                <div x-show="mobileDropdownOpen" class="pl-4 mt-2 space-y-2">
                    <a href="{{ route('empresas.status', ['status_slug' => 'ativas']) }}" class="block text-gray-600 hover:text-green-600">Ativas</a>
                    <a href="{{ route('empresas.status', ['status_slug' => 'suspensas']) }}" class="block text-gray-600 hover:text-green-600">Suspensas</a>
                    <a href="{{ route('empresas.status', ['status_slug' => 'inaptas']) }}" class="block text-gray-600 hover:text-green-600">Inaptas</a>
                    <a href="{{ route('empresas.status', ['status_slug' => 'baixadas']) }}" class="block text-gray-600 hover:text-green-600">Baixadas</a>
                    <a href="{{ route('empresas.status', ['status_slug' => 'nulas']) }}" class="block text-gray-600 hover:text-green-600">Nulas</a>
                </div>
            </div>
            <a href="{{ route('home') }}#consultar" @click="mobileMenuOpen = false" class="block w-full text-center bg-green-500 text-white font-bold py-3 px-5 rounded-full mt-4">
                Consultar CNPJ
            </a>
        </div>
    </div>
</header>
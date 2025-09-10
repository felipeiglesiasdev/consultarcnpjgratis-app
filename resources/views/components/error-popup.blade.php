@if (session()->has('error'))
    {{-- 
        Este container só é renderizado se houver um erro na sessão.
        O Alpine.js controla a visibilidade (mostrar/esconder) do popup.
    --}}
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center px-4 font-sans" {{-- Garante a fonte correta --}}
         style="display: none;">
        
        {{-- Overlay escuro --}}
        <div class="absolute inset-0 bg-black opacity-60" @click="show = false"></div>

        {{-- Modal --}}
        <div @click.away="show = false"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="relative bg-white rounded-lg shadow-xl p-6 m-4 max-w-sm w-full text-center">
            
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>

            <h3 class="text-lg leading-6 font-semibold text-gray-900 mt-4">Atenção!</h3>
            <div class="mt-2">
                {{-- Exibe a mensagem de erro que veio do controller --}}
                <p class="text-sm text-gray-500">{{ session('error') }}</p>
            </div>

            <div class="mt-5">
                <button @click="show = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm cursor-pointer"> {{-- Adicionado cursor-pointer --}}
                    Entendi
                </button>
            </div>
        </div>
    </div>
@endif


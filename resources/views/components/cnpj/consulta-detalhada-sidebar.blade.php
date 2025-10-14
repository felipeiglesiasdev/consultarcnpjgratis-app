@props(['data'])

{{-- O card agora é estático, sem o efeito 'sticky' --}}
<div class="mt-8">
    {{-- Card com borda gradiente sutil e sombra mais pronunciada para um look premium --}}
    <div class="bg-white border border-transparent rounded-lg p-6 shadow-lg transition-all duration-300 ease-in-out hover:shadow-2xl hover:border-green-300">
        
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">
            Desvende o Histórico Completo
        </h3>
        
        {{-- Preço com estilo sofisticado --}}
        <div class="my-4 text-center">
            <span class="text-green-600 align-top text-2xl font-semibold">R$</span>
            <span class="text-green-600 text-5xl font-bold tracking-tight">29</span>
            <span class="text-green-600 align-top text-2xl font-semibold">,90</span>
        </div>
        
        <p class="text-gray-600 mb-5 text-center text-sm">
            Acesse informações restritas e tome decisões com mais segurança:
        </p>

        {{-- Lista de benefícios atualizada --}}
        <ul class="text-gray-600 mb-6 space-y-2 text-sm">
            <li class="flex items-start">
                <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span><span class="font-semibold text-gray-700">Inscrição Estadual</span> e situação no Sintegra</span>
            </li>
            <li class="flex items-start">
                <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span>Opção pelo <span class="font-semibold text-gray-700">Simples Nacional</span> e MEI</span>
            </li>
            <li class="flex items-start">
                <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span><span class="font-semibold text-gray-700">Faturamento Presumido</span> e Limite de Crédito</span>
            </li>
             <li class="flex items-start">
                <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span>Nomes dos <span class="font-semibold text-gray-700">Sócios e Administradores</span></span>
            </li>
            <li class="flex items-start">
                <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span><span class="font-semibold text-gray-700">Score de Crédito</span> e muito mais!</span>
            </li>
        </ul>

        {{-- Botão de Call to Action com nova chamada e estilo --}}
        <a href="https://wa.me/5511999999999?text=Olá,%20gostaria%20de%20solicitar%20a%20consulta%20detalhada%20para%20o%20CNPJ%20{{ $data['cnpj_completo'] }}" 
           target="_blank" 
           rel="nofollow noopener noreferrer"
           class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-semibold rounded-md text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 shadow-lg hover:shadow-green-500/50 transition-all duration-300 transform hover:scale-105 cursor-pointer"
           title="Solicitar Consulta Detalhada no WhatsApp">
            Desbloquear Relatório Completo
        </a>
    </div>
</div>


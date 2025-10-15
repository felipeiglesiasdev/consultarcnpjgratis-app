<div>
    <div class="container mx-auto py-16">
        {{-- O card principal --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 md:p-10 flex flex-col md:flex-row items-start">
            
            {{-- Ícone de Informação para dar apelo visual --}}
            <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-8">
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Conteúdo de texto com letras maiores --}}
            <div class="flex-grow">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Transparência e Fonte dos Dados</h3>
                {{-- Aumentado para text-base, que é o tamanho padrão de parágrafo --}}
                <p class="text-base text-gray-600 leading-relaxed">
                    As informações de CNPJ exibidas neste site são dados públicos, coletados diretamente da Receita Federal. A divulgação destes dados é uma prática legal e transparente, em conformidade com a 
                    <a href="https://www.planalto.gov.br/ccivil_03/_ato2011-2014/2011/lei/l12527.htm" 
                       target="_blank" rel="nofollow noopener" 
                       class="text-green-600 hover:text-green-800 font-semibold underline transition-colors">
                       Lei de Acesso à Informação (Nº 12.527/2011)
                    </a> 
                    e com a 
                    <a href="https://www.planalto.gov.br/CCIVIL_03/_Ato2015-2018/2016/Decreto/D8777.htm" 
                       target="_blank" rel="nofollow noopener" 
                       class="text-green-600 hover:text-green-800 font-semibold underline transition-colors">
                       Política de Dados Abertos do Governo Federal (Decreto Nº 8.777/2016)
                    </a>.
                </p>
            </div>

        </div>
    </div>
</div>
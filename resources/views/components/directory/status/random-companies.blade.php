@props(['randomCompanies', 'statusName'])

<div>
    <h3 class="text-3xl font-bold text-gray-800 mb-2 text-center">Amostra de Empresas {{ $statusName }}</h3>
    <p class="text-gray-600 text-center mb-8">Uma lista com 100 empresas aleatórias que se encontram nesta situação.</p>

    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razão Social / Local</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($randomCompanies as $estabelecimento)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('cnpj.show', ['cnpj' => $estabelecimento->cnpj_completo]) }}" class="text-sm font-medium text-green-600 hover:text-green-800 hover:underline">
                                    {{ Str::limit($estabelecimento->empresa->razao_social, 70) }}
                                </a>
                                <span class="block text-xs text-gray-500 mt-1">{{ $estabelecimento->municipioRel->descricao ?? 'N/A' }} - {{ $estabelecimento->uf }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ $estabelecimento->cnpj_completo_formatado }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@props(['empresas'])

<div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">
        Amostra de Empresas do Setor
    </h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razão Social / Local</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Capital Social</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($empresas as $estabelecimento)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('cnpj.show', ['cnpj' => $estabelecimento->cnpj_completo]) }}" 
                               class="text-sm font-semibold text-green-600 hover:text-green-800 hover:underline">
                                {{ Str::limit($estabelecimento->empresa->razao_social, 50) }}
                            </a>
                            <span class="block text-xs text-gray-500 mt-1">{{ $estabelecimento->municipioRel->descricao ?? 'N/A' }} - {{ $estabelecimento->uf }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                            {{ $estabelecimento->cnpj_completo_formatado }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold text-right">
                            R$ {{ number_format($estabelecimento->empresa->capital_social ?? 0, 2, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                            Nenhuma empresa ativa encontrada para esta atividade.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
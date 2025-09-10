@if (!empty($data['empresas_semelhantes']))
<div class="similar-companies-section">
    <div class="similar-companies-header">
        <i class="bi bi-diagram-3-fill header-icon"></i>
        <h2>Empresas Semelhantes</h2>
    </div>
    {{-- TEXTO DESCRITIVO ADICIONADO AQUI --}}
    <p class="similar-companies-subtitle">
        Listando empresas com a mesma atividade principal <strong>({{ $data['similar_context']['cnae_descricao'] }})</strong>, localizadas em <strong>{{ $data['similar_context']['cidade'] }}</strong>.
    </p>
    <div class="similar-companies-grid">
        @foreach ($data['empresas_semelhantes'] as $semelhante)
            <a href="{{ $semelhante['url'] }}" class="similar-company-card" title="{{ $semelhante['razao_social'] }}">
                <span class="company-name">{{ $semelhante['razao_social'] }}</span>
                <span class="company-location">{{ $semelhante['cidade_uf'] }}</span>
            </a>
        @endforeach
    </div>
</div>
@endif
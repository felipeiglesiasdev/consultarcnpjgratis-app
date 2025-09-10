@props(['Data'])
<div class="data-card">
    <div class="card-header">
        <i class="bi bi-briefcase-fill header-icon"></i>
        <h2>Atividades Econômicas (CNAE)</h2>
    </div>
    <div class="card-body">
        <div class="cnae-section-title">Atividade Principal</div>
        <div class="cnae-item cnae-item--principal">
            <div class="cnae-code">{{ $data['cnae_principal']['codigo'] }}</div>
            <div class="cnae-description">{{ $data['cnae_principal']['descricao'] }}</div>
        </div>

        @if (!empty($data['cnaes_secundarios']))
            <div class="cnae-section-title" style="margin-top: 1rem;">Atividades Secundárias</div>
            @foreach ($data['cnaes_secundarios'] as $cnae)
                <div class="cnae-item">
                    <div class="cnae-code">{{ $cnae['codigo'] }}</div>
                    <div class="cnae-description">{{ $cnae['descricao'] }}</div>
                </div>
            @endforeach
        @endif
    </div>
</div>
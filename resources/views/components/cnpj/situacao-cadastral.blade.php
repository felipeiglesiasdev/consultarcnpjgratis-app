@props(['Data'])
<div class="data-card {{ $data['situacao_cadastral'] === 'ATIVA' ? 'card--active' : '' }}">
    <div class="card-header">
        <i class="bi bi-patch-check-fill header-icon"></i>
        <h2>Situação Cadastral</h2>
    </div>
    <div class="card-body">
        <div class="data-item">
            <span class="label">Situação Cadastral</span>
            <span class="value">
                <span class="status-badge {{ $data['situacao_cadastral_classe'] }}">
                    {{ $data['situacao_cadastral'] }}
                </span>
            </span>
        </div>
        <div class="data-item">
            <span class="label">Data da Situação Cadastral</span>
            <span class="value">{{ $data['data_situacao_cadastral'] }}</span>
        </div>
    </div>
    {{-- TEXTO PROMOCIONAL CONDICIONAL --}}
    @if ($data['situacao_cadastral'] === 'ATIVA')
        <div class="card-promo-text">
            Esta empresa pode se tornar seu cliente! <a href="{{ route('listas-segmentadas') }}">Nós filtramos empresas como esta para você.</a>
        </div>
    @endif
</div>
@props(['Data'])
<div class="data-card">
    <div class="card-header">
        <i class="bi bi-geo-alt-fill header-icon"></i>
        <h2>Endereço</h2>
    </div>
    <div class="address-card-body">
        <div class="address-grid">
            <div class="data-item">
                <span class="label">Logradouro</span>
                <span class="value">{{ $data['logradouro'] }}</span>
            </div>
            <div class="data-item">
                <span class="label">Bairro</span>
                <span class="value">{{ $data['bairro'] }}</span>
            </div>
                <div class="data-item">
                <span class="label">Complemento</span>
                <span class="value">{{ $data['complemento'] ?? 'N/A' }}</span>
            </div>
            <div class="data-item">
                <span class="label">Cidade / UF</span>
                <span class="value">{{ $data['cidade_uf'] }}</span>
            </div>
            <div class="data-item">
                <span class="label">CEP</span>
                <span class="value">{{ $data['cep'] }}</span>
            </div>
        </div>
        <div class="address-map-col">
            <div class="map-container">
                <a href="{{ $data['google_maps_url'] }}" class="btn btn-secondary map-link" target="_blank" rel="nofollow noopener noreferrer" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i class="bi bi-map-fill"></i> Abrir no Mapa
                </a>
            </div>
        </div>
    </div>
    </div>
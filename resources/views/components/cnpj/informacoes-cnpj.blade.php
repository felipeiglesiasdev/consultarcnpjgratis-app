@props(['data'])
<div class="data-card">
    <div class="card-header">
        <i class="bi bi-building header-icon"></i>
        <h2>Informações do CNPJ</h2>
    </div>
    <div class="card-body">
        <div class="data-item">
            <span class="label">CNPJ</span>
            <span class="value">{{ $data['cnpj_completo'] }}</span>
        </div>
        <div class="data-item">
            <span class="label">Razão Social</span>
            <span class="value">{{ $data['razao_social'] }}</span>
        </div>
        <div class="data-item">
            <span class="label">Nome Fantasia</span>
            <span class="value">{{ $data['nome_fantasia'] ?? 'Não informado' }}</span>
        </div>
        <div class="data-item">
            <span class="label">Natureza Jurídica</span>
            <span class="value">{{ $data['natureza_juridica'] }}</span>
        </div>
        <div class="data-item">
            <span class="label">Capital Social</span>
            <span class="value">R$ {{ $data['capital_social'] }}</span>
        </div>
        <div class="data-item">
            <span class="label">Porte da Empresa</span>
            <span class="value">{{ $data['porte'] ?? 'Não informado' }}</span>
        </div>
        <div class="data-item">
            <span class="label">Matriz ou Filial</span>
            <span class="value">{{ $data['matriz_ou_filial'] }}</span>
        </div>
        <div class="data-item">
            <span class="label">Data de Abertura</span>
            <span class="value">{{ $data['data_abertura'] }}</span>
        </div>
    </div>
</div>
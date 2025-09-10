@props(['Data'])
    
@if (!empty($data['quadro_societario']))
<div class="data-card">
    <div class="card-header">
        <i class="bi bi-people-fill header-icon"></i>
        <h2>Quadro Societário (QSA)</h2>
    </div>
    <div style="padding: 1.5rem;">
        <table class="qsa-table">
            <thead>
                <tr>
                    <th>Nome do Sócio</th>
                    <th>Qualificação</th>
                    <th>Data de Entrada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['quadro_societario'] as $socio)
                    <tr>
                        <td data-label="Nome">{{ $socio['nome'] }}</td>
                        <td data-label="Qualificação">{{ $socio['qualificacao'] }}</td>
                        <td data-label="Entrada">{{ $socio['data_entrada'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
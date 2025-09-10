@props(['Data'])
@if (!empty($data['telefone_1']) || !empty($data['telefone_2']) || !empty($data['email']))
<div class="data-card">
    <div class="card-header">
        <i class="bi bi-telephone-fill header-icon"></i>
        <h2>Contato</h2>
    </div>
    <div class="card-body">
        @if (!empty($data['telefone_1']))
            <div class="data-item">
                <span class="label">Telefone 1</span>
                <span class="value"><a href="tel:{{ preg_replace('/\D/', '', $data['telefone_1']) }}" rel="nofollow">{{ $data['telefone_1'] }}</a></span>
            </div>
        @endif
        @if (!empty($data['telefone_2']))
            <div class="data-item">
                <span class="label">Telefone 2</span>
                <span class="value"><a href="tel:{{ preg_replace('/\D/', '', $data['telefone_2']) }}" rel="nofollow">{{ $data['telefone_2'] }}</a></span>
            </div>
        @endif
        @if (!empty($data['email']))
            <div class="data-item">
                <span class="label">E-mail</span>
                <span class="value"><a href="mailto:{{ strtolower($data['email']) }}" rel="nofollow">{{ strtolower($data['email']) }}</a></span>
            </div>
        @endif
    </div>
</div>
@endif
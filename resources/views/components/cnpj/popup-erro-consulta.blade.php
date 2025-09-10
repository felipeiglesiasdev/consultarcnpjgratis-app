
<div id="error-popup" class="error-popup">
    <div class="popup-content">
        <span class="popup-close" id="popup-close">&times;</span>
        <div class="popup-icon" id="popup-icon"></div>
        <h4 id="popup-title"></h4>
        <p id="popup-message"></p>
        <button id="popup-confirm" class="btn btn-primary popup-confirm-btn">Entendido</button>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('error'))
        // Verifica se a função global 'showPopup' existe (criada no app.js)
        if (typeof window.showPopup === 'function') {
            // CHAMA O POPUP DE ERRO DE BACK-END
            window.showPopup(
                'bi-emoji-frown', // Ícone de carinha triste
                'CNPJ não encontrado',
                'Lamentamos, mas não encontramos este CNPJ em nossa base de dados. Por favor, verifique o número e tente novamente.',
                false // não é um erro crítico, é um aviso
            );
        }
    @endif
});
</script>
@endpush
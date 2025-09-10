@props(['data'])
<section class="disclaimer-section">
    <div class="container">
        <p class="disclaimer-text">
            <strong>Aviso Importante:</strong> As informações exibidas nesta página são dados públicos coletados diretamente das bases de dados da Receita Federal do Brasil, em conformidade com o Decreto nº 8.777/2016 e a Lei de Acesso à Informação (Lei nº 12.527/2011). Este site não representa a empresa mencionada.
            Se você é o proprietário desta empresa e deseja solicitar a remoção desta página, por favor, <a href="#" id="openRemovalModal">clique aqui</a>.
        </p>
    </div>
</section>
<div class="removal-modal-overlay" id="removalModalOverlay">
    <div class="removal-modal-content">
        <button class="removal-modal-close" id="closeRemovalModal">&times;</button>
        <h3>Solicitar Remoção de Página</h3>
        <p>Por favor, preencha o formulário abaixo para solicitar a remoção dos dados deste CNPJ do nosso site.</p>
        <div id="modal-response-message" class="response-message"></div>
        <form id="removalForm">
            @csrf
            <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" id="cnpj" name="cnpj" value="{{ $data['cnpj_completo'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="razao_social">Razão Social</label>
                <input type="text" id="razao_social" name="razao_social" value="{{ $data['razao_social'] }}" readonly>
            </div>
            <div class="form-group">
                <label for="nome">Seu Nome Completo</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Seu E-mail de Contato</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="motivo">Motivo da Solicitação</label>
                <textarea id="motivo" name="motivo" rows="4" required></textarea>
            </div>
            <button type="submit" class="submit-button">Enviar Solicitação</button>
        </form>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Seleciona os elementos do modal com os NOMES CORRIGIDOS
    const modalOverlay = document.getElementById('removalModalOverlay');
    const openModalBtn = document.getElementById('openRemovalModal');
    const closeModalBtn = document.getElementById('closeRemovalModal');
    const removalForm = document.getElementById('removalForm');
    const responseMessageDiv = document.getElementById('modal-response-message');

    // O resto do script permanece igual, pois ele usa IDs que não mudaram
    if (!modalOverlay) return; // Garante que o código só execute se o modal existir

    openModalBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modalOverlay.style.display = 'flex';
    });

    closeModalBtn.addEventListener('click', function() {
        modalOverlay.style.display = 'none';
    });

    modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) {
            modalOverlay.style.display = 'none';
        }
    });

    removalForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(removalForm);
        const submitButton = removalForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Enviando...';

        fetch('{{ route('solicitacao.remocao.store') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            responseMessageDiv.style.display = 'block';
            if (data.errors) {
                responseMessageDiv.className = 'response-message error';
                let errorHtml = '<ul>';
                for (const error in data.errors) {
                    errorHtml += `<li>${data.errors[error][0]}</li>`;
                }
                errorHtml += '</ul>';
                responseMessageDiv.innerHTML = errorHtml;
            } else {
                responseMessageDiv.className = 'response-message success';
                responseMessageDiv.textContent = data.success;
                // Opcional: resetar e esconder o form após o sucesso
                removalForm.style.display = 'none'; 
            }
        })
        .catch(error => {
            responseMessageDiv.style.display = 'block';
            responseMessageDiv.className = 'response-message error';
            responseMessageDiv.textContent = 'Ocorreu um erro inesperado. Tente novamente mais tarde.';
            console.error('Error:', error);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Enviar Solicitação';
        });
    });
});
</script>
@endpush


import IMask from 'imask';

// Roda o script depois que o conteúdo da página carregar
document.addEventListener('DOMContentLoaded', () => {
    
    // Encontra TODOS os inputs que tiverem o atributo 'data-mask="cnpj"'
    const cnpjInputs = document.querySelectorAll('[data-mask="cnpj"]');
    
    // Para cada input encontrado, aplica a máscara
    cnpjInputs.forEach(function(element) {
        const maskOptions = {
            mask: '00.000.000/0000-00'
        };
        const mask = IMask(element, maskOptions);
    });

});
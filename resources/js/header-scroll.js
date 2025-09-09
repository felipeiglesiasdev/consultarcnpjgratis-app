document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('main-header');
    const logoLight = document.getElementById('logo-light');
    const logoDark = document.getElementById('logo-dark');
    const navLink = document.getElementById('nav-link');
    const headerInput = document.getElementById('cnpj-header-input'); // Seleciona o input pelo ID

    // Garante que todos os elementos existem antes de adicionar o listener
    if (header && logoLight && logoDark && navLink && headerInput) {
        const scrollThreshold = 10; // Distância em pixels para ativar o efeito

        const handleScroll = () => {
            if (window.scrollY > scrollThreshold) {
                // --- ESTADO ROLADO (FUNDO ESCURO) ---
                header.classList.remove('bg-white', 'shadow-sm');
                header.classList.add('bg-[#171717]', 'shadow-lg');
                
                logoLight.classList.add('hidden');
                logoLight.classList.remove('block');

                logoDark.classList.add('block');
                logoDark.classList.remove('hidden');

                navLink.classList.remove('text-gray-800');
                navLink.classList.add('text-white');
                
                // Altera o input para ter fundo branco e texto escuro, mesmo no header escuro
                headerInput.classList.remove('border-gray-300');
                headerInput.classList.add('bg-white', 'text-gray-900', 'border-gray-500');

            } else {
                // --- ESTADO TOPO (FUNDO BRANCO) ---
                header.classList.add('bg-white', 'shadow-sm');
                header.classList.remove('bg-[#171717]', 'shadow-lg');

                logoLight.classList.remove('hidden');
                logoLight.classList.add('block');
                
                logoDark.classList.remove('block');
                logoDark.classList.add('hidden');
                
                navLink.classList.add('text-gray-800');
                navLink.classList.remove('text-white');

                // Restaura o input para o estado original
                headerInput.classList.add('border-gray-300');
                headerInput.classList.remove('bg-white', 'text-gray-900', 'border-gray-500');
            }
        };

        window.addEventListener('scroll', handleScroll, { passive: true });
    }
});
<aside class="cnpj-sidebar">
    <div class="sidebar-widget">
        <h3><i class="bi bi-plus-circle header-icon"></i> Nova Consulta</h3>
        <p class="widget-description">
            Deseja pesquisar outro CNPJ? Utilize o campo abaixo.
        </p>
        <form class="search-form" action="{{ route('cnpj.consultar') }}" method="POST">
            @csrf
            <input type="text" name="cnpj" id="cnpj-input" class="search-input" placeholder="00.000.000/0000-00" required>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
                <span>Consultar</span>
            </button>
        </form>
        
    </div>
    <div class="sidebar-widget ad-widget">
        <h3>Precisando de Mais Dados?</h3>
        <p>Encontre seus próximos clientes com listas de empresas altamente segmentadas.</p>
        <a href="" class="btn btn-primary">Conhecer Listas</a>
    </div>
</aside>
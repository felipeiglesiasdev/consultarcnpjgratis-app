@props(['data'])
<p class="seo-intro-text">
    Consulte abaixo os dados públicos da empresa <strong>{{ $data['razao_social'] }}</strong>, inscrita sob o CNPJ <strong>{{ $data['cnpj_completo'] }}</strong>. 
    Fundada em <strong>{{ $data['data_abertura'] }}</strong>, a organização está localizada na cidade de <strong>{{ $data['cidade'] }}</strong> e atua principalmente no setor de <strong>"{{ $data['cnae_principal']['descricao'] }}"</strong>.
    Veja abaixo detalhes sobre a situação cadastral, endereço, quadro de sócios e outras informações relevantes.
</p>
{% extends 'partials/body.twig.php'  %}

{% block title %}Perfil - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Meu Perfil</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>
    <div class="p-3 osahan-cart-item osahan-home-page">
        {% include '_cliente/perfil/conteudo.twig.php' %}
    </div>
</div>
{% if isLogin != 'undefined' %}
{% if isLogin != 0 %}
{% include 'partials/footer.twig.php' %}
{% endif %}
{% endif %}
{% endblock %}
{% extends 'partials/body.twig.php'  %}

{% block title %}Pedidos para Entrega - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Pedidos para entrega</h5>
    </div>
    <div id="listarEntregasMotoboy"></div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footerMotoboy.twig.php' %}
{% endblock %}
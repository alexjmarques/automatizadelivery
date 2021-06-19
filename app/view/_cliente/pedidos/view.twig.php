{% extends 'partials/body.twig.php'  %}
{% block title %}Meus Pedidos - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Meu Pedido</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/meus-pedidos"> Voltar</a>
    </div>
    <div class="mb-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="bg-white rounded shadow mt-n5">
                <div id="acompanharStatusPedido" data-pedido="{{venda.numero_pedido}}" data-status="{{venda.status}}"></div>
            </div>
        </div>
    </div>
</div>
{% include 'partials/modalCancelPedido.twig.php' %}
{% include 'partials/footer.twig.php' %}
{% endblock %}
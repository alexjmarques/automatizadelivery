{% extends 'partials/body.twig.php' %}

{% block title %}Busca de Pedidos - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Pegar Pedido</h5>
    </div>
    <div class="p-3 osahan-cart-item osahan-home-page">
        <div class="bg-white rounded shadow mt-n5">
            <div class="border-bottom p-3">
                <div class="left mr-3 p-0">
                    <span class="text-muted text-small d-block">Digite o número do pedido para efetuar uma busca</span>
                </div>
                <div class="pt-3 pb-3 text-center osahan-verification">
                    <form method="get" id="formBusca"
                        action="{{BASE}}{{empresa.link_site}}/motoboy/pegar/entrega/busca">
                        <div class="row mx-0 mb-4 mt-3">
                            <div class="col pr-1 pl-0 ">
                                <input type="number" value="" name="numero_pedido" id="numero_pedido"
                                    class="form-control form-control-lg text-center numero_pedidoMoto">
                            </div>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block mt-2">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="carregar"></div>
    <div id="pesquisaEntregasMotoboy"></div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footerMotoboy.twig.php' %}
{% endblock %}
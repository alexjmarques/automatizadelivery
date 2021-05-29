{% extends 'partials/body.twig.php'  %}

{% block title %}Avaliação - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Avalie nosso Atendimento</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page mb-3">
    <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
        <div class="full_page">
            <form class="" method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/avaliar/pedido">
            <header class='header text-left'>
                <h5>Você tem um minuto?</h5>
                <p>Deixe aqui sua opnião sobre nosso serviço!</p>
            </header>
            <section class='rating-widget text-left'>
                <p class="mt-4">Qual nota daria ao nosso Atendimento? </p>
                <div class="avaliacao_pedido" data-rating="5"></div>


                <p class="mt-4">Qual nota daria a o nosso Motoboy? </p>
                <div class="avaliacao_motoboy" data-rating="5"></div>


                <p class="mt-4">Alguma Observação? </p>
                <div class="mb-0 input-group full-width mt-0 col-md-12 text-letf p-0">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="feather-message-square"></i></span></div>
                    <textarea name="observacao" id="observacao" aria-label="With textarea" class="form-control"></textarea>
                </div>
                <div class="mb-0 input-group full-width btn-center mt-4">
                    
<button class="btn btn-success d-block mt-3 full-width">Avaliar {{empresa[':nomeFantasia']}}</button>
                </div>

                <div class="clearfix full-width text-center pt-3">ou</div>
                <div class="mb-0 input-group full-width text-center mb-4">
                    <a href="{{BASE}}{{empresa.link_site}}/meus-pedidos" class="mt-3 full-width">Não Quero Avaliar</a>
                </div>
            </section>

                <input type="hidden" id="avaliacao_pedido" name="avaliacao_pedido" value="5">
                <input type="hidden" id="avaliacao_motoboy" name="avaliacao_motoboy" value="5">
                <input type="hidden" id="numero_pedido" name="numero_pedido" value="{{pedido}}">
                <input type="hidden" id="id_cliente" name="id_cliente" value="{{id_cliente}}">
                <input type="hidden" id="id_motoboy" name="id_motoboy" value="{{id_motoboy}}">
                <input type="hidden" id="data_compra" name="data_compra" value="{{data_compra}}">

            </form>
            <div class="clearfix"></div>
            <div class="success-box text-center hide full-width"><div class="clearfix"></div><img alt="tick image" width="32" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K"><div class="text-message"><span>Agradecemos pela sua avaliação!</span></div><div class="clearfix"></div></div>



            </div>
        </div>
    </div>
    </div>

</div>
{% if delivery[':status'] == 0 %}
<div class="StatusRest">ESTAMOS FECHADOS NO MOMENTO</div>
{% endif%}
{% if sessaoLogin is not empty %}
{% if sessaoLogin != 0 %}
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footer.twig.php' %}
{% endif %}
{% endif %}
{% endblock %}
{% extends 'partials/body.twig.php'  %}

{% block title %}Meus Pedidos - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Meus Pedidos</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>
    {% for v in vendas %}
    {% if v[':status'] != 0 %}
    <div class="mb-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="bg-white rounded shadow mt-n5">
                <div class="d-flex  border-bottom p-3">
                    <div class="left col-md-8 p-0">
                    <h6 class="mb-1 font-weight-bold">#{{ v[':numero_pedido }} - Seu pedido  
                    {% if v[':status'] == 1 %}
                    foi <span class="badge badge-info">Recebido</span>
                    {% endif %}

                    {% if v[':status'] == 2 %}
                    está em <span class="badge badge-warning">Produção</span>
                    {% endif %}

                    {% if v[':status'] == 3 %}
                    {% if v[':tipo_frete'] == 1 %}
                        <span class="badge badge-secondary">Pronto para retirar</span>
                    {% else %}
                        <span class="badge badge-secondary">Saiu para entregar</span>
                    {% endif %}
                    {% endif %}

                    {% if v[':status'] == 4 %}
                    foi <span class="badge badge-success">Entregue</span>
                    {% endif %}

                    {% if v[':status'] == 5 %}
                    foi <span class="badge badge-danger">Recusado</span>
                    {% endif %}

                    {% if v[':status'] == 6 %}
                    foi <span class="badge badge-secondary">Cancelado</span>
                    {% endif %}</h6>
                    <p class="text-muted m-0 __cf_email__">Pedido do dia {{ v[':data']|date("d/m/Y") }} • Total {{ moeda[':simbolo }} {{ v[':total']|number_format(2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow mb-0">
        <a href="{{BASE}}{{empresa.link_site}}/meu-pedido/{{ v[':chave }}" class="btn btn-primary full-btn">Ver itens do pedido</a>
    </div>
    <div class="clearfix mb-3"></div>
        </div>

        
        
    </div>
    {% endif %}
    {% endfor %}

    {% if vendas is null %}
    <div class="osahan-coming-soon p-4 d-flex justify-content-center">
        <div class="osahan-img">
        <svg enable-background="new 0 0 512 512" version="1.1" class="svgPedido" fill="#807b7b" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Layer_1"/><g id="Layer_2"><g><path d="M423.9,232.9c0-12.8-10.4-23.2-23.2-23.2h-20.1c-0.5-1.1-1-2.2-1.7-3.2l-45.8-71.3c-3.3-5.1-8.4-8.7-14.3-10    c-6-1.3-12-0.2-17.2,3.1c-10.6,6.8-13.6,20.9-6.8,31.5l32,49.8H185.3l32-49.8c2.4-3.7,3.6-7.9,3.6-12.3c0-7.8-3.9-15-10.5-19.2    c-5.1-3.3-11.2-4.4-17.2-3.1c-5.9,1.3-11,4.8-14.3,10l-45.8,71.3c-0.7,1-1.2,2.1-1.7,3.2h-20.1c-12.8,0-23.2,10.4-23.2,23.2v1.5    c0,12.8,10.4,23.2,23.2,23.2h2.2l38.1,124.3c1,3.2,3.9,5.3,7.2,5.3h194.2c3.3,0,6.2-2.2,7.2-5.3l38.1-124.3h2.2    c12.8,0,23.2-10.4,23.2-23.2V232.9z M307.3,151.8c-2.3-3.6-1.3-8.4,2.3-10.8c1.8-1.1,3.8-1.5,5.9-1.1c2,0.4,3.8,1.6,4.9,3.4    l42.6,66.3h-18.5L307.3,151.8z M191.6,143.3c1.1-1.8,2.9-3,4.9-3.4c2-0.4,4.1-0.1,5.9,1.1c2.2,1.4,3.6,3.9,3.6,6.6    c0,1.5-0.4,2.9-1.2,4.2l-37.2,57.9h-18.5L191.6,143.3z M347.6,372.2H164.4l-35.2-114.6h253.5L347.6,372.2z M408.9,234.4    c0,4.5-3.7,8.2-8.2,8.2h-7.7c0,0-0.1,0-0.1,0H119.2c0,0-0.1,0-0.1,0h-7.7c-4.5,0-8.2-3.7-8.2-8.2v-1.5c0-4.5,3.7-8.2,8.2-8.2H137    c0,0,0.1,0,0.1,0h34.4c0,0,0,0,0,0c0,0,0,0,0,0h168.8c0,0,0,0,0,0c0,0,0,0,0,0h34.4c0,0,0,0,0.1,0h25.7c4.5,0,8.2,3.7,8.2,8.2    V234.4z"/><path d="M208.9,342.8c4.1,0,7.5-3.4,7.5-7.5v-40.8c0-4.1-3.4-7.5-7.5-7.5s-7.5,3.4-7.5,7.5v40.8    C201.4,339.5,204.8,342.8,208.9,342.8z"/><path d="M256,342.8c4.1,0,7.5-3.4,7.5-7.5v-40.8c0-4.1-3.4-7.5-7.5-7.5s-7.5,3.4-7.5,7.5v40.8C248.5,339.5,251.9,342.8,256,342.8z    "/><path d="M303.1,342.8c4.1,0,7.5-3.4,7.5-7.5v-40.8c0-4.1-3.4-7.5-7.5-7.5s-7.5,3.4-7.5,7.5v40.8    C295.6,339.5,298.9,342.8,303.1,342.8z"/></g></g></svg>
            <div class="osahan-text text-center mt-0">
                <p class="mb-5">Nenhum pedido encontrado, faça um pedido em nosso restaurante clicando no link abaixo</p>
                <a href="{{BASE}}{{empresa.link_site}}/" class="btn btn-primary"> Fazer um Pedido </a>
            </div>
        </div>
    </div>
    {% endif %}
    
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footer.twig.php' %}
{% endblock %}
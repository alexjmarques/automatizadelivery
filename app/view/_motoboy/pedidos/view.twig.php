{% extends 'partials/body.twig.php'  %}

{% block title %}Meus Pedidos - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Meu Pedido</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/motoboy/entregas"> Voltar</a>
    </div>

    <div class="mb-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="bg-white rounded shadow mt-n5">
            <div class="linePreloader"></div>
                <div class="d-flex  border-bottom p-3">
                    <div class="left col-md-8 p-0">
                    <h6 class="mb-1 font-weight-bold">Pedido #{{ venda[':numero_pedido }}
                    {% if venda[':status'] == 1 %}
                    <span class="badge badge-info">Recebido</span>
                    {% endif %}

                    {% if venda[':status'] == 2 %}
                    <span class="badge badge-warning">Produção</span>
                    {% endif %}

                    {% if venda[':status'] == 3 %}
                        {% if venda[':tipo_frete'] == 1 %}
                            <span class="badge badge-secondary">Pronto para retirar</span>
                        {% else %}
                            <span class="badge badge-secondary">Saiu para entregar</span>
                        {% endif %}
                    {% endif %}
                    {% if venda[':status'] == 4 %}
                    <span class="badge badge-success">Entregue</span>
                    {% endif %}

                    {% if venda[':status'] == 5 %}
                    <span class="badge badge-danger">Recusado</span>
                    {% endif %}

                    {% if venda[':status'] == 6 %}
                    <span class="badge badge-secondary">Cancelado</span>
                    {% endif %}</h6>
                    
                    </div>
                    
                </div>
            </div>
            

            <div class="bg-white shadow mb-3 ">
                <div class="gold-members d-flex justify-content-between px-3 py-2 pt-0">
                    <p class=" mt-2 __cf_email__">
                    {% for user in usuarios %}
                        {% if user[':id'] == venda[':id_cliente'] %}
                            <strong class="mediumNome">{{ user[':nome }} </strong><br/>
                        Telefone: <a href="tel:{{ user[':telefone }}">{{ user[':telefone }}</a> <br/>
                        {% endif %}
                    {% endfor %}

                    {% for end in enderecos %}
                        {% if end[':id_usuario'] == venda[':id_cliente'] %}
                            {{ end[':rua }}, {{ end[':numero }} {{ end[':complemento }} - {{ end[':bairro }} <br/>
                            CEP: {{ end[':cep }}
                        {% endif %}
                    {% endfor %}
                    </p>
                </div>
            </div>



            <div class="osahan-cart-item-profile  bg-white shadow mb-3 ">
            <form  method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/motoboy/entrega/mudarStatus" novalidate>
            <div class="d-flex  border-bottom p-3">
                <div class="left col-md-8 p-0">
                    <h6 class="mb-1 font-weight-bold">Status do Pedido</h6>
                </div>
            </div>
            
                <div class="border-bottom p-3 radioMoto">
                    <div class="custom-control custom-radio mb-2 px-0">
                        <input type="radio" id="status4" name="status" class="custom-control-input" value="4">
                        <label class="custom-control-label border osahan-check p-3 w-100 rounded bg-light status4" for="status4">
                            <b> Pedido Entregue ao cliente</b> <br>
                            <p class="small mb-0"></p>
                        </label>
                    </div>

                    <div class="custom-control custom-radio mb-2 px-0">
                        <input type="radio" id="status5" name="status" class="custom-control-input" value="5">
                        <label class="custom-control-label border osahan-check p-3 w-100 rounded bg-light status5" for="status5">
                            <b> Cliente Recusou pedido</b> <br>
                            <p class="small mb-0">Informe abaixo o motivo</p>
                        </label>
                    </div>

                    <div class="custom-control custom-radio mb-2 px-0 recusaInfo" style="display:none;">
                        <p class="mt-3 mb-2"><strong class="mediumNome">Qual motivo da recusa?</strong></p>
                        <div class="mt-0 input-group full-width">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather-message-square"></i></span></div>
                                <textarea name="observacao" id="observacao" placeholder="Alguma observação no pedido?" aria-label="With textarea" class="form-control"></textarea>
                            </div>
                        </div>
                        {% for user in usuarios %}
                            {% if user[':id'] == venda[':id_cliente'] %}
                                <input type="hidden" value="{{ user[':email }}" name="email" id="email">
                                <input type="hidden" value="{{ user[':id }}" name="id_cliente" id="id_cliente">
                            {% endif %}
                        {% endfor %}

                        <input type="hidden" value="{{ venda[':id }}" name="id" id="id">
                        <input type="hidden" value="{{ venda[':numero_pedido }}" name="numero_pedido" id="numero_pedido">
                        <input type="hidden" value="{{ venda[':chave }}" name="chave" id="chave">
                        <input type="hidden" value="{{ venda[':motoboy }}" name="id_motoboy" id="id_motoboy">
                        <div class="pt-1">
                        <button id="fullBtnNac" class="btn btn-success mb-2 mt-3 full-btn  p-3"> INFORMAR AO RESTAURANTE</button>
                        </div>
                    </div>

                <div class="clearfix"></div>
                </div>
            </form>

        </div>
    </div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footerMotoboy.twig.php' %}
{% endblock %}
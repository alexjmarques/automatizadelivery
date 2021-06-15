{% extends 'partials/body.twig.php'  %}

{% block title %}Meus Pedidos - {{empresa.nome_fantasia }}{% endblock %}

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
                    <h6 class="mb-1 font-weight-bold">Pedido #{{ venda.numero_pedido }}
                    {% for st in status %}
                            {% if venda.status == st.id %}
                            {% if venda.tipo_frete == 1 %}
                            <span class="badge badge-{{st.class}}">{{st.retirada}}</span>
                            {% else %}
                            <span class="badge badge-{{st.class}}">{{st.delivery}}</span>
                            {% endif %}
                            {% endif %}
                        {% endfor %}</h6>
                    
                    </div>
                    
                </div>
            </div>
            

            <div class="bg-white shadow mb-3 ">
                <div class="gold-members d-flex justify-content-between px-3 py-2 pt-0">
                    <p class=" mt-2 __cf_email__">
       
                            <strong class="mediumNome">{{ usuario.nome }} </strong><br/>
                        Telefone: <a href="tel:{{ usuario.telefone }}">({{ usuario.telefone[:2] }}) {{ usuario.telefone|slice(2, 5) }}-{{ usuario.telefone|slice(7, 9) }}</a> <br/>
                            {{ endereco.rua }}, {{ endereco.numero }} {{ endereco.complemento }} - {{ endereco.bairro }} <br/>
                            CEP: {{ endereco.cep }}
                    </p>
                </div>
            </div>



            <div class="osahan-cart-item-profile  bg-white shadow mb-3 ">
            <form  method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/motoboy/entrega/mudarStatus">
            <div class="d-flex  border-bottom p-3">
                <div class="left col-md-8 p-0">
                    <h6 class="mb-1 font-weight-bold">Status do Pedido</h6>
                </div>
            </div>
            
                <div class="border-bottom p-3 radioMoto">
                    <div class="custom-control custom-radio mb-2 px-0">
                        <input type="radio" id="status4" name="status" class="custom-control-input" value="4">
                        <label class="custom-control-label border osahan-check p-3 w-100 rounded bg-light status4" for="status4" required>
                            <b> Pedido Entregue ao cliente</b> <br>
                            <p class="small mb-0"></p>
                        </label>
                    </div>

                    <div class="custom-control custom-radio mb-2 px-0">
                        <input type="radio" id="status5" name="status" class="custom-control-input" value="5" required>
                        <label class="custom-control-label border osahan-check p-3 w-100 rounded bg-light status5" for="status5">
                            <b> Cliente Recusou pedido</b> <br>
                            <p class="small mb-0">Informe abaixo o motivo</p>
                        </label>
                    </div>

                    <div class="custom-control custom-radio mb-2 px-0 recusaInfo" style="display:none;">
                        <p class="mt-3 mb-2"><strong class="mediumNome">Qual motivo da recusa?</strong></p>
                        <div class="mt-0 input-group full-width">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="feather-message-square"></i></span></div>
                                <textarea name="observacao" id="observacao" placeholder="Alguma observação no pedido?" class="form-control">...</textarea>
                            </div>
                        </div>
                        {% for user in usuarios %}
                            {% if user.id == venda.id_cliente %}
                                <input type="hidden" value="{{ user.email }}" name="email" id="email">
                                <input type="hidden" value="{{ user.id }}" name="id_cliente" id="id_cliente">
                            {% endif %}
                        {% endfor %}

                        <input type="hidden" value="{{ venda.id }}" name="id_pedido" id="id_pedido">
                        <input type="hidden" value="{{ entrega.id }}" name="id_entrega" id="id_entrega">
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
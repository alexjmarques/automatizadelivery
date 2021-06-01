{% if venda.numero_pedido is not null %}
<div class="mb-3 osahan-cart-item osahan-home-page">
        <div class="p-3 pt-0 osahan-profile">
            <div class="bg-white rounded shadow">
                <div class="d-flex  border-bottom p-3">
                    <div class="left col-md-8 p-0">
                    <h6 class="mb-1 font-weight-bold">Número do Pedido: #{{ venda.numero_pedido }}</h6>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow mb-3 ">

                <div class="gold-members d-flex justify-content-between px-3 py-2">
                    <p class="text-muted m-0 __cf_email__"><span class="large"><strong  class="subprice">Dados do Cliente</strong> </span> </p>
                </div>

                <div class="gold-members d-flex justify-content-between px-3 py-2 pt-0">
                    <p class=" m-0 __cf_email__">

                            <strong class="mediumNome">{{ cliente.nome }} </strong><br/>
                        Telefone: <a href="tel:{{ cliente.telefone }}">{{ numero }}</a> <br/>

                    </p>
                </div>
        
        <div class="col-md-12 mb-3 mt-3">
        <p class="text-muted m-0 __cf_email__ float-left"><span class="medium">Pagamento via <strong class="subprice">{% for t in tipo_pagamento %}
                        {% if t.id == venda.tipo_pagamento %}
                            {{t.tipo}}
                        {% endif %}
                    {% endfor %}</strong> </span>
                    </p>
        <div class="clearfix"></div>
        <!-- <p class=" text-gray mb-0 time float-left"><span class="text-black-50"><span class="medium">Cobrar do Cliente</span> {{ moeda.simbolo }} {{ venda.total_pago|number_format(2, ',', '.') }}</span></p> -->
        
        
        <div class="clearfix"></div>
       
        </div>
        <div class="gold-members d-flex justify-content-between p-2 border-bottom pt-2">
            {% set count = venda.status %}
            {% set count = count + 1 %}
            <a onclick="mudarStatusEntrega({{venda.id}}, {{count}}, {{caixa}}, {{id_motoboy}}, {{venda.numero_pedido}}, {{venda.id_cliente}})" class="btn btn-success full_id">Entregar este pedido</a>
        </div>
    </div>
    
        </div>
    </div>
    {% endif %}
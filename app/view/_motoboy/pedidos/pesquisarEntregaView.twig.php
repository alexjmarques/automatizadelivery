{% if venda.status < 4 %}
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
                        {% if t.code == venda.tipo_pagamento %}
                            {{t.tipo}}
                        {% endif %}
                    {% endfor %}</strong> </span>
                    </p>
        <div class="clearfix"></div>
        <!-- <p class=" text-gray mb-0 time float-left"><span class="text-black-50"><span class="medium">Cobrar do Cliente</span> {{ moeda.simbolo }} {{ venda.total_pago|number_format(2, ',', '.') }}</span></p> -->
        
        
        <div class="clearfix"></div>
       
        </div>
        <div class="gold-members d-flex justify-content-between p-2 border-bottom pt-2">
            <form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/motoboy/pegar/entrega/mudarStatus" class="tooltip-label-right" enctype="multipart/form-data">
            <input type="hidden" id="pedido" name="pedido" value="{{venda.id}}">
            <button class="btn btn-success full_id">Entregar este pedido</button>
            </form>
        </div>
    </div>
    
        </div>
    </div>
{% else %}
<div class="mb-3 osahan-cart-item osahan-home-page">
    <div class="p-3 pt-0 osahan-profile">
        <div class="bg-white rounded shadow">
            <div class="d-flex  border-bottom p-3">
                <div class="left col-md-8 p-0">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2" class="errorSup mt-0">
                    <circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                    <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
                    <line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
                </svg>
                <h6 class="mt-2 mb-1 text-center">Pedido inválido</h6>
                <p class="text-center">Este pedido já foi designado a um motoboy! Verifique o número e tente novamente.</p>
                </div>
            </div>
        </div>
    </div>
</div>
{% endif %}
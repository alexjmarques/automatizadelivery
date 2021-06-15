
    {% for v in vendas %}
    {% if v.status == 3 %}
    <div class="mb-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="bg-white rounded shadow mt-n5">
                <div class="d-flex  border-bottom p-3">
                    <div class="left col-md-8 p-0">
                    <h6 class="mb-1 font-weight-bold">#{{ v.numero_pedido }} - 

                    {% for st in status %}
                            {% if v.status == st.id %}
                            {% if v.tipo_frete == 1 %}
                            {{st.retirada}}
                            {% else %}
                            {{st.delivery}}
                            {% endif %}
                            {% endif %}
                        {% endfor %}

                    </div>
                </div>
            </div>
            <div class="bg-white shadow mb-3 ">
        {% for c in carrinho %}
        {% if c.numero_pedido == v.numero_pedido %}

        {% for p in produto %}
        {% if p.id == c.id_produto %}
        {% set valorTotal = p.valor * c.quantidade %}
        <div class="gold-members d-flex justify-content-between px-3 py-2 border-bottom">
            <div class="media ">
                <div class="mr-2 text-success">&middot;</div>
                <div class="media-body">
                <p class="m-0">{{c.quantidade}}x - {{p.nome}}</p>
                </div>
            </div>
            <div class="d-flex">
                <p class="text-gray mb-0 float-right ml-2 text-muted">{{ moeda.simbolo }} {{ valorTotal|number_format(2, ',', '.') }}</p>
            </div>
        </div>
        {% endif %}
        {% endfor %}

        {% endif %}
        {% endfor %}

        <div class="gold-members d-flex justify-content-between px-3 py-2">
            <p class="text-muted m-0 __cf_email__"><span class="large"><strong  class="subprice">Dados para a {% for t in tipo_frete %}{% if t.code == v.tipo_frete %}{{t.tipo}}{% endif %}{% endfor %}</strong> </span> </p>
        </div>

        <div class="gold-members d-flex justify-content-between px-3 py-2 pt-0">
            <p class=" m-0 __cf_email__">
            {% for user in usuario %}
                {% if user.id == v.id_cliente %}
                    <strong class="mediumNome">{{ user.nome }} </strong><br/>
                   Telefone: <a href="tel:{{ user.telefone }}">({{ user.telefone[:2] }}) {{ user.telefone|slice(2, 5) }}-{{ user.telefone|slice(7, 9) }}</a> <br/>
                {% endif %}
            {% endfor %}

            {% for end in enderecos %}
                {% if end.id_usuario == v.id_cliente %}
                {% if end.principal == 1 %}
                    {{ end.rua }}, {{ end.numero }} {{ end.complemento }} - {{ end.bairro }} <br/>
                    CEP: {{ end.cep }}
                    {% endif %}
                {% endif %}
            {% endfor %}
            </p>
        </div>

        {% for end in enderecos %}
                {% if end.id_usuario == v.id_cliente %}
                {% if end.principal == 1 %}
                <div class="gold-members justify-content-between px-3 py-2 pt-2 full_id">
                <a href="https://waze.com/ul?q={{ end.rua|replace({" ": "%20"})}}%20{{ end.numero|replace({" ": "%20"})}}&navigate=yes" class="btn btn-waze full_id">Waze</a>
                </div>
                <div class="gold-members justify-content-between px-3 py-2 pt-2 full_id">
                    <a href="http://maps.google.com/maps?saddr={{ empresa.rua|replace({" ": "+"})}}+{{ empresa.numero}}&daddr={{ end.rua|replace({" ": "+"})}}+{{ end.numero|replace({" ": "+"})}}+-+{{ end.bairro|replace({" ": "+"})}}" class="btn btn-maps full_id">Google Maps</a>
                </div>
                {% endif %}
                {% endif %}
            {% endfor %}



        <div class="gold-members d-flex justify-content-between px-3 py-2 border-bottom pt-2">
            <a href="{{BASE}}{{empresa.link_site}}/motoboy/entrega/{{ v.numero_pedido }}" class="btn btn-success full_id">Informar Status do pedido</a>
        </div>
        
        <div class="col-md-12 mb-3 mt-3">
        <p class="text-muted m-0 __cf_email__ float-right"><span class="medium">Pagamento via <strong class="subprice">{% for t in tipo_pagamento %}
                        {% if t.code == v.tipo_pagamento %}
                            {{t.tipo}}
                        {% endif %}
                    {% endfor %}</strong> </span>
                    </p>
        <div class="clearfix"></div>
        <p class=" text-gray mb-3 time float-right"><span class="text-black-50"><span class="medium">Cobrar do Cliente</span> {{ moeda.simbolo }} {{ v.total_pago|number_format(2, ',', '.') }}</span></p>
        
        
        <div class="clearfix"></div>
        </div>
    </div>
    
        </div>
    </div>
    {% endif %}
    {% endfor %}

    {% if pedidosQtd == 0 %}
    <div class="mb-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="osahan-text text-center mt-3">
                <h4 class="text-primary">Nenhum pedido para entrega no momento.</h4>
                <p class="lead small mb-5">Atualize a pagina ou aguarde o carregamento automatico.</p>
                <a href="{{BASE}}{{empresa.link_site}}/motoboy/pedidos" class="btn btn-primary"> Atualizar Página</a>
            </div>
        </div>
    </div>
    {% endif %}
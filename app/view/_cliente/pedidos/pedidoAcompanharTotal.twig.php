{% for stats in status %}
    {% if venda.status == stats.id %}
        {% if venda.tipo_frete == 2 %}
            <div class="status badge-{{stats.class}} p-2 text-center">
            {{ stats.mensagem }}
            </div>
        {% else %}

            {% if stats.id == 3 %}
            <div class="status badge-{{stats.class}} p-2 text-center">
            {{ stats.retirada }}
            </div>
            {% else %}
            <div class="status badge-{{stats.class}} p-2 text-center">
            {{ stats.mensagem }}
            </div>
            {% endif %}

        {% endif %}
    {% endif %}
{% endfor %}


<div class="d-flex  border-bottom p-3" data-status="{{venda.status}}">
<div class="left col-md-8 p-0">
    <h6 class="mb-1 font-weight-bold">
        #{{ venda.numero_pedido }}
    </h6>
    <p class="text-muted m-0 __cf_email__">Tempo medio para entrega: <strong>{{ delivery.previsao_minutos }} min</strong>
    </p>
</div>
</div>
</div>
<div class="bg-white shadow mb-3 ">
{% for c in carrinho %}
{% if c.numero_pedido == venda.numero_pedido %}
{% for p in produto %}
{% if p.id == c.id_produto %}
{% set valorTotal = p.valor * c.quantidade %}
<div class="gold-members d-flex justify-content-between px-3 py-2 border-bottom">
    <div class="media full-width">
        <div class="mr-2 text-success">&middot;</div>
        <div class="media-body">
            <p class="m-0 small-mais">{{c.quantidade}}x {% if c.variacao is not null %}{% set foo = c.variacao|split(' - ') %}{{ foo[0] }}<br/>{% else %}{{ p.nome }}{% endif %}
                <span class="text-gray mb-0 right">{{ moeda.simbolo }} {{ (c.quantidade * c.valor)|number_format(2, ',', '.') }}</span>
            </p>
            {% for cartAd in carrinhoAdicional %}
            {% if p.id == cartAd.id_produto %}
            {% for a in adicionais %}
            {% if a.id == cartAd.id_adicional %}
            <p class="m-0 small subprice">
                - <strong>{{ cartAd.quantidade }}
                    x </strong>{{ a.nome }} <span class="moeda_valor right text-bold-18">{{ moeda.simbolo }} {{ (a.valor * cartAd.quantidade)|number_format(2, ',', '.') }}</span>
            </p>
            {% endif %}
            {% endfor %}
            {% endif %}
            {% endfor %}

            {% if c.variacao is not null %}
                                <p class="mb-0 mt-0"><strong>Massa: </strong>
                                    {{ foo[1] }}<br/>
                                </p>
                                
                                <p class="mb-0 mt-0"><strong>Sabor: </strong>
                                    {% if foo[2] %}{{ foo[2] }}{% endif %}
                                    {% if foo[3] %} - {{ foo[3] }}{% endif %}
                                    {% if foo[4] %} - {{ foo[4] }}{% endif %}
                                    {% if foo[5] %} - {{ foo[5] }}{% endif %}
                                </p>
                                {% endif %}

            {% for s in sabores %}
            {% if s.id == c.id_sabores %}
            <p class="m-0 small">(Sabor: <strong>{{ s.nome }} </strong>)</p>
            {% endif %}
            {% endfor %}

            {% if c.observacao != "" %}
            <p class="m-0 small">(Observação: <strong>{{ c.observacao }} </strong>)</p>
            {% endif %}
        </div>
    </div>
</div>
{% endif %}
{% endfor %}
{% endif %}
{% endfor %}


<div class="gold-members d-flex justify-content-between px-3 py-2 border-bottom">
    <p class="text-muted m-0 __cf_email__"><span class="medium">Seu pedido e do tipo <strong class="subprice">
                {% for t in tipo %}
                {% if t.code == venda.tipo_frete %}
                {{t.tipo}}
                {% endif %}
                {% endfor %}</strong> </span> <br /><span class="medium">Pagamento via <strong class="subprice">
                {% for t in pagamento %}
                {% if t.code == venda.tipo_pagamento %}
                {{t.tipo}}
                {% endif %}
                {% endfor %}</strong> </span>
    </p>
</div>


<div class="col-md-12 mb-3 mt-3">

    <p class="mb-0 mt-0">Taxa de Entrega<span class="float-right"> {{ moeda.simbolo }} {{ venda.valor_frete|number_format(2, ',', '.') }}</span></p>
    {% if venda.tipo_pagamento == 1 %}
    <p class="mb-0 mt-0">Seu Troco<span class="float-right"> {{ moeda.simbolo }} {{ (venda.troco - venda.total_pago)|number_format(2, ',', '.') }}</span></p>
    {% endif %}
    <p class=" text-gray mb-3 time mt-0 float-right"><span class="text-black-50"><span class="medium">Total do pedido</span> {{ moeda.simbolo }} {{ venda.total_pago|number_format(2, ',', '.') }}</span></p>
    <div class="clearfix"></div>

    {% if venda.status == 4 %}
    <div class="status badge-success p-2 text-center mb-3">
        Seu pedido foi Entregue
    </div>
    {% if avaliacao == 0 %}
    <script>
        var tempo = new Number();
        tempo = 10;

        function startCountdown() {
            if ((tempo - 1) >= 0) {
                var min = parseInt(tempo / 60);
                var seg = tempo % 60;
                if (min < 10) {
                    min = "0" + min;
                    min = min.substr(0, 2);
                }
                if (seg <= 9) {
                    seg = "0" + seg;
                }
                horaImprimivel = 'Você será direcionado em <strong>' + seg + '</strong> para avaliar nossos serviços';
                $("#sessao").html(horaImprimivel);

                setTimeout('startCountdown()', 1000);

                tempo--;

            } else {
                window.location.href = "{{BASE}}{{empresa.link_site}}/avaliacao/{{venda.numero_pedido}}";
            }

        }
        startCountdown();
    </script>
    <div id="sessao" class="success-box text-center full-width p-2 mb-2"></div>
    {% endif %}
    {% endif %}
    <div class="clearfix"></div>
</div>
{% if venda.status == 1 %}
<a href="#" data-toggle="modal" data-target="#cancelarPedido" class="btnEnderecos btnCancelFloatMod">Cancelar Pedido <i class="feather-delete text-danger"></i></a>
{% endif %}
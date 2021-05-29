{% extends 'partials/body.twig.php'  %}
{% block title %}Carrinho - {{empresa[':nomeFantasia']}}{% endblock %}
{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Carrinho</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>
<div class="p-3 osahan-cart-item osahan-home-page">
<div class="bg-white rounded shadow mb-3 pb-0 mt-n5">
<p class="mb-0 text-center p-3 pb-0"><span class="sx-20">Olá Visitante!</span> <br/> Você esta como Visitante, para finalizar seu pedido siga os passos a seguir! </p>
</div>
<form  method="post" id="formFinish"  action="{{BASE}}{{empresa.link_site}}/carrinho/finaliza" novalidate>
    <div class="bg-white rounded shadow mb-3 pb-0">
    <h5 class="itCart">Itens</h5>
    {% for c in carrinho %}
        {% if sessao_id == c[':sessao_id'] %}
        {% for p in produtos %}
            {% if p[':id'] == c[':id_produto'] %}
                <div class="gold-members d-flex  justify-content-between px-3 py-2 border-bottom">
                    <div class="media full-width">
                            <div class="media-body">
                            <a href="#acaoPedido" data-toggle="modal" data-target="#acaoPedido" id="btMod{{c[':id']}}" data-chave="{{c[':chave']}}" onclick="produtosModal({{ p.id']}}, {{c[':id']}})">
                                <p class="m-0 small-mais"><strong>{{c[':quantidade']}}x {{ p.nome }}</strong>
                                <span class="text-gray mb-0 float-right ml-2 text-muted text-bold-18"><strong>{{ moeda[':simbolo }} {{ (c[':quantidade'] * c[':valor'])|number_format(2, ',', '.') }}</strong></span>
                                </p>
                                
                                {% if c[':id_sabores'] != '' %}
                                <p class="m-0 mt-0"><strong>Sabor: </strong>
                                {{c[':id_sabores']|length}}
                                {% for s in sabores %}
                                    {% if s[':id'] in c[':id_sabores'] %}
                                        {{ s[':nome }}{% if c[':id_sabores']|length > 1 %}, {% endif %}
                                    {% endif %}
                                {% endfor %}
                                </p>
                                {% endif %}
            
                                {% if c[':observacao'] != '' %}
                                    <p class="mb-0 mt-0"><strong>Observação: </strong>
                                        {{c[':observacao']}}
                                    </p>
                                {% endif %}

                                {% for cartAd in carrinhoAdicional %}
                                    {% if p[':id'] == cartAd[':id_produto'] %}

                                    {% if c[':chave'] == cartAd[':chave'] %}
                                        {% for a in adicionais %}
                                            {% if a[':id'] == cartAd[':id_adicional'] %}
                                            <p class="m-0 small subprice">
                                            - <strong>{{ cartAd[':quantidade }}
                                            x </strong>{{ a[':nome }} 
                                            {% if cartAd[':valor'] == 0.00 %}
                                                <span class="moeda_valor right text-bold-18">-</span><br />
                                                {% else %}
                                                <span class="moeda_valor right text-bold-18">{{ moeda[':simbolo }} {{ (a[':valor'] * cartAd[':quantidade'])|number_format(2, ',', '.') }}</span><br />
                                                {% endif %}
                                        </p>
                                            {% endif %}
                                        {% endfor %}
                                        {% endif %}
                                    {% endif %}
                                {% endfor %}
                                </a>
                            </div>
                    </div>
                </div>
            {% endif %}
        {% endfor %}
        {% endif %}
    {% endfor %}
    </div>

<div class="shadow bg-white rounded p-3 clearfix">
<p class="mb-1">Subtotal<span class="float-right text-dark">{{ moeda[':simbolo }} {{ valorPedido|number_format(2, ',', '.') }}</span></p>

<!-- {% if produto[':valor_promocional'] != '0.00' %}{{ produto[':valor_promocional']|number_format(2, ',', '.') }}{% else %}{{ produto[':valor']|number_format(2, ',', '.') }}{% endif %}</span></p> -->
<p class="mb-1 text-success" id="trocoCliente" style="display:none;">Seu Troco<span class="float-right text-success"> </span></p>
<hr>
<input type="hidden" name="chave" id="chave" value="{{ chave }}">
{% if km > delivery[':km_entrega_excedente'] %}
<input type="hidden" name="total_pago" id="total_pago" value="{{ valorPedido }}">
<input type="hidden" name="valor_frete" id="valor_frete" value="0">
{%else%}
<input type="hidden" name="total_pago" id="total_pago" value="{{ calculoFrete + valorPedido }}">
<input type="hidden" name="valor_frete" id="valor_frete" value="{{ calculoFrete }}">
{%endif%}
<input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
<input type="hidden" name="numero_pedido" id="numero_pedido" value="{{ numero_pedido }}">
<input type="hidden" name="troco" id="troco" value="0">
<input type="hidden" name="km" id="km" value="{{km}}">
{% if km > delivery[':km_entrega_excedente'] %}
<h6 class="font-weight-bold mb-0">Total <span class="float-right">  <span id="valorProdutoMostra">{{ moeda[':simbolo }} {{ (valorPedido)|number_format(2, ',', '.') }}</span></span></h6>
{%else%}
<h6 class="font-weight-bold mb-0">Total <span class="float-right">  <span id="valorProdutoMostra">{{ moeda[':simbolo }} {{ (calculoFrete + valorPedido)|number_format(2, ',', '.') }}</span></span></h6>
{%endif%}
<!--{% if produto[':valor_promocional'] != '0.00' %}{{ produto[':valor_promocional']|number_format(2, ',', '.') }}{% else %}{{ produto[':valor']|number_format(2, ',', '.') }}{% endif %}--> 
</div>     
<a href="#NovoPorAqui" class="btn btn-success btn-block btn-lg acaoBtn btnValida" data-toggle="modal" data-target="#NovoPorAqui">FINALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></a>
</form>
</div>
</div>
{% include 'partials/modalAcaoPedido.twig.php' %}
{% include 'partials/modalCancelPedido.twig.php' %}
{% include 'partials/modalNovo.twig.php' %}

{% endblock %}

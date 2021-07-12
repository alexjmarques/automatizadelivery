{% extends 'partials/body.twig.php' %}
{% block title %}Meu pedido - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}

<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Meu pedido</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page">
        <form method="post" autocomplete="off" id="formFinish" action="{{BASE}}{{empresa.link_site}}/carrinho/finaliza" novalidate>
            <div class="bg-white rounded shadow mb-3 pb-0 mt-n5">
                <h5 class="itCart">Itens</h5>
                {% for c in carrinho %}
                {% for p in produtos %}
                {% if p.id == c.id_produto %}
                <div class="gold-members d-flex  justify-content-between px-3 py-2 border-bottom">
                    <div class="media full-width">
                        <div class="media-body">
                            <a href="#acaoPedido" data-toggle="modal" data-target="#acaoPedido" id="btMod{{c.id}}" onclick="produtosModal({{ p.id}}, {{c.id}})">
                                <p class="m-0 small-mais text-uppercase"><strong>{{c.quantidade}}x</strong> {% if c.variacao is not null %}
                                    {% set foo = c.variacao|split(' - ') %}<strong>{{ foo[0] }}</strong><br/>{% else %}<strong>{{ p.nome }}</strong>{% endif %}
                                    <span class="text-gray mb-0 float-right ml-2 text-muted text-bold-18"><strong>{{
                                            moeda.simbolo }} {{ (c.quantidade * c.valor)|number_format(2,
                                            ',', '.') }}</strong></span>
                                </p>
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
                                {% if c.id_sabores != '' %}
                                <p class="m-0 mt-0"><strong>Sabor: </strong>
                                    {{c.id_sabores|length}}
                                    {% for s in sabores %}
                                    {% if s.id in c.id_sabores %}
                                    {{ s.nome }}{% if c.id_sabores|length > 1 %}, {% endif %}
                                    {% endif %}
                                    {% endfor %}
                                </p>
                                {% endif %}

                                {% if c.observacao != '' %}
                                <p class="mb-0 mt-0"><strong>Observação: </strong>
                                    {{c.observacao}}
                                </p>
                                {% endif %}

                                {% for cartAd in carrinhoAdicional %}
                                {% if p.id == cartAd.id_produto %}

                                {% if c.id == cartAd.id_carrinho %}
                                {% for a in adicionais %}
                                {% if a.id == cartAd.id_adicional %}
                                <p class="m-0 small subprice">
                                    - <strong>{{ cartAd.quantidade }}
                                        x </strong>{{ a.nome }}
                                    {% if cartAd.valor == 0.00 %}
                                    <span class="moeda_valor right text-bold-18">-</span><br />
                                    {% else %}
                                    <span class="moeda_valor right text-bold-18">{{ moeda.simbolo }} {{ (a.valor
                                        * cartAd.quantidade)|number_format(2, ',', '.') }}</span><br />
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
                {% endfor %}
            </div>

            <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix">
                <h5 class="pb-2">Escolha uma opção <span class="statusCart">Pronto <i class="feather-check"></i></span></h5>
                <div class="mb-0 input-group full-width mt-0">
                    <select id="tipo_frete" name="tipo_frete" class="form-control" required>
                        {% if km > deliveryEntregaExcedente %}
                        {% for t in tipo %}
                        {% if t.status == 1 and t.code == 1 %}
                        <option value="1" selected>Retirada</option>
                        {% endif %}
                        {% endfor %}
                        {% else %}
                        {% for t in tipo %}
                        {% if t.status != 0 %}
                        <option value="{{t.code}}" {% if endereco is not null %}{% if t.code == 2 %}selected{% endif %}{% endif %}>{{t.tipo}}</option>
                        {% endif %}
                        {% endfor %}
                        {% endif %}
                    </select>
                </div>
                {% if km > deliveryEntregaExcedente %}
                <div class="dados-usuario row pt-3">
                    {% else %}
                    <div id="entrega_end" class="dados-usuario row pt-3">
                        {% endif %}
                        <h5 class="pt-4 pl-3 pr-3">Endereço para Retirada <span class="statusCart">Pronto <i class="feather-check"></i></span></h5>
                        {% for t in tipo %}
                        {% if t.status == 1 and t.code == 1 %}
                        <div class="card">
                            <p><strong>{{ empresaEndereco.rua }}, {{ empresaEndereco.numero }} </strong> <br />
                                {% if empresaEndereco.complemento != "" %}
                                {{ empresaEndereco.complemento }} -
                                {% endif %}{{ empresaEndereco.bairro }} - {{ empresaEndereco.cidade }}/{{ empresaEndereco.estado }}
                            </p>
                        </div>
                        {% endif %}
                        {% endfor %}
                    </div>

                    {% if km <= deliveryEntregaExcedente %}
                    <div id="entregaForm" class="dados-usuario row pt-3">
                        <h5 class="pt-4 pl-3 pr-3 pb-2">Qual o seu endereço? <span class="statusCart">Pronto <i class="feather-check"></i></span></h5>
                        <div class="card">
                            <a href="{{BASE}}{{empresa.link_site}}/enderecos" class="up_end"><i class="feather-edit-2"></i></a>
                            <p>
                                {% if endereco.principal == 1 %}
                                <strong>{{ endereco.rua }} {{ endereco.numero }}</strong> <br />
                                {{ endereco.complemento }} - {{ endereco.bairro }} - {{ endereco.cidade }}/{{ endereco.estado }}
                                {% endif %}
                            </p>
                        </div>

                    </div>
                    {% endif %}

                </div>
                <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix">
                    <h5 class="pb-2">Como você vai pagar? <span class="statusCart tipo_pagamento">Pronto <i class="feather-check"></i></span></h5>
                    <div class="mb-0 input-group full-width mt-0">
                        <select id="tipo_pagamento" name="tipo_pagamento" class="form-control" required>
                            <option value="" selected>Forma de Pagamento</option>
                            {% for pag in pagamento %}
                            <option value="{{pag.code}}">{{pag.tipo}}</option>
                            {% endfor %}
                        </select>
                    </div>

                    <div id="trocoMod" class="mt-3">
                        <p class=" mt-3">Informe o total em Dinheiro para calcular o seu Troco</p>
                        <span class="text-center mb-2">Ex.: 100,00</span>
                        <input type="text" class="form-control" id="trocoCli" placeholder="Total em Dinheiro" name="trocoCli">

                        <a class="btn btn-primary full-btn mt-2" href="#" id="calcularTroco"> Calcular Troco </a>
                    </div>


                    <div id="dinMod" class="mt-3 float-left full-width">
                        <p class="mt-0">Quanto em dinheiro?</p>
                        <input type="text" class="form-control" id="dinheiro" placeholder="Total em Dinheiro" name="dinheiro">

                    </div>

                </div>



                <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix">
                    <h5 class="pb-2">Alguma observação para acrescentar?</h5>
                    <div class="mb-0 input-group full-width mt-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather-message-square"></i></span>
                        </div>
                        <textarea name="observacao" id="observacao" placeholder="Deixe-nos saber se tem alguma observação..." aria-label="With textarea" class="form-control"></textarea>
                    </div>
                </div>


                {% if empresa.nfPaulista is not null %}
                <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix verdeNf">
                    <div class="mb-0 input-group full-width mt-0">
                        <h4>CPF na nota?</h4>
                        <p class="full-width mb-1">Informe no campo a baixo!</p>
                        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF">
                    </div>
                </div>
                {% endif %}

                {% if calculoFrete != 0 %}
                {% if cupomVerifica == 0 %}
                <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix" id="itemCupom">
                    <h5 class="pb-2">Cupom de Desconto?</h5>
                    <div class="input-group-sm mb-2 input-group full-width mt-0">
                        <input placeholder="Insira o código" type="text" class="form-control" name="cupomDesconto" id="cupomDesconto">
                        <div class="input-group-append">
                            <button id="button-addon2" type="button" class="btn btn-primary"> Aplicar</button>
                        </div>
                    </div>
                </div>
                {% endif %}
                {% endif %}

                <input type="hidden" name="valorProduto" id="valorProduto" value="{% if p.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
                <div class="shadow bg-white rounded p-3 clearfix">
                    <p class="mb-1">Subtotal<span class="float-right text-dark">{{ moeda.simbolo }} {{
                        valorPedido|number_format(2, ',', '.') }}</span></p>

                    {% if km < deliveryEntregaExcedente %}
                    {% if calculoFrete == 0 %}
                    <p class="mb-1 text-success" id="freteCal">Taxa de Entrega<span class="float-right text-success">
                            Grátis
                            {% else %}
                            <p class="mb-1 " id="freteCal">Taxa de Entrega<span class="float-right text-dark">
                                    {{ moeda.simbolo }} {{ calculoFrete|number_format(2, ',', '.') }}
                                    {% endif %}
                                </span></p>
                            {% endif %}
                            <!-- {% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}</span></p> -->
                            <p class="mb-1 text-success" id="trocoCliente" style="display:none;">Seu Troco<span class="float-right text-success"> </span></p>

                            {% if cupomVerifica == 0 %}
                            <p class="mb-1" id="cupomCal">Cupom Desconto<span class="float-right text-price"></span></p>
                            {% else %}
                            <p class="mb-1" id="cupomLoad">Cupom Desconto<span class="float-right text-price">- {{ moeda.simbolo }} {{ cupomValor|number_format(2, ',', '.') }}</span></p>
                            {% endif %}
                            <hr>
                            <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
                            {% if km > deliveryEntregaExcedente %}
                            {% if cupomVerifica == 0 %}
                            <input type="hidden" name="total_pago" id="total_pago" value="{{ valorPedido }}">
                            {% else %}
                            {% set valorNovoTotalinfos = valorPedido - cupomValor %}
                            <input type="hidden" name="total_pago" id="total_pago" value="{{ valorNovoTotalinfos }}">
                            {% endif %}

                            <input type="hidden" name="valor_frete" id="valor_frete" value="0">
                            {% else %}

                            <input type="hidden" name="valor_frete" id="valor_frete" value="{{ calculoFrete }}">
                            {% if cupomVerifica == 0 %}
                            <input type="hidden" name="total_pago" id="total_pago" value="{{ calculoFrete + valorPedido }}">
                            {% else %}
                            {% set valorNovoTotalin = (calculoFrete + valorPedido) - cupomValor %}
                            <input type="hidden" name="total_pago" id="total_pago" value="{{ valorNovoTotalin }}">
                            {% endif %}
                            {% endif %}
                            <input type="hidden" name="numero_pedido" id="numero_pedido" value="{{ numero_pedido }}">
                            <input type="hidden" name="troco" id="troco" value="0">

                            <input type="hidden" name="chave" id="chave" value="{{chave}}">
                            <input type="hidden" name="km" id="km" value="{{km}}">
                            {% if cupomVerifica == 0 %}
                            <input type="hidden" name="total" id="total" value="{{valorPedido}}">
                            <input type="hidden" name="pagCartao" id="pagCartao" value="{{ calculoFrete + valorPedido }}">
                            {% else %}
                            {% set valorNovoTotalinfo = (calculoFrete + valorPedido) - cupomValor %}
                            <input type="hidden" name="pagCartao" id="pagCartao" value="{{ valorNovoTotalinfo }}">

                            {% set valorNovoPedi = valorPedido - cupomValor %}
                            <input type="hidden" name="total" id="total" value="{{valorNovoPedi}}">
                            {% endif %}

                            {% if km > deliveryEntregaExcedente %}
                            {% for t in tipo %}
                            {% if t.status == 1 and t.code == 1 %}
                            <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="valorProdutoMostra">{{
                                    moeda.simbolo }} {{ (valorPedido)|number_format(2, ',', '.') }}</span></span></h6>
                            {% endif %}
                            {% endfor %}
                            {% else %}
                            {% if cupomVerifica == 0 %}
                            <h6 class="font-weight-bold mb-0">Total<span class="float-right"> <span id="valorProdutoMostra">{{moeda.simbolo }} {{ (calculoFrete + valorPedido)|number_format(2, ',', '.')}}</span></span></h6>
                            {% else %}
                            {% set valorNovoTotal = (calculoFrete + valorPedido) - cupomValor %}
                            <h6 class="font-weight-bold mb-0">Total<span class="float-right"> <span id="valorProdutoMostra">{{ moeda.simbolo }} {{ valorNovoTotal|number_format(2, ',', '.')}}</span></span></h6>
                            {% endif %}


                            {% endif %}
                            <!--{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}-->
                </div>
                {% if km > deliveryEntregaExcedente %}
                {% for t in tipo %}
                {% if t.status == 1 and t.code == 1 %}
                <div class="btn_acao">
                    <div class="carrega"></div>
                    <button class="btn btn-success btn-block btn-lg acaoBtn btnValida">FINALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></button>
                    {% endif %}
                    {% endfor %}
                    {% else %}

                    <button class="btn btn-success btn-block btn-lg acaoBtn btnValida">FINALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></button>
                    {% endif %}
                </div>
        </form>
    </div>
</div>
{% if km > deliveryEntregaExcedente %}
{% for t in tipo %}
{% if t.status == 0 and t.code == 1 %}
<div id="foraDaAreaEntrega"></div>
{% include 'partials/modalAlertSite.twig.php' %}
{% endif %}
{% endfor %}
{% endif %}
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/modalAcaoPedido.twig.php' %}
{% include 'partials/modalPedido.twig.php' %}

{% endblock %}
{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Novo Pedido</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/categorias">Pedidos</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo Pedido</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<div class="card mb-4">
    <div id="smartWizardPedidos" class="sw-main sw-theme-check">
        <ul class="card-header nav nav-tabs step-anchor">
            <li class="p-3 nav-item done"><a href="#">Cliente<br /><small>Dados do Cliente e Entrega</small></a></li>
            <li class="p-3 nav-item done"><a href="#">Produtos<br /><small>Produtos do pedido</small></a></li>
            <li class="p-3 nav-item active"><a href="#step-2">Pedido<br /><small>Entrega e Pagamento</small></a></li>
        </ul>
        <div class="card-body">
            <div id="step-2">
                <div class="osahan-checkout">


                    <div class="p-0 osahan-cart-item osahan-home-page flex">
                        <form method="post" autocomplete="off" id="formFinish" action="{{BASE}}{{empresa.link_site}}/admin/carrinho/finaliza" novalidate>
                            <div class="bg-white mb-3 pb-0 col-md-7 float-left">
                                <table class="data-table data-table-simple responsive nowrap">
                                    <thead class="linhaTop">
                                        <tr>
                                            <th style="width: 30px;">#</th>
                                            <th>Item</th>
                                            <th style="width: 50px !important;">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {% for c in carrinho %}
                                        {% for p in produtos %}
                                        {% if p.id == c.id_produto %}
                                        <tr>
                                            <td>
                                                <a href="{{BASE}}{{empresa.link_site}}/admin/carrinho/deletar/{{c.id_produto}}/{{c.id}}" class="btn excluir_prod"><i class="simple-icon-close"></i></a>
                                            </td>
                                            <td>
                                                <div class="media full-width">
                                                    <div class="media-body">

                                                        <p class="m-0 small-mais"><strong>{{c.quantidade}}x

                                                                {% if c.variacao is not null %}
                                                                {% set foo = c.variacao|split(' - ') %}<strong>{{ foo[0] }}</strong><br />{% else %}<strong>{{ p.nome }}</strong>{% endif %}

                                                        </p>
                                                        {% if c.variacao is not null %}
                                                        <p class="mb-0 mt-0"><strong>Borda:</strong>
                                                            {{ foo[1] }}<br />
                                                        </p>

                                                        <p class="mb-0 mt-0"><strong>Sabor: </strong>
                                                            {% if foo[2] %}{{ foo[2] }}{% endif %}
                                                            {% if foo[3] %} - {{ foo[3] }}{% endif %}
                                                            {% if foo[4] %} - {{ foo[4] }}{% endif %}
                                                            {% if foo[5] %} - {{ foo[5] }}{% endif %}
                                                        </p>
                                                        {% endif %}

                                                        {% if c.id_sabores != '' %}
                                                        {% for s in sabores %}
                                                        {% if s.id in c.id_sabores %}
                                                        {{ s.nome }}{% if c.id_sabores|length > 1 %}, {% endif %}
                                                        {% endif %}
                                                        {% endfor %}

                                                        {% endif %}

                                                        </p>

                                                        {% for cartAd in carrinhoAdicional %}
                                                        {% if p.id == cartAd.id_produto %}
                                                        {% for a in adicionais %}
                                                        {% if a.id == cartAd.id_adicional and p.id == cartAd.id_produto and c.id ==
                                            cartAd.id_carrinho %}
                                                        <p class="m-0 small subprice">
                                                            - <strong>{{ cartAd.quantidade }}
                                                                x </strong>{{ a.nome }} <span class="moeda_valor right text-bold-18">{{ moeda.simbolo }} {{
                                                    (a.valor * cartAd.quantidade)|number_format(2, ',', '.') }}</span>
                                                        </p>
                                                        {% endif %}
                                                        {% endfor %}
                                                        {% endif %}
                                                        {% endfor %}

                                                        {% if c.observacao != '' %}
                                                        <p class="mb-0 mt-0"><strong>Observação: </strong>
                                                            {{c.observacao}}
                                                        </p>
                                                        {% endif %}
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="text-gray mb-0 float-right ml-2 text-muted text-bold-18"><strong>{{ moeda.simbolo }} {{ (c.quantidade * c.valor)|number_format(2,',', '.') }}</strong></span>
                                            </td>
                                        </tr>

                                        {% endif %}
                                        {% endfor %}
                                        {% endfor %}
                                    </tbody>
                                </table>
                            </div>

                            <div class="mb-3 p-3 py-3 col-md-5 float-left cinza">
                                <h5 class="full-width pb-0">Entrega ou Retirada?</h5>
                                <div class="mb-0 input-group full-width mt-0">
                                    <select id="tipo_frete" name="tipo_frete" class="form-control" required>
                                        {% if km > km_entrega_excedente %}
                                        {% for t in tipo %}
                                        {% if t.status == 1 and t.code == 1 %}
                                        <option value="1" selected>Retirada</option>
                                        {% endif %}
                                        {% endfor %}
                                        {% else %}
                                        <option value="" {% if endereco is null %}selected{% endif %}>Tipo de Entrega
                                        </option>
                                        {% for t in tipo %}
                                        <option value="{{t.code}}" {% if endereco is not null %}{% if t.code==2 %}selected{%
                                            endif %}{% endif %}>{{t.tipo}}</option>
                                        {% endfor %}
                                        {% endif %}
                                    </select>
                                </div>
                                {% if km > km_entrega_excedente %}
                                {% for t in tipo %}
                                {% if t.status == 1 and t.code == 1 %}
                                <div class="clearfix"></div>
                                <div class="dados-usuario row pt-3 m-0 full-width">
                                    {% endif %}
                                    {% endfor %}
                                    {% else %}
                                    <div class="clearfix"></div>
                                    <div id="entrega_end" class="dados-usuario pt-3 m-0 full-width">
                                        {% endif %}
                                        <div class="card full-width">
                                            <div>
                                                <strong class="m-0">Nosso Endereço para Retirada</strong>
                                                <hr class="mt-2 mb-2">
                                                <p><strong>Endereço: </strong> {{ enderecoAtivo.rua }}, {{ enderecoAtivo.numero }}
                                                    <br />
                                                    {% if enderecoAtivo.complemento != "" %}
                                                    <strong>Complemento: </strong>{{ enderecoAtivo.complemento }}<br />
                                                    {% endif %}
                                                    <strong>Bairro: </strong> {{ enderecoAtivo.bairro }}
                                                </p>
                                                <strong>CEP: </strong> {{ enderecoAtivo.cep }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    {% if km <= km_entrega_excedente %}
                                    <div id="entregaForm" class="dados-usuario pt-3 full-width">
                                        <div class="card full-width">
                                            <strong class="mt-2 mb-2">Confirme seus Dados de Entrega</strong>
                                            <hr class="m-2">
                                            <p>
                                                {% if endereco.principal == 1 %}
                                                <strong>Endereço: </strong> {{ endereco.rua }}, {{ endereco.numero }}
                                                <br />
                                                <strong>Complemento: </strong>{{ endereco.complemento }}<br />
                                                <strong>Bairro: </strong>{{ endereco.bairro }}<br />
                                                <strong>CEP: </strong>{{ endereco.cep }}
                                                {% endif %}
                                            </p>
                                        </div>
                                    </div>
                                    {% endif %}

                                    <div class="mb-0 input-group full-width mt-2">
                                        <hr>
                                        <h5 class="full-width pb-0">Formas de Pagamento</h5>
                                        <select id="tipo_pagamento" name="tipo_pagamento" class="form-control" required>
                                            <option value="">Forma de Pagamento</option>
                                            {% for pag in pagamento %}
                                            <option value="{{pag.code}}">{{pag.tipo}}</option>
                                            {% endfor %}
                                        </select>
                                    </div>

                                    <div id="trocoMod" class="mt-1">
                                        <p class=" mt-3">Informe o total em Dinheiro para calcular o seu Troco</p>
                                        <span class="text-center mb-2">Ex.: 100,00</span>
                                        <input type="text" class="form-control" id="trocoCli" placeholder="Total em Dinheiro" name="trocoCli">

                                        <a class="btn btn-primary full-btn" href="#" id="calcularTroco"> Calcular Troco </a>

                                    </div>
                                    <hr>
                                    <div class="mb-0 input-group full-width mt-0">
                                        <h5 class="full-width pb-0">Observações do pedido</h5>
                                        <div class="clearfix"></div>
                                        <textarea name="observacao" id="observacao" placeholder="" aria-label="With textarea" class="form-control"></textarea>
                                    </div>


                                    {% if empresa.nfPaulista is not null %}

                                    <div class="mb-0 input-group full-width mt-0">
                                        <h5 class="full-width pb-0">CPF na nota?</h5>
                                        <p class="full-width mb-1">Informe no campo a baixo!</p>
                                        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF">
                                    </div>

                                    {% endif %}
                                    <div class="full-width pt-4 pb-4">
                                        <input type="hidden" name="valorProduto" id="valorProduto" value="{% if p.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">

                                        <p class="mb-1">Subtotal<span class="float-right text-dark">{{ moeda.simbolo }} {{
                                            valorPedido|number_format(2, ',', '.') }}</span></p>
                                        {% if km <= km_entrega_excedente %} <p class="mb-1" id="freteCal">Taxa de
                                            Entrega<span class="float-right text-dark">{{ moeda.simbolo }} {{
                                            calculoFrete|number_format(2, ',', '.') }}</span></p>
                                        {% endif %}
                                        <!-- {% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}</span></p> -->
                                        <p class="mb-1 text-success" id="trocoCliente" style="display:none;">Seu
                                            Troco<span class="float-right text-success"> </span></p>
                                        <hr>
                                        {% if km > km_entrega_excedente %}
                                        <input type="hidden" name="total_pago" id="total_pago" value="{{ valorPedido }}">
                                        <input type="hidden" name="valor_frete" id="valor_frete" value="0">
                                        {% else %}
                                        <input type="hidden" name="total_pago" id="total_pago" value="{{ calculoFrete + valorPedido }}">
                                        <input type="hidden" name="valor_frete" id="valor_frete" value="{{ calculoFrete }}">
                                        {% endif %}
                                        <input type="hidden" name="numero_pedido" id="numero_pedido" value="{{ numero_pedido }}">
                                        <input type="hidden" name="troco" id="troco" value="0">
                                        <input type="hidden" name="total" id="total" value="{{ valorPedido }}">

                                        <input type="hidden" name="km" id="km" value="{{km}}">
                                        {% if km > km_entrega_excedente %}
                                        {% for t in tipo %}
                                        {% if t.status == 1 and t.code == 1 %}
                                        <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="valorProdutoMostra">{{ moeda.simbolo }} {{
                                                    (valorPedido)|number_format(2, ',', '.') }}</span></span></h6>
                                        {% endif %}
                                        {% endfor %}
                                        {% else %}
                                        <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="valorProdutoMostra">{{ moeda.simbolo }} {{ (calculoFrete +
                                                    valorPedido)|number_format(2, ',', '.') }}</span></span></h6>
                                        {% endif %}
                                        {#<!--{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}--> #}
                                    </div>
                                    {% if km > km_entrega_excedente %}
                                    {% for t in tipo %}
                                    {% if t.status == 1 and t.code == 1 %}
                                    <button class="btn btn-success btn-block btn-lg acaoBtn btnValida p-4" type="submit">FINALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></button>
                                    {% endif %}
                                    {% endfor %}
                                    {% else %}
                                    <button class="btn btn-success btn-block btn-lg acaoBtn btnValida p-4" type="submit">FINALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></button>
                                    {% endif %}
                                </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

{% endblock %}
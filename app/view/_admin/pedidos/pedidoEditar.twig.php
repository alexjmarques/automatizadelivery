{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Editar Pedido #{{ pedido.numero_pedido }}</h1>
<div class="separator mb-5"></div>
<div class="card mb-4">
    <div id="smartWizardPedidos" class="sw-main sw-theme-check">
        <div class="card-body">
            <div class="col-md-7 float-left p-0">

                <div id="step-1" class="tab-pane step-content" style="display: block;">
                    {% if empresa.id_categoria == 6 %}
                    <div class="pt-3 title bg-white pl-0">
                        {% for tam in tamanhos %}
                        <div class="osahan-slider-item col-4 float-left pb-4 pl-0 px-1">
                            <div class=" bg-white h-100 overflow-hidden position-relative">
                                <button class="p-2 position-relative btn-categoria pizza" data-toggle="modal" data-target="#modProduto" onclick="produtoPizzaModalEditar({{ tam.id }}, {{ pedido.numero_pedido }})">
                                    <div class="list-card-body">
                                        <h6 class="mb-1">
                                            {{ tam.nome }}
                                        </h6>
                                    </div>
                                </button>
                            </div>
                        </div>
                        {% endfor %}
                        <div class="clearfix"></div>
                    </div>
                    {% endif %}
                    {% set idCategoria = 0 %}
                    {% set idTamanhos = 0 %}
                    {% for c in categoria %}
                    {% for tc in tamanhosCategoria %}
                    {% if c.id == tc.id_categoria %}
                    {% set idCategoria = c.id %}
                    {% set idTamanhos = tc.id_tamanhos %}
                    {% endif %}
                    {% endfor %}
                    {% if c.id == idCategoria %}

                    {# {% if c.produtos > 0 %}
                <div class="pt-3 title d-flex bg-white">
                    <h5 id="{{ c.slug }}" name="{{ c.slug }}" class="mt-1 bold">{{ c.nome }}</h5>
                    
                </div>
                <div class="pt-3 title bg-white">
                    {% for tc in tamanhosCategoria %}
                    {% if c.id == tc.id_categoria %}
                    {% for tam in tamanhos %}
                    {% if c.id == tc.id_categoria and tam.id == tc.id_tamanhos %}

                    {% for i in range(1, tam.qtd_sabores) %}
                    <div class="osahan-slider-item col-3 float-left pb-4 pl-0 px-1">
                        <div class="list-card bg-white h-100 overflow-hidden position-relative">
                            <button class="p-2 position-relative" data-toggle="modal" data-target="#modProduto" onclick="produtoPizzaModalEditar('{{c.slug}}', {{tc.id}}, {{tam.id}}, {{i}})">
                                <div class="list-card-body">
                                    <h6 class="mb-1">

                                        Pizza {{tam.nome}} {% if i == 1 %}{{i}} SABOR {% else %}{{i}} SABORES {% endif %}

                                    </h6>
                                    <p class="text-gray mb-0 pb-0">Esta pizza tem {% if tam.qtd_pedacos == 1 %} {{tam.qtd_pedacos}} pedaço {% else %} {{tam.qtd_pedacos}} pedaços {% endif %}</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    {% endfor %}

                    {% endif %}
                    {% endfor %}
                    {% endif %}
                    {% endfor %}
                    <div class="clearfix"></div>
                </div>
                {% endif %} #}

                    {% else %}


                    {% if c.produtos > 1 %}
                    <div class="px-3 pt-3 title d-flex bg-white">
                        <h5 id="{{ c.slug }}" name="{{ c.slug }}" class="mt-1 bold">{{ c.nome }}</h5>
                    </div>
                    {% endif %}
                    <ul class="lista">
                        {% for p in produto %}
                        {% if c.id == p.id_categoria %}
                        <li class="col-md-4 disable-text-selection bg-white" data-toggle="modal" data-target="#modProduto" onclick="produtoModalEditar({{p.id}}, {{ pedido.numero_pedido }})">
                            <div class="col-md-12 mb-4 p-0">
                                <div class="card" style="height: 93px;">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-12">
                                                {% if p.imagem is not empty %}
                                                <img src="{{BASE}}uploads/{{p.imagem}}" class="card-img-top" style="float: left;width: 90px;margin: 0 5px 0 0;border-radius: 5px;">
                                                {% endif %}
                                                <h6 class="mb-1">
                                                    <a href="#" class="text-black"><strong>{{p.nome}}</strong></a>
                                                </h6>

                                                {% if p.valor_promocional != '0.00' %}
                                                <p class="text-black mb-1 dequanto pmais"><span class="float-left por mr-2">De</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{
                                                    p.valor|number_format(2, ',', '.') }}</span></p>
                                                <p class="text-black mb-1 porquanto pmais"> <span class="float-left por pl-4 mr-2">Por</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{
                                                    p.valor_promocional|number_format(2, ',', '.') }}</span></p>
                                                {% else %}
                                                <p class="text-black mb-1 porquanto pmais"> <span class="float-left text-black-50"> {{moeda.simbolo}} {{
                                                    p.valor|number_format(2, ',', '.') }}</span></p>
                                                {% endif %}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        {% endif %}
                        {% endfor %}
                    </ul>

                    {% endif %}
                    {% endfor %}

                </div>
            </div>

            <div class="col-md-5 float-left pl-3 pt-0 pr-0">
                <div class="produtosEditar p-3">
                    <h4><strong>Cliente:</strong> {{ cliente.nome }}</h4>
                    <h4><strong>Telefone:</strong> ({{ cliente.telefone[:2] }}) {{ cliente.telefone|slice(2, 5) }}-{{ cliente.telefone|slice(7, 9) }}</h4>
                    <div class="separator mb-2 mt-3"></div>

                    <form method="post" autocomplete="off" id="formFinish" action="{{BASE}}{{empresa.link_site}}/admin/carrinho/finaliza-update" novalidate>
                        <div class="bg-white mb-3 col-md-12 p-0 float-left">
                            <table id="customers" class="data-table">
                                <thead class="linhaTop">
                                    <tr>
                                        <th>Item</th>
                                        <th style="width: 50px !important;">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for c in carrinho %}
                                    {% for p in produto %}
                                    {% if p.id == c.id_produto %}
                                    <tr>
                                        <td>
                                            
                                            <div class="media full-width">
                                                <a href="{{BASE}}{{empresa.link_site}}/admin/carrinho/deletar/{{c.id_produto}}/{{c.id}}/{{ pedido.id }}" class="btn excluir_prod"><i class="simple-icon-close"></i></a>
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

                        <div class="mb-3 col-md-12 p-3 float-left cinza">
                                <div class="mb-0 input-group full-width mt-2">
                                    <h5 class="full-width pb-0 bold">Formas de Pagamento</h5>
                                    <select id="tipo_pagamento" name="tipo_pagamento" class="form-control" required>
                                        <option value="">Forma de Pagamento</option>
                                        {% for pag in pagamento %}
                                        <option value="{{pag.code}}" {% if pedido.tipo_pagamento == 1 %} {% else %} {% if pag.code == pedido.tipo_pagamento %} selected {% endif %} {% endif %}>{{pag.tipo}}</option>
                                        {% endfor %}
                                    </select>
                                </div>
                                

                                <div id="trocoMod" class="mt-1" style="display: block;">
                                    <p class=" mt-3">Informe o total em Dinheiro para calcular o seu Troco</p>
                                    <span class="text-center mb-2">Ex.: 100,00</span>
                                    <input type="text" class="form-control" id="trocoCli" placeholder="Total em Dinheiro" name="trocoCli">

                                    <a class="btn btn-primary full-btn" href="#" id="calcularTroco"> Calcular Troco </a>

                                </div>
                                <hr>
                                <div class="mb-0 input-group full-width mt-0">
                                    <h5 class="full-width pb-0 bold">Observações do pedido</h5>
                                    <div class="clearfix"></div>
                                    <textarea name="observacao_final" id="observacao_final" placeholder="" aria-label="With textarea" class="form-control"></textarea>
                                </div>

                                {% if empresa.nfPaulista is not null %}
                                <div class="mb-0 input-group full-width mt-0">
                                    <h5 class="full-width pb-0 bold">CPF na nota?</h5>
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

                                    <input type="hidden" name="id" id="id" value="{{pedido.id}}">

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
                                <button class="btn btn-success btn-block btn-lg acaoBtn btnValida p-4" type="submit">ATUALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></button>
                                {% endif %}
                                {% endfor %}
                                {% else %}
                                <button class="btn btn-success btn-block btn-lg acaoBtn btnValida p-4" type="submit">ATUALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></button>
                                {% endif %}
                            </div>

                    </form>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="modal fade modal-right" id="modProduto" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content pb-0">
            <div class="modal-body p-0" id="mostrarProduto">
                <div class="text-center pb-3">
                    <h4 class="text-center pt-5">Carregando...</h4>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none">
                            <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform>
                        </path>
                    </svg>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>

            </div>
        </div>

    </div>

    {% endblock %}
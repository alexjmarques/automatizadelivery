{% extends 'partials/body.twig.php' %}
{% block title %}{{ produto.nome }} - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">{{ produto.nome }}</h5>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page">

        <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/produto/addCarrinho/adicionais" novalidate>
            <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
                {% if produto.imagem is not empty %}
                <img alt="{{ produto.nome }}" src="{{BASE}}uploads/{{ produto.imagem }}"
                    class="mr-2 rounded-circle img-fluid">
                {% endif %}
                <div class="d-flex flex-column">
                    <h6 class="mb-1 font-weight-bold">{{ carrinho.quantidade }}x {{ produto.nome }}</h6>
                    {% if carrinho.id_sabores != '' %}
                    <p class="mb-0"><strong>Sabor: </strong>
                        {% for sab in produtoSabores %}
                        {% if carrinho.id_sabores == sab.id %}
                        {{sab.nome}}
                        {% endif %}
                        {% endfor%}
                    </p>
                    {% endif %}
                    {% if carrinho.observacao != '' %}
                    <p class="mb-0 mt-0"><strong>Observação: </strong>
                        {{carrinho.observacao}}
                    </p>
                    {% endif %}
                </div>


            </div>
            {% if produto.adicional is not null %}
            <div class="bg-white rounded shadow mb-3 py-2">
                <div class="col-md-12">
                    <div class="mdc-card" id="add_itens">
                        <h4 class="pl-0">Turbine seu pedido</h4>
                        <p>Adicione a seu pedido complementos adicionais!</p>
                        {% for ta in tipoAdicional %}
                        <div id="{{ ta.slug }}" data-tipo="{{ ta.slug }}" data-tipo_escolha="{{ ta.tipo_escolha}}"
                            data-qtd="{{ ta.qtd }}">
                            <h6 class="clearfix mt-3 bold">{{ ta.tipo}}
                                {% if ta.tipo_escolha == 2 %}
                                {% if ta.qtd == 1 %}
                                <span class="adicional_item"> ({{ta.qtd}} item Obrigatório) </span> <span
                                    class="adicional_item_ok"> {{ta.qtd}} selecionado </span>
                                {% else %}
                                <span class="adicional_item"> ({{ta.qtd}} itens Obrigatórios) </span> <span
                                    class="adicional_item_ok"> {{ta.qtd}} selecionados </span>
                                {% endif %}
                                {% endif %}
                                {% if ta.tipo_escolha == 3 %}
                                <span class="adicional_item"> (escolha até {{ta.qtd}} itens) </span> <span
                                    class="adicional_item_ok"></span>
                                {% endif%}
                            </h6>

                            {% for padici in produtoAdicional %}
                            {% if ta.id == padici.tipo_adicional %}
                            {% if padici.id in produto.adicional %}
                            <div class="custom-control border-bottom py-3">
                                <input class="custom-control-input" type="checkbox" data-tipoSlug="{{ ta.slug}}"
                                    id="id_adicional{{padici.id}}" name="adicional[]" value="{{padici.id}}"
                                    valor="{% if padici.valor is null %}0.00{% else %}{{padici.valor}}{% endif %}" {%
                                    for padiciCart in produtoAdicionalCart %} {% if padici.id==padiciCart.code_adicional
                                    %}checked{% endif %}{% endfor%}>
                                <label class="custom-control-label" for="id_adicional{{padici.id}}">{{padici.nome}}
                                    {% if padici.valor == 0.00 %}
                                    <br /><span class="text-success">Grátis</span>
                                    {% else %}
                                    <br /><span class="text-muted">{{moeda.simbolo}}
                                        {{padici.valor|number_format(2, ',', '.')}}</span>
                                    <input type="hidden" id="valor{{padici.id}}" name="valor{{padici.id}}"
                                        value="{{padici.valor}}">
                                    {% endif %}
                                </label>


                                <div class="input-group plus-minus-input id_adicional{{padici.id}} {% for padiciCart in produtoAdicionalCart %} {% if padici.id == padiciCart.code_adicional %}abreelemento{% endif %}{% endfor%}"
                                    style="display:none;">
                                    <div class="input-group-button">
                                        <button type="button" class="btn btn-danger btn-number minuss"
                                            id-select="{{padici.id}}" data-quantity="minus"
                                            data-field="qtd_ad{{padici.id}}">
                                            <i class="feather-minus"></i>
                                        </button>
                                    </div>
                                    <input type="number" id="qtd_ad{{padici.id}}" min="1" name="qtd_ad{{padici.id}}"
                                        class="input-group-field qtd-control id_adicional{{padici.id}}"
                                        value="{% for padiciCart in produtoAdicionalCart %}{% if padici.id == padiciCart.code_adicional %}{{padiciCart.quantidade}}{% endif %}{% endfor%}">
                                    <div class="input-group-button">
                                        <button type="button" class="btn btn-success btn-number"
                                            id-select="{{padici.id}}" data-quantity="plus"
                                            data-field="qtd_ad{{padici.id}}">
                                            <i class="feather-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {% endif%}
                            {% endif%}
                            {% endfor%}
                        </div>
                        {% endfor%}

                    </div>
                </div>
            </div>
            {% endif%}
            <input type="hidden" name="id_carrinho" id="id_carrinho" value="{{carrinho.id}}">
            <input type="hidden" name="id_produto" id="id_produto" value="{{produto.id}}">
            <input type="hidden" name="id_cliente" id="id_cliente" value="{{usuario.id}}">

            <input type="hidden" name="numero_pedido" id="numero_pedido" value="{{carrinho.numero_pedido}}">
            <input type="hidden" name="chave" id="chave" value="{{carrinho.chave}}">
            {% set valorTotal = (carrinho.quantidade * carrinho.valor) + somaAdicional.total %}
            <input type="hidden" name="valorFinal" id="valorFinal" value="{{ valorTotal }}">

            <input type="hidden" name="valor" id="valor"
                value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
            <div class="shadow bg-white rounded p-3 clearfix">
                <p class="mb-1">Valor unitário <span class="float-right text-dark">{{ moeda.simbolo }}
                        {% if produto.valor_promocional != '0.00' %}{{ carrinho.valor|number_format(2, ',', '.') }}{%
                        else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}</span></p>
                <hr>
                <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="total">{{ moeda.simbolo }}
                            {{ valorTotal|number_format(2, ',', '.') }}</span></span></h6>
            </div>

            <a href="{{BASE}}{{empresa.link_site}}/carrinho" class="btn btn-success btn-block btn-lg addStyle">ATUALIZAR
                PEDIDO <i class="feather-shopping-cart"></i></a>
    </div>
    <form>
</div>
{% include 'partials/modal.twig.php' %}


{% include 'partials/footer.twig.php' %}
{% endblock %}
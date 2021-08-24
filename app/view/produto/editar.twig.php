{% extends 'partials/body.twig.php'  %}
{% block title %}{{ produto.nome }} - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">{{ produto.nome }}</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/carrinho"> Voltar</a>
    </div>

<div class="p-3 osahan-cart-item osahan-home-page">

<form  method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/produto/updateCarrinho/{{produto.id}}">

        <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
        {% if produto.imagem is not empty %}
        <img alt="{{ produto.nome }}" src="{{BASE}}uploads/{{ produto.imagem }}" class="mr-2 rounded-circle img-fluid">
            {% endif %}
            <div class="d-flex flex-column">
                <h6 class="mb-1 font-weight-bold">{{ produto.nome }}</h6>
                <p class="mb-0">{{ produto.descricao }}</p>
            </div>
        </div>

        <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3">
        <p class="mb-1 mt-2 font-weight-bold line-e">Informe a quantidade?</p>
            <div class="col-lg-3 quantidade">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number quantity-left-minus"  data-type="minus" data-field=""><span class="feather-minus"></span></button>
                    </span>
                        <input type="text" id="quantity" name="quantity" class="count-number-input input-number" value="{{carrinho.quantidade}}" min="1" max="100">
                        <input type="hidden" id="valor" name="valor" value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-number quantity-right-plus" data-type="plus" data-field=""><span class="feather-plus"></span></button>
                    </span>
                </div>
            </div>
        </div>

    {% if produto.sabores is not null %}
    <div class="bg-white rounded shadow mb-3 py-2">
        <div class="col-md-12">
            <div class="mdc-card" id="add_itenSabores">
                <h4>Sabores</h4>
                
                    {% for padici in produtoSabores %}
                        {% if padici.id in carrinho.id_sabores %}
                        <div class="custom-control custom-radio border-bottom py-2">
                            <input class="custom-control-input" type="radio" id="id_sabor{{padici.id}}" name="sabores[]" value="{{padici.id}}" {% if padici.id in carrinho.id_sabores %}checked{% endif%}>
                            <label class="custom-control-label" for="id_sabor{{padici.id}}">{{padici.nome}}</label>
                        </div>
                        {% endif%}
                    {% endfor%}
                </div>
            </div>
        </div>

    {% endif%}
        <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix">
            <div class="mb-0 input-group full-width">
                <div class="input-group-prepend"><span class="input-group-text"><i class="feather-message-square"></i></span></div>
                <textarea name="observacao" id="observacao" placeholder="Alguma observação no pedido?" aria-label="With textarea" class="form-control">{{carrinho.observacao}}</textarea>
            </div>
        </div>
        {% if produto.sabores is null %}
            <input type="hidden" name="id_adicional" id="id_adicional" value="0">
        {% else %}
            <input type="hidden" name="id_adicional" id="id_adicional" value="1">
        {% endif %}
        <input type="hidden" name="id_carrinho" id="id_carrinho" value="{{carrinho.id}}">
        <input type="hidden" name="id_produto" id="id_produto" value="{{produto.id}}">
        <input type="hidden" name="adicional" id="adicional" value="{{produto.adicional}}">
        <input type="hidden" name="valor" id="valor" value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
        <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
        <input type="hidden" name="chave" id="chave" value="{{carrinho.chave}}">
        <input type="hidden" name="quantidadeAnterior" id="quantidadeAnterior" value="{{carrinho.quantidade}}">

        <div class="shadow bg-white rounded p-3 clearfix">
            <p class="mb-1">Valor unitário <span class="float-right text-dark">{{ moeda.simbolo }} 
            {% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}</span></p>
            <hr>
            <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="total">{{ moeda.simbolo }} {{ (carrinho.quantidade * carrinho.valor)|number_format(2, ',', '.') }}</span></span></h6>
        </div>
                <button class="btn btn-success btn-block btn-lg">ATUALIZAR ITEM <i class="feather-shopping-cart"></i></button>

        </div>
    <form>
</div>

{% include 'partials/modal.twig.php' %}
{% if isLogin is not empty %}
{% if isLogin != 'undefined' %}
{% if isLogin != 0 %}
{% include 'partials/footer.twig.php' %}
{% endif %}
{% endif %}
{% endif %}
{% endblock %}
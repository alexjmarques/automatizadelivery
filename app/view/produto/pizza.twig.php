{% extends 'partials/body.twig.php' %}
{% block title %} {{categoria.nome}} {{tamanho.nome}} {% if ii == 1 %}{{i}} SABOR {% else %}{{ ii }} SABORES {% endif %}({{tamanho.qtd_pedacos}} PEDAÇOS) - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}
{% if detect.isMobile() %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">
        {{categoria.nome}}</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>
    <div class="p-3 osahan-cart-item osahan-home-page">
        <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/{{categoriaSlug}}/produto/{{tamanhoCatId}}/{{tamanhoId}}/{{ii}}/addCarrinho">
            <div class="d-flex mb-0 osahan-cart-item-profile bg-white shadow rounded-top p-3 mt-n5">
                <div class="">
                    <h6 class="mb-1 font-weight-bold text-uppercase">Pizza {{tamanho.nome}} {% if ii == 1 %}{{ii}} SABOR {% else %}{{ ii }} SABORES {% endif %}({{tamanho.qtd_pedacos}} PEDAÇOS)</h6>
                    <p class="mb-0">Escolha {% if ii == 1 %}{{ ii }} sabor {% else %} {{ ii }} sabores{% endif %}</p>
                </div>
            </div>
            {% if isLogin != 0 %}
            <div class="bg-white rounded-top shadow mb-0 py-2 pt-0 pb-0">
                <div class="garnish-choices__header">
                    <span class="garnish-choices__header-content">
                        <p class="garnish-choices__title" data-test-id="Escolha 1 opção.">Escolha a sua Preferência
                            <span class="garnish-choices__title-desc">Escolha 1 opção.</span>
                        </p>
                        <span id="massa_choice" class="garnish-choices__tags">
                            <span class="marmita-minitag marmita-minitag--black marmita-minitag--small">OBRIGATÓRIO</span>
                        </span>
                    </span>
                </div>
                <div class="col-md-12 pt-3">
                    <div class="mdc-card" id="add_itenMassa">
                        {% for mass in massas %}
                        <div class="custom-control custom-radio border-bottom py-2">
                            <input class="custom-control-input" type="radio" id="id_massa{{mass.id}}" data-valor="{{ mass.valor }}" name="massa" value="{{mass.id}}">
                            <label class="custom-control-label" for="id_massa{{mass.id}}">{{mass.nome}} <span class="garnish-choices__option-price">{% if mass.valor != 0.00 %}+ {{moeda.simbolo}} {{ mass.valor|number_format(2, ',', '.')}}{% endif %}</span></label> 
                        </div>
                        {% endfor %}
                    </div>
                </div>
            </div>


            <div class="bg-white rounded shadow mb-3 py-2 pt-0">
                <div class="garnish-choices__header">
                    <span class="garnish-choices__header-content">
                        <p class="garnish-choices__title" data-test-id="Escolha 1 opção.">Escolha um sabor
                            <span class="garnish-choices__title-desc">Escolha 2 opção.</span>
                        </p>
                        <span class="garnish-choices__tags">
                            <span id="pizza_choice"><span class="marmita-minitag marmita-minitag--black marmita-minitag--small">OBRIGATÓRIO</span></span>
                            <span id="saborCounts" class="marmita-minitag marmita-minitag--black marmita-minitag--small">
                                <span id="saborCount">0</span>/<span id="iCount">{{ii}}</span>
                            </span>
                        </span>
                    </span>
                </div>
                <div class="col-md-12">
                    <div class="mdc-cards" id="add_itenPizza">
                        <div>
                            {% for prod in produtos %}
                            {% if ii == 1 %}
                            <div class="custom-control custom-radio border-bottom py-2">
                                <input class="custom-control-input" type="radio" id="id_pizza_prod{{prod.id}}" {% for prodVal in produtoValor %}{% if prodVal.id_produto == prod.id %} data-valor="{{ prodVal.valor }}"{% endif %}{% endfor %}  name="pizza_prod" value="{{prod.id}}">
                                <label class="custom-control-label" for="id_pizza_prod{{prod.id}}">PIZZA {{prod.nome}} - {{prod.descricao}} {% if prod.observacao is not null %} <strong class="size10">({{prod.observacao}})</strong>{% endif %}
                                    <span class="garnish-choices__option-price">+ {{moeda.simbolo}} 
                                    {% for prodVal in produtoValor %}
                                    {% if prodVal.id_produto == prod.id %}
                                    {{ prodVal.valor|number_format(2, ',', '.')}}
                                    {% endif %}
                                    {% endfor %}
                                </span></label> 
                            </div>
                            {% else %}
                            <div class="custom-control border-bottom py-3">
                                <input class="custom-control-input" type="checkbox" {% for prodVal in produtoValor %}{% if prodVal.id_produto == prod.id %}data-valor="{{ (prodVal.valor / ii)}}"{% endif %}{% endfor %}
                                    id="id_pizza_prod{{prod.id}}" name="pizza_prod[]" value="{{prod.id}}">
                                <label class="custom-control-label"
                                    for="id_pizza_prod{{prod.id}}">1/{{ii}} PIZZA {{prod.nome}} - {{prod.descricao}} {% if prod.observacao is not null %} <strong class="size10">({{prod.observacao}})</strong>{% endif %}
                                    <span class="garnish-choices__option-price">+ {{moeda.simbolo}} 

                                        {% for prodVal in produtoValor %}
                                        {% if prodVal.id_produto == prod.id %}
                                            {{ (prodVal.valor / ii)|number_format(2, ',', '.')}}</span>
                                        {% endif %}
                                        {% endfor %}
                                    
                                </label>
                            </div>
                            {% endif %}
                            {% endfor %}


                            


                        </div>

                    </div>
                </div>
            </div>
 

            {% if delivery.status == 1 %}
            <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix">
                <div class="mb-0 input-group full-width">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="feather-message-square"></i></span></div>
                    <textarea name="observacao" id="observacao" placeholder="Alguma observação no pedido?" aria-label="With textarea" class="form-control"></textarea>
                </div>
            </div>
            {% endif %}
            {% endif %}

            <input type="hidden" name="totalMassa" id="totalMassa" value="0">
            <input type="hidden" name="massa" id="massa" value="">
            <input type="hidden" name="totalPizza" id="totalPizza" value="0">

            <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
            <input type="hidden" name="id_produto" id="id_produto" value="{{produto.id}}">

            <input type="hidden" name="valor" id="valor" value="">
            <div class="shadow bg-white rounded p-3 clearfix">
              
                <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="total">{{ moeda.simbolo}} 0,00</span></span></h6>
            </div>

            {% if delivery.status == 1 %}

            {% if isLogin == 0 %}
            <div class="alert alert-warning text-center mt-3" role="alert">Para efetuar um pedido você precisa informar seus dados, tais como <strong>Nome</strong>, <strong>Telefone</strong> e <strong>Endereço de entrega</strong>!
                <a href="{{BASE}}{{empresa.link_site}}/login" class="btn btn-success btn-block btn-lg addStyleMod mt-3">Informar meus Dados</a>
            </div>
            {% else %}

            <button id="btn_pedido" class="btn btn-success btn-block btn-lg addStyle">ADICIONAR AO PEDIDO <i class="feather-shopping-cart"></i></button>

            {% endif %}

            {% endif %}

            {% if delivery.status == 0 %}
            <div class="alert alert-warning text-center mt-3" role="alert">No momento, não estamos aceitando novos
                pedidos. Nosso horário de atendimento e </div>
            {% endif%}
    </div>
    <form>
</div>

{% include 'partials/modal.twig.php' %}

{% if delivery.status == 0 %}
<div class="StatusRest">ESTAMOS FECHADOS NO MOMENTO</div>
{% endif%}
{% if isLogin != 0 %}
{% include 'partials/footer.twig.php' %}
{% endif %}

{% else %}

{# CONTEUDO DO DESKTOP #}

{% endif %}
{% endblock %}
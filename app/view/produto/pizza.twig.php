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
        <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/produto/addCarrinho/{{produto.id}}">
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
                        <span class="garnish-choices__tags">
                            <span class="marmita-minitag marmita-minitag--black marmita-minitag--small">OBRIGATÓRIO</span>
                        </span>
                    </span>
                </div>
                <div class="col-md-12">
                    <div class="mdc-card" id="add_itenMassa">
                        {% for mass in massas %}
                        <div class="custom-control custom-radio border-bottom py-2">
                            <input class="custom-control-input" type="radio" id="id_massa{{mass.id}}" name="massa" value="{{mass.id}}">
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
                        <span class="garnish-choices__tags"><span class="marmita-minitag marmita-minitag--black marmita-minitag--small"><span id="saborCount">0</span>/{{ii}}</span><span class="marmita-minitag marmita-minitag--black marmita-minitag--small">OBRIGATÓRIO</span></span>
                    </span>
                </div>
                <div class="col-md-12">
                    <div class="mdc-card" id="add_itemPizza">

                        <div id="{{ ta.slug }}" data-tipo="{{ ta.slug }}"
                            data-tipo_escolha="{{ ta.tipo_escolha}}" data-qtd="{{ ta.qtd }}">
                            <h6 class="clearfix mt-3 bold">{{ ta.tipo}}
                                {% if ta.tipo_escolha == 2 %}
                                {% if ta.qtd == 1 %}
                                <span class="pizza_prod_item"> ({{ta.qtd}} item Obrigatório) </span> <span
                                    class="pizza_prod_item_ok"> {{ta.qtd}} selecionado </span>
                                {% else %}
                                <span class="pizza_prod_item"> ({{ta.qtd}} itens Obrigatórios) </span> <span
                                    class="pizza_prod_item_ok"> {{ta.qtd}} selecionados </span>
                                {% endif %}
                                {% endif %}
                                {% if ta.tipo_escolha == 3 %}
                                <span class="pizza_prod_item"> (escolha até {{ta.qtd}} itens) </span> <span
                                    class="pizza_prod_item_ok"></span>
                                {% endif%}
                            </h6>

                            {% for prod in produtos %}
                            {% if ii == 1 %}
                            <div class="custom-control custom-radio border-bottom py-2">
                                <input class="custom-control-input" type="radio" id="id_pizza_prod{{prod.id}}" name="pizza_prod" value="{{prod.id}}">
                                <label class="custom-control-label" for="id_pizza_prod{{prod.id}}">Pizza {{prod.nome}} 
                                    {{prod.descricao}} {{prod.observacao}}
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
                                <input class="custom-control-input" type="checkbox" data-tipoSlug="{{ ta.slug}}"
                                    id="id_pizza_prod{{prod.id}}" name="pizza_prod[]" value="{{prod.id}}"
                                    valor="{% if prod.valor is null %}0.00{% else %}{{prod.valor}}{% endif %}">
                                <label class="custom-control-label"
                                    for="id_pizza_prod{{prod.id}}">+ {{moeda.simbolo}} 1/{{ii}}  Pizza {{prod.nome}}
                                    {{prod.descricao}}
                                    {{prod.observacao}}
                                    <span class="garnish-choices__option-price">+ {{moeda.simbolo}} 

                                        {% for prodVal in produtoValor %}
                                        {% if prodVal.id_produto == prod.id %}
                                            {{ (prodVal.valor / ii)|number_format(2, ',', '.')}}</span>
                                        {% endif %}
                                        {% endfor %}
                                    
                                </label>

                                <div class="input-group plus-minus-input id_pizza_prod{{prod.id}}"
                                    style="display:none;">
                                    <div class="input-group-button">
                                        <button type="button" class="btn btn-danger btn-number minuss"
                                            id-select="{{prod.id}}" data-quantity="minus"
                                            data-field="qtd_ad{{prod.id}}">
                                            <i class="feather-minus"></i>
                                        </button>
                                    </div>
                                    <input type="number" id="qtd_ad{{prod.id}}" min="1"
                                        name="qtd_ad{{prod.id}}"
                                        class="input-group-field qtd-control id_pizza_prod{{prod.id}}" value="1">
                                    <div class="input-group-button">
                                        <button type="button" class="btn btn-success btn-number"
                                            id-select="{{prod.id}}" data-quantity="plus"
                                            data-field="qtd_ad{{prod.id}}">
                                            <i class="feather-plus"></i>
                                        </button>
                                    </div>
                                </div>
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
            {% endif%}
            {% endif%}

            {% if produto.sabores is null %}
            <input type="hidden" name="id_adicional" id="id_adicional" value="0">
            {% else %}
            <input type="hidden" name="id_adicional" id="id_adicional" value="1">
            {% endif %}
            <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
            <input type="hidden" name="id_produto" id="id_produto" value="{{produto.id}}">
            <input type="hidden" name="adicional" id="adicional" value="{{produto.adicional}}">
            <input type="hidden" name="valor" id="valor" value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
            <div class="shadow bg-white rounded p-3 clearfix">
                <p class="mb-1">Valor unitário <span class="float-right text-dark">{{ moeda.simbolo }}
                        {% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional|number_format(2,
                        ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}</span></p>
                <hr>
                <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="total">{{ moeda.simbolo
                            }} {% if produto.valor_promocional != '0.00' %}{{
                            produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{
                            produto.valor|number_format(2, ',', '.') }}{% endif %}</span></span></h6>
            </div>

            {% if delivery.status == 1 %}
            {% if produto.status == 1 %}
            {% if isLogin == 0 %}
            <div class="alert alert-warning text-center mt-3" role="alert">Para efetuar um pedido você precisa informar seus dados, tais como <strong>Nome</strong>, <strong>Telefone</strong> e <strong>Endereço de entrega</strong>!
                <a href="{{BASE}}{{empresa.link_site}}/login" class="btn btn-success btn-block btn-lg addStyleMod mt-3">Informar meus Dados</a>
            </div>
            {% else %}

            {% if produto.adicional is null %}
            <button class="btn btn-success btn-block btn-lg addStyle">ADICIONAR AO PEDIDO <i class="feather-shopping-cart"></i></button>
            {% else %}
            <button class="btn btn-info btn-block btn-lg addStyle">PROSSEGUIR <i class="feather-next"></i></button>
            {% endif %}

            {% endif %}

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



<!-- Sidebar -->
{% include 'partials/desktop/sidebar.twig.php' %}
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        {% include 'partials/desktop/menuTop.twig.php' %}
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            {% set LINK = "uploads/" %}

            <div class="row">
                <div class="col-lg-6">


                    <div class="card shadow mb-4">

                        <div class="card-body p-0">
                            <div class="modal-content-page osahan-item-detail-pop">
                                <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/produto/addCarrinho/{{produto.id}}">
                                    <div class="modal-body px-3 pt-0 pb-3">
                                        <div class="pb-3 position-relative">
                                            <div class="position-absolute heart-fav">
                                                <a href="#"><i class="mdi mdi-heart"></i></a>
                                            </div>
                                            <img src="{{BASE}}{{LINK}}{{produto.imagem}}" class="img-fluid col-md-12 p-0 rounded" style="margin-top: -15px;">
                                        </div>

                                        <h4 class="mb-2">{{ produto.nome }}</h4>
                                        <p>{{ produto.descricao }}</p>
                                        <hr>
                                        {% if produto.observacao is not null %}
                                        <p class="mb-1 mt-0 font-weight-bold line-e">Observações <span style="color:red;">*</span></p>
                                        <p>{{ produto.observacao }}</p>
                                        {% endif %}
                                        <hr>
                                        {% if delivery.status == 1 %}

                                        <div class="d-flex mb-3 osahan-cart-item-profile bg-white p-3">
                                            <p class="mb-1 mt-2 font-weight-bold line-e">Informe a quantidade?</p>
                                            <div class="col-lg-3 quantidade">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-danger btn-number quantity-left-minus" data-type="minus" data-field=""><span class="fa fa-minus"></span></button>
                                                    </span>
                                                    <input type="text" id="quantity" name="quantity" class="count-number-input input-number" value="1" min="1" max="100">
                                                    <input type="hidden" id="valor" name="valor" value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-success btn-number quantity-right-plus" data-type="plus" data-field=""><span class="fa fa-plus"></span></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {% endif %}

                                        <hr>

                                        {% if produto.sabores is not null %}
                                        <div class="bg-white rounded shadow mb-3 py-2">
                                            <div class="col-md-12">
                                                <div class="mdc-card" id="add_itenSabores">
                                                    <h4>Sabores</h4>
                                                    {% for prod in produtoSabores %}
                                                    {% if prod.id in produto.sabores %}
                                                    <div class="custom-control custom-radio border-bottom py-2">
                                                        <input class="custom-control-input" type="radio" id="id_sabor{{prod.id}}" name="sabores[]" value="{{prod.id}}">
                                                        <label class="custom-control-label" for="id_sabor{{prod.id}}">{{prod.nome}}</label>
                                                    </div>
                                                    {% endif%}
                                                    {% endfor%}

                                                </div>

                                            </div>
                                        </div>
                                        {% endif%}

                                        {% if delivery.status == 1 %}
                                        <div class="mb-3 shadow bg-white rounded p-3 py-3 mt-3 clearfix">
                                            <div class="mb-0 input-group full-width">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-quote"></i></span></div>
                                                <textarea name="observacao" id="observacao" placeholder="Alguma observação no pedido?" aria-label="With textarea" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        {% endif%}

                                        {% if produto.sabores is null %}
                                        <input type="hidden" name="id_adicional" id="id_adicional" value="0">
                                        {% else %}
                                        <input type="hidden" name="id_adicional" id="id_adicional" value="1">
                                        {% endif %}
                                        <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
                                        <input type="hidden" name="id_produto" id="id_produto" value="{{produto.id}}">
                                        <input type="hidden" name="adicional" id="adicional" value="{{produto.adicional}}">
                                        <input type="hidden" name="valor" id="valor" value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
                                        <div class="shadow bg-white rounded p-3 clearfix">
                                            <p class="mb-1">Valor unitário <span class="float-right text-dark">{{
                                                moeda.simbolo }}
                                                    {% if produto.valor_promocional != '0.00' %}{{
                                                produto.valor_promocional|number_format(2,
                                                ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{%
                                                endif %}</span></p>
                                            <hr>
                                            <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="total">{{ moeda.simbolo
                                                    }} {% if produto.valor_promocional != '0.00' %}{{
                                                    produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{
                                                    produto.valor|number_format(2, ',', '.') }}{% endif %}</span></span>
                                            </h6>
                                        </div>

                                        {% if delivery.status == 1 %}
                                        {% if produto.status == 1 %}
                                        {% if produto.adicional is null %}
                                        {# <button class="btn btn-success btn-block btn-lg addStyle">ADICIONAR AO PEDIDO <i
                                            class="feather-shopping-cart"></i></button> #}
                                        {% else %}

                                        {# <button class="btn btn-block btn-lg btn-primary btn-block addStyle">PROSSEGUIR <i
                                            class="feather-next"></i></button> #}
                                        {% endif %}

                                        {% endif %}
                                        {% endif %}

                                        {% if delivery.status == 0 %}
                                        <div class="alert alert-warning text-center mt-3" role="alert">No momento, não
                                            estamos aceitando novos
                                            pedidos. Nosso horário de atendimento e </div>
                                        {% endif%}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <!-- Footer -->
    {% include 'partials/desktop/footer.twig.php' %}
    <!-- End of Footer -->
</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
{% include 'partials/desktop/modal.twig.php' %}


{% endif %}
{% endblock %}
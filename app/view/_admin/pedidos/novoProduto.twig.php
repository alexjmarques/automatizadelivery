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
            <li class="p-3 nav-item active"><a href="#step-1">Produtos<br /><small>Produtos do pedido</small></a></li>
            <li class="p-3"><a href="#step-2">Pedido<br /><small>Informações do Pedido</small></a></li>
        </ul>

        <a href="{{BASE}}{{empresa.link_site}}/admin/pedido/novo/produtos/detalhes" class="btn btn-success btn-block btn-lg btn-sm btnFPedido {% if carrinhoqtd == 0 %}hide{% endif %}">Finalizar
            Pedido</a>

        <div class="card-body">
            <div id="step-1" class="tab-pane step-content" style="display: block;">
            {% if empresa.id_categoria == 6 %}
            <div class="px-3 pt-3 title bg-white"> 
                {% for tam in tamanhos %}
                    <div class="osahan-slider-item col-3 float-left pb-4 pl-0 px-1">
                        <div class=" bg-white h-100 overflow-hidden position-relative">
                            <button class="p-2 position-relative btn-categoria pizza" data-toggle="modal" data-target="#modProduto" onclick="produtoPizzaModal({{ tam.id }})">
                                <div class="list-card-body">
                                    <h6 class="mb-1">
                                        {{ tam.nome }}
                                    </h6>
                                </div>
                            </button>
                        </div>
                    </div>  
                    {% endfor %}                                                                                                                                                         <div class="clearfix"></div>
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
                <div class="px-3 pt-3 title d-flex bg-white">
                    <h5 id="{{ c.slug }}" name="{{ c.slug }}" class="mt-1 bold">{{ c.nome }}</h5>
                    
                </div>
                <div class="px-3 pt-3 title bg-white">
                    {% for tc in tamanhosCategoria %}
                    {% if c.id == tc.id_categoria %}
                    {% for tam in tamanhos %}
                    {% if c.id == tc.id_categoria and tam.id == tc.id_tamanhos %}

                    {% for i in range(1, tam.qtd_sabores) %}
                    <div class="osahan-slider-item col-3 float-left pb-4 pl-0 px-1">
                        <div class="list-card bg-white h-100 overflow-hidden position-relative">
                            <button class="p-2 position-relative" data-toggle="modal" data-target="#modProduto" onclick="produtoPizzaModal('{{c.slug}}', {{tc.id}}, {{tam.id}}, {{i}})">
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
                    <li class="col-md-4 disable-text-selection bg-white" data-toggle="modal" data-target="#modProduto" onclick="produtoModal({{p.id}})">
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
    </div>
</div>

<button class="btn shadow cartFlut {% if carrinhoqtd == 0 %}hide{% endif %}" data-toggle="modal" data-target="#modProduto" id="modProdutoCarrinho">
    <!-- <i class="iconsminds-shopping-basket"></i> <span class="qtd">{{carrinhoqtd }}</span> iten(s) -->
    <strong>Itens do Pedido</strong>
</button>
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
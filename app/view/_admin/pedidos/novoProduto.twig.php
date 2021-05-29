{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
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
                            {% if carrinhoqtd > 0 %}
                                <a href="{{BASE}}{{empresa.link_site}}/admin/pedido/novo/produtos/detalhes" class="btn btn-info btn-sm btnFPedido">Finalizar Pedido</a>
                            {% endif %}
                            <div class="card-body">
                                <div id="step-1" class="tab-pane step-content" style="display: block;">
                                        {% for c in categoria %}
                                            {% if c[':produtos'] > 1 %}
                                                <div class="px-3 pt-3 title d-flex bg-white">
                                                    <h5 id="{{ c[':slug }}" name="{{ c[':slug }}" class="mt-1">{{ c[':nome }}</h5>
                                                </div>
                                            {% endif %}
                                        <ul class="lista">
                                        {% for p in produto %}
                                        {% if c[':id'] == p[':categoria'] %}
                                            <li class="col-md-3 disable-text-selection bg-white" data-toggle="modal" data-target="#modProduto" onclick="produtoModal({{p[':id']}})">
                                            <div class="col-md-12 mb-4 p-0">
                                                <div class="card">
                                                    <div class="position-relative">
                                                        {% if p[':imagem'] is not empty %}
                                                            <img src="{{BASE}}uploads/{{p[':imagem']}}" class="card-img-top">
                                                        {% endif %}
                                                        {% if p[':status_produto'] == 0 %}
                                                            <span class="badge badge-secondary badge-theme-1 position-absolute badge-top-left">ESGOTADO</span>
                                                        {% endif %}

                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12 p-0">
                                                            <h6 class="mb-1">
                                                            <a href="#" class="text-black">{{p[':nome']}}</a></h6>

                                                            {% if p[':valor_promocional'] != '0.00' %}
                                                                <p class="text-black mb-1 dequanto pmais"><span class="float-left por mr-2">De</span> <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor']|number_format(2, ',', '.') }}</span></p>
                                                                <p class="text-black mb-1 porquanto pmais"> <span class="float-left por pl-4 mr-2">Por</span> <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor_promocional']|number_format(2, ',', '.') }}</span></p>
                                                            {% else %}
                                                                <p class="text-black mb-1 porquanto pmais"> <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor']|number_format(2, ',', '.') }}</span></p>
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
                                        {% endfor %}

                                </div>
                            </div>
                        </div>
                    </div>

{% if carrinhoqtd > 0 %}

<button class="btn shadow cartFlut" data-toggle="modal" data-target="#modProduto" id="modProdutoCarrinho"><i class="iconsminds-shopping-basket"></i> <span class="qtd">{{ carrinhoqtd }}</span> iten(s) <strong>Carrinho</strong></button>
{% endif %}
<div class="modal fade" id="modProduto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="mostrarProduto" class="modal-content pb-3">
        <div class="text-center pb-3">
            <h4 class="text-center pt-5">Carregando...</h4>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>
            </svg>
        </div>
    </div>
</div>

{% endblock %}
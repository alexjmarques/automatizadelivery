{% extends 'partials/body.twig.php' %}
{% block title %}{{ produto.nome }} - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}
{% if detect.isMobile() %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">{{ produto.nome }}</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>
    <div class="p-3 osahan-cart-item osahan-home-page">
        <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/produto/addCarrinho/{{produto.id}}">
            <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
                {% if produto.imagem is not empty %}
                <img alt="{{ produto.nome }}" src="{{BASE}}uploads/{{ produto.imagem }}"
                    class="mr-2 rounded-circle img-fluid">
                {% endif %}
                <div class="d-flex flex-column">
                    <h6 class="mb-1 font-weight-bold">{{ produto.nome }}</h6>
                    <p class="mb-0">{{ produto.descricao }}</p>
                </div>
            </div>
            {% if produto.observacao is not null %}
            <div class=" mb-3 osahan-cart-item-profile bg-white shadow rounded p-3">
                <p class="mb-1 mt-0 font-weight-bold line-e">Observações <span style="color:red;">*</span></p>
                {{produto.observacao}}
            </div>
            {% endif %}

            {% if isLogin != 0 %}
            {% if delivery.status == 1 %}
            <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3">
                <p class="mb-1 mt-2 font-weight-bold line-e">Informe a quantidade?</p>
                <div class="col-lg-3 quantidade">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger btn-number quantity-left-minus"
                                data-type="minus" data-field=""><i class="fa fa-minus"></i></button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="count-number-input input-number"
                            value="1" min="1" max="100">
                        <input type="hidden" id="valor" name="valor"
                            value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-number quantity-right-plus"
                                data-type="plus" data-field=""><i class="fa fa-plus"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            {% endif %}

            {% if produto.sabores is not null %}
            <div class="bg-white rounded shadow mb-3 py-2">
                <div class="col-md-12">
                    <div class="mdc-card" id="add_itenSabores">
                        <h4>Sabores</h4>
                        {% for padici in produtoSabores %}
                        {% if padici.id in produto.sabores %}
                        <div class="custom-control custom-radio border-bottom py-2">
                            <input class="custom-control-input" type="radio" id="id_sabor{{padici.id}}" name="sabores[]"
                                value="{{padici.id}}">
                            <label class="custom-control-label" for="id_sabor{{padici.id}}">{{padici.nome}}</label>
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
                    <div class="input-group-prepend"><span class="input-group-text"><i
                                class="feather-message-square"></i></span></div>
                    <textarea name="observacao" id="observacao" placeholder="Alguma observação no pedido?"
                        aria-label="With textarea" class="form-control"></textarea>
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
            <input type="hidden" name="valor" id="valor"
                value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
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

            {% if produto.adicional is null %}
            <button class="btn btn-success btn-block btn-lg addStyle">ADICIONAR AO PEDIDO <i
                    class="feather-shopping-cart"></i></button>
            {% else %}
            {% if isLogin == 0 %}
            <div class="alert alert-warning text-center mt-3" role="alert">Para efetuar um pedido você precisa informar seus dados, tais como <strong>Nome</strong>, <strong>Telefone</strong> e <strong>Endereço de entrega</strong>!
            <a href="{{BASE}}{{empresa.link_site}}/login" class="btn btn-success btn-block btn-lg addStyleMod mt-3">Informar meus Dados</a>
        </div>
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
                                        <img src="{{BASE}}{{LINK}}{{produto.imagem}}"
                                            class="img-fluid col-md-12 p-0 rounded" style="margin-top: -15px;">
                                    </div>

                                    <h4 class="mb-2">{{ produto.nome }}</h4>
                                    <p>{{ produto.descricao }}</p>
                                    <hr>
                                    {% if produto.observacao is not null %}
                                    <p class="mb-1 mt-0 font-weight-bold line-e">Observações <span
                                            style="color:red;">*</span></p>
                                    <p>{{ produto.observacao }}</p>
                                    {% endif %}
                                    <hr>
                                    {% if delivery.status == 1 %}

                                    <div class="d-flex mb-3 osahan-cart-item-profile bg-white p-3">
                                        <p class="mb-1 mt-2 font-weight-bold line-e">Informe a quantidade?</p>
                                        <div class="col-lg-3 quantidade">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button"
                                                        class="btn btn-danger btn-number quantity-left-minus"
                                                        data-type="minus" data-field=""><span
                                                            class="fa fa-minus"></span></button>
                                                </span>
                                                <input type="text" id="quantity" name="quantity"
                                                    class="count-number-input input-number" value="1" min="1" max="100">
                                                <input type="hidden" id="valor" name="valor"
                                                    value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
                                                <span class="input-group-btn">
                                                    <button type="button"
                                                        class="btn btn-success btn-number quantity-right-plus"
                                                        data-type="plus" data-field=""><span
                                                            class="fa fa-plus"></span></button>
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
                                                {% for padici in produtoSabores %}
                                                {% if padici.id in produto.sabores %}
                                                <div class="custom-control custom-radio border-bottom py-2">
                                                    <input class="custom-control-input" type="radio"
                                                        id="id_sabor{{padici.id}}" name="sabores[]"
                                                        value="{{padici.id}}">
                                                    <label class="custom-control-label"
                                                        for="id_sabor{{padici.id}}">{{padici.nome}}</label>
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
                                            <div class="input-group-prepend"><span class="input-group-text"><i
                                                        class="fa fa-quote"></i></span></div>
                                            <textarea name="observacao" id="observacao"
                                                placeholder="Alguma observação no pedido?" aria-label="With textarea"
                                                class="form-control"></textarea>
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
                                    <input type="hidden" name="valor" id="valor"
                                        value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">
                                    <div class="shadow bg-white rounded p-3 clearfix">
                                        <p class="mb-1">Valor unitário <span class="float-right text-dark">{{
                                                moeda.simbolo }}
                                                {% if produto.valor_promocional != '0.00' %}{{
                                                produto.valor_promocional|number_format(2,
                                                ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{%
                                                endif %}</span></p>
                                        <hr>
                                        <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span
                                                    id="total">{{ moeda.simbolo
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
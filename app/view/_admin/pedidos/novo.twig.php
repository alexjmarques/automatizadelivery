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
                                <li class="p-3 nav-item active"><a href="#step-0">Cliente<br /><small>Dados do Cliente e Entrega</small></a></li>
                                <li class="p-3"><a href="#step-1">Produtos<br /><small>Produtos do pedido</small></a></li>
                                <li class="p-3"><a href="#step-2">Pedido<br /><small>Informações do Pedido</small></a></li>
                            </ul>

                            <div class="card-body">
                                <div id="step-0">
                                <form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/pedido/novo/start" class="tooltip-label-right" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="form-group col-md-5 mb-5">
                                            <label class="col-12 col-form-label" style="padding-left: 0;">Nome do Cliente</label>
                                                <select id="cliente" name="cliente" class="form-control select2-single" required>
                                                <option value="">Nome do Cliente</option>
                                                {% for ce in clientesEmpresa %}
                                                {% for c in clientes %}
                                                {% if c.id == ce.id_usuario %}
                                                    <option value="{{ c.id }}">{{ c.nome }} - {{ c.telefone }}</option>
                                                    {% endif %}
                                                {% endfor %}
                                                {% endfor %}
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 mt-4 pl-5 pt-2">
                                                <p class="p-0 mt-2 pr-2 left">Cliente não tem cadastro?</p>
                                                    <a data-toggle="modal" data-target="#modalNovoCliente" href="#" class="btn btn-info btn-sm left">Cadastrar Cliente</a>
                                                </div>
                                            </div>
                                             <!-- <div class="form-group row mb-1 pl-6 col-md-6 ">
                                                <div class="col-12">
                                                    <label class="col-12 col-form-label" style="padding-left: 0;">Seu cliente vai receber este pedido?</label>
                                                    <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left">
                                                            <input class="custom-switch-input" id="switch" name="switch" value="0" type="checkbox">
                                                        <label class="custom-switch-btn" for="switch"></label>
                                                    </div>
                                                </div>
                                            </div> -->

                                            
                                        <button class="btn btn-success btn-block btn-lg float-letf btn_Pedido mb-5" type="submit">Continuar</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {% include 'partials/modalNovoCliente.twig.php'  %}
                    {% endblock %}

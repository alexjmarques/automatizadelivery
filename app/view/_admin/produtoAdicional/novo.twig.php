{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1 id="titleBy" data-id="{{ catProdAdi }}">Novo produto adicional</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/produtos-adicionais">Produto Adicional</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/produto-adicional/i" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5>Item ou sabor adicional</h5>
            <p class="mb-4">Este item poderá será atrelado ao produto como item adicional. <br />
                o mesmo serve como item adicional, tal como sabor, ingredientes ou brindes que seu cliente escolha na
                hora do pedido.</p>
            <div class="form-row">

                <div class="form-group col-md-4 mb-0">
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="" required>
                </div>

                <div class="form-group col-md-2 mb-0">
                    <label>Valor</label>
                    <input type="text" class="form-control" id="valor" placeholder="Insira o Valor " name="valor"
                        value="" required>
                </div>

                <div class="form-group col-md-12 pt-2 mt-0">
                    <strong class=" float">Obs.: Caso queira atrelar a algum produto. Após criação vá para a Página
                        de Cardápios selecione o produto expecífico e adicione ao produto.</strong>
                </div>
                <div class="clearfix"></div>
                <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
                <input type="hidden" id="tipo_adicional" name="tipo_adicional" value="{{catProdAdi}}">

            </div>
            <button type="submit" name="cadastrar" id="cadastrar" class="btn btn-info d-block">Cadastrar</button>

        </div>
    </div>
</form>
{% endblock %}
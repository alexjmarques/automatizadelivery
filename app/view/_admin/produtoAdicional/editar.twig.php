{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Editar produto adicional</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/produtos-adicionais">Produto Adicional</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/produto-adicional/u/{{retorno.id}}" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5 id="titleBy" data-id="{{retorno.id}}">Item ou sabor adicional</h5>
            <p class="mb-4">Este item poderá será atrelado ao produto como item adicional. <br />
                o mesmo serve como item adicional, tal como sabor, ingredientes ou brindes que seu cliente escolha na hora do pedido.</p>
            <div class="form-row">

                <div class="form-group col-md-4">
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{retorno.nome}}" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Valor</label>
                    <input type="text" class="form-control" id="valor" placeholder="Insira o Valor " name="valor" value="{{retorno.valor}}" required>
                </div>

                <div class="form-group col-md-4 mb-0">
                    <div class="form-group position-relative">
                        <label for="tipoSabor">Categoria do Adicional</label>
                        <select class="form-control select2-single" id="tipo_adicional" name="tipo_adicional">
                            
                            {% for ta in tipoAdicional %}
                            <option value="{{ta.id}}" {% if retorno.tipo_adicional == ta.id  %}selected{% endif %}>{{ta.tipo}}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>


                <div class="form-group col-md-6">
                    <strong class="pt-4 float">Obs.: Caso queira atrelar a algum produto. Após criação vá para a Página de Produto > Editar e adiciona ao produto selecionado.</strong>
                </div>
                <input type="hidden" class="form-control" id="id" name="id" value="{{retorno.id}}">

                <div class="clearfix"></div>
            </div>
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <div class="btn_acao"><div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
                </div>

        </div>
    </div>
</form>
{% endblock %}
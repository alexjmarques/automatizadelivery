{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Editar Categoria</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/categorias">Categorias</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar Categoria</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/categoria/u/{{retorno.id}}"
    enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5 id="titleBy" data-id="{{retorno.id}}">Categia dos produtos</h5>
            <div class="form-row">
                <div class="form-group col-md-8 catProds">
                    <label>Nome da Categoria</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{retorno.nome}}" required>
                </div>
                <div class="form-group col-md-4 hidden">
                    <label>Slug</label>
                    <input type="hidden" class="form-control" id="slug" placeholder="Slug" name="slug"
                        value="{{retorno.slug}}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Posição no Site</label>
                    <input type="text" class="form-control" id="posicao" placeholder="Posição" name="posicao"
                        value="{{retorno.posicao}}" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao">{{retorno.descricao}}</textarea>
                </div>
            </div>
            <input type="hidden" id="produtos" name="produtos" value="{{retorno.produtos}}">
            <input type="hidden" id="id" name="id" value="{{retorno.id}}">
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
        </div>
    </div>
</form>
{% endblock %}
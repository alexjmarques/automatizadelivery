
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Editar {{preferencias.sabor()}}</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/produtos-sabores">Sabores</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/produto-sabor/update"  enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5 id="titleBy" data-id="{{retorno.id}}">{{preferencias.sabor()}}</h5>
            <p class="mb-4">Este item poderá será atrelado ao produto como {{preferencias.sabor()}}. <br/>
            o mesmo serve como {{preferencias.sabor()}}, tal como {{preferencias.sabor()}}, ingredientes ou brindes que seu cliente escolha na hora do pedido.</p>
                <div class="form-row">

                  <div class="form-group col-md-4">
                       <label>Nome</label>
                      <input type="text" class="form-control" id="nome" name="nome" value="{{retorno.nome}}" required>
                  </div>

                    <div class="form-group col-md-8 pt-2">
                    <strong class="pt-4 float">Obs.: Caso queira atrelar a algum produto. Após criação vá para a Página de Produto > Editar e adiciona ao produto selecionado.</strong>
                    </div>
                    <input type="hidden" id="id" name="id" value="{{retorno.id}}">
                    <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>

                </div>
                
        </div>
    </div>
</form>
{% endblock %}

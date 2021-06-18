{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Meu perfil</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Meu Perfil</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/meu-perfil/u"
    enctype="multipart/form-data">
    <div class="card mb-4 col-md-5">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-12 catProds">
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{retorno.nome}}" required>
                </div>
                <div class="form-group col-md-12 catProds">
                    <label>Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="({{ retorno.telefone[:2] }}) {{ retorno.telefone|slice(2, 5) }}-{{ retorno.telefone|slice(7, 9) }}" disabled>
                </div>
                <div class="form-group col-md-12 catProds">
                    <label>Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{retorno.email}}" required>
                </div>
                
                <div class="form-group col-md-12 catProds">
                    <label>Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" value="">
                </div>
            </div>
            <input type="hidden" id="id" name="id" value="{{retorno.id}}">
            <div class="btn_acao">
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
                </div>
        </div>
    </div>
</form>
{% endblock %}
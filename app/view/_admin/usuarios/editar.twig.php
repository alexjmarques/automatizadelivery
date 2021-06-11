
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Editar Usuário</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/usuarios">Usuários</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/usuario/u/{{retorno.id}}"  enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5 id="titleBy" data-id="{{retorno.id}}">Usuário</h5>
            <p>Cadastre de clientes e funcionários, diretamente pelo sistema.</p>
                <div class="form-row">
                  <div class="form-group col-md-6">
                        <label>Nome</label>
                      <input type="text" class="form-control" id="nome" name="nome" value="{{retorno.nome}}" required>
                  </div>
                  <div class="form-group col-md-6">
                       <label>E-mail</label>
                      <input type="text" class="form-control" id="email" name="email" value="{{retorno.email}}" required>
                  </div>
                  <div class="form-group col-md-4">
                       <label>Telefone</label>
                      <input type="text" class="form-control" id="telefone" name="telefone" value="{{retorno.telefone}}" required>
                  </div>
                  <div class="form-group col-md-3">
                       <label>Nível de acesso</label>
                      <select class="form-control select2-single" id="nivel" name="nivel">
                            <option value="selecione">Selecione</option>
                            <option value="0" {% if( retorno.nivel == 0 ) %} selected {% endif %}>Administrador</option>
                            <option value="1" {% if( retorno.nivel == 1 ) %} selected {% endif %}>Atendente</option>
                            <option value="2" {% if( retorno.nivel == 2 ) %} selected {% endif %}>Cliente</option>
                        </select>
                  </div>

                </div>
                <input type="hidden" id="id" name="id" value="{{retorno.id}}">
                <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
    
        </div>
    </div>
</form>
{% endblock %}





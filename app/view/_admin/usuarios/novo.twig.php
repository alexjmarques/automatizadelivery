
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Novo Usuário</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/usuarios">Usuários</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
                <div class="col-12">
                <form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/usuario/i"  enctype="multipart/form-data">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>Usuário</h5>
                            <p>Cadastre de clientes e funcionários, diretamente pelo sistema.</p>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                        <label>Nome</label>
                                      <input type="text" class="form-control" id="nome" name="nome" value="" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                       <label>E-mail</label>
                                      <input type="text" class="form-control" id="email" name="email" value="" required>
                                  </div>
                                  <div class="form-group col-md-4">
                                       <label>Telefone</label>
                                      <input type="text" class="form-control" id="telefone" name="telefone" value="" required>
                                  </div>
                                  <div class="form-group col-md-3">
                                       <label>Nível de acesso</label>
                                      <select class="form-control select2-single" id="nivel" name="nivel">
                                            <option value="selecione">Selecione</option>
                                            <option value="0">Administrador</option>
                                            <option value="2">Atendente</option>
                                            <option value="1">Motoboy</option>
                                            <option value="3">Cliente</option>
                                        </select>
                                  </div>
                                  <div class="form-group col-md-3">
                                       <label>Senha</label>
                                      <input type="password" class="form-control" id="senha" name="senha" value="" required>
                                  </div>
                                </div>
                                <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>
                            
                        </div>
                    </div>
                    
                    </form>
                </div>
{% endblock %}

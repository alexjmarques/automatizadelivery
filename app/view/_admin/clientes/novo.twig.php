{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Novo Cliente</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/clientes">Cliente</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
    <form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/cliente/i" enctype="multipart/form-data">
        <div class="card mb-4">
            <div class="card-body">
                <p>Cadastro de atendentes.</p>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Nome <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" value="" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" value="">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Telefone <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="" required>
                    </div>
                </div>
                <input type="hidden" id="nivel" name="nivel" value="3">
                <input type="hidden" id="mensagemSuccess" name="mensagemSuccess" value="Cliente Cadastrado com sucesso!">
                <input type="hidden" id="mensagemError" name="mensagemError" value="Não foi possível cadastrar o cliente no sistema!">
                <input type="hidden" id="url" name="url" value="admin/clientes">
                <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>

            </div>
        </div>

    </form>

{% endblock %}
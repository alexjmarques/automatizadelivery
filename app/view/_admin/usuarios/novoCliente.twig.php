
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
            <a href="{{BASE}}{{empresa.link_site}}/admin/clientes">Clientes</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/cliente/novo/i"  enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5>Cadastro de cliente</h5>
                <div class="form-row">
                  <div class="form-group col-md-4">
                        <label>Nome <span style="color:red;">*</span></label>
                      <input type="text" class="form-control" id="nome" name="nome" value="" required>
                  </div>
                  <div class="form-group col-md-4">
                       <label>E-mail</label>
                      <input type="text" class="form-control" id="email" name="email" value="">
                  </div>
                  <div class="form-group col-md-4">
                       <label>Telefone <span style="color:red;">*</span></label>
                      <input type="text" class="form-control" id="telefone" name="telefone" value="" required>
                  </div>
                </div>


                <div class="form-group row mb-1 pl-0 col-md-12 ">
                <h6 class="mt-3 pl-3">Cadastrar Endereço?</h6>
                    <div class="col-12">
                        <label class="col-12 col-form-label" style="padding-left: 0;">Seu cliente vai receber o pedido? Cadastre aqui o endereço de entrega!</label>
                        <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left">
                                <input class="custom-switch-input" id="switchEnd" name="switchEnd" value="0" type="checkbox">
                            <label class="custom-switch-btn" for="switchEnd"></label>
                        </div>
                    </div>
                </div>

                <div class="enderecoCad">
                    <h6 class="mt-3">Endereço de Entrega</h6>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                        <label class="text-dark" for="rua">CEP <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="cep" name="cep" value="" >
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label class="text-dark" for="rua">Rua <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="rua" name="rua" placeholder="Nome da rua" value="" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label class="text-dark" for="numero">Número <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" value="" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="text-dark" for="complemento">Complemento ou referência <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="complemento" name="complemento" placeholder="ex.: casa, conj, portão azul..." value="" required>
                        </div>
                    </div>

                    <div class="form-row">

                    <div class="form-group col-md-4">
                        <label class="text-dark" for="bairro">Bairro <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="" >
                    </div>

                    <div class="form-group col-md-3">
                        <label class="text-dark" for="cidade">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="" >
                    </div>


                    <div class="form-group col-md-2">
                        <label class="text-dark" for="cidade">Estado</label>
                        <select id="estado" name="estado" class="form-control select2-single">
                            {% for e in estadosSelecao %}
                                <option value="{{ e[':id }}">{{ e[':uf }}</option>
                            {% endfor %}
                        </select>
                    </div>
                    </div>
                </div>

                <input type="hidden" id="nivel" name="nivel" value="3">
                <input type="hidden" id="senha" name="senha" value="{{senha}}">
                
<button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>
            
        </div>
    </div>
</form>
{% endblock %}

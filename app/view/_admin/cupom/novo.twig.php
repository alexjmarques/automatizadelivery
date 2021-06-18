
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Cupom de desconto</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/cupons">Cupom de Desconto</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
                <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/cupom/i" enctype="multipart/form-data">
                    <div class="card mb-4">
                        <div class="card-body">
                                <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="tipo">Tipo Cupom</label>
                                        <select class="form-control select2-single" id="tipo_cupom" name="tipo_cupom">
                                            <option value="1">Desconto em Porcentagem</option>
                                            <option value="2">Desconto em Dinheiro</option>
                                        </select>
                                </div>

                                  <div class="form-group col-md-5 catProds">
                                       <label>Nome do cupom</label>
                                      <input type="text" class="form-control" id="nome_cupom" name="nome_cupom" value="" required>
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label>Valor</label>
                                      <input type="text" class="form-control" id="valor_cupom" name="valor_cupom" value="" required>
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label>Data Validade</label>
                                    
                                        <div class="input-group date">
                                            <input type="text" id="expira" name="expira" class="form-control">
                                            <span class="input-group-text input-group-append input-group-addon">
                                                <i class="simple-icon-calendar"></i>
                                            </span>
                                        </div>
                                  </div>
                                  <div class="form-group col-md-5">
                                    <label>Quantas utilizações por pessoa?</label>
                                    <input type="text" class="form-control" id="qtd_utilizacoes" name="qtd_utilizacoes">
                                  </div> 

                                  <div class="form-group row mb-1 pl-3 col-md-3">
                                    <div class="col-12">
                                        <label class="col-12 col-form-label" style="padding-left: 0;">Status</label>
                                        <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left" title="Status do seu produto na plataforma">
                                            <input class="custom-switch-input" id="switch" name="switch" value="1" type="checkbox" checked>
                                            <label class="custom-switch-btn" for="switch"></label>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
                                <div class="btn_acao"><div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>
                </div>
                            
                        </div>
                    </div>
                    </form>

{% endblock %}



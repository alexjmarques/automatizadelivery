
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Nova Forma de Pagamento</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/formas-pagamento">Formas de Pagamento</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Nova</li>
    </ol>
</nav>
<div class="separator mb-5"></div>

                <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/formas-pagamento/i" enctype="multipart/form-data">
                    <div class="card mb-4">
                        <div class="card-body">
                        <h5>Forma de Pagamento</h5>
                                <div class="form-row">
                                <div class="form-group col-md-4">
                                       <label>Nome</label>
                                      <input type="text" class="form-control" id="tipo" name="tipo" value="" required>
                                  </div>
                                  <div class="form-group row mb-1 col-md-7">
                                        <div class="col-md-12">
                                            <label class="col-12 col-form-label" style="padding-left: 0;">Status forma de pagamento</label>
                                            <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left" title="Status da forma de pagamento na plataforma">
                                                <input class="custom-switch-input" id="switch" name="switch" value="1" type="checkbox" checked>
                                                <label class="custom-switch-btn" for="switch"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>
                            
                        </div>
                    </div>
                    </form>

{% endblock %}



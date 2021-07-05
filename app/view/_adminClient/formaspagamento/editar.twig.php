
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Editar forma de pagamento</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/formas-pagamento">Formas de Pagamento</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
                <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/formas-pagamento/u/{{retorno.id}}"  enctype="multipart/form-data">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 id="titleBy" data-id="{{retorno.id}}">Forma de Pagamento</h5>
                                <div class="form-row">
                                  <div class="form-group col-md-4">
                                       <label>Nome</label>
                                      <input type="text" class="form-control" id="tipo" name="tipo" value="{{retorno.tipo}}" required>
                                  </div>
                                  <div class="col-md-4">
                                                <label class="col-12 col-form-label" style="padding-left: 0;">Status forma de pagamento</label>
                                                <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left" title="Status da forma de pagamento na plataforma">
                                                    {% if(retorno.status == 1 ) %}
                                                        <input class="custom-switch-input" id="switch" name="switch" value="1" type="checkbox" checked>
                                                    {% else %}
                                                        <input class="custom-switch-input" id="switch" name="switch" value="0" type="checkbox">
                                                    {% endif %}
                                                    <label class="custom-switch-btn" for="switch"></label>
                                            </div>
                                    </div>
                                </div>
                            <input type="hidden" id="id" name="id" value="{{retorno.id}}">
                            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<div class="btn_acao"><div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
                </div>
                            
                        </div>
                    </div>
                    
                    </form>
{% endblock %}

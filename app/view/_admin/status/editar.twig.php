
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Editar Status</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/status">Status</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
                <form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/status/u/{{retorno.id}}"  enctype="multipart/form-data">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 id="titleBy" data-id="{{retorno.id}}">Status</h5>
                                <div class="form-row">
                                  <div class="form-group col-md-4">
                                       <label>Delivery</label>
                                      <input type="text" class="form-control" id="tipo" name="tipo" value="{{retorno.delivery}}" required>
                                  </div>

                                  <div class="form-group col-md-4">
                                       <label>Retirada</label>
                                      <input type="text" class="form-control" id="tipo" name="tipo" value="{{retorno.retirada}}" required>
                                  </div>
                                </div>
                            <input type="hidden" id="id" name="id" value="{{retorno.id}}">
                            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
                            
                        </div>
                    </div>
                    
                    </form>
{% endblock %}


{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Editar Motoboy</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/motoboys">Motoboys</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
                <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/motoboy/u/{{retorno.id}}"  enctype="multipart/form-data">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 id="titleBy" data-id="{{retorno.id}}">Motoboy</h5>
                                <div class="form-row">
                                  <div class="form-group col-md-5">
                                        <label>Nome</label>
                                        {% for u in usuario %}
                                        {% if retorno.id_usuario == u.id %}
                                        <input type="text" class="form-control" id="nome" name="nome" value="{{ u.nome }}" disabled>
                                        {% endif %}
                                        {% endfor %}
                                  </div>
                                  <div class="form-group col-md-2">
                                       <label>Diaria</label>
                                      <input type="text" class="form-control" id="diaria" name="diaria" value="{{retorno.diaria}}" required>
                                  </div>
                                  <div class="form-group col-md-2">
                                       <label>Taxa de Entrega</label>
                                      <input type="text" class="form-control" id="taxa" name="taxa" value="{{retorno.taxa}}" required>
                                  </div>
                                  <div class="form-group col-md-3">
                                       <label>Placa do Veículo</label>
                                      <input type="text" class="form-control" id="placa" name="placa" value="{{retorno.placa}}">
                                  </div>
                                </div>
                                <input type="hidden" id="id" name="id" value="{{retorno.id}}">
                                <input type="hidden" id="id_usuario" name="id_usuario" value="{{retorno.id_usuario}}">
                                <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-info d-block mt-3">Editar</button>
                    
                        </div>
                    </div>
                    
                    </form>
{% endblock %}

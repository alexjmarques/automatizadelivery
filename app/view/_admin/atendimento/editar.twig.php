{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Editar Categoria</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/categorias">Categorias</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar Categoria</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/conf/atendimento/u"
    enctype="multipart/form-data">
    <div class="card mb-4">
    <div class="card-body">
                            <h5>Horário de Funcionamento</h5>
                                <div class="form-row">
                                  <div class="form-group col-md-4 catProds">
                                       <label>Dia</label>
                                       <select class="form-control select2-single" id="dia" name="dia">
                                        {% for d in dias %}
                                            <option value="{{ d.id }}"{% if retorno.id_dia == d.id %}selected{% endif %}>{{ d.nome }}</option>
                                        {% endfor %}    
                                        </select>
                                  </div>
                                
                                  <div class="form-group col-md-4">
                                      <label>Aberto das (Ex: 10:00)</label>
                                      <input type="text" class="form-control timepicker" id="abertura" name="abertura" value="{{ retorno.abertura }}">
                                  </div>

                                  <div class="form-group col-md-4">
                                      <label>Fecha às: (Ex: 22:30)</label>
                                      <input type="text" class="form-control timepicker" id="fechamento" name="fechamento" value="{{ retorno.fechamento }}">
                                  </div>
                                 
                                </div>
                                <input type="hidden" id="id" name="id" value="{{ retorno.id }}">
                            <div class="btn_acao"><div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
                </div>
                            
                        </div>
    </div>
</form>
{% endblock %}
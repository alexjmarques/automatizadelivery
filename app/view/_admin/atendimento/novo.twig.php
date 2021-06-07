
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Horário de Funcionamento</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/categorias">Categorias</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Horário de Funcionamento</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
                <form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/conf/atendimento/i" enctype="multipart/form-data">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>Horário de Funcionamento</h5>
                                <div class="form-row">
                                  <div class="form-group col-md-4 catProds">
                                       <label>Dia</label>
                                       <select class="form-control select2-single" id="dia" name="dia">
                                        {% for d in dias %}
                                            <option value="{{ d.id }}">{{ d.nome }}</option>
                                        {% endfor %}    
                                        </select>
                                  </div>
                                
                                  <div class="form-group col-md-4">
                                      <label>Aberto das (Ex: 10:00)</label>
                                      <input type="text" class="form-control timepicker" id="abertura" name="abertura" value="" required>
                                  </div>

                                  <div class="form-group col-md-4">
                                      <label>Fecha às: (Ex: 22:30)</label>
                                      <input type="text" class="form-control timepicker" id="fechamento" name="fechamento" value="" required>
                                  </div>
                                 
                                </div>
                            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
                            <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>
                            
                        </div>
                    </div>
                    </form>

{% endblock %}



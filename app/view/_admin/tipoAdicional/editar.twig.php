{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Categoria Adicional</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/tipo-adicionais">Categoria do Adicional</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar Categoria do Adicional</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/tipo-adicional/u/{{retorno.id}}" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-5 catProds">
                    <label>Categoria</label>
                    <input type="text" class="form-control" id="tipo" name="tipo" value="{{retorno.tipo}}" required>
                </div>

                <div class="form-group col-md-8 hidden">
                    <input type="hidden" class="form-control" id="slug" name="slug" value="{{retorno.slug}}">
                </div>

                <div class="form-group col-md-3">
                    <div class="form-group position-relative">
                        <label for="tipoSabor">Tipo de Escolha</label>
                        <select class="form-control select2-single" id="tipo_escolha" name="tipo_escolha">
                            <option value="1" {% if retorno.tipo_escolha == 1 %}selected{% endif %}>Opcional</option>
                            <option value="2" {% if retorno.tipo_escolha == 2 %}selected{% endif %}>Obrigatório</option>
                            <option value="3" {% if retorno.tipo_escolha == 3 %}selected{% endif %}>Obrigatório até X escolha</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row mb-1 pl-3 col-md-4">

                    <div class="col-12">
                        <label class="col-12 col-form-label" style="padding-left: 0;">Status</label>
                        <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left" title="Status da Categoria do Adicional">
                            {% if(retorno.status == 1 ) %}
                            <input class="custom-switch-input" id="switch" name="switch" value="1" type="checkbox" checked>
                            {% else %}
                            <input class="custom-switch-input" id="switch" name="switch" value="0" type="checkbox">
                            {% endif %}
                            <label class="custom-switch-btn" for="switch"></label>
                        </div>
                    </div>

                </div>

                <div id="tipo_escolhaQtd" class="form-group col-md-3 {% if retorno.tipo_escolha == 1 %}hide{% endif %} {% if retorno.tipo_escolha == 2 %}show{% endif %}">
                    <label for="tipoSabor">Informe a Quantidade</label>
                    <input type="number" class="form-control" id="qtd" name="qtd" value="{{retorno.qtd}}">
                </div>

            </div>
            <input type="hidden" id="id" name="id" value="{{retorno.id}}">
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>

        </div>
    </div>

</form>

{% endblock %}
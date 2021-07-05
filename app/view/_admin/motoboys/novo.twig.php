{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Novo Motoboy</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/motoboys">Motoboys</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<div class="separator mb-5"></div>

<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/motoboy/i" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5>Motoboy</h5>
            <p>Cadastre seus entregadores para que possa ter um gerencimanto de cada entrega</p>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <div class="form-group position-relative">
                        <label for="id_usuario">Motoboy</label>
                        <select class="form-control select2-single" id="id_usuario" name="id_usuario" required>
                            <option value="0">Selecione o Motoboy</option>
                            {% for me in motoboysEmpresa %}
                            {% for m in motoboys %}
                            {% if m.id == me.id_usuario %}
                            <option value="{{ m.id }}">{{ m.nome }}</option>
                            {% endif %}
                            {% endfor %}
                            {% endfor %}
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label>Diaria</label>
                    <input type="text" class="form-control" id="diaria" name="diaria" value="" required>
                </div>

                <div class="form-group col-md-2">
                    <label>Taxa de Entrega por km</label>
                    <input type="text" class="form-control" id="taxa" name="taxa" value="" required>
                </div>

                <div class="form-group col-md-3">
                    <label>Placa do Veículo</label>
                    <input type="text" class="form-control" id="placa" name="placa" value="">
                </div>
            </div>
            <input type="hidden" id="produtos" name="produtos" value="0">
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <div class="btn_acao"><div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>
                </div>

        </div>
    </div>
</form>

{% endblock %}
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Entregas</h1>
<div class="separator mb-5"></div>
<div class="row">
    <div class="col-12 col-xl-12 mb-4">
        <form  method="get" id="formBusca" action="{{BASE}}{{empresa.link_site}}/admin/buscar/entregas">
            <div class="card h-100">
                <div class="card-body">
                    <p class="mb-4">Para verificar as entregas feitas selecione o periodo de quando iniciou e quando finalizou as entregas de determinado Motoboy.</p>
                        <div class="form-group mb-1 col-md-3">
                            <label>Motoboy</label>
                            <div class="input-group ">
                                <select class="form-control select2-single" id="id_motoboy" name="id_motoboy" autocomplete="off" required>
                                    <option value="0">Selecione um Motoboy</option>
                                    {% for m in motoboy %}
                                    <option value="{{ m[':id }}">{{ m[':nome }}</option>
                                    {% endfor %}
                                </select>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-1 col-md-4">
                            <label>Data de início</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" name="inicio" id="inicio" autocomplete="off" required>
                                <span class="input-group-text input-group-append input-group-addon">
                                    <i class="simple-icon-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-1 col-md-4">
                            <label>Data do término</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" name="termino" id="termino" autocomplete="off" required>
                                <span class="input-group-text input-group-append input-group-addon">
                                    <i class="simple-icon-calendar"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-1 col-md-1">
                            <div class="input-group-append buscarFull">
                                <button type="submit" class="btn btn-primary default"><i class="simple-icon-magnifier"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="carregar"></div>
    <div id="mensagem"></div>
    <div id="buscaResultado"></div>
</div>
    </div>
{% endblock %}

{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Novo Local</h1>
<div class="separator mb-5"></div>
<div class="col-12">
    <form action="{{BASE}}{{empresa.link_site}}/admin/locais/insert-locais/" method="post"  enctype="multipart/form-data">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Local</h5>
                <p>Se você possui mais de uma loja dívida os atendimentos por locais</p>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nome do Local</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="" required>
                    </div>
                </div>
            <input type="hidden" id="produtos" name="produtos" value="0">
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
        <button type="submit" name="cadastrar" id="cadastrar" class="btn btn-info d-block mt-3">Cadastrar</button>
        
            </div>
        </div>
    </form>
</div>
{% endblock %}

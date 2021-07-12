{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1 data-id="{{retorno.id}}">Nova Massa</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/massas">Massa de Pizzas</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Nova Massa de pizza</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/massa/i" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6 catProds">
                    <label>Massa de pizza</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{retorno.nome}}" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Valor</label>
                    <input type="text" class="form-control" id="valor" name="valor" value="{{retorno.valor}}" required autocomplete="off">
                </div>
            </div>

            <div class="form-row mb-4">
                <div class="col-md-12">
                    <label class="bold">Tamanhos</label>
                </div>
                <div class="row col-md-12">
                    {% for cat in tamanhos %}
                    <div class="col-md-4 mt-2">
                        <div class="p-2 colAdc">
                            <input checked type="checkbox" id="tamanhos{{ cat.id }}" name="tamanhos[]" value="{{ cat.id }}" class="mp2">
                            <label class="form-check-label" for="tamanhos{{ cat.id }}"> {{ cat.nome }}</label>
                        </div>
                    </div>
                    {% endfor %}
                </div>
            </div>
            
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Adicionar</button>
            </div>
        </div>
    </div>
</form>
{% endblock %}
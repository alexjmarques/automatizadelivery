{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Nova Tamanho</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/tamanhos">Tamanhos</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Nova Tamanho</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/tamanho/i" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5>Tamanho</h5>
            <p>Indique aqui quais os tamanhos que suas pizzas são produzidas, em quantos pedaços são cortadas e até quantos sabores seu restaurante monta cada tamanho:</p>
            <div class="form-row">
                <div class="form-group col-md-6 catProds">
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Qtd. Pedaços (até 20)</label>
                    <input type="number" class="form-control" id="qtd_pedacos" name="qtd_pedacos" value="1" required min="1" max="20">
                </div>
                <div class="form-group col-md-3">
                    <label>Qtd. Sabores (até 4)</label>
                    <input type="number" class="form-control" id="qtd_sabores" name="qtd_sabores" value="4" required min="1" max="4">
                </div>
            </div>

            <div class="form-row mb-4">
                <div class="col-md-12">
                    <label class="bold">Categorias</label>
                </div>
                <div class="row col-md-12">
                    {% for cat in categorias %}
                    <div class="col-md-4 mt-2">
                        <div class="p-2 colAdc">
                            <input checked type="checkbox" id="categorias{{ cat.id }}" name="categorias[]" value="{{ cat.id }}" class="mp2">
                            <label class="form-check-label" for="categorias{{ cat.id }}"> {{ cat.nome }}</label>
                        </div>
                    </div>
                    {% endfor %}
                </div>
            </div>
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>
            </div>

        </div>
    </div>
</form>

{% endblock %}
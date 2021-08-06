{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Produtos</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Produtos</li>
    </ol>
</nav>

{% if categoriaQtd == 0 %}
<div class="alert alert-warning" role="alert">
    Para cadastrar um novo produdo cadastre as Categorias! <a href="{{BASE}}{{empresa.link_site}}/admin/categoria/nova">Clique aqui</a> para Cadastrar.
</div>
{% else %}
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/produto/novo" class="btn btn-info btn-sm"><i class="simple-icon-plus"></i> Novo produto</a>
    {% if empresa.id_categoria == 6 %}
    {% if qtdTamanho > 0 %}
    <a href="{{BASE}}{{empresa.link_site}}/admin/produto-pizza/novo" class="btn btn-info btn-sm ml-2"> <i class="simple-icon-plus"></i>
        Nova Pizza</a>
    {% endif %}
    {% endif %}
</div>
{% endif %}
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <table class="data-table data-table-simple responsive" data-order='[[ 2, "asc" ]]'>
                    <thead class="linhaTop">
                        <tr>
                            <th style="width: 100px;">Imagem</th>
                            <th>Nome</th>
                            <th style="width: 100px !important;">Valor</th>
                            <th style="width: 110px !important;">Categoria</th>
                            <th style="width: 100px !important;">Status</th>
                            <th style="width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in produtos %}
                        <tr style="width: 100px;">
                            <td>
                                {% if p.imagem is not empty %}
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produto/editar/{{ p.id }}"><img src="{{BASE}}uploads{{p.imagem}}" width="80px" /></a>
                                {% endif %}
                            </td>
                            <td>
                                <p><a href="{{BASE}}{{empresa.link_site}}/admin/produto/editar/{{ p.id }}">{{ p.nome }}</a></p>
                            </td>

                            <td>
                                <p class="text-center">
                                {% if p.valor == 0.00 %}
                                {% set maxValue = 0 %}-----{% else %}
                                    {{ moeda.simbolo }} {{ p.valor|number_format(2, ',', '.') }}
                                {% endif %}
                                </p>
                            </td>
                            <td>
                                <p class="text-center">
                                    {% for cat in categorias %}
                                    {% if p.id_categoria == cat.id %}
                                    {{cat.nome}}
                                    {% endif %}
                                    {% endfor %}
                                </p>
                            </td>
                            <td>
                                <p class="text-muted text-center">{% if p.status == 1 %}
                                    <span class="text-success cartao text-center" data-toggle="tooltip" data-placement="top" title="Produto Ativo"><i class="simple-icon-check"></i></span>
                                    {% else %}<span class="text-danger cartao text-center" data-toggle="tooltip" data-placement="top" title="Produto Desativado"><i class="simple-icon-close"></i></span>{% endif %}
                                </p>
                            </td>
                            <td>
                            {% if p.valor == 0.00 %}
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produto-pizza/editar/{{ p.id }}" class="btn btn-outline-success" ata-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i></a>
                                {% else %}
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produto/editar/{{ p.id }}" class="btn btn-outline-success" ata-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i></a>
                                {% endif %}
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                <div class="col-12 center-block text-center float-ceter">{{paginacao|raw}}</div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
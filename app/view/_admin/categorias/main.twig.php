{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Categorias</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Categorias</li>
    </ol>
</nav>
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/categoria/nova"
        class="btn btn-info btn-sm">Nova Categoria</a></div>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <table class="data-table data-table-simple responsive nowrap">
                    <thead class="linhaTop">
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th style="width: 50px !important;">Posição</th>
                            <th style="width: 50px !important;">Produtos</th>
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in categorias %}
                        <tr>
                            <td>
                                <p class="list-item-heading"><a
                                        href="{{BASE}}{{empresa.link_site}}/admin/categoria/editar/{{ p.id }}">{{ p.nome
                                        }}</a></p>
                            </td>
                            <td>
                                <p class="text-muted">{{ p.descricao }}</p>
                            </td>
                            <td>
                                <p class="text-center">{{ p.posicao }}</p>
                            </td>
                            <td>
                                <p class="text-center">{{ p.produtos }}</p>
                            </td>
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/categoria/editar/{{ p.id }}"
                                    class="btn btn-outline-success mb-1"><i class="simple-icon-note"></i></a>
                                {% if p.produtos == 0 %}
                                <a href="{{BASE}}{{empresa.link_site}}/admin/categoria/d/{{ p.id }}"
                                    class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i></a>
                                {% endif %}
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                <div class="col-12 center-block text-center float-ceter">
                    {{paginacao|raw}}
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
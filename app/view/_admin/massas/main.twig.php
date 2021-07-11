{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Massa de Pizza</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Massa de Pizza</li>
    </ol>
</nav>
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/massa/nova"
        class="btn btn-info btn-sm"><i class="simple-icon-plus"></i> Massa de Pizza</a></div>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <table class="data-table data-table-simple responsive nowrap">
                    <thead class="linhaTop">
                        <tr>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in massas %}
                        <tr>
                            <td>
                                <p class="list-item-heading"><a href="{{BASE}}{{empresa.link_site}}/admin/massa/editar/{{ p.id }}">{{ p.nome }}</a></p>
                            </td>
                            <td>
                            {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}
                            </td>
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/massa/editar/{{ p.id }}" class="btn btn-outline-success mb-1"><i class="simple-icon-note"></i> Editar</a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                <div class="col-7 center-block text-center float-ceter">
                    {{paginacao|raw}}
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
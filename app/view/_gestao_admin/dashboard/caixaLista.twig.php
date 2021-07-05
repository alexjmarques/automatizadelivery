{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Fluxo de Caixa</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Fluxo de Caixa</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        {% if totalPedidos == 0 %}
        <div class="row">
            <div class="form-side col-lg-12">
                <div class="text-center pt-4">

                    <p class="display-1 font-weight-bold mt-5">
                        <span class="iconsminds-digital-drawing iconeMenu"></span>
                    </p>
                    <p class="mb-0 text-muted text-small mb-2">Inicie seu atendimento e venda mais</p>
                    <h6 class="mb-4">Você não possui dados o suficiente para gerar relatório!</h6>
                    <a href="{{BASE}}{{empresa.link_site}}/admin" class="btn btn-primary btn-lg btn-shadow">Venda
                        mais</a>
                </div>
            </div>
        </div>
        {% else %}
        <div class="card">

            <div class="card-body">
                <table class="data-table data-table-simple responsive nowrap">
                    <thead class="linhaTop">
                        <tr>
                            <th>Caixa</th>
                            <th style="width: 150px !important;">Data</th>
                            <th style="width: 100px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for c in caixas %}
                        {% if c.data_final is not null %}
                        <tr>
                            <td>
                                <p class="text-muted"><a
                                        href="{{BASE}}{{empresa.link_site}}/admin/caixa/dia/{{ c.id }}">Dia ({{
                                        c.data_inicio|date('m-d') }})</a></p>
                            </td>
                            <td>
                                <p class="text-muted"><a
                                        href="{{BASE}}{{empresa.link_site}}/admin/caixa/dia/{{ c.id }}">{{
                                        c.data_inicio|date('d/m/Y') }}</a></p>
                            </td>
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/caixa/dia/{{ c.id }}"
                                    class="btn btn-outline-success mb-1"><i class="simple-icon-eye"></i> Visualizar</a>
                            </td>
                        </tr>
                        {% endif %}
                        {% endfor %}
                    </tbody>
                </table>
                <div class="col-6 center-block text-center float-ceter">
                    {{paginacao|raw}}
                </div>

            </div>
        </div>
        {% endif %}
    </div>
</div>
{% endblock %}
{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Horário de Funcionamento</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Horário de Funcionamento</li>
    </ol>
</nav>
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/conf/atendimento/novo"
        class="btn btn-info btn-sm">Novo Horário</a></div>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <table id="customers" class="data-table">
                    <thead class="linhaTop">
                        <tr>
                            <th style="width: 200px !important;">Dia</th>
                            <th style="width: 200px !important;">Abertura</th>
                            <th style="width: 200px !important;">Fechamento</th>
                            <th style="width: 100px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in funcionamento %}
                        <tr>
                            <td>
                                <p class="text-muted">
                                
                                {% for d in dias %}
                                {% if p.id_dia == d.id %}
                                
                                {{ d.nome }}

                                {% endif %}
                                {% endfor %}
                                </p>
                            </td>
                            <td>
                                <p class="text-muted">{{ p.abertura|date('H:i') }}</p>
                            </td>
                            <td>
                                <p class="text-muted">{{ p.fechamento|date('H:i') }}</p>
                            </td>
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/conf/atendimento/editar/{{ p.id }}" class="btn btn-outline-success"><i class="simple-icon-note"></i></a>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/conf/atendimento/deletar/{{ p.id }}" class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i></a>
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
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Relatórios</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Relatórios</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<div class="row mb-4">
<div class="col-12 data-tables-hide-filter">
<div class="card">
    <div class="card-body">
        <table id="customers" class="data-table">
                    <thead class="linhaTop">
                        <tr>
                            <th>Caixa</th>
                            <th style="width: 150px !important;">Data</th>
                            <th style="width: 100px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for c in caixa%}
                            {% if c[':data_final'] is not null %}
                            <tr>
                                <td>
                                <p class="list-item-heading"><a href="{{BASE}}{{empresa.link_site}}/admin/caixa/dia/{{ c[':id }}">Dia-{{ c[':id }}</a></p>
                                </td>
                                <td>
                                <p class="list-item-heading"><a href="{{BASE}}{{empresa.link_site}}/admin/caixa/dia/{{ c[':id }}">{{ c[':data_inicio']|date('d/m/Y') }}</a></p>
                                </td>
                                <td>
                                    <a href="{{BASE}}{{empresa.link_site}}/admin/caixa/dia/{{ c[':id }}" class="btn btn-outline-success" ><i class="simple-icon-eye"></i></a>
                                </td>
                            </tr>
                            {% endif %}
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
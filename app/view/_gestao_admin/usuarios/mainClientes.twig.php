{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Clientes</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Clientes</li>
    </ol>
</nav>
{% if nivelUsuario == 0 %}
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/cliente/novo" class="btn btn-info btn-sm">Novo Cliente</a></div>
{% endif %}
<div class="separator mb-5"></div>
<div class="row mb-4">
<div class="col-12 data-tables-hide-filter">
<div class="card">
    <div class="card-body">
        <table class="data-table data-table-simple responsive nowrap" >
                    <thead class="linhaTop">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in usuario%}
                        <tr>
                            <td>
                               <p class="list-item-heading"><a href="{{BASE}}{{empresa.link_site}}/admin/usuario/editar/{{ p.id }}">{{ p.nome }}</a></p>
                            </td>
                            <td>
                                <p class="text-muted">{{ p.email }}</p>
                            </td>
                            <td>
                                <p class="text-muted">{{ p.telefone }}</p>
                            </td>
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/usuario/editar/{{ p.id }}" class="btn btn-outline-success mb-1" ata-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i></a>
                                {% if nivelUsuario == 0 %}
                                <a href="{{BASE}}{{empresa.link_site}}/admin/usuario/d/{{ p.id }}" class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i></a>
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

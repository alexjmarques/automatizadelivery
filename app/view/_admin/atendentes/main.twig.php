{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Atendentes</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Atendentes</li>
    </ol>
</nav>

{% if nivelUsuario == 0 %}
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/atendente/novo" class="btn btn-info btn-sm">Novo Atendente</a></div>
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
                    {% for m in retorno %}
                    {% for user in usuarios %}
                        {% if m.id_usuario == user.id %}
                        <tr>
                            <td>
                               <p class="text-muted">{{ user.nome }}</p>
                            </td>
                            <td>
                                <p class="text-muted">{{ user.email }}</p>
                            </td>
                            <td>
                                <p class="text-muted">({{ user.telefone[:2] }}) {{ user.telefone|slice(2, 5) }}-{{ user.telefone|slice(7, 9) }}</p>
                            </td>
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/atendente/editar/{{ user.id }}" class="btn btn-outline-success mb-1" ata-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i></a>
                                {% if nivelUsuario == 0 %}
                                <a href="{{BASE}}{{empresa.link_site}}/admin/atendente/d/{{ user.id }}/{{ user.nivel }}" class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i> Excluir</a>
                                {% endif%}
                            </td>
                        </tr>
                        {% endif %}
                      {% endfor %}
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

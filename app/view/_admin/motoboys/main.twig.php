{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Motoboys</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Motoboys</li>
    </ol>
</nav>
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/motoboy/novo" class="btn btn-info btn-sm">Novo Motoboy</a></div>
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
                            <th style="width: 50px !important;">Diaria</th>
                            <th style="width: 50px !important;">Taxa</th>
                            <th style="width: 50px !important;">Placa</th>
                            
                            <th style="width: 100px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in motoboy %}
                            {% for u in usuario %}
                                {% if p.id_usuario == u.id %}
                                <tr>
                                    <td>
                                    <p><a href="{{BASE}}{{empresa.link_site}}/admin/motoboy/editar/{{ p.id }}">{% if u.id == p.id_usuario %}{{ u.nome }}{% endif %}</a></p>
                                    </td>

                                    <td>
                                    <p>{% if u.id == p.id_usuario %}{{ u.email }}{% endif %}</p>
                                    </td>
                                    <td>
                                        <p class="text-center">{{ moedaAtivo.simbolo }} {{ p.diaria|number_format(2, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-center">{{ moedaAtivo.simbolo }} {{ p.taxa|number_format(2, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-center">{{ p.placa }}</p>
                                    </td>
                                    <td>
                                        <a href="{{BASE}}{{empresa.link_site}}/admin/motoboy/editar/{{ p.id }}" class="btn btn-outline-success mb-1" ><i class="simple-icon-note"></i> Editar</a>
                                        <a href="{{BASE}}{{empresa.link_site}}/admin/motoboy/d/{{ p.id }}" class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i> Deletar</a>
                                    </td>
                                </tr>
                                {% endif %}
                            {% endfor %}
                        {% endfor %}
                    </tbody>
            </table>
            <div class="col-4 center-block text-center float-ceter">
            {{paginacao|raw}}
            </div>
     </div>
     </div>
     </div>
     </div>
{% endblock %}


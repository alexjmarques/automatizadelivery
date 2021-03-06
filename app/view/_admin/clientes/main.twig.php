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

<div class="separator mb-5"></div>
<div class="row mb-4">
<div class="col-12 data-tables-hide-filter">
<div class="card">
    <div class="card-body">
        <table class="data-table data-table-simple responsive nowrap" >
                    <thead class="linhaTop">
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Data Cadastro</th>
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    {% for user in usuarios %}
                    {% for u in retorno %}
                        {% if u.id_usuario == user.id %}
                        <tr>
                            <td>
                               <p class="text-muted">{{ user.nome }}</p>
                            </td>
                            
                            <td>
                                <p class="text-muted">({{ user.telefone[:2] }}) {{ user.telefone|slice(2, 5) }}-{{ user.telefone|slice(7, 9) }}</p>
                            </td>
                            <td>
                               <p class="text-muted">{{ user.created_at|date('d/m/Y') }}</p>
                            </td>
                            <td>
                            <a class="btn btn-outline-info mb-1" data-toggle="modal" data-target="#alerta" onclick="verEndereco({{ user.id }})"><i class="simple-icon-eye"></i></a>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/cliente/editar/{{ user.id }}" class="btn btn-outline-success" ata-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i></a>
                                {% if nivelUsuario == 0 %}
                                <a href="{{BASE}}{{empresa.link_site}}/admin/cliente/d/{{ user.id }}/{{ user.nivel }}" class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i></a>
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

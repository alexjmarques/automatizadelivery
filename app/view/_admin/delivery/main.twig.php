{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}

<h1>Delivery</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Delivery</li>
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
                            <th>Delivery</th>
                            <th style="width: 50px !important;">Status</th>
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in delivery%}
                        <tr>
                            <td>
                               <p class="list-muted"><a href="{{BASE}}{{empresa.link_site}}/admin/delivery/editar/{{ p.id }}">{{ p.tipo }}</a></p>
                            </td>
                            <td>
                                    <p class="text-muted text-center">{% if p.status == 1 %} 
                                    <span class="text-success cartao text-center" data-toggle="tooltip" data-placement="top" title="Produto Ativo"><i class="simple-icon-check"></i></span>
                                            {% else %}<span class="text-danger cartao text-center" data-toggle="tooltip"
                                data-placement="top" title="Produto Desativado"><i class="simple-icon-close"></i></span>{% endif %}</p>
                            </td>
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/delivery/editar/{{ p.id }}" class="btn btn-outline-success mb-1" data-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i> Editar</a>
                                
                            </td>
                        </tr>
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

{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}

<h1>Status</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Status</li>
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
                            <th >Retirada</th>
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in status %}
                        <tr>
                            <td>
                               <p class="text-muted">{{ p.delivery }}</p>
                            </td>
                            <td>
                                <p class="text-muted">{{ p.retirada }}</p>
                            </td>
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/status/editar/{{ p.id }}" class="btn btn-outline-success mb-1" ><i class="simple-icon-note"></i></a>
                                
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

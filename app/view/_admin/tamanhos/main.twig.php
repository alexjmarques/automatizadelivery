{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Tamanho de Pizza</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Tamanho de Pizza</li>
    </ol>
</nav>
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/tamanho/novo"
        class="btn btn-info btn-sm"><i class="simple-icon-plus"></i> Tamanho de Pizza</a></div>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <table id="customers" class="data-table">
                    <thead class="linhaTop">
                        <tr>
                            <th>Nome</th>
                            <th>Qtd. Pedaços</th>
                            <th>Qtd. Sabores</th>
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in tamanhos %}
                        <tr>
                            <td>
                                <p class="list-item-heading"><a
                                        href="{{BASE}}{{empresa.link_site}}/admin/tamanho/editar/{{ p.id }}">{{ p.nome
                                        }}</a></p>
                            </td>
                            <td>
                                {{ p.qtd_pedacos }}
                            </td>
                            <td>
                            até {{ p.qtd_sabores }}
                            </td>
                            
                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/tamanho/editar/{{ p.id }}"
                                    class="btn btn-outline-success"><i class="simple-icon-note"></i></a>
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
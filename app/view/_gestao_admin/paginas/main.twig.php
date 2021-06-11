{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Páginas</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Páginas</li>
    </ol>
</nav>
<div class="top-right-button-container"><a href="{{BASE}}admin/pagina/nova" class="btn btn-info btn-sm">Nova Página</a></div>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <table class="data-table data-table-simple responsive nowrap">
                    <thead class="linhaTop">
                        <tr>
                            <th>Nome</th>
                            <th style="width: 50px !important;">Slug</th>
                            <th style="width: 50px !important;">Conteudo</th>
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in paginas %}
                        <tr>
                            <td>
                                <p class="list-item-heading"><a href="{{BASE}}admin/categoria/editar/{{ p.id }}">{{ p.titulo
                                        }}</a></p>
                            </td>
                            <td>
                                <p class="text-muted">{{ p.slug }}</p>
                            </td>
                            <td>
                                <p class="text-muted text-center">{% if p.conteudo != "" %}
                                    <span class="text-success cartao text-center" data-toggle="tooltip" data-placement="top" title="Página Ativa"><i class="simple-icon-check"></i></span>
                                    {% else %}<span class="text-danger cartao text-center" data-toggle="tooltip" data-placement="top" title="Produto Desativado"><i class="simple-icon-close"></i></span>{% endif %}
                                </p>
                            </td>
                            <td>
                                <a href="{{BASE}}admin/pagina/editar/{{ p.id }}" class="btn btn-outline-success mb-1"><i class="simple-icon-note"></i> Editar</a>
                                <a href="{{BASE}}admin/pagina/d/{{ p.id }}" class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i> Deletar</a>
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
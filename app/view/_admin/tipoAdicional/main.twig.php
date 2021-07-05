{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Categoria Adicional</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Categoria Adicional</li>
    </ol>
</nav>

<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/tipo-adicional/nova" class="btn btn-info btn-sm">Nova
        Categoria Adicional</a></div>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <table class="data-table data-table-simple responsive nowrap">
                    <thead class="linhaTop">
                        <tr>
                            <th>Tipo</th>
                            <th style="width: 50px !important;">Tipo de Escolha</th>
                            <th style="width: 50px !important;">Quantidade</th>
                            <th style="width: 50px !important;">Status</th>
                            <th style="width: 200px !important;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in tipoAdicional%}
                        <tr>
                            <td>
                                <p class="list-item-heading"><a href="{{BASE}}{{empresa.link_site}}/admin/tipo-adicional/editar/{{ p.id }}">{{ p.tipo }}</a>
                                </p>
                            </td>
                            <td>
                                {% if p.tipo_escolha == 1 %}Opcional{% endif %}
                                {% if p.tipo_escolha == 2 %}Obrigatório{% endif %}
                                {% if p.tipo_escolha == 3 %}Obrigatório até <strong>{{ p.qtd }}</strong>
                                escolha{% endif %}

                            </td>
                            <td class="list-item-heading text-center">
                                {{ p.qtd }}
                            </td>
                            <td>
                                <p class="text-muted text-center">{% if p.status == 1 %}
                                    <span class="text-success cartao text-center" data-toggle="tooltip" data-placement="top" title="Tipo Adicional Ativo"><i class="simple-icon-check"></i></span>
                                    {% else %}<span class="text-danger cartao text-center" data-toggle="tooltip" data-placement="top" title="Tipo Adicional Desativado"><i class="simple-icon-close"></i></span>{% endif %}
                                </p>
                            </td>
                            </td>

                            <td>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/tipo-adicional/editar/{{ p.id }}" class="btn btn-outline-success mb-1"><i class="simple-icon-note"></i> Editar</a>
                                <a href="{{BASE}}{{empresa.link_site}}/admin/tipo-adicional/d/{{ p.id }}" class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i> Deletar</a>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{% endblock %}
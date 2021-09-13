{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Produto Adicional</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Produto Adicional</li>
    </ol>
</nav>

<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/tipo-adicional/nova" class="btn btn-info btn-sm"><i class="simple-icon-plus"></i>Adicionar categoria</a></div>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <div id="accordion">
                    {% set indexCat = 0 %}
                    {% for c in adicionalTipoAdicional %}
                    <div class="border border-classic-big p-3 mb-3 pb-0x">
                        {% set indexCat = indexCat + 1 %}
                        <div class="btn-link-collapse pb-2">
                            <button id="cats{{ c.id }}" class="btn float-left buton-collapse" data-toggle="collapse" data-target="#adicional{{ c.id }}" aria-expanded="true" aria-controls="adicional{{ c.id }}">
                                <i aria-hidden="true" class="icon category-group-header-options__icon fa fa-chevron-down fa fa-plus"></i>
                            </button>
                            <div class="float-left menu-list-category-actions">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/tipo-adicional/editar/{{ c.id }}">{{ c.tipo }}</a>
                            </div>
                            <div class="top-right-button-container">
                                <a href="{{BASE}}{{empresa.link_site}}/admin/produto-adicional/novo/{{ c.id }}" class="btn btn-info btn-sm btn-inverter">
                                    <i class="simple-icon-plus"></i>
                                    Adicionar item</a>

                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <div id="adicional{{ c.id }}" class="collapse {% if indexCat == 1 %}show{% endif %}" data-parent="#accordion">
                            <table class="data-table data-table-simple responsive pt-2 pb-2 linha-top" data-order='[[ 2, "asc" ]]'>
                                <thead class="linhaTop">
                                    <tr>
                                        <th>Nome</th>
                                        <th style="width: 100px !important;">Valor</th>
                                        <th style="width: 160px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {% for p in tipoAdicional %}
                                    {% if c.id == p.tipo_adicional %}
                                    <tr style="width: 100px;">
                                        <td>
                                            <p class="list-item-heading"><a href="{{BASE}}{{empresa.link_site}}/admin/produto-adicional/editar/{{ p.id }}">{{ p.nome }}</a></p>
                                        </td>
                                        <td>
                                            <p class="text-muted">{{ moeda.simbolo }} {{ p.valor|number_format(2, ',', '.') }}</p>
                                        </td>
                                        <td>
                                            <a href="{{BASE}}{{empresa.link_site}}/admin/produto-adicional/editar/{{ p.id }}" class="btn btn-outline-success" ata-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i></a>
                                            <a href="{{BASE}}{{empresa.link_site}}/admin/produto-adicional/d/{{ p.id }}" class="btn btn-outline-danger mb-1"><i class="simple-icon-trash"></i></a>
                                        </td>
                                    </tr>
                                    {% endif %}
                                    {% endfor %}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {% endfor %}
                </div>
            </div>


            
        </div>
    </div>
</div>
{% endblock %}
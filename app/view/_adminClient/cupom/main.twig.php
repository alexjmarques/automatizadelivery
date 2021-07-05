{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Cupom de Desconto</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Cupom de Desconto</li>
    </ol>
</nav>
<div class="top-right-button-container"><a href="{{BASE}}{{empresa.link_site}}/admin/cupom/novo" class="btn btn-info btn-sm">Novo Cupom de Desconto</a></div>
<div class="separator mb-5"></div>
<div class="row mb-4">
<div class="col-12 data-tables-hide-filter">
<div class="card">
    <div class="card-body">
        <table class="data-table data-table-simple responsive nowrap" >
                    <thead class="linhaTop">
                        <tr>
                            <th>Cupom Desconto</th>
                            <th>Valor</th>
                            <th style="width: 50px !important;">Validade</th>
                            <th style="width: 50px !important;">Expira</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in cupom%}
                        <tr>
                            <td>
                               <p class="list-item-heading">{{ p.nome_cupom }}</p>
                            </td>
                            <td>
                                <p class="text-left">{% if p.tipo_cupom == 1%}
                                    {{ p.valor_cupom|round(1, 'floor') }}%
                                    {% else %}
                                    {{ moeda.simbolo }} {{ p.valor_cupom|number_format(2, ',', '.')|raw }}
                                    {% endif %}</p>
                            </td>
                            <td>
                                <p class="text-center">
                                {{ p.qtd_utilizacoes}} por pessoa
                                </p>
                            </td>
                            <td>
                                <p class="text-center">{{ p.expira|date('d/m/Y')|raw }}</p>
                            </td>
                            
                        </tr>
                        {% endfor %}
                    </tbody>
            </table>
            <div class="col-5 center-block text-center float-ceter">
            {{paginacao|raw}}
            </div>
     </div>
     </div>
     </div>
     </div>
{% endblock %}

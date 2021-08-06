{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Fluxo de Compras</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Fluxo de compra por cliente</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        {% if totalPedidos == 0 %}
        <div class="row">
            <div class="form-side col-lg-12">
                <div class="text-center pt-4">
                    <p class="display-1 font-weight-bold mt-5">
                        <span class="iconsminds-digital-drawing iconeMenu"></span>
                    </p>
                    <p class="mb-0 text-muted text-small mb-2">Inicie seu atendimento e venda mais</p>
                    <h6 class="mb-4">Você não possui dados o suficiente para gerar relatório!</h6>
                    <a href="{{BASE}}{{empresa.link_site}}/admin" class="btn btn-primary btn-lg btn-shadow">Venda
                        mais</a>
                </div>
            </div>
        </div>
        {% else %}
        <div class="card">

            <div class="card-body">
                <table id="customers" class="data-table">
                    <thead class="linhaTop">
                        <tr>
                            <th>Cliente</th>
                            <th style="width: 150px !important;">Telefone</th>
                            <th style="width: 100px !important;">Pedidos</th>
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
                                <p class="text-muted">({{ user.telefone[:2] }}) {{ user.telefone|slice(2, 5) }}-{{ user.telefone|slice(7, 9) }}</p>
                            </td>
                            <td>
                                <p class="text-muted">{{ m.pedidos }}</p>
                            </td>
                        </tr>
                        {% endif %}
                      {% endfor %}
                    {% endfor %}
                    </tbody>
                </table>
                <div class="col-6 center-block text-center float-ceter">
                    {{paginacao|raw}}
                </div>

            </div>
        </div>
        {% endif %}
    </div>
</div>
{% endblock %}
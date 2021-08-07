{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<div class="container-fluid">
    <div class="col-12">
        <h1 id="titleBy" data-id="{{caixaDados.id}}">Dia ({{ caixaDados.data_inicio|date('m-d') }})</h1>
        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item">
                    <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{BASE}}{{empresa.link_site}}/admin/caixa">Relatórios</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Dia ({{ caixaDados.data_inicio|date('m-d') }})
                </li>
            </ol>
        </nav>
        <div class="separator mb-5"></div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4 progress-banner">
                <div class="card-body justify-content-between d-flex flex-row align-items-center">
                    <div>
                        <i class="iconsminds-money-bag mr-2 text-white align-text-bottom d-inline-block"></i>
                        <div>

                            <p class="text-small text-white">Total Pedidos </p>
                            <p class="text-small text-white">{{caixaDados.data_inicio|date('d/m/Y')}}</p>

                        </div>
                    </div>

                    <div>
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative"
                            data-color="white" data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{totalPedidos}}"
                            aria-valuemax="12" data-show-percent="false">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4 progress-banner">
                <div class="card-body justify-content-between d-flex flex-row align-items-center">
                    <div>
                        <i class="simple-icon-clock mr-2 text-white align-text-bottom d-inline-block"></i>
                        <div>
                            <p class="text-small text-white">Total Entregas efetuadas</p>
                        </div>
                    </div>
                    <div>
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative"
                            data-color="white" data-trail-color="rgba(255,255,255,0.2)"
                            aria-valuenow="{{totalEntregas + totalRecusado}}" aria-valuemax="6" data-show-percent="false">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4 progress-banner">
                <div class="card-body justify-content-between d-flex flex-row align-items-center">
                    <div>
                        <i class="iconsminds-bell mr-2 text-white align-text-bottom d-inline-block"></i>
                        <div>
                            <p class="text-small text-white">Total Cancelados e ou Recusados</p>
                        </div>
                    </div>
                    <div>
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative"
                            data-color="white" data-trail-color="rgba(255,255,255,0.2)"
                            aria-valuenow="{{totalCancelados + totalRecusado}}" aria-valuemax="10" data-show-percent="false">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 data-tables-hide-filter">
            <div class="card">
                <div class="card-body">
                    <table id="customers" class="data-table">
                        <thead class="linhaTop">
                            <tr>
                                <th>Numero Pedido</th>
                                <th style="width: 150px !important;">Frete</th>
                                <th style="width: 150px !important;">Pagamento</th>
                                <th style="width: 150px !important;">Status</th>
                                <th style="width: 100px !important;">Valor Pago</th>
                                <th style="width: 100px !important;">Custo com Entrega</th>
                                <th style="width: 100px !important;">Ganho total</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for ped in pedidos %}
                                {% for stats in status %}
                                        {% if ped.status == stats.id %}
                                            <tr class="formStatus{{ stats.id }}">
                                        {% endif %}
                                {% endfor %}

                                <td>
                                    <p class="text-muted">{{ ped.numero_pedido }}</p>
                                </td>
                                <td>
                                    <p class="text-muted">
                                        {% for tipoDel in tipoDelivery %}
                                        {% if ped.tipo_frete == tipoDel.code %}
                                        {{ tipoDel.tipo }}
                                        {% endif %}
                                        {% endfor %}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-muted">
                                        {% for tipoPag in tipoPagamento %}
                                        {% if ped.tipo_pagamento == tipoPag.code %}
                                        {{ tipoPag.tipo }}
                                        {% endif %}
                                        {% endfor %}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-muted">
                                    {% for stats in status %}
                                        {% if ped.status == stats.id %}
                                            {% if ped.tipo_frete == 2 %}
                                                {{ stats.delivery }}
                                            {% else %}
                                                {{ stats.retirada }}
                                            {% endif %}
                                        {% endif %}
                                    {% endfor %}</p>
                                </td>
                                <td class="text-right">
                                    <p class="text-muted">
                                    {{moeda.simbolo}} {{ ped.total_pago|number_format(2, ',', '.')}}</p>
                                </td>

                                <td class="text-right">
                                    {% if ped.tipo_frete == 2 %}
                                    <p class="text-danger">{{moeda.simbolo}} {{ (ped.valor_frete - delivery.taxa_entrega_motoboy)|number_format(2, ',',
                                        '.') }}</p>
                                    {% else %}
                                        ----
                                    {% endif %}
                                </td>

                                <td class="text-right">
                                    <p class="text-success">
                                        {% if ped.status == 5 %}
                                            {% if ped.tipo_frete == 2 %}
                                            <strong>- {{moeda.simbolo}} {{ (ped.valor_frete - delivery.taxa_entrega_motoboy)|number_format(2, ',',
                                            '.') }}</strong>
                                            {% else %}
                                            ----
                                            {% endif %}

                                        {% else %}
                                            {% if ped.tipo_frete == 2 %}
                                            <strong>{{moeda.simbolo}} {{ (ped.total_pago - ped.valor_frete)|number_format(2, ',',
                                            '.') }}</strong>
                                            {% else %}
                                            <strong>{{moeda.simbolo}} {{ ped.total_pago|number_format(2, ',', '.') }}</strong>
                                            {% endif %}
                                        {% endif %}

                                    </p>
                                </td>

                            </tr>
                            {% endfor %}
                        </tbody>
                         <tfoot class="linhaTop linhaFooter">
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th class="text-right" style="width: 100px !important;">{{moeda.simbolo}} {{vendas.total|number_format(2, ',', '.')}}</th>
                                <th class="text-right text-danger" style="width: 100px !important;">- {{moeda.simbolo}} {{entregas.total|number_format(2, ',', '.')}}</th>
                                <th class="text-right text-success" style="width: 100px !important;">{{moeda.simbolo}} {{(totalFinal.total - entregas.total)|number_format(2, ',', '.')}}</th>

                                
                            </tr>
                        </tfoot>
                    </table>
                    <div class="col-12 center-block text-center float-ceter">
                        {{paginacao|raw}}
                    </div>

                </div>
            </div>
        </div>
    </div>


   


</div>
{% endblock %}
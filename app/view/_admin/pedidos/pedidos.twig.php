{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Pedidos Finalizados</h1>
<div class="separator mb-5"></div>
<div class="row mb-4"> 
<div class="col-12 data-tables-hide-filter">
<div class="mb-3 osahan-cart-item osahan-home-page">
                    <div class="card">
                        <div class="card-body">
                        <table class="data-table data-table-simple responsive" >
                                <thead class="linhaTop">
                                    <tr>
                                        <th style="width: 120px;">Número Pedido</th>
                                        <th style="width: 120px;">Data e Hora</th>
                                        <th style="width: 100px !important;">Pagamento</th>
                                        <th style="width: 100px !important;">Valor</th>
                                        <th style="width: 100px !important;">Status</th>
                                        <th style="width: 90px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                {% for p in pedidos %}
                                {% for stats in status %}
                                        {% if p.status == stats.id %}
                                            <tr class="formStatus{{ stats.id }} ">
                                        {% endif %}
                                {% endfor %}
                                        <td>
                                        <p>#{{p.numero_pedido}}</p>
                                        </td>
                                        <td>
                                        <p> {{p.data_pedido|date('d/m/Y')}} {{p.hora|date('H:i')}}</p>
                                        </td>
                                        
                                        <td>
                                        <p> {% for tipoPag in tipoPagamento %}
                                        {% if p.tipo_pagamento == tipoPag.code %}
                                        {{ tipoPag.tipo }}
                                        {% endif %}
                                        {% endfor %}</p>
                                        </td>
                                        <td>
                                            <p class="text-right">
                                            {{ moeda.simbolo }} {{ p.total_pago|number_format(2, ',', '.') }}</p>
                                        </td>
                                        <td>
                                            <p class="text-center">
                                            {% for stats in status %}
                                        {% if p.status == stats.id %}
                                            {% if p.tipo_frete == 2 %}
                                                {{ stats.delivery }}
                                            {% else %}
                                                {{ stats.retirada }}
                                            {% endif %}
                                        {% endif %}
                                    {% endfor %}
                                            </p>
                                        </td>
                                        <td>
                                        <a data-toggle="modal" data-target="#modPedido" onclick="produtosModal({{p.id}}, {{p.numero_pedido}} )" class="btn btn-outline-success mb-1" ata-toggle="modal" data-target="#rightModal">Ver Mais</a>
                                        </td>
                                    </tr>
                                {% endfor %}
                                </tbody>
                            </table>  
                        </div>
                    </div>
            </div>
     </div>

     <div class="modal fade" id="modPedido" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="mostrarPedido" class="modal-content">       
				               
            </div>
        </div>
    </div>
{% endblock %}
{% extends 'partials/bodySupAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}

{% set dinheiro = 0 %}
{% set debito = 0 %}
{% set credito = 0 %}
{% set qrCode = 0 %}
{% set vr = 0 %}
{% set va = 0 %}
{% set total = 0 %}

{% set domingoValor = 0 %}
{% set segundaValor = 0 %}
{% set tercaValor = 0 %}
{% set quartaValor = 0 %}
{% set quintaValor = 0 %}
{% set sextaValor = 0 %}
{% set sabadoValor = 0 %}
{% set domingoValorC = 0 %}
{% set segundaValorC = 0 %}
{% set tercaValorC = 0 %}
{% set quartaValorC = 0 %}
{% set quintaValorC = 0 %}
{% set sextaValorC = 0 %}
{% set sabadoValorC = 0 %}

{% for ped in pedidosAll %}

{% if ped.tipo_pagamento == 1 %}
{% set dinheiro = dinheiro + 1 %}
{% endif %}

{% if ped.tipo_pagamento == 2 %}
{% set debito = debito + 1 %}
{% endif %}

{% if ped.tipo_pagamento == 3 %}
{% set credito = credito + 1 %}
{% endif %}

{% if ped.tipo_pagamento == 4 %}
{% set qrCode = qrCode + 1 %}
{% endif %}

{% if ped.tipo_pagamento == 5 %}
{% set vr = vr + 1 %}
{% endif %}

{% if ped.tipo_pagamento == 6 %}
{% set va = va + 1 %}
{% endif %}

{% if ped.data_pedido >= domingo %}
{% if ped.data_pedido <= sabado %}
{% if ped.data_pedido == domingo %}
{{ped.total_pago}}
{% set domingoValor = domingoValor + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == segunda %}
{% set segundaValor = segundaValor + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == terca %}
{% set tercaValor = tercaValor + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == quarta %}
{% set quartaValor = quartaValor + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == quinta %}
{% set quintaValor = quintaValor + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == sexta %}
{% set sextaValor = sextaValor + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == sabado %}
{% set sabadoValor = sabadoValor + ped.total_pago %}
{% endif %}
{% if ped.status == 6 %}
{% if ped.data_pedido == domingo %}
{{ped.total_pago}}
{% set domingoValorC = domingoValorC + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == segunda %}
{% set segundaValorC = segundaValorC + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == terca %}
{% set tercaValorC = tercaValorC + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == quarta %}
{% set quartaValorC = quartaValorC + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == quinta %}
{% set quintaValorC = quintaValorC + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == sexta %}
{% set sextaValorC = sextaValorC + ped.total_pago %}
{% endif %}
{% if ped.data_pedido == sabado %}
{% set sabadoValorC = sabadoValorC + ped.total_pago %}
{% endif %}
{% endif %}
{% endif %}
{% endif %}
{% endfor %}

<div class="container-fluid">
    <div class="col-12">
        <h1>Dashboard</h1>
        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item active" aria-current="page">tempo real</li>
            </ol>
        </nav>
        <div class="separator mb-5"></div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4 progress-banner">
                <a href="#" class="card-body justify-content-between d-flex flex-row align-items-center">
                    <div>
                        <i class="iconsminds-money-bag mr-2 text-white align-text-bottom d-inline-block"></i>
                        <div>
                            <p class="text-small text-white">Empresas Cadastradas</p>
                        </div>
                    </div>
                    <div>
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative" data-color="white" data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{empresasCont}}" aria-valuemax="12" data-show-percent="false">
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4 progress-banner">
                <a href="#" class="card-body justify-content-between d-flex flex-row align-items-center">
                    <div>
                        <i class="simple-icon-clock mr-2 text-white align-text-bottom d-inline-block"></i>
                        <div>
                            <p class="text-small text-white">Total Pedidos</p>
                        </div>
                    </div>
                    <div>
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative" data-color="white" data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="0" aria-valuemax="6" data-show-percent="false">
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4 progress-banner">
                <a href="#" class="card-body justify-content-between d-flex flex-row align-items-center">
                    <div>
                        <i class="iconsminds-bell mr-2 text-white align-text-bottom d-inline-block"></i>
                        <div>
                            <p class="text-small text-white">Total Entregas</p>
                        </div>
                    </div>
                    <div>
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative" data-color="white" data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="0" aria-valuemax="10" data-show-percent="false">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    {# <div class="row">
        <div class="col-lg-12 col-xl-6">
            <div class="icon-cards-row">
                <div class="glide dashboard-numbers">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <li class="glide__slide">
                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsminds-clock"></i>
                                        <p class="card-text mb-0">Produto Esgotado</p>
                                        <p class="lead text-center">{{produtosEsgotado}}</p>
                                    </div>
                                </a>
                            </li>
                            <li class="glide__slide">
                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsminds-basket-coins"></i>
                                        <p class="card-text mb-0">Produto Ativos</p>
                                        <p class="lead text-center">{{produtosAtivos}}</p>
                                    </div>
                                </a>
                            </li>
                            <li class="glide__slide">
                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsminds-arrow-refresh"></i>
                                        <p class="card-text mb-0">Categorias</p>
                                        <p class="lead text-center">{{categorias}}</p>
                                    </div>
                                </a>
                            </li>
                            <li class="glide__slide">
                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="simple-icon-plane"></i>
                                        <p class="card-text mb-0">Motoboys</p>
                                        <p class="lead text-center">{{motoboys}}</p>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="icon-cards-row">
                <div class="glide dashboard-numbers">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <li class="glide__slide">
                                <a href="#" class="card">
                                    <div class="card-body text-center">
                                        <i class="iconsminds-male"></i>
                                        <p class="card-text mb-0">Usuários cadastrados</p>
                                        <p class="lead text-center">{{usuarios}}</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Produtos mais Vendidos</h5>
                    <table class="data-table data-table-simple responsive nowrap" data-order="[[ 1, &quot;desc&quot; ]]">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Vendas</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for p in maisVendidos %}
                            <tr>
                                <td>
                                    <p class="text-muted">{{p.nome}}</p>
                                </td>
                                <td>
                                    <p class="text-muted">{{p.vendas}}</p>
                                </td>
                            </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> #}




    <div class="row">
        <!-- <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card dashboard-filled-line-chart">
                        <div class="card-body ">
                            <div class="float-left float-none-xs">
                                <div class="d-inline-block">
                                    <h5 class="d-inline">Website Visits</h5>
                                    <span class="text-muted text-small d-block">Unique Visitors</span>
                                </div>
                            </div>
                            <div class="btn-group float-right float-none-xs mt-2">
                                
<button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    This Week
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Last Week</a>
                                    <a class="dropdown-item" href="#">This Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="chart card-body pt-0">
                            <canvas id="visitChart"></canvas>
                        </div>
                    </div>
                </div> -->

        <!-- <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card dashboard-filled-line-chart">
                        <div class="card-body ">
                            <div class="float-left float-none-xs">
                                <div class="d-inline-block">
                                    <h5 class="d-inline">Pages Viewed</h5>
                                    <span class="text-muted text-small d-block">Per Session</span>
                                </div>
                            </div>
                            <div class="btn-group float-right mt-2 float-none-xs">
                                
<button class="btn btn-outline-secondary btn-xs dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    This Week
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Last Week</a>
                                    <a class="dropdown-item" href="#">This Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="chart card-body pt-0">
                            <canvas id="conversionChart" ></canvas>
                        </div>
                    </div>
                </div> -->
    </div>
</div>
{% endblock %}
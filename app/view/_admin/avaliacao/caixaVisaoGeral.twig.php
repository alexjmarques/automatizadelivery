{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}

{% set total = 0 %}
{% set totalEntregas = 0 %}
{% set totalCancelados = 0 %}

    {% set loopOutput %} 

    {% for ped in pedidosAll %}

        
        {% set total = total + 1 %}

        {% if ped[':tipo_frete'] == 2 %}
            {% set totalEntregas = totalEntregas + 1 %}
        {% endif %}

        {% if ped[':status'] == 6 %}
            {% set totalCancelados = totalCancelados + 1 %}
        {% endif %}
    
    
    {% endfor %}
    {% endset %}
<div class="container-fluid">
<div class="col-12">
<h1>Visão Geral</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Visão Geral</li>
    </ol>
</nav>
        <div class="separator mb-5"></div>

</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4 progress-banner">
            <a href="{{BASE}}{{empresa.link_site}}/admin/pedidos" class="card-body justify-content-between d-flex flex-row align-items-center">
                <div>
                    <i class="iconsminds-money-bag mr-2 text-white align-text-bottom d-inline-block"></i>
                    <div>
                        
                        <p class="text-small text-white">Pedidos até hoje </p>
                        <p class="text-small text-white">{{caixaDados[':data_inicio']|date('d/m/Y')}}</p>
                        
                    </div>
                </div>

                <div>
                    <div role="progressbar"
                        class="progress-bar-circle progress-bar-banner position-relative" data-color="white"
                        data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{total}}" aria-valuemax="12"
                        data-show-percent="false">
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4 progress-banner">
            <a href="{{BASE}}{{empresa.link_site}}/admin/entregas" class="card-body justify-content-between d-flex flex-row align-items-center">
                <div>
                    <i class="simple-icon-clock mr-2 text-white align-text-bottom d-inline-block"></i>
                    <div>
                        <p class="text-small text-white">Total Entregas</p>
                    </div>
                </div>
                <div>
                    <div role="progressbar"
                        class="progress-bar-circle progress-bar-banner position-relative" data-color="white"
                        data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{totalEntregas}}" aria-valuemax="6"
                        data-show-percent="false">
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4 progress-banner">
            <a href="{{BASE}}{{empresa.link_site}}/admin/pedidos-cancelados" class="card-body justify-content-between d-flex flex-row align-items-center">
                <div>
                    <i class="iconsminds-bell mr-2 text-white align-text-bottom d-inline-block"></i>
                    <div>
                        <p class="text-small text-white">Total Cancelados</p>
                    </div>
                </div>
                <div>
                    <div role="progressbar"
                        class="progress-bar-circle progress-bar-banner position-relative" data-color="white"
                        data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{totalCancelados}}" aria-valuemax="10"
                        data-show-percent="false">
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-3 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label">Vendas Concluídas</p>
                                    <p class="leadPrice color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{vendas['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-3 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label text-small">Total em Entregas</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{entregas['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-3 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label text-small">Vendas Canceladas</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{vendasCanceladas['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-3 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label text-small">Vendas Recusadas</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{vendasRecusadas['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>


                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-2 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label">Dinheiro</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{dinheiro['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-2 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label">Débito</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{debito['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-2 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label">Crédito</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{credito['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-2 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label">Vale Refeição</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{vr['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-2 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label">Vale Alimentação</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{va['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-2 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="mb-0 label">QrCode</p>
                                    <p class="leadSub color-theme-1 mb-1 value">{{moeda[':simbolo']}} {{qrCode['total']|number_format(2, ',', '.')}}</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>


            </div>


        </div>
{% endblock %}
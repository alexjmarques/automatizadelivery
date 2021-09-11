{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}

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
    {% if totalPedidos == 0 %}
    <div class="row">
        <div class="form-side col-lg-12">
            <div class="text-center pt-4">

                <p class="display-1 font-weight-bold mt-5">
                    <span class="iconsminds-digital-drawing iconeMenu"></span>
                </p>
                <p class="mb-0 text-muted text-small mb-2">Inicie seu atendimento e venda mais</p>
                <h6 class="mb-4">Você não possui dados o suficiente para gerar relatório!</h6>
                <a href="{{BASE}}{{empresa.link_site}}/admin" class="btn btn-primary btn-lg btn-shadow">Venda mais</a>
            </div>
        </div>
    </div>
    {% else %}
    <div class="row">

        <div class="col-lg-4">
            <div class="card mb-4 progress-banner">
                <div class="card-body justify-content-between d-flex flex-row align-items-center">
                    <div>
                        <i class="iconsminds-money-bag mr-2 text-white align-text-bottom d-inline-block"></i>
                        <div>
                            <p class="text-small text-white">Pedidos até hoje </p>
                            <p class="text-small text-white">{{caixaDados.data_inicio|date('d/m/Y')}}</p>

                        </div>
                    </div>

                    <div>
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative" data-color="white" data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{totalPedidos}}" aria-valuemax="12" data-show-percent="false">
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
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative" data-color="white" data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{totalEntregas + totalRecusado}}" aria-valuemax="6" data-show-percent="false">
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
                        <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative" data-color="white" data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{totalCancelados + totalRecusado}}" aria-valuemax="10" data-show-percent="false">
                        </div>
                    </div>
                </div>
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
                            <p class="leadPrice color-theme-1 mb-1 value">{{moeda.simbolo}} {{vendas.total|number_format(2, ',', '.')}}</p>
                        </div>
                    </div>
                </div>

                <div class="col-3 mb-4">
                    <div class="card dashboard-small-chart-analytics">
                        <div class="card-body">
                            <p class="mb-0 label text-small">Total em Entregas</p>
                            <p class="leadSub color-theme-1 mb-1 value">{{moeda.simbolo}} {{entregas.total|number_format(2, ',', '.')}}</p>
                        </div>
                    </div>
                </div>

                <div class="col-3 mb-4">
                    <div class="card dashboard-small-chart-analytics">
                        <div class="card-body">
                            <p class="mb-0 label text-small">Vendas Canceladas</p>
                            <p class="leadSub color-theme-1 mb-1 value">{{moeda.simbolo}} {{vendasCanceladas.total|number_format(2, ',', '.')}}</p>
                        </div>
                    </div>
                </div>

                <div class="col-3 mb-4">
                    <div class="card dashboard-small-chart-analytics">
                        <div class="card-body">
                            <p class="mb-0 label text-small">Vendas Recusadas</p>
                            <p class="leadSub color-theme-1 mb-1 value">{{moeda.simbolo}} {{vendasRecusadas.total|number_format(2, ',', '.')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endif %}


{% endblock %}
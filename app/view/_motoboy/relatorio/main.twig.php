{% extends 'partials/body.twig.php'  %}

{% block title %}Dashboard - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}

<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Dashboard</h5>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page">

    <div class="bg-white rounded shadow mt-n5">
        <div class="border-bottom p-3">
            <div class="left mr-0 p-0">
                <h5 class="d-inline">Ganhos de hoje</h5>
                <span class="text-muted text-small d-block">Você fez {{ entregasDia }} entregas hoje</span>
            </div>
            <div class="pt-3 pb-3 text-center">
                <h5 class="d-inline valorFullSize">{{ moeda.simbolo }} {{ entregasFeitasDia|number_format(2, ',', '.') }}</h5>
                
            </div>
        </div>
    </div>

    <!-- <div class="mt-3 clearfix">
        
        <div class="metade pr-2">
            <div class="bg-white rounded shadows ml1">
                <div class="border-bottom p-3">
                    <div class="left mr-0 p-0">
                        <h6 class="d-inline">Entregas do dia</h6>
                    </div>
                    <div class="pt-1 pb-1 text-center">
                        <h5 class="d-inline valorFullSizeMini"> {{ entregasDia }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="metade pl-2">
            <div class="bg-white rounded shadows">
                <div class="border-bottom p-3">
                    <div class="left mr-0 p-0">
                        <h6 class="d-inline">Ganhos do Dia</h6>
                    </div>
                    <div class="pt-1 pb-1 text-center">
                        <h5 class="d-inline valorFullSizeMini">{{ moeda.simbolo }} {{ entregasFeitasDia|number_format(2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="bg-white rounded shadow mt-3">
        <div class=" dashboard-filled-line-chart">
        <div class="card-body motoFull">
                <div class="float-left float-none-xs">
                    <div class="d-inline-block">
                        <h5 class="d-inline">Entregas Feitas</h5>
                        <span class="text-muted text-small d-block">Entregas por mês</span>
                    </div>
                </div>
                <div class="btn-group float-right float-none-xs mt-0">
                    <select id="mes" name="mes" class="form-control selectMes">
                        <option value="" selected>Selecione</option>
                            <option value="01">Janeiro</option>
                            <option value="02">Fevereiro</option>
                            <option value="03">Março</option>
                            <option value="04">Abril</option>
                            <option value="05">Maio</option>
                            <option value="06">Junho</option>
                            <option value="07">Julho</option>
                            <option value="08">Agosto</option>
                            <option value="09">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                    </select>
                </div>
            </div>
            <div class="chart card-body pt-3">
                <div id="dadosMes"></div>
                <div class="carregar"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    </div>
</div>
{% include 'partials/footerMotoboy.twig.php' %}
{% endblock %}
{% extends 'partials/body.twig.php'  %}

{% block title %}Dashboard - {{empresa[':nomeFantasia']}}{% endblock %}

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
                <h5 class="d-inline">Ganhos até agora</h5>
                <span class="text-muted text-small d-block">Ganhos deste Mês com entregas</span>
            </div>
            <div class="pt-3 pb-3 text-center">
                <h5 class="d-inline valorFullSize">{{ moeda[':simbolo }} {{ entregasFeitas|number_format(2, ',', '.') }}</h5>
            </div>
        </div>
    </div>

    <div class="mt-3 clearfix">
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
                        <h5 class="d-inline valorFullSizeMini">{{ moeda[':simbolo }} {{ entregasFeitasDia|number_format(2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <option value="">Selecione</option>
                            <option value="01" {% if mesAtual == 01 %}selected{% endif %}>Janeiro</option>
                            <option value="02" {% if mesAtual == 02 %}selected{% endif %}>Fevereiro</option>
                            <option value="03" {% if mesAtual == 03 %}selected{% endif %}>Março</option>
                            <option value="04" {% if mesAtual == 04 %}selected{% endif %}>Abril</option>
                            <option value="05" {% if mesAtual == 05 %}selected{% endif %}>Maio</option>
                            <option value="06" {% if mesAtual == 06 %}selected{% endif %}>Junho</option>
                            <option value="07" {% if mesAtual == 07 %}selected{% endif %}>Julho</option>
                            <option value="08" {% if mesAtual == 08 %}selected{% endif %}>Agosto</option>
                            <option value="09" {% if mesAtual == 09 %}selected{% endif %}>Setembro</option>
                            <option value="10" {% if mesAtual == 10 %}selected{% endif %}>Outubro</option>
                            <option value="11" {% if mesAtual == 11 %}selected{% endif %}>Novembro</option>
                            <option value="12" {% if mesAtual == 12 %}selected{% endif %}>Dezembro</option>
                    </select>
                </div>
            </div>
            <div class="chart card-body pt-3">
                <div id="dadosMes"></div>
                <div class="carregar"></div>
            </div>
        </div>
    </div>

    </div>
</div>
{% include 'partials/footerMotoboy.twig.php' %}
{% endblock %}
{% extends 'partials/body.twig.php'  %}

{% block title %}Dashboard - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}

<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Dashboard</h5>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page">

   <!-- {# <div class="bg-white rounded shadow mt-n5">
        <div class="border-bottom p-3">
            <div class="left mr-0 p-0">
                <h5 class="d-inline">Ganhos de hoje</h5>
                <span class="text-muted text-small d-block">Você fez {{ entregasDia }} entregas hoje</span>
            </div>
            <div class="pt-3 pb-3 text-center">
                <h5 class="d-inline valorFullSize">{{ moeda.simbolo }} {{ entregasFeitasDia|number_format(2, ',', '.') }}</h5>
                
            </div>
        </div>
    </div> #}

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
                        <h5 class="d-inline valorFullSizeMini">{{ moeda.simbolo }} {{ entregasFeitasDia|number_format(2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="bg-white rounded shadow mt-3 mt-n5">
        <div class=" dashboard-filled-line-chart">
        <div class="card-body motoFull">
                <div class="float-left float-none-xs">
                    <div class="d-inline-block">
                        <h5 class="d-inline">Entregas Feitas</h5>
                        <span class="text-muted text-small d-block pb-2">Entregas do dia</span>
                    </div>
                </div>

                <table class="table table-striped mt-3">
    <thead>
        <tr>
            <th scope="col">Data</th>
            <th scope="col">nº Pedido</th>
            <th scope="col">KM</th>
        </tr>
    </thead>
    <tbody>
    {% for en in entregas %}
            <tr>
                <td>
                {{en.data_pedido|date('h:m')}}
                </td>
                <td>
                    {{en.numero_pedido}}
                </td>
                <td>
                {{en.km}}
                </td>
            </tr>
        {% endfor %}
    </tbody>
</table>
                
            </div>
            

           
            <div class="clearfix"></div>

        </div>
    </div>

    </div>
</div>
{% include 'partials/footerMotoboy.twig.php' %}
{% endblock %}
{% extends 'partials/body.twig.php'  %}

{% block title %}Diaria e Veículo - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Diaria e Veículo</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/motoboy/perfil"> Voltar</a>
    </div>
    <div class="p-3 osahan-cart-item osahan-home-page">

        
    <div class="bg-white rounded shadow mt-n5">
        <div class="d-flex  border-bottom p-3">
            <div class="left mr-3">
            <svg version="1.1" class="svg" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 460.8 460.8" style="enable-background:new 0 0 460.8 460.8;" xml:space="preserve"><g><g><path d="M230.432,0c-65.829,0-119.641,53.812-119.641,119.641s53.812,119.641,119.641,119.641s119.641-53.812,119.641-119.641S296.261,0,230.432,0z"/></g></g><g><g><path d="M435.755,334.89c-3.135-7.837-7.314-15.151-12.016-21.943c-24.033-35.527-61.126-59.037-102.922-64.784c-5.224-0.522-10.971,0.522-15.151,3.657c-21.943,16.196-48.065,24.555-75.233,24.555s-53.29-8.359-75.233-24.555c-4.18-3.135-9.927-4.702-15.151-3.657c-41.796,5.747-79.412,29.257-102.922,64.784c-4.702,6.792-8.882,14.629-12.016,21.943c-1.567,3.135-1.045,6.792,0.522,9.927c4.18,7.314,9.404,14.629,14.106,20.898c7.314,9.927,15.151,18.808,24.033,27.167c7.314,7.314,15.673,14.106,24.033,20.898c41.273,30.825,90.906,47.02,142.106,47.02s100.833-16.196,142.106-47.02c8.359-6.269,16.718-13.584,24.033-20.898c8.359-8.359,16.718-17.241,24.033-27.167c5.224-6.792,9.927-13.584,14.106-20.898C436.8,341.682,437.322,338.024,435.755,334.89z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
            </div>
            <div class="col-md-8">
            <h6 class="mb-1 font-weight-bold">{{usuarioAtivo.nome}}</h6>
            <p class="text-muted m-0 small __cf_email__">Telefone: {{usuarioAtivo.telefone}}</p>
            </div>
        </div>
    </div>

<div class="bg-white rounded shadow mt-3 profile-details">
<div class="osahan-credits  p-3">
                    <div class="custom-control mb-2 px-0">
                        <div class="border p-3 w-100 rounded bg-light status5">
                            <b> Diaria:</b> {{ moeda.simbolo }} {{ motoboy.diaria|number_format(2, ',', '.') }}<br>
                            <b> Taxa por KM:</b> {{ moeda.simbolo }} {{ motoboy.taxa|number_format(2, ',', '.') }}<br>
                            <b> Placa do veículo:</b> {{motoboy.placa}}<br>
                        </div>
                    </div>

                    
                </div>

</div>
</div>

<div class="accordion px-3 pb-3" id="accordionExample">
    <div class="osahan-card bg-white overflow-hidden shadow rounded mb-2">
        <div class="osahan-card-header" id="headingOne">    
            <h2 class="mb-0">
            <button class="d-flex p-3  btn btn-link w-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
             Atualizar Placa do veículo
            <i class="feather-chevron-down ml-auto"></i>
            </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
            <div class="osahan-card-body border-top p-3">
            <form method="post" action="{{BASE}}{{empresa.link_site}}/motoboy/placa/editar" id="form" enctype="multipart/form-data">
                    <div class="custom-control mb-2 px-0">
                        <p class="mt-3 mb-2"><strong class="mediumNome">Atualizar Placa do veículo</strong></p>
                        <div class="mt-0 input-group full-width">
                        <input type="text" class="form-control" id="placa" name="placa" placeholder="Placa" value="{{motoboy.placa}}" required>
                        </div>
                        
                        <input type="hidden" value="{{ motoboy.id }}" name="id" id="id">
                        <input type="hidden" value="{{ motoboy.diaria }}" name="diaria" id="diaria">
                        <input type="hidden" value="{{ motoboy.taxa }}" name="taxa" id="taxa">
                        <input type="hidden" value="{{ motoboy.id_usuario }}" name="id_usuario" id="id_usuario">
                        <button id="fullBtnNac" class="btn btn-primary mb-2 mt-3 full-btn"> Atualizar Placa</button>
                    </div>

                    
                    </form>
            </div>
        </div>
    </div>
</div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footerMotoboy.twig.php' %}
{% endblock %}
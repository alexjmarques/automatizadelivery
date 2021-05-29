{% extends 'partials/body.twig.php'  %}

{% block title %}Favoritos - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Favoritos</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>

    {% for f in favoritos %}
    {% for p in produto %}
    {% if(p[':id'] == f[':id_produto'] ) %}
    <div class="p-3 osahan-cart-item osahan-home-page mb-3">
    <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
        <img alt="osahan" src="/uploads/{{ p.imagem }}" class="mr-2 rounded-circle img-fluid">
        <div class="d-flex flex-column">
            <h6 class="mb-1 font-weight-bold">{{ p.nome }}</h6>
            <p class="mb-0">{{ p.descricao }}</p>
        </div>

        <div class="right col-md-3 p-0">
           <a href="{{BASE}}{{empresa.link_site}}/favorito/d/{{f[':id']}}" class="btnEnderecos btnDeletarFloatMod">Remover <i class="feather-delete text-danger"></i></a>
        </div>
    </div>
    </div>
    {% endif %}
    {% endfor %}
    {% endfor %}

    {% if favoritos is null %}
    <div class="osahan-coming-soon p-4 d-flex justify-content-center">
        <div class="osahan-img">
        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:#807b7b;}</style></defs><title/><g data-name="Layer 54" id="Layer_54"><path class="cls-1" d="M16,28.72a3,3,0,0,1-2.13-.88L3.57,17.54a8.72,8.72,0,0,1-2.52-6.25,8.06,8.06,0,0,1,8.14-8A8.06,8.06,0,0,1,15,5.68l1,1,.82-.82h0a8.39,8.39,0,0,1,11-.89,8.25,8.25,0,0,1,.81,12.36L18.13,27.84A3,3,0,0,1,16,28.72ZM9.15,5.28A6.12,6.12,0,0,0,4.89,7a6,6,0,0,0-1.84,4.33A6.72,6.72,0,0,0,5,16.13l10.3,10.3a1,1,0,0,0,1.42,0L27.23,15.91A6.25,6.25,0,0,0,29,11.11a6.18,6.18,0,0,0-2.43-4.55,6.37,6.37,0,0,0-8.37.71L16.71,8.8a1,1,0,0,1-1.42,0l-1.7-1.7a6.28,6.28,0,0,0-4.4-1.82Z"/></g></svg>
        <div class="osahan-text text-center mt-0">
                <p class="mb-5">Você não selecionou nenhum produto como favorito.</p>
                
            </div>
        </div>
    </div>
    {% endif %}

</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footer.twig.php' %}
{% endblock %}
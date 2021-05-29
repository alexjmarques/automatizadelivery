{% extends 'partials/body.twig.php'  %}

{% block title %}Termos de Uso - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Termos de Uso</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/perfil"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page mb-3">
    <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
        <div class="full_page">
        <h6 class="mb-1 font-weight-bold full_page">{{ empresa[':nomeFantasia }}</h6>
            <p class="pb-0"><strong>CNPJ:</strong> {{empresa[':cnpj']}}</p>
            
            <p class="pt-0 mt-0 mb-3"><strong>Endereço:</strong> {{empresa[':rua']}}, {{empresa[':numero']}} {{empresa[':complemento']}} - {{empresa[':bairro']}} - {{empresa[':cidade']}} | 
            {% for e in estados %}
                {% if e[':id'] == empresa[':estado'] %}
                    {{ e[':uf }}
                {% endif %}
            {% endfor %}
        </p>
        <hr>
            <p class="mb-0">{{empresa[':sobre']}}</p>
        </div>
    </div>
    </div>

</div>
{% include 'partials/footer.twig.php' %}
{% endblock %}
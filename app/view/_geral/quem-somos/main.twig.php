{% extends 'partials/body.twig.php'  %}

{% block title %}Sobre a Loja - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Sobre a Loja</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page mb-3">
    <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
        <div class="full_page">
        <h5 class="mb-1 font-weight-bold full_page">{{ empresa[':nomeFantasia }}</h5>
            
            <p class="pb-0"><strong>CNPJ:</strong> {{empresa[':cnpj']}}</p>
            <p class="pt-0 mt-0 mb-3"><strong>Endereço:</strong> {{empresa[':rua']}}, {{empresa[':numero']}} {{empresa[':complemento']}} - {{empresa[':bairro']}} - {{empresa[':cidade']}} | 
            {% for e in estados %}
                {% if e[':id'] == empresa[':estado'] %}
                    {{ e[':uf }}
                {% endif %}
            {% endfor %}
        </p>

        <p class="mb-0 mt-0 p-0">{{empresa[':sobre']}}</p>

                <div class="sc-kNPvCX iOMsuf">
                    <div class="icon-wrap">
                    <h5 class="mb-1 font-weight-bold full_page"><i class="feather-clock"></i> Horário de funcionamento</h5>
                    <p class="pb-0"><strong>{% if empresa[':diasAtendimento'] == "2,3,4,5,6" %}Terça-feira a Sábado{% endif%}{% if empresa[':diasAtendimento'] == "2,3,4,5,6,7" %}Terça-feira a Domingo{% endif%}{% if empresa[':diasAtendimento'] == "1,2,3,4,5" %}Segunda-feira a Sexta-feira{% endif%}{% if empresa[':diasAtendimento'] == "1,2,3,4,5,6" %}Segunda-feira a Sábado{% endif%}{% if empresa[':diasAtendimento'] == "1,2,3,4,5,6,7" %}Todos os dias{% endif%}
                    </strong> </p>
                    <p class="pb-0 mt-1">{{ delivery[':abertura']|date('H:i')}}h às {{ delivery[':fechamento']|date('H:i')}}h</p>
                </div>
            
                <div class="sc-kNPvCX iOMsuf mt-3">
                    <div class="icon-wrap">
                    <h5 class="mb-1 font-weight-bold full_page"><i class="feather-dollar-sign"></i>  Formas de pagamento aceitas</h5>
                    <h6 class="mb-1 mt-0 font-weight-bold full_page">Pagamento na entrega</h6>
                    <ul>
                    {% for f in formaPagamento %}
                        {% if f[':status'] == 1 %}
                        <li class="pl-2"> - {{ f[':tipo }}</li>
                         {% endif %}
                    {% endfor %}
                    </ul>
                </div>
        </div>
    </div>
    </div>

</div>
{% if delivery[':status'] == 0 %}
<div class="StatusRest">ESTAMOS FECHADOS NO MOMENTO</div>
{% endif%}
{% if sessaoLogin is not empty %}
{% if sessaoLogin != 0 %}
{% include 'partials/footer.twig.php' %}
{% endif %}
{% endif %}
{% endblock %}
{% for p in produtoTop5 %}
{% if hoje in p.dias_disponiveis %}
<div class="col-md-3 col-sm-6 mb-4">
    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
        <div class="list-card-image">
            <!-- <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
            <div class="favourite-heart text-danger position-absolute"><a href="#"><i class="icofont-heart"></i></a></div> -->
            <div class="member-plan position-absolute">
            {% if p.valor_promocional != '0.00' %}<span class="badge badge-dark">PROMOÇÃO DO DIA</span>{% endif %}</div>
            {% if p.imagem is not empty %}
           
                <img src="{{BASE}}uploads/{{p.imagem}}" class="img-fluid item-img">
   
            {% endif %}
        </div>
        <div class="p-3 position-relative">
            <div class="list-card-body">
                <h6 class="mb-1">{{p.nome}}</h6>
                <p class="text-gray mb-2">{{p.descricao}}</p>
                {% if p.valor_promocional != '0.00' %}
                <p class="text-black mb-2 dequanto"><span class="float-left por">De</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                <p class="text-black mb-2 porquanto"> <span class="float-left por">Por</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor_promocional|number_format(2, ',', '.') }}</span></p>
                {% else %}
                <p class="text-black mb-2 porquanto"> <span class="text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                {% endif %}
            </div>
        </div>
    </div>
</div>
{% endif %}
{% endfor %}
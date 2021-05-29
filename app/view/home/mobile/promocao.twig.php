{% for p in produto %}
{% if p[':valor_promocional'] != '0.00' %}
<div class="most_sale px-3 pb-3">
    <div class="row">
        <div class="col-12">
                <div class="mt-3 list-card bg-white rounded overflow-hidden position-relative shadow-sm">
                {% if p[':imagem'] is empty %}
                <div class="pt-2 pl-2 pr-2 pb-0 position-relative col-md12">
                {% else %}
                <div class="pt-2 pl-2 pr-2 pb-0 position-relative col-md6">
                    {% endif %}
                        <div class="list-card-body">
                            <h6 class="mb-1"> 
                            <a href="{{BASE}}{{empresa.link_site}}/produto/{{p[':id']}}" class="text-black">
                            {{p[':nome']}}</a></h6>
                            <p class="text-gray mb-3">{{p[':descricao']}}</p>
                        </div>
                        <div class="list-card-badge">
                        {% if p[':valor_promocional'] != '0.00' %}
                            <p class="text-black dequanto"><span class="float-left por">De</span> <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor']|number_format(2, ',', '.') }}</span></p>
                            <p class="text-black porquanto"> <span class="float-left por">Por</span> <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor_promocional']|number_format(2, ',', '.') }}</span></p>
                        {% else %}
                            <p class="text-black mb-1 porquanto"> <span class="float-left por">Por</span> <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor']|number_format(2, ',', '.') }}</span></p>
                        {% endif %}
                        </div>
                    </div>
                    {% if p[':imagem'] is not empty %}
                    <div class="list-card-image col-md4">
                        <a href="{{BASE}}{{empresa.link_site}}/produto/{{p[':id']}}" >
                        <img src="{{BASE}}uploads/{{p[':imagem']}}" class="img-fluid item-img w-100">
                        </a>
                    </div>
                    {% endif %}
                    
                    {% if p[':valor_promocional'] != '0.00' %}
                        <div class="star position-absolute right"><span class="badge badge-success"><i class="feather-star"></i> PROMOÇÃO DO DIA</span></div>
                    {% endif %}
                </div>
        </div>
    </div>
</div>
{% endif %}
{% endfor %}



<div class="p-3 title d-flex">
<h5 class="m-0 pt-3">O mais vendidos</h5>
</div>

<div class="most_sale px-3 pb-3">
    <div class="row">
    {% for p in produtoTop5 %}
        {% if hoje in p[':dias_disponiveis'] %}
        <div class="col-12 pt-2">
                <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                
                {% if p[':imagem'] is empty %}
                <div class="p-3 position-relative col-md12">
                {% else %}
                    <div class="p-3 position-relative col-md6">
                    {% endif %}
                        <div class="list-card-body ">
                            <h6 class="mb-1">
  
                            <a href="{{BASE}}{{empresa.link_site}}/produto/{{p[':id']}}" class="text-black">
                            {{p[':nome']}}</a></h6>
                            <p class="text-gray mb-2">{{p[':descricao']}}</p>
                        </div>

                        <div class="list-card-badge">
                        {% if p[':valor_promocional'] != '0.00' %}
                            <p class="text-black mb-0 dequanto"><span class="float-left por">De</span> <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor']|number_format(2, ',', '.') }}</span></p>
                            <p class="text-black mb-0 porquanto"> <span class="float-left por">Por</span> <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor_promocional']|number_format(2, ',', '.') }}</span></p>
                        {% else %}
                            <p class="text-black mb-0 porquanto">  <span class="float-left text-black-50"> {{moeda[':simbolo']}} {{ p.valor']|number_format(2, ',', '.') }}</span></p>
                        {% endif %}
                        </div>
                    </div>

                    {% if p[':imagem'] is not empty %}
                    <div class="list-card-image col-md4">
                    <a href="{{BASE}}{{empresa.link_site}}/produto/{{p[':id']}}">
                        <img src="{{BASE}}uploads/{{p[':imagem']}}" class="img-fluid item-img w-100">
                    </a>
                    </div>
                    {% endif %}
                    {% if p[':valor_promocional'] != '0.00' %}
                        <div class="star position-absolute"><span class="badge badge-success"><i class="feather-star"></i> PROMOÇÃO DO DIA</span></div>
                    {% endif %}
                </div>
        </div>
        {% endif %}
    {% endfor %}
    </div>
</div>
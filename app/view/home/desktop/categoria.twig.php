{% for c in categoria %}
{% if c.produtos >= 1 %}
<h5 class="mb-4 mt-3 col-md-12">{{ c.nome }} <small class="h6 text-black-50">({{ c.produtos }} itens)</small></h5>
<div class="col-md-12">
    <div class="bg-white rounded border shadow-sm mb-4">
        {% for p in produto %}
        {% if p.status == 1 %}
        {% if c.id == p.id_categoria %}
        {% if hoje in p.dias_disponiveis %}
        <div class="gold-members p-3 border-bottom">
            <div class="media">
                
                <div class="mr-3">{% if p.imagem is not empty %}
           
           <img src="{{BASE}}uploads/{{p.imagem}}" class="img-fluid item-img" style="max-height: 80px;">

       {% endif %}</div>
                <div class="media-body">
                    <h5 class="mb-1">{{p.nome}}</h5>
                    <p class="text-gray mb-0">{{p.descricao}}</p>
                    {% if p.valor_promocional != '0.00' %}
                    <p class="text-black mb-1 dequanto pmais"><span class="float-left por">De </span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',',
                                '.') }}</span></p>
                    <p class="text-black mb-1 porquanto pmais"> <span class="float-left por">Por </span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{
                                p.valor_promocional|number_format(2, ',', '.') }}</span></p>
                    {% else %}
                    <p class="text-black mb-1 porquanto pmais"> <span class="float-left text-black-50">
                            {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                    {% endif %}
                </div>
            </div>
        </div>
        {% endif %}
        {% endif %}
        {% endif %}
        {% endfor %}
    </div>
</div>
{% endif %}
{% endfor %}
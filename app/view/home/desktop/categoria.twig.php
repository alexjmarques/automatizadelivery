<ul class="nav nav-tabs border-0 mb-4" id="myTab" role="tablist">
    {% for c in categoria %}
    {% if c.produtos > 0 %}
    <li class="nav-item mr-2" role="presentation">
        <a class="nav-link border-0 btn btn-light" id="bt-{{ c.id }}" data-toggle="tab" href="#{{ c.slug }}"
            role="tab" aria-controls="{{ c.slug }}" aria-selected="true">{{ c.nome }}</a>
    </li>
    {% endif %}
    {% endfor %}
</ul>
<div class="tab-content" id="myTabContent">
    {% for c in categoria %}
    {% if c.produtos > 1 %}
    <div class="tab-pane fade" id="{{ c.slug }}" role="tabpanel" aria-labelledby="{{ c.slug }}-tab">
        <div class="d-flex align-items-center justify-content-between mb-3 mt-2">
            <h5 class="mb-0">{{ c.nome }}</h5>
        </div>
        <div class="row">
            {% for p in produto %}
            {% if p.status == 1 %}
            {% if c.id == p.id_categoria %}
            {% if hoje in p.dias_disponiveis %}
            <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}"  class="text-decoration-none text-dark col-xl-4 col-md-12 mb-4">
                <div class="shadow bg-white rounded">
                <div class="envImage rounded overflow-hidden">
                    <img src="{{ BASE~'uploads/'~p.imagem}}" class="img-fluid">
                </div>
                <div class="p-2 pb-0 align-items-center mt-1 mb-0">
                    <p class="text-black h6 m-0">{{p.nome}}</p>
                    <p class="text-gray mb-2">{{p.descricao}}</p>

                    <div class="price">
                        {% if p.valor_promocional != '0.00' %}
                        <p class="text-black mb-1 dequanto pmais"><span class="float-left por">De </span> <span
                                class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',',
                                '.') }}</span></p>
                        <p class="text-black mb-1 porquanto pmais"> <span class="float-left por">Por </span> <span
                                class="float-left text-black-50"> {{moeda.simbolo}} {{
                                p.valor_promocional|number_format(2, ',', '.') }}</span></p>
                        {% else %}
                        <p class="text-black mb-1 porquanto pmais"> <span class="float-left text-black-50">
                                {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                        {% endif %}
                        
                        {% if p.valor_promocional != '0.00' %}
                        <span class="badge ml-auto badge-success"><i class="mdi mdi-ticket-percent-outline"></i>
                            DESCONTO</span>
                        {% endif %}
                    </div>
                </div>

                <p class="small mb-2 pb-2 pl-2">
                    <i class="mdi mdi-star text-warning"></i>
                    <span class="font-weight-bold text-dark ml-1">4.8</span>(1,873) <i
                        class="mdi mdi-silverware-fork-knife ml-2 mr-1"></i> Burger <i
                        class="mdi mdi-motorbike ml-2 mr-2"></i>45 - 55 min
                </p>
                </div>
            </a>
            {% endif %}
            {% endif %}
            {% endif %}
            {% endfor %}
        </div>
    </div>
    {% endif %}
    {% endfor %}
</div>
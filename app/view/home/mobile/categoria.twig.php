<div id="menuCat" class="sc-dkIXFM fjHKJw">
    <ul class="row-scroll">
        {% for c in categoria %}
        {% if c.produtos > 0 %}
        <li class="col-xl-1"> <a id="bt-{{ c.id }}" class="smoothScroll" href="#{{ c.slug }}" name="{{ c.slug }}">
                <div>{{ c.nome }}</div>
            </a></li>
        {% endif %}
        {% endfor %}
    </ul>
</div>
{% set idCategoria = 0 %}
{% set idTamanhos = 0 %}
{% for c in categoria %}
{% for tc in tamanhosCategoria %}
{% if c.id == tc.id_categoria %}
{% set idCategoria = c.id %}
{% set idTamanhos = tc.id_tamanhos %}
{% endif %}
{% endfor %}
    {% if c.id == idCategoria %}
    {% if c.produtos > 0 %}
    <div class="px-3 pt-3 title d-flex bg-white">
        <h5 id="{{ c.slug }}" name="{{ c.slug }}" class="mt-1">{{ c.nome }}</h5>
</div>
    <div class="px-3 pt-3 title bg-white">
    {% for tc in tamanhosCategoria %}
    {% if c.id == tc.id_categoria %}
    {% for tam in tamanhos %}
    {% if c.id == tc.id_categoria and tam.id == tc.id_tamanhos %}

    {% for i in range(1, tam.qtd_sabores) %}
    <div class="osahan-slider-item col-6 float-left pb-2 pl-0 px-1">
        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative">
            <div class="p-1 position-relative">
                <div class="list-card-body">
                    <h6 class="mb-1">
                        <a href="{{BASE}}{{empresa.link_site}}/{{c.slug}}/produto/{{tc.id}}/{{tam.id}}/{{i}}" class="text-black text-uppercase">
                            Pizza {{tam.nome}} {% if i == 1 %}{{i}} SABOR {% else %}{{i}} SABORES {% endif %}
                            </a>
                    </h6>
                    <p class="text-gray mb-0 pb-0">Esta pizza tem {% if i == 1 %} {{tam.qtd_pedacos}} pedaço {% else %} {{tam.qtd_pedacos}} pedaços {% endif %}</p>
                </div>
            </div>
        </div>
    </div>
    {% endfor %}


    {% endif %}
    {% endfor %}
    {% endif %}
    {% endfor %}
  
    <div class="clearfix"></div>
    </div>
    {% endif %}

    {% else %}

    {% if c.produtos > 1 %}
    <div class="px-3 pt-3 title d-flex bg-white">
        <h5 id="{{ c.slug }}" name="{{ c.slug }}" class="mt-1">{{ c.nome }}</h5>
        <!-- <a class="font-weight-bold ml-auto" href="trending.html">Ver todos <i class="feather-chevrons-right"></i></a> -->
    </div>

        <div class="trending-slider bg-white linha">
        {% for p in produto %}
        {% if c.id == p.id_categoria %}
        {% if hoje in p.dias_disponiveis %}
        {% if veriFavoritos == 0 %}
        <div class="osahan-slider-item py-3 px-1">
            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative">
                <div class="list-card-image">
                    {% if p.valor_promocional != '0.00' %}
                    <div class="star position-absolute"><span class="badge badge-success"><i class="feather-star"></i> DESCONTO</span></div>
                    {% endif %}

                    {% if p.status == 0 %}
                    <div class="star position-absolute"><span class="badge badge-secondary">ESGOTADO</span></div>
                    {% endif %}
                    <div class="favourite-heart text-danger position-absolute">
                        <a href="#" class="addFavorito" data-favorito="{{p.id}}"><i id="itFavorito{{p.id}}" class="fa fa-heart-o"></i></a>
                    </div>
                    {% if p.imagem is not empty %}
                    <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}">

                        <img src="{{BASE}}uploads/{{ p.imagem }}" class="img-fluid item-img w-100">

                    </a>
                    {% endif %}
                </div>
                <div class="p-2 position-relative">
                    <div class="list-card-body">
                        <h6 class="mb-1">
                            <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}" class="text-black">
                                {{p.nome}}</a>
                        </h6>
                        <p class="text-gray mb-3">{{p.descricao}}</p>

                        {% if p.valor_promocional != '0.00' %}
                        <p class="text-black mb-1 dequanto pmais"><span class="float-left por">De</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                        <p class="text-black mb-1 porquanto pmais"> <span class="float-left por">Por</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor_promocional|number_format(2, ',', '.') }}</span></p>
                        {% else %}
                        <p class="text-black mb-1 porquanto pmais"> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                        {% endif %}
                    </div>
                </div>
            </div>
        </div>
        {% else %}
        {% for fav in favoritos %}
        <div class="osahan-slider-item py-3 px-1">
            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                <div class="list-card-image">
                    {% if p.valor_promocional != '0.00' %}
                    <div class="star position-absolute"><span class="badge badge-success"><i class="feather-star"></i> DESCONTO</span></div>
                    {% endif %}

                    {% if p.status == 0 %}
                    <div class="star position-absolute"><span class="badge badge-secondary">ESGOTADO</span></div>
                    {% endif %}
                    <div class="favourite-heart text-danger position-absolute">

                        <a href="#" class="addFavorito" data-favorito="{{p.id}}"><i id="itFavorito{{p.id}}" class="fa {% if fav.id_produto == p.id %} fa-heart{% else %}fa-heart-o{% endif %}"></i></a>
                    </div>
                    {% if p.imagem is not empty %}
                    <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}">
                        <img src="{{BASE}}uploads/{{ p.imagem }}" class="img-fluid item-img w-100">
                    </a>
                    {% endif %}
                </div>
                <div class="p-3 position-relative">
                    <div class="list-card-body">
                        <h6 class="mb-1">
                            {% if isLogin is empty %}
                            <a href="{{BASE}}{{empresa.link_site}}/login" class="text-black">
                                {% else %}
                                <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}" class="text-black">
                                    {% endif %}{{p.nome}}</a>
                        </h6>
                        <p class="text-gray mb-3">{{p.descricao}}</p>

                        {% if p.valor_promocional != '0.00' %}
                        <p class="text-black mb-1 dequanto"><span class="float-left por">De</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                        <p class="text-black mb-1 porquanto pmais"> <span class="float-left por">Por</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor_promocional|number_format(2, ',', '.') }}</span></p>
                        {% else %}
                        <p class="text-black mb-1 porquanto pmais"> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                        {% endif %}
                    </div>
                </div>
            </div>
        </div>
        {% endfor %}
        {% endif %}

        {% endif %}

        {% endif %}
        {% endfor %}
    </div>
    {% elseif c.produtos == 1 %}
    <div class="px-3 pt-3 title d-flex bg-white">
        <h5 id="{{ c.slug }}" name="{{ c.slug }}" class="mt-1">{{ c.nome }}</h5>
        <!-- <a class="font-weight-bold ml-auto" href="trending.html">Ver todos <i class="feather-chevrons-right"></i></a> -->
    </div>
    <div class="bg-white linha ">
    {% for p in produto %}
    {% if c.id == p.id_categoria %}
    {% if hoje in p.dias_disponiveis %}
    {% if veriFavoritos == 0 %}
    <div class="col-12 pt-2 mb-4">
        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">

            {% if p.imagem is empty %}
            <div class="p-3 position-relative col-md12">
                {% else %}
                <div class="p-3 position-relative col-md6">
                    {% endif %}
                    <div class="list-card-body ">
                        <h6 class="mb-1">
                            <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}" class="text-black">
                                {{p.nome}}</a>
                        </h6>
                        <p class="text-gray mb-2">{{p.descricao}}</p>
                    </div>
                    <div class="favourite-heart text-danger position-absolute">
                        <a href="#" class="addFavorito" data-favorito="{{p.id}}"><i id="itFavorito{{p.id}}" class="fa fa-heart-o"></i></a>
                    </div>

                    <div class="list-card-badge">
                        {% if p.valor_promocional != '0.00' %}
                        <p class="text-black mb-0 dequanto"><span class="float-left por">De</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                        <p class="text-black mb-0 porquanto"> <span class="float-left por">Por</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor_promocional|number_format(2, ',', '.') }}</span></p>
                        {% else %}
                        <p class="text-black mb-0 porquanto"> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                        {% endif %}
                    </div>
                </div>

                {% if p.imagem is not empty %}
                <div class="list-card-image col-md4">
                    <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}">
                        <img src="{{BASE}}uploads/{{p.imagem}}" class="img-fluid item-img w-100">
                    </a>
                </div>
                {% endif %}
                {% if p.valor_promocional != '0.00' %}
                <div class="star position-absolute"><span class="badge badge-success"><i class="feather-star"></i> PROMOÇÃO DO DIA</span></div>
                {% endif %}
            </div>
        </div>
        {% else %}
        {% for fav in favoritos %}

        <div class="col-12 pt-2 mb-4">
            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">

                {% if p.imagem is empty %}
                <div class="p-3 position-relative col-md12">
                    {% else %}
                    <div class="p-3 position-relative col-md6">
                        {% endif %}
                        <div class="list-card-body ">
                            <h6 class="mb-1">
                                <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}" class="text-black">
                                    {{p.nome}}</a>
                            </h6>
                            <p class="text-gray mb-2">{{p.descricao}}</p>
                        </div>
                        <div class="favourite-heart text-danger position-absolute">

                            <a href="#" class="addFavorito" data-favorito="{{p.id}}"><i id="itFavorito{{p.id}}" class="fa {% if fav.id_produto == p.id %} fa-heart{% else %}fa-heart-o{% endif %}"></i></a>
                        </div>

                        <div class="list-card-badge">
                            {% if p.valor_promocional != '0.00' %}
                            <p class="text-black mb-0 dequanto"><span class="float-left por">De</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                            <p class="text-black mb-0 porquanto"> <span class="float-left por">Por</span> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor_promocional|number_format(2, ',', '.') }}</span></p>
                            {% else %}
                            <p class="text-black mb-0 porquanto"> <span class="float-left text-black-50"> {{moeda.simbolo}} {{ p.valor|number_format(2, ',', '.') }}</span></p>
                            {% endif %}
                        </div>
                    </div>

                    {% if p.imagem is not empty %}
                    <div class="list-card-image col-md4">
                        <a href="{{BASE}}{{empresa.link_site}}/produto/{{p.id}}">
                            <img src="{{BASE}}uploads/{{p.imagem}}" class="img-fluid item-img w-100">
                        </a>
                    </div>
                    {% endif %}
                    {% if p.valor_promocional != '0.00' %}
                    <div class="star position-absolute"><span class="badge badge-success"><i class="feather-star"></i> PROMOÇÃO DO DIA</span></div>
                    {% endif %}
                </div>
            </div>

            {% endfor %}
            {% endif %}
            {% endif %}
            {% endif %}
            {% endfor %}
        </div>
{% endif %}
{% endif %}
{% endfor %}
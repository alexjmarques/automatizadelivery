{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}

<div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="mb-2">
                        <h1>Planos</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="{{BASE}}{{empresa.link_site}}/admin">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Planos</li>
                            </ol>
                        </nav>
                        <div class="separator mb-5"></div>
                    </div>
                    {% if planoAtivo == 0 %}
                    <div class="alert alert-danger rounded" role="alert">Contrate um plano e comece a usar o sistema!</div>
                    {% endif %}
                    <div class="row equal-height-container">
                    
                    {% for p in planos %}
                        <div class="mb-4 col-item-plans">
                            <div class="card">
                            {% if p.id == planoAtivo %}
                                        <i class="ativoPlano simple-icon-check"></i>
                            {% endif %}
                                <div class="card-body pt-4 pb-4 d-flex flex-lg-column flex-md-row flex-sm-row flex-column">
                                    <div class="price-top-part">
                                        <h2 class="mb-0 font-weight-semibold color-theme-1 mb-4">{{p.nome}}</h2>
                                        {% if p.id < 4 %}
                                        <p class="text-large mb-2 text-default">{{ moeda.simbolo }} {{ p.valor|number_format(2, ',', '.') }}</p>
                                        <p class="text-muted text-small">Mês</p>
                                        {% else %}

                                        <p class="text-large mb-2 text-default">Consulte-nos</p>
                                        <p class="text-muted text-small"></p>
                                        {% endif %}
                                    </div>
                                    <div class="pl-0 pr-0 pt-0 pb-0 d-flex price-feature-list flex-column flex-grow-1">
                                        <ul class="list-unstyled">
                                            <li>
                                                <p class="mb-0 ">{{p.descricao}}</p>
                                            </li>
                                            <li>
                                                <p class="mb-0 "> - 
                                                {% if p.limite is null %}
                                                <strong>Pedidos Ilimitados  </strong>
                                                {% else %}  
                                                <strong>{{p.limite }} pedidos mês</strong>
                                                {% endif %}
                                            </p>
                                            </li>
                                            <li>
                                                - <strong>7 dias grátis</strong>
                                            </li>
                                        </ul>
                                        {% if p.id < 4 %}
                                        {% if p.id == planoAtivo %}
                                        <!-- <button class="btn  btn-link btn-empty btn-lg">Cancelar este Plano</button> -->
                                        {% else %}
                                        <div class="text-center">
                                            <a href="{{BASE}}{{empresa.link_site}}/admin/plano/{{p.id}}/{{p.slug}}" class="btn btn-primary btn-lg">Contratar este plano</a>
                                        </div>
                                        {% endif %}
                                        {% else %}
                                        <!-- <div class="text-center">
                                            <a href="#" class="btn btn-secundary btn-lg">EM BREVE</a>
                                        </div> -->
                                        {% endif %}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {% endfor %}

                    </div>

                </div>
            </div>

            
        </div>
 
{% endblock %}

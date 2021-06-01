{% extends 'partials/body.twig.php' %}

{% block title %}Sobre a Loja - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
{% if detect.isMobile() %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Sobre a Loja</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page mb-3">
        <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">
            <div class="full_page">
                <h5 class="mb-1 font-weight-bold full_page">{{ empresa.nome_fantasia }}</h5>

                <p class="pb-0"><strong>CNPJ:</strong> {{empresa.cnpj}}</p>
                <p class="pt-0 mt-0 mb-3"><strong>Endereço:</strong> {{endereco.rua}}, {{endereco.numero}}
                    {{endereco.complemento}} - {{endereco.bairro}} - {{endereco.cidade}} |
                    {% for e in estados %}
                    {% if e.id == endereco.estado %}
                    {{ e.uf }}
                    {% endif %}
                    {% endfor %}
                </p>

                <p class="mb-0 mt-0 p-0">{{empresa.sobre}}</p>

                <div class="sc-kNPvCX iOMsuf">
                    <div class="icon-wrap">
                        <h5 class="mb-1 font-weight-bold full_page"><i class="feather-clock"></i> Horário de
                            funcionamento</h5>
                       
                        <ul>
                            {% for func in funcionamento %}
                            {% for dia in dias %}
                            {% if dia.id == func.id_dia %}
                            <li class="pl-2"> - {{ dia.nome }} - <strong>Das {{ func.abertura }} às {{ func.fechamento
                                    }}</strong></li>
                            {% else %}
                            <li class="pl-2 text-cian"> - {{ dia.nome }} - Fechado</li>
                            {% endif %}
                            {% endfor %}
                            {% endfor %}
                        </ul>
                    </div>

                    <div class="sc-kNPvCX iOMsuf mt-3">
                        <div class="icon-wrap">
                            <h5 class="mb-1 font-weight-bold full_page"><i class="feather-dollar-sign"></i> Formas de
                                pagamento aceitas</h5>
                            <ul>
                                {% for f in formasPagamento %}
                                {% if f.status == 1 %}
                                <li class="pl-2"> - {{ f.tipo }}</li>
                                {% endif %}
                                {% endfor %}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {% if delivery.status == 0 %}
        <div class="StatusRest">ESTAMOS FECHADOS NO MOMENTO</div>
        {% endif%}
        {% if isLogin is not empty %}
        {% if isLogin != 0 %}
        {% include 'partials/footer.twig.php' %}
        {% endif %}
        {% endif %}




        {% else %}

        <!-- Sidebar -->
        {% include 'partials/desktop/sidebar.twig.php' %}
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                {% include 'partials/desktop/menuTop.twig.php' %}
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">{{ empresa.nome_fantasia }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="full_page">
                <h5 class="mb-1 font-weight-bold full_page">{{ empresa.nome_fantasia }}</h5>

                <p class="pb-0"><strong>CNPJ:</strong> {{empresa.cnpj}}</p>
                <p class="pt-0 mt-0 mb-3"><strong>Endereço:</strong> {{endereco.rua}}, {{endereco.numero}}
                    {{endereco.complemento}} - {{endereco.bairro}} - {{endereco.cidade}} |
                    {% for e in estados %}
                    {% if e.id == endereco.estado %}
                    {{ e.uf }}
                    {% endif %}
                    {% endfor %}
                </p>

                <p class="mb-0 mt-0 p-0">{{empresa.sobre}}</p>

                <div class="sc-kNPvCX iOMsuf mt-2">
                    <div class="icon-wrap">
                        <h5 class="mb-1 font-weight-bold full_page"><i class="feather-clock"></i> Horário de
                            funcionamento</h5>
                        <ul>
                            {% for func in funcionamento %}
                            {% for dia in dias %}
                            {% if dia.id == func.id_dia %}
                            <li class="pl-2"> - {{ dia.nome }} - <strong>Das {{ func.abertura }} às {{ func.fechamento
                                    }}</strong></li>
                            {% else %}
                            <li class="pl-2 text-cian"> - {{ dia.nome }} - Fechado</li>
                            {% endif %}
                            {% endfor %}
                            {% endfor %}
                        </ul>
                    </div>

                    <div class="sc-kNPvCX iOMsuf mt-3">
                        <div class="icon-wrap">
                            <h5 class="mb-1 font-weight-bold full_page"><i class="feather-dollar-sign"></i> Formas de
                                pagamento aceitas</h5>
                            <ul>
                                {% for f in formasPagamento %}
                                {% if f.status == 1 %}
                                <li class="pl-2"> - {{ f.tipo }}</li>
                                {% endif %}
                                {% endfor %}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            {% include 'partials/desktop/footer.twig.php' %}
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    {% include 'partials/desktop/modal.twig.php' %}

    {% endif %}
    {% endblock %}
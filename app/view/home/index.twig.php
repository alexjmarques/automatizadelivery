{% extends 'partials/body.twig.php'  %}
{% block title %}{{empresa.nomeFantasia}} - Automatiza.App{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% if detect.isMobile() %}
{% include 'partials/headerPrincipal.twig.php' %}
<div id="listarUltimaVenda"></div>
<div class="osahan-home-page">
    <div class="bg-light">
        {% include 'home/mobile/promocao.twig.php' %}
        {% include 'home/mobile/maisVendidos.twig.php' %}
        {% include 'home/mobile/categoria.twig.php' %}
    </div>
</div>
{% if delivery.status == 0 %}
<div class="StatusRest ">ESTAMOS FECHADOS NO MOMENTO</div>
{% endif %}
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
                    <div class="banner-image p-0 mt-n4 mx-n4 position-relative overflow-hidden maxHeight300">
                        <div class="position-absolute heart-icon">
                            <a href="#" class="bg-white text-decoration-none rounded p-2 text-dark font-weight-bold"><i
                           class="far fa-heart"></i></a>
                        </div>
                        {% if empresa.capa is null %}
                        <img src="{{ BASE~'uploads/capa_modelo.jpg'}}" class="img-fluid shadow">
                        {% else %}
                        <img src="{{ BASE~'uploads/'~empresa.capa}}" class="img-fluid shadow">
                        {% endif %}
                    </div>
                    <div class="mt-n5 bg-white p-3 mb-4 rounded shadow position-relative">
                        <div class="osahan-single-top-info d-flex">
                        {% if empresa.capa is null %}
                        <img src="{{ BASE~'uploads/logo_modelo.png'}}" class="img-fluid border p-2 mb-auto rounded brand-logo shadow-sm brandLogo">
                        {% else %}
                        <img src="{{ BASE~'uploads/'~empresa.logo}}" class="img-fluid border p-2 mb-auto rounded brand-logo shadow-sm brandLogo">
                        {% endif %}
                            <div class="ml-3">
                                <h3 class="mb-0 font-weight-bold">{{empresa.nomeFantasia}} <small><i class="mdi mdi-silverware-fork-knife ml-2 mr-1"></i> American, Fast Food</small></h3>
                                <div class="restaurant-detail mt-2 mb-3">
                                    <span class="badge badge-light"><i class="mdi mdi-truck-fast-outline"></i> Free delivery</span>
                                    <span class="badge badge-success"><i class="mdi mdi-ticket-percent-outline"></i> 55% OFF</span>
                                    {% if delivery.status == 1 %}
                                    <span class="badge badge-info"><i class="mdi mdi-clock-outline"></i> Aberto</span>
                                    {% else %}
                                    <span class="badge badge-info"><i class="mdi mdi-clock-outline"></i> Abre as </span>
                                    {% endif %}
                                    
                                </div>
                                <p class="text-muted p-0 mt-2 mb-2">{{empresa.sobre}}</p>
                                <p class="mb-0 small">
                                    <i class="mdi mdi-star text-warning"></i> <span class="font-weight-bold text-dark">4.8</span> - 500+ Ratings
                                    <i class="fas fa-hand-holding-usd text-dark ml-3 mr-2"></i> 350 Cost for two
                                    <i class="fas fa-map-marked-alt text-dark ml-3 mr-2"></i>4.3 km (Irving St, San Francisco, California)
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {% include 'home/desktop/categoria.twig.php' %}
                    <!-- Tabs radio -->
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


{% endif %} #}

{% endblock %}
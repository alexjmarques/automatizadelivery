{% extends 'partials/body.twig.php'  %}
{% block title %}{{ trans.t('Portal de pedidos - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% if sessaoLogin is not empty %}
<!-- Sidebar -->
{% include 'partials/desktop/sidebar.twig.php' %}
<!-- End of Sidebar -->
{% endif %}
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                {% include 'partials/desktop/menuTop.twig.php' %}
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-flex align-items-center justify-content-between mb-3 mt-2">
                        <h5 class="mb-0">{{ trans.t('Por Categoria')}}</h5>
                        <a href="listing.html" class="small font-weight-bold text-dark">{{ trans.t('Ver tudo')}} <i class="mdi mdi-chevron-right mr-2"></i></a>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Popular -->
                        <a href="listing.html" class="text-decoration-none col-xl-2 col-md-4 mb-4">
                            <div class="rounded py-4 bg-white shadow-sm text-center">
                                <i class="mdi mdi-fire bg-danger text-white osahan-icon mx-auto rounded-pill"></i>
                                <h6 class="mb-1 mt-3">Popular</h6>
                                <p class="mb-0 small">286+ options</p>
                            </div>
                        </a>
                        <!-- fast delivery -->
                        <a href="listing.html" class="text-decoration-none col-xl-2 col-md-4 mb-4">
                            <div class="rounded py-4 bg-white shadow-sm text-center">
                                <i class="mdi mdi-motorbike bg-primary text-white osahan-icon mx-auto rounded-pill"></i>
                                <h6 class="mb-1 mt-3">Fast Delivery</h6>
                                <p class="mb-0 small">1,843+ options</p>
                            </div>
                        </a>
                        <!-- high class -->
                        <a href="listing.html" class="text-decoration-none col-xl-2 col-md-4 mb-4">
                            <div class="rounded py-4 bg-white shadow-sm text-center">
                                <i class="mdi mdi-wallet-outline bg-warning text-white osahan-icon mx-auto rounded-pill"></i>
                                <h6 class="mb-1 mt-3">High class</h6>
                                <p class="mb-0 small">25+ options</p>
                            </div>
                        </a>
                        <!-- Dine in -->
                        <a href="listing.html" class="text-decoration-none col-xl-2 col-md-4 mb-4">
                            <div class="rounded py-4 bg-white shadow-sm text-center">
                                <i class="mdi mdi-silverware-variant bg-danger text-white osahan-icon mx-auto rounded-pill"></i>
                                <h6 class="mb-1 mt-3">Dine in</h6>
                                <p class="mb-0 small">182+ options</p>
                            </div>
                        </a>
                        <!-- Pick up -->
                        <a href="listing.html" class="text-decoration-none col-xl-2 col-md-4 mb-4">
                            <div class="rounded py-4 bg-white shadow-sm text-center">
                                <i class="mdi mdi-home-variant-outline bg-primary text-white osahan-icon mx-auto rounded-pill"></i>
                                <h6 class="mb-1 mt-3">Pick up</h6>
                                <p class="mb-0 small">3,548+ options</p>
                            </div>
                        </a>
                        <!-- Nearest -->
                        <a href="listing.html" class="text-decoration-none col-xl-2 col-md-4 mb-4">
                            <div class="rounded py-4 bg-white shadow-sm text-center">
                                <i class="mdi mdi-map-outline bg-warning text-white osahan-icon mx-auto rounded-pill"></i>
                                <h6 class="mb-1 mt-3">Nearest</h6>
                                <p class="mb-0 small">44+ options</p>
                            </div>
                        </a>
                    </div>
                    <!-- Page Heading -->
                    <div class="d-flex align-items-center justify-content-between mb-3 mt-2">
                        <h5 class="mb-0">{{ trans.t('Em destaque')}}</h5>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Featured restaurants -->
                    {% for emp in empresas%}
                        <a href="detail.html" class="text-dark text-decoration-none col-xl-4 col-lg-12 col-md-12">
                            <div class="bg-white shadow-sm rounded d-flex align-items-center p-1 mb-4 osahan-list">
                                <div class="bg-light p-3 rounded">
                                    <img src="{{ BASE~'uploads/'~emp[':logo']}}" class="img-fluid">
                                </div>
                                <div class="mx-3 py-2 w-100">
                                    <p class="mb-2 text-black">{{emp[':nomeFantasia']}}</p>
                                    <p class="small mb-2">
                                        <!-- <i class="mdi mdi-star text-warning mr-1"></i> <span class="font-weight-bold text-dark">0.8</span> (873) -->
                                        <i class="mdi mdi-silverware-fork-knife mr-1"></i> Burger
                                        <i class="mdi mdi-currency-inr ml-3"></i> 340/-
                                    </p>
                                    <p class="mb-0 text-muted d-flex align-items-center">
                                        
                                        <span class="small ml-auto"><i class="mdi mdi-map-marker"></i> 0.3 km</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    {% endfor %}
                    </div>
                    <!-- Content Row -->
                    
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            {% if sessaoLogin is empty %}
            <section class="section pt-5 pb-5 becomemember-section border-bottom">
         <div class="container">
            <div class="section-header text-center white-text">
               <h2>Você tem um Estabelecimento?</h2>
               <p>Lorem Ipsum is simply dummy text of</p>
               <span class="line"></span>
            </div>
            <div class="row">
               <div class="col-sm-12 text-center">
                  <a href="{{BASE}}cadastrar" class="btn btn-success btn-lg">
                  Cadastre-se <i class="fa fa-chevron-circle-right"></i>
                  </a>
               </div>
            </div>
         </div>
      </section>
      {% endif %}

            <!-- Footer -->
            {% include 'partials/desktop/footer.twig.php' %}
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    {% include 'partials/desktop/modal.twig.php' %}
{% endblock %}
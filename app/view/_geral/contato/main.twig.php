{% extends 'partials/body.twig.php'  %}

{% block title %}Contato - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
{% if detect.isMobile() %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Contato</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/perfil"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page mb-3">
    <div class="d-flex mb-3 osahan-cart-item-profile bg-white shadow rounded p-3 mt-n5">

    <div class="flex-column full_page">
        <h6 class="font-weight-bold">Fale Conosco</h6>
        <p class="text-muted">Se você tiver dúvidas ou quiser apenas dizer olá, entre em contato conosco.</p>
        <form class="mt-3" method="post" action="{{BASE}}{{empresa.link_site}}/contato/i" id="form" enctype="multipart/form-data">
        <div class="form-group">
        <label for="exampleFormControlInput1" class="small font-weight-bold">Seu Nome</label>
        <input type="text" class="form-control" id="nome" name="nome">
        </div>
        <div class="form-group">
        <label for="exampleFormControlInput2" class="small font-weight-bold">Email</label>
        <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
        <label for="exampleFormControlInput3" class="small font-weight-bold">Telefone</label>
        <input type="tel" class="form-control" id="telefone" name="telefone" >
        </div>
        <div class="form-group">
        <label for="exampleFormControlTextarea1" class="small font-weight-bold">COMO PODEMOS TE AJUDAR?</label>
        <textarea class="form-control" id="mensagem" name="mensagem" rows="4"></textarea>
        </div>
        <div class="btn_acao"><div class="carrega"></div>
            <button id="btn-atualizar-end" class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnEnviar"><span>Enviar</span></button>
        </div>
        </form>
    </div>


    </div>
    </div>

</div>


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
                                    <h6 class="m-0 font-weight-bold text-primary">Fale Conosco</h6>
                                </div>
                                <div class="card-body">
                                <div class="flex-column full_page">
                                <p class="text-muted">Se você tiver dúvidas ou quiser apenas dizer olá, entre em contato conosco.</p>
                                <form class="mt-3" method="post" action="{{BASE}}{{empresa.link_site}}/contato/i" id="form" enctype="multipart/form-data">
                                <div class="form-group">
                                <label for="exampleFormControlInput1" class="small font-weight-bold">Seu Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlInput2" class="small font-weight-bold">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlInput3" class="small font-weight-bold">Telefone</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" >
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlTextarea1" class="small font-weight-bold">COMO PODEMOS TE AJUDAR?</label>
                                <textarea class="form-control" id="mensagem" name="mensagem" rows="4"></textarea>
                                </div>
                                <div class="btn_acao"><div class="carrega"></div>
                                    <button id="btn-atualizar-end" class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnEnviar"><span>Enviar</span></button>
                                </div>
                                </form>
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
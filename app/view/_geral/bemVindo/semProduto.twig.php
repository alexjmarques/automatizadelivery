{% extends 'partials/bodyFull.twig.php'  %}
{% block title %}Seja Bem Vindo - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}
{% if detect.isMobile() %}
<div class="vh-100 location location-page">
<div class="d-flex align-items-center justify-content-center vh-100 flex-column">
<img src="{{BASE}}img/landing1.png" class="img-fluid mx-auto" alt="{{empresa.nome_fantasia }}">
<div class="px-0 text-center mt-4">
<h5 class="text-dark">Olá, tudo bem com você!</h5>
<p class="mb-5">Delivery novo na área, aguarde mais um pouco que logo mais poderá ver os produtos da <strong>{{empresa.nome_fantasia }}</strong>.</p>

<a href="https://automatiza.app" target="_Blank">© Automatiza.app</a>
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
                <h5 class="text-dark">Olá, tudo bem com você!</h5>
<p class="mb-5">Delivery novo na área, aguarde mais um pouco que logo mais poderá ver os produtos da <strong>{{empresa.nome_fantasia }}</strong>.</p>
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
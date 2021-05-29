<div class="osahan-menu-fotter fixed-bottom bg-white p-0 text-center">
    <div class="row">
    <div id="home" class="col">
            <a href="{{BASE}}{{empresa.link_site}}/motoboy" class="text-dark small font-weight-bold text-decoration-none"><p class="h4 m-0"><i class="feather-home"></i></p>Painel</a>
        </div>
    <div id="entrega" class="col">
        <a href="{{BASE}}{{empresa.link_site}}/motoboy/pegar/entrega" class="text-dark small font-weight-bold text-decoration-none"><p class="h4 m-0"><i class="feather-plus"></i></p>Nova Entrega</a>
    </div>
    <div id="pedidos" class="col">
        <a href="{{BASE}}{{empresa.link_site}}/motoboy/entregas" class="text-dark small font-weight-bold text-decoration-none"><p class="h4 m-0"><i class="feather-map-pin"></i></p><span id="mostrarQtd"></span>Entregas</a>
    </div>
    <div id="perfil" class="col">
            <a href="{{BASE}}{{empresa.link_site}}/motoboy/perfil" class="text-dark small font-weight-bold text-decoration-none"><p class="h4 m-0"><i class="feather-user"></i></p>Perfil</a>
        </div>
    </div>
</div>
{% include 'partials/modalCarrinho.twig.php' %}




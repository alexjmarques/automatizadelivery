<div class="osahan-menu-fotter fixed-bottom bg-white p-0 text-center">
    <div class="row">
        <div id="home" class="col">
            <a href="{{BASE}}{{empresa.link_site}}/" class="text-dark small font-weight-bold text-decoration-none"><p class="h4 m-0"><i class="feather-home"></i></p>Início</a>
        </div>
        <div id="pedidos" class="col">
            <a href="{{BASE}}{{empresa.link_site}}/meus-pedidos" class="text-dark small font-weight-bold text-decoration-none"><p class="h4 m-0"><i class="feather-list"></i></p>Pedidos</a>
        </div>
        <div class="col bg-white rounded-circle mt-n4 px-3 py-2">
            <div class="bg-danger rounded-circle mt-n0 shadow">
            {% if carrinhoQtd == 0 %}
                <a href="#" data-toggle="modal" data-target="#carrinhoEmpty" class="text-white small font-weight-bold text-decoration-none"><i class="feather-shopping-cart"></i></a>
            {% else %}
                <a href="{{BASE}}{{empresa.link_site}}/carrinho" class="text-white small font-weight-bold text-decoration-none"><i class="feather-shopping-cart"></i><span id="total_itens_header" class="ml-1">{{carrinhoQtd}}</span></a>
            {% endif %}
            </div>
        </div>
        <div id="endereco" class="col">
            <a href="{{BASE}}{{empresa.link_site}}/enderecos" class="text-dark small font-weight-bold text-decoration-none"><p class="h4 m-0"><i class="feather-map-pin"></i></p>Enderecos</a>
        </div>
        <div id="perfil" class="col">
            <a href="{{BASE}}{{empresa.link_site}}/perfil" class="text-dark small font-weight-bold text-decoration-none"><p class="h4 m-0"><i class="feather-user"></i></p>Perfil</a>
        </div>
    </div>
</div>
{% include 'partials/modalCarrinho.twig.php' %}
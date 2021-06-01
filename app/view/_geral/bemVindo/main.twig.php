{% extends 'partials/bodyFull.twig.php'  %}

{% block title %}Seja Bem Vindo - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}

<div class="vh-100 landing-page-skip">
<a class="position-absolute btn-sm btn btn-outline-primary m-4 zindex" href="{{BASE}}{{empresa.link_site}}/">Pronto <i class="feather-chevrons-right"></i></a>

<div class="osahan-slider">
    <div class="osahan-slider-item text-center">
        <div class="d-flex align-items-center justify-content-center vh-100 flex-column">
            <img src="{{BASE}}img/location.png" class="img-fluid mx-auto" alt="{{empresa.nome_fantasia }}">
            <h4 class="my-4 text-dark">Veja como é Fácil</h4>
            <p>Faça seu cadastro, informe seu endereço para visualizar o cardápio e fazer seu pedido.</p>
        </div>
    </div>
    <div class="osahan-slider-item text-center">
        <div class="d-flex align-items-center justify-content-center vh-100 flex-column">
            <img src="{{BASE}}img/landing2.png" class="img-fluid mx-auto" alt="{{empresa.nome_fantasia }}">
            <h4 class="my-4 text-dark">Faça seu pedido</h4>
            <p>Através de uma tela intuitiva você faz seu pedido sem enrolação.</p>
        </div>
    </div>
    <div class="osahan-slider-item text-center">
        <div class="d-flex align-items-center justify-content-center vh-100 flex-column">
            <img src="{{BASE}}img/landing3.png" class="img-fluid mx-auto" alt="{{empresa.nome_fantasia }}">
            <h4 class="my-4 text-dark">Recebendo seu Pedido</h4>
            <p>Após efetuar seu pedido, vocês acompanha o passo a passo da produção de seu pedido, até a entrega em sua casa.</p>
        </div>
    </div>
</div>
</div>
{% endblock %}
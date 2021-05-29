{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Novo Pedido</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/categorias">Pedidos</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo Pedido</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
                <div class="card mb-4">
                <div id="smartWizardPedidos" class="sw-main sw-theme-check">
                            <ul class="card-header nav nav-tabs step-anchor">
                                <li class="p-3 nav-item done"><a href="#">Cliente<br /><small>Dados do Cliente e Entrega</small></a></li>
                                <li class="p-3 nav-item done"><a href="#">Produtos<br /><small>Produtos do pedido</small></a></li>
                                <li class="p-3 nav-item done"><a href="#">Pedido<br /><small>Entrega e Pagamento</small></a></li>
                            </ul>

                            <div class="card-body">
                                
                                
                                <div id="step-2">
                                    <h4 class="text-center">Thank you for your feedback!</h4>
                                    <p class="muted text-center p-4">
                                        Podcasting operational change management inside of workflows to establish a
                                        framework. Taking seamless key performance indicators offline to maximise the
                                        long tail. Keeping your eye on the ball while performing a deep dive on the
                                        start-up mentality.
                                    </p>
                                </div>
                                
                            </div>

                            
                        </div>
                    </div>
{% endblock %}
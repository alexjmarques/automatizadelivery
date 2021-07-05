{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Pedidos</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
    </ol>
</nav>
<div class="search top-right-button-container">
    <input id="inpFiltro" name="inpFiltro" class="form-control" placeholder="Pesquisar...">
    <span class="search-icon"><i class="simple-icon-magnifier"></i></span>
</div>
<div class="separator mb-5"></div>
<div class="lists">
		<div class="list cinza">
			<header>Pedidos Recebidos</header>
            <ul id="recebido" class="filtro">
            </ul>
            <div id="carregaRecebido"></div>
		</div>

		<div class="list orange">
			<header>Em Produção</header>
			<ul id="producao" class="filtro">
            </ul>
		</div>

		<div class="list green">
			<header>Entrega e Finalização</header>
			<ul id="geral" class="filtro">
			</ul>
		</div>
    </div>

	<div class="modal fade" id="modPedido" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="mostrarPedido" class="modal-content">       
				               
            </div>
        </div>
    </div>
{% endblock %}
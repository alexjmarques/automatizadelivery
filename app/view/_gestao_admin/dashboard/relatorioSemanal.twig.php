{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Painel</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Planos</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Ativo</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
{% endblock %}
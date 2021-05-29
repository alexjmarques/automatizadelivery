{% extends 'partials/bodyFull.twig.php'  %}
{% block title %}Seja Bem Vindo - {{empresa[':nomeFantasia']}}{% endblock %}
{% block body %}
<div class="vh-100 location location-page">
<div class="d-flex align-items-center justify-content-center vh-100 flex-column">
<img src="img/landing1.png" class="img-fluid mx-auto" alt="{{empresa[':nomeFantasia']}}">
<div class="px-0 text-center mt-4">
<h5 class="text-dark">Olá, tudo bem com você!</h5>
<p class="mb-5">Delivery novo na área, aguarde mais um pouco que logo mais poderá ver os produtos da <strong>{{empresa[':nomeFantasia']}}</strong>.</p>

<a href="https://automatiza.app" target="_Blank">© Automatiza.app</a>
</div>
</div>
</div>
{% endblock %}
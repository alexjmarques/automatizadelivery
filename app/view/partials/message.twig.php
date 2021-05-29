
{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}{{titulo}} - Automatiza.App{% endblock %}
{% block body %}
<h1>{{titulo}}</h1>
<div class="separator mb-5"></div>
    <div class="col-12">
        {{descricao}}
        {% if link != null %}
        <a href="{{link}}">Voltar</a>
        {% endif %}
    </div>
{% endblock %}

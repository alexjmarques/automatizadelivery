{% extends 'partials/body.twig.php'  %}
{% block title %}{{page.titulo}}{{ trans.t(' - Automatiza Delivery') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTopWhite.twig.php' %}
<section class="section pt-5 pb-5">
   <div class="container">
      <div class="row">
         <div class="col-md-10 mx-auto bg-white p-5 rounded">
         <h2 class="text-left">{{page.titulo}}</h2>
            {{ page.conteudo|raw }}
         </div>
      </div>
   </div>
</section>
{% include 'partials/desktop/footer.twig.php' %}
{% endblock %}
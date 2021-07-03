{% extends 'partials/bodyHome.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTopWhite.twig.php' %}
<section class="section pt-5 pb-5">
   <div class="container">
      <div class="row">
         <div class="col-md-10 mx-auto bg-white p-5 rounded">
            <h5 class="mb-0">Conte-nos sobre seu estabelecimento.</h4>
               <p class="mb-4">Para criar sua conta e utilizar o nosso sistema preciso de algumas informações.</p>
               
         </div>
      </div>
   </div>
</section>
{% include 'partials/desktop/footer.twig.php' %}
{% endblock %}
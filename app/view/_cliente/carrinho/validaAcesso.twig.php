{% extends 'partials/body.twig.php'  %}

{% block title %}Carrinho - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}



<div class="osahan-verification">
<div class="p-3 border-bottom">
<a class="text-primary" href="login.html"><i class="feather-chevron-left"></i> Voltar</a>
</div>
<div class="verify_number p-4">
<h2 class="mb-3">Verifique em seu telefone!</h2>
<h6 class="text-black-50">O código que enviamos para validar seu acesso.</h6>
<form id="form"  action="{{BASE}}{{empresa.link_site}}/valida/acesso/code" >
<div class="row my-5 mx-0">
<div class="col pr-1 pl-0">
<input type="text" value="" name="codeValida" id="codeValida" class="form-control form-control-lg">
</div>
</div>
<button class="btn btn-success btn-block btn-lg acaoBtn btnValida">VALIDAR</button>
</form>
</div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}

{% endblock %}

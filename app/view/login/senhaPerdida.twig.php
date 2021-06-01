{% extends 'partials/body.twig.php'  %}

{% block title %}Recuperar Senha - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="login-page" style="">
<div class="p-4 osahan-home-page">
<h2 class="text-white my-0">Olá</h2>
<p class="text-white text-50">Insira se número de Telefone abaixo que enviaremos por SMS instruções para recuperar sua senha!</p>
<form class="mt-5 mb-4" method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/recuperar-senha/recuperar">
    <div class="form-group">
    <label for="email" class="text-white">Número de Telefone cadastrado (Ex.: (11) 00000-0000)</label>
    <input type="text" class="form-control" id="emailOurTel" name="emailOurTel" required>
    </div>
    
<button class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnEnviar">ENVIAR</button>
    
</form>
</div>
<div class="d-flex justify-content-center">
<a href="{{BASE}}{{empresa.link_site}}/cadastro">
<p class="text-center text-white m-0">Não tem conta? Cadastre-se</p>
</a>
</div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% if empresa.capa is null %}
<style>.fixed-bottom-bar{margin:0 !important;background: url(/uploads/capa_modelo.jpg); background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;}</style>
{% else %}
<style>.fixed-bottom-bar{margin:0 !important;background: url(/uploads/{{empresa.capa}}); background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;}</style>
{% endif %}
{% endblock %}
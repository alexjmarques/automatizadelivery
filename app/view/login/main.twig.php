{% extends 'partials/body.twig.php'  %}

{% block title %}Login - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="login-page" style="">
<div class="p-5 osahan-home-page">
<h2 class="text-white my-0">Olá novamente</h2>
<p class="text-white text-50">Valide seu acesso para continuar</p>
<form class="mt-5 mb-4 pt-4" method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/login/valida">
    <div class="form-group">
    <label for="email" class="text-white">Telefone (Ex.: (11) 00000-0000)</label>
    <input type="text" placeholder="Telefone" class="form-control" id="emailOurTel" name="emailOurTel" value="" required>
    </div>
    <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-primary btn-lg btn-block acaoBtn">VALIDAR</button>
    <!-- <p class="text-center text-white mt-3">Não tem conta? Cadastre-se</p>
    <div class="py-2 mt-2">
    <a href="{{BASE}}{{empresa.link_site}}/cadastro" class="btn btn-lg btn-outline-primary btn-block"><i class="feather-mail"></i> Cadastrar com Telefone</a>
    </div> -->
    <!-- <div class="py-2">
    <a href="{{facebook}}" class="btn btn-lg btn-facebook btn-block"><i class="feather-facebook"></i> Conectar com Facebook</a>
    </div> -->
</form>
<!-- <a href="{{BASE}}{{empresa.link_site}}/recuperar-senha" class="text-decoration-none">
<p class="text-white text-center">Perdeu a senha? Clique aqui</p>
</a> -->
</div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/modalValidaLogin.twig.php' %}
{% if empresa[':capa'] is null %}
<style>.fixed-bottom-bar{margin:0 !important;background: url(/uploads/capa_modelo.jpg); background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;}</style>
{% else %}
<style>.fixed-bottom-bar{margin:0 !important;background: url(/uploads/{{empresa[':capa']}}); background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;}</style>
{% endif %}
{% endblock %}
{% extends 'partials/body.twig.php'  %}

{% block title %}Recuperar Senha - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="login-page" style="">
    <div class="p-4 osahan-home-page">
        <h2 class="text-white my-0">Olá {{usuario.nome}}</h2>
        <p class="text-white text-50">Cadastre sua nova senha!</p>
        <form class="mt-5 mb-4" method="post" id="form" action="{{BASE}}{{empresa.link_site}}/recuperar/senha/i">
            <div class="form-group">
                <label for="email" class="text-white">Informe uma nova senha</label>
                <input type="password" placeholder="Senha" class="form-control" id="senha" name="senha" aria-describedby="emailHelp" required>
            </div>
            <div class="form-group">
                <label for="email" class="text-white">Confirme sua nova senha</label>
                <input type="password" placeholder="Senha" class="form-control" id="senhaUp" name="senhaUp" aria-describedby="emailHelp" required>
            </div>
            <input type="hidden" id="id" name="id" value="{{usuario.id}}">
            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnCadastrat">CADASTRAR</button>
            </div>
        </form>
    </div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% if empresa.capa is null %}
<style>
    .fixed-bottom-bar {
        margin: 0 !important;
        background: url(/uploads/capa_modelo.jpg);
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
{% else %}
<style>
    .fixed-bottom-bar {
        margin: 0 !important;
        background: url(/uploads/{{empresa.capa}});
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
{% endif %}
{% endblock %}
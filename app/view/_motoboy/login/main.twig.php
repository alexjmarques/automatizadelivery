{% extends 'partials/body.twig.php'  %}

{% block title %}Login - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="login-page" style="">
    <div class="p-4 osahan-home-page">
        <h2 class="text-white my-0">Olá Entregador</h2>
        <p class="text-white text-50">Faça o login no {{empresa.nome_fantasia }}</p>
        <form class="mt-5 mb-4" method="post" id="form" action="{{BASE}}{{empresa.link_site}}/motoboy/login/valida">
            <div class="form-group">
                <div class="form-group">
                    <label for="telefone" class="text-white">Telefone (Ex.: (11) 00000-0000)</label>
                    <input type="tel" placeholder="Telefone" class="form-control" id="telefone" name="telefone" maxlength="15" required>
                </div>

                <div class="form-group">
                    <label for="senha" class="text-white">Senha</label>
                    <input type="password" placeholder="Senha" class="form-control" id="senha" name="senha" required>
                </div>

                <input type="hidden" placeholder="Email" class="form-control" id="email" name="email" value="">
                <input type="hidden" id="nivel" name="nivel" value="1">
                <div class="btn_acao">
                    <div class="carrega"></div>
                    <button class="btn btn-primary btn-lg btn-block acaoBtnLogin">Login</button>

                    <p class="text-center text-white mt-4">Não tem conta? Cadastre-se</p>
            <div class="py-2 mt-3">
                <a href="{{BASE}}{{empresa.link_site}}/motoboy/cadastro" class="btn btn-lg btn-outline-primary btn-block"><i class="feather-mail"></i> Cadastrar</a>
            </div>

                </div>
        </form>
    </div>
</div>

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
    .modal-backdrop {
    z-index: 1000 !important;
    height: initial !important;
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
    .modal-backdrop {
    z-index: 1000 !important;
    height: initial !important;
}
</style>
{% endif %}
{% include 'partials/modalAlertSite.twig.php' %}

{% endblock %}
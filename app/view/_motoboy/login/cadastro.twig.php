{% extends 'partials/body.twig.php'  %}

{% block title %}Cadastre-se - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="login-page" style="">
    <div class="p-4 osahan-home-page">
        <h2 class="text-white my-0">Olá Entregador</h2>
        <p class="text-white text-50">Faça seu cadastro para que possa efetuar entregas para o {{empresa.nome_fantasia }}</p>
        <form class="mt-5 mb-4" method="post" id="form" action="{{BASE}}{{empresa.link_site}}/motoboy/cadastro/insert">
            <div class="form-group">
                <label for="nome" class="text-white">Nome</label>
                <input type="text" placeholder="Nome Completo" class="form-control" id="nome" name="nome" value="" required>
            </div>

            <div class="form-group">
                <label for="telefone" class="text-white">Telefone (Ex.: (11) 00000-0000)</label>
                <input type="tel" placeholder="Telefone" class="form-control" id="telefone" name="telefone" maxlength="15" required>
            </div>

            <div class="form-group">
                <label for="senha" class="text-white">Informe uma Senha</label>
                <input type="password" placeholder="Senha" class="form-control" id="senha" name="senha" required>
            </div>

            <div class="form-group privacy-container">
                <label class="privacy-label" for="politicaPrivacidade">
                    <input id="politicaPrivacidade" type="checkbox" name="politicaPrivacidade" required>
                    Li e concordo com os termos da <a target="_blank" href="{{BASE}}{{empresa.link_site}}/politica-de-privacidade">Política de privacidade</a>
                </label>
            </div>
            <input type="hidden" placeholder="Email" class="form-control" id="email" name="email" value="">
            <input type="hidden" id="nivel" name="nivel" value="1">
            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-primary btn-lg btn-block acaoBtn">CADASTRAR</button>
            </div>
        </form>
    </div>

</div>

{% if empresa.capa is null %}
<style>
    .modal-backdrop {
    z-index: 1000 !important;
    height: initial !important;
}
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
    .modal-backdrop {
    z-index: 1000 !important;
    height: initial !important;
}
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
{% include 'partials/modalAlertSite.twig.php' %}

{% endblock %}
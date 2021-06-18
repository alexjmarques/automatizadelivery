{% extends 'partials/body.twig.php'  %}
{% block title %}Cadastre-se - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}
<div class="login-page" style="">
    <div class="p-4 osahan-home-page">
        <h2 class="text-white my-0">Olá Bem-vindo</h2>
        <p class="text-white text-50">Cadastre-se para continuar</p>
        <form id="form" method="post" class="mt-5 mb-4" action="{{BASE}}{{empresa.link_site}}/cadastro/finaliza/social">
            <div class="form-group">
                <label for="nome" class="text-white">Nome</label>
                <input type="text" placeholder="Nome Completo" class="form-control" id="nome" name="nome" value="{{nome}}" aria-describedby="emailHelp" required>
            </div>

            <div class="form-group">
                <label for="telefone" class="text-white">Telefone (Ex.: (11) 00000-0000)</label>
                <input type="tel" placeholder="Telefone" class="form-control" id="telefone" name="telefone" aria-describedby="emailHelp" maxlength="15" required>
            </div>

            <div class="form-group">
                <label for="email" class="text-white">Email</label>
                <input type="email" placeholder="Email" class="form-control" id="email" name="email" value="{{email}}" aria-describedby="emailHelp" required>
            </div>

            <div class="form-group privacy-container">
                <label class="privacy-label" for="politicaPrivacidade">
                    <input id="politicaPrivacidade" type="checkbox" name="politicaPrivacidade" required>
                    Li e concordo com os termos da <a target="_blank" href="{{BASE}}{{empresa.link_site}}/politica-de-privacidade">Política de privacidade</a>
                </label>
            </div>
            <input type="hidden" id="senha" name="senha" value="12345678">
            <input type="hidden" id="nivel" name="nivel" value="3">
            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-primary btn-lg btn-block acaoBtnCadastro">FINALIZAR CADASTRO</button>
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-center">
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
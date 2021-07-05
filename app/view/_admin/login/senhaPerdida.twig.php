{% extends 'partials/bodyAdminLogin.twig.php'  %}
{% block title %}Admin Automatiza Delivery - Recuperar Senha{% endblock %}
{% block body %}
<div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-8 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="form-side full">
                            <a href="https://www.automatiza.app" target="_blank">
                                <img src="{{BASE}}adm/images/Automatiza-ext.jpg" height="60" alt="">
                            </a>
                            <h6 class="mb-4">Recuperar Senha</h6>
                            <p class="mb-4">Insira seu endereço de e-mail abaixo e nós lhe enviaremos um e-mail com instruções sobre como alterar sua senha</p>
                            <form id="form"  action="{{BASE}}{{empresa.link_site}}/recuperar-senha/recuperar">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="text" name="email" id="email"/>
                                    <span>Seu email de cadastro</span>
                                </label>

                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-primary btn-lg btn-shadow acaoBtn" type="submit">ENVIAR</button>
                                </div>
                                <div id="mensagem" class="text-center col-md-12 mt-3 m-0 p-0"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{% endblock %}

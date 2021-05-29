{% extends 'partials/bodyAdminLogin.twig.php'  %}
{% block title %}Admin Automatiza.App - Cadastre sua nova senha!{% endblock %}
{% block body %}
<div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-6 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="form-side full">
                            <a href="https://www.automatiza.app" target="_blank">
                                <img src="{{BASE}}adm/images/Automatiza-ext.jpg" height="60" alt="">
                            </a>
                            <h6 class="mb-4">Cadastre sua nova senha!</h6>
                            <form id="form"  action="{{BASE}}{{empresa.link_site}}/admin/recuperar/senha/i">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" name="senha" id="senha"/>
                                    <span>Informe uma nova senha</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" name="senhaUp" id="senhaUp" placeholder="" />
                                    <span>Confirme sua nova senha</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                <input type="hidden" id="id" name="id" value="{{usuario[':id']}}">
                                    
<button class="btn btn-primary btn-lg btn-shadow" type="submit">CADASTRAR</button>
                                </div>
                                <div id="mensagem" class="text-center col-md-12 mt-3 m-0 p-0"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{% endblock %}

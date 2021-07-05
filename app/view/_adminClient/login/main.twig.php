{% extends 'partials/bodyAdminLogin.twig.php'  %}
{% block title %}Admin Automatiza.App - Login{% endblock %}
{% block body %}
<div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-8 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="form-side full">
                            <a href="https://www.automatiza.app" target="_blank">
                                <img src="{{BASE}}adm/images/Automatiza-ext.jpg" height="60" alt="">
                            </a>
                            <h6 class="mb-4">Login</h6>
                            <form id="form"  action="{{BASE}}admin/login/valida">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="email" id="email"/>
                                    <span>E-mail</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" name="senha" id="senha" placeholder="" />
                                    <span>Senha</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{BASE}}{{empresa.link_site}}/admin/recuperar-senha">Perdeu a senha? Clique aqui</a>
                                    <button class="btn btn-primary btn-lg btn-shadow acaoBtnLogin" type="submit">Login</button>
                                    <input type="hidden" name="idEmpresa" id="idEmpresa" value="{{ empresa.id }}" />
                                </div>
                                
                                <div id="mensagem" class="text-center col-md-12 mt-3 m-0 p-0 b-0 alert alert-danger" style="border: none;"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{% endblock %}
{% extends 'partials/body.twig.php'  %}

{% block title %}Alterar Senha - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Alterar Senha</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/perfil"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="bg-white rounded shadow mt-n5">
                <div class=" border-bottom p-3">
                    <div class=" text-center">
                    <h6 class="mb-1 font-weight-bold">Alterar Senha </h6>
                    <p class="text-muted m-0 text-center">Informe uma nova senha!</p>
                    </div>
                </div>
                <div class="osahan-credits d-flex  p-3">
                    <form method="post" autocomplete="off" action="{{BASE}}{{empresa.link_site}}/perfil/senha/u" id="form" class="full_page" enctype="multipart/form-data">
                        <p class="text-muted m-0 small">(Campos Obrigatório <span style="color:red;">*</span>)</p>
                        <div class="dados-usuario full_page">
                        <div class="col-md-6 pl-0 pr-0">
                        <div class="form-group">
                            <label class="text-dark" for="rua">Senha<span style="color:red;">*</span></label>
                            <input type="password" class="form-control" id="senha" name="senha" value="" required>
                           
                        </div>
                        </div>

                        <div class="col-md-6 pl-0 pr-0">
                        <div class="form-group">
                            <label class="text-dark" for="rua">Confirme sua senha<span style="color:red;">*</span></label>
                            <input type="password" class="form-control" id="senhaValida" name="senhaValida" value="" required>
                        </div>
                        </div>
                        </div>
                        <div class="btn_acao">
                            <button id="btn-atualizar-end" class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnCadastro"><span>Alterar</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footer.twig.php' %}


{% endblock %}
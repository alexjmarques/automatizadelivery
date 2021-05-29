{% extends 'partials/body.twig.php'  %}

{% block title %}Alterar Número de Telefone - {{empresa[':nomeFantasia']}}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Alterar Telefone</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/perfil"> Voltar</a>
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="bg-white rounded shadow mt-n5">
                <div class=" border-bottom p-3">
                    <div class=" text-center">
                    <h6 class="mb-1 font-weight-bold">Alterar Número</h6>
                    <p class="text-muted m-0 text-center">Informe seu novo número de telefone!</p>
                    </div>
                </div>
                <div class="osahan-credits d-flex  p-3">
                    <form method="post" action="{{BASE}}{{empresa.link_site}}/perfil/telefone/u" id="form" class="full_page" enctype="multipart/form-data">
                        <p class="text-muted m-0 small">(Campos Obrigatório <span style="color:red;">*</span>)</p>
                        <div class="dados-usuario full_page">
                        <div class="col-md-6 pl-0 pr-0">
                        <div class="form-group">
                            <label class="text-dark" for="rua">Telefone<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="telefone" name="telefone" value="" required>
                           
                        </div>
                        </div>
                        </div>
                            <button id="btn-atualizar-end" class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnCadastro"><span>Alterar</span></button>
                            
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
{% if resulEnderecos > 0 %}
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footer.twig.php' %}
{% endif %}


{% endblock %}
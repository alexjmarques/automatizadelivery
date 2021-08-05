{% extends 'partials/body.twig.php'  %}

{% block title %}Cadastre-se - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="osahan-verifications">
    <div class="p-4 osahan-home-page">
        <h5>{{ usuarioLogado.nome }}</h5>
        <p class="text-dark text-50">Preciso de um endereço para entrega, mesmo se for retirada.</p>

        <form class="mt-4 mb-4" method="post" id="form" action="{{BASE}}{{empresa.link_site}}/endereco/pri/i" autocomplete="off">
        <h6 class="mt-4 pb-2 bold">Endereço para entrega <span style="color:red;">*</span></h6>
            <div class="form-group col-8 float-left pl-0 pr-0">
                <label for="telefone" class="text-dark">Rua <span style="color:red;">*</span></label>
                <input type="text" id="rua" name="rua" value="" class="form-control" autocomplete="off" required>
            </div>
            <div class="form-group col-4 float-left pr-0">
                <label for="telefone" class="text-dark">Número<span style="color:red;">*</span></label>
                <input type="text" id="numero" name="numero" value="" class="form-control" autocomplete="off" required>
            </div>

            <input type="hidden" id="cep" name="cep" value="">
            <input type="hidden" id="bairro" name="bairro" value="">
            <input type="hidden" id="cidade" name="cidade" value="{{empresaEndereco.cidade }}">
            <input type="hidden" id="estado" name="estado" value="{{empresaEndereco.estado }}">

            <div class="form-group">
                <label for="telefone" class="text-dark">Complemento ou referência <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="complemento" name="complemento" required autocomplete="off">
            </div>

            <div class="btn_acao"><div class="carrega"></div>
            <button class="btn btn-primary btn-lg btn-block acaoBtnCadastro">CADASTRAR</button>
            </div>
        </form>
    </div>

</div>
{% include 'partials/modalAlertSite.twig.php' %}

{% endblock %}
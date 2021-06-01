{% extends 'partials/body.twig.php'  %}

{% block title %}Carrinho - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}

<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white text-center">Confirmação de Dados</h5>
    </div>

<div class="p-3 osahan-cart-item osahan-home-page">
<form  method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/carrinho/cadastro/valida">
    <div class="bg-white rounded shadow mb-3 mt-n5">
    <p class="mb-0 text-left p-3 pb-0"><span class="sx-20">Olá, Tudo bem?</span> <br/> Poderia me informar seu nome é número de telefone!</p>
    
    <div class="form-row p-3 pb-0 m-0">
        <div class="form-group col-md-4 pb-0 mb-0">
        <label class="text-center">Seu nome <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="nome" name="nome" value="" required>
        </div>
    </div>

    <div class="form-row p-3 pb-0 m-0">
        <div class="form-group col-md-4 pb-0 mb-0">
        <label class="text-center">Seu Telefone <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="" required>
        </div>
    </div>
    </div>
    <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-success btn-block btn-lg acaoBtn btnValida">CONTINUAR</button>
</form>
</div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/modalValida.twig.php' %}

{% endblock %}

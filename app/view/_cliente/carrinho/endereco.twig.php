{% extends 'partials/body.twig.php'  %}
{% block title %}Carrinho - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}

<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white text-center">Endereço de Entrega</h5>
    </div>
<div class="p-3 osahan-cart-item osahan-home-page">
<form  method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/endereco/i" novalidate>
    <div class="bg-white rounded shadow mb-3 mt-n5">
    <p class="mb-0 text-center p-3 pb-0"><span class="sx-20">Legal <strong>{{nome}}</strong>!</span> <br/> Agora preciso que me inform o endereço para entrega!</p>
    
    <div class="form-row p-3 pb-0 m-0">
        <div class="form-group col-md-8 pb-0 mb-0 cepL">
            <label class="text-center">Rua <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="rua" name="rua" value="" required>
        </div>
        <div class="form-group col-md-2 pb-0 mb-0 numL">
            <label class="text-center">Número <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="numero" name="numero" required>
        </div>
    </div>
    <div class="form-row p-3 pb-0 m-0 pt-0">
        <div class="form-group col-md-4 pb-0 mb-0">
            <label class="text-center">Complemento ou Ponto de Referência <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="complemento" name="complemento">
        </div>
    </div>

    <div id="endOK" class="form-row cinza p-3 pb-0 m-0 " style="display: none;">
        <div class="form-group col-md-4 text-left pb-0 mb-0">
            <label class="text-left bold">Seu Endereço é? </label>
            <p class="mb-0 text-left color-theme-2 pb-2 full-width" ><span id="endPrint"></span>
        </p>
            
        </div>
    </div>
    </div>

    <input type="hidden" id="id_usuario" name="id_usuario">
    <input type="hidden" id="email" name="email">
    <input type="hidden" id="cep" name="cep">
    <input type="hidden" id="bairro" name="bairro">
    <input type="hidden" id="cidade" name="cidade">
    <select id="estado" name="estado" style="display: none;">
        {% for e in estadosSelecao %}
            <option value="{{ e.id }}">{{ e.uf }}</option>
        {% endfor %}
    </select>

    <input type="hidden" id="cidadePrinc" name="cidadePrinc" value="{{ empresa.cidade }}">
    {% for end in estadosSelecao %}
    {% if end.id == empresa.estado %}
    <input type="hidden" id="estadoPrinc" name="estadoPrinc" value="{{ end.uf }}">
    {% endif %}
    {% endfor %}
    <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
<button class="btn btn-success btn-block btn-lg acaoBtn btnValida">FINALIZAR CADASTRO</button>
</form>
</div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}

{% endblock %}

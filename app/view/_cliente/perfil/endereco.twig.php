{% extends 'partials/body.twig.php' %}

{% block title %}Endereço - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Novo Endereço</h5>
        {% if resulEnderecos > 0 %}
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/enderecos"> Voltar</a>
        {% endif %}
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="bg-white rounded shadow mt-n5">

                <div class="osahan-credits d-flex  p-3">

                    <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/endereco/i">
                        <p class="text-muted m-0 small text-right mb-3">(Campos Obrigatório <span style="color:red;">*</span>)</p>


                        <div class="form-group col-md-12 p-0 mb-3">
                            <label class="text-center">Endereço Principal <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="nome_endereco" name="nome_endereco" value="" required>
                        </div>


                        <div class="form-group col-md-12 p-0 mb-0">
                            <label class="text-dark" for="cidade">Endereço Atual para entrega?</label>
                            <select id="principal" name="principal" class="form-control select2-single" required>
                                <option value="">Selecione</option>
                                <option value="1" {% if enderecoAtivo.principal == 1 %}selected{% endif %}>Sim</option>
                                <option value="0" {% if enderecoAtivo.principal == 0 %}selected{% endif %}>Não</option>
                            </select>
                        </div>

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

                        <input type="hidden" id="id_usuario" name="id_usuario" value="{{usuarioAtivo.id}}">
                        <input type="hidden" id="email" name="email" value="{{usuarioAtivo.email}}">
                        <div class="btn_acao">
                            <div class="carrega"></div>
                            <button id="btn-atualizar-end" class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnCadastro"><span>Cadastrar</span></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
{% if resulEnderecos > 0 %}
{% if isLogin != 'undefined' %}
{% if isLogin != 0 %}
{% include 'partials/footer.twig.php' %}
{% endif %}
{% endif %}
{% endif %}

{% include 'partials/modalAlertSite.twig.php' %}

{% endblock %}
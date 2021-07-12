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
                        <div class="form-group enderecoCampo">
                            <svg class="landing-v2-address-search__pin-icon" width="22" height="23" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.835 17.274c-.555 0-1.058-.324-1.313-.855L4.305 9.635a5.985 5.985 0 0 1 .105-5.289c.81-1.56 2.22-2.557 3.855-2.731.367-.04.757-.04 1.125 0 1.635.174 3.037 1.172 3.855 2.731a5.96 5.96 0 0 1 .105 5.289.556.556 0 0 1-.758.269.62.62 0 0 1-.255-.8 4.726 4.726 0 0 0-.09-4.188c-.607-1.211-1.695-1.987-2.962-2.121a4.274 4.274 0 0 0-.9 0c-1.26.134-2.348.91-2.978 2.121a4.726 4.726 0 0 0-.082 4.188l3.217 6.785c.083.174.24.198.3.198s.218-.016.3-.198l1.613-3.412a.558.558 0 0 1 .757-.27.62.62 0 0 1 .255.8l-1.612 3.412c-.255.523-.758.855-1.32.855z" fill="currentColor"></path>
                                <path d="M8.835 9.555c-1.275 0-2.317-1.1-2.317-2.446 0-1.354 1.042-2.446 2.317-2.446 1.275 0 2.318 1.1 2.318 2.446.007 1.354-1.035 2.446-2.318 2.446zm0-3.705c-.66 0-1.192.563-1.192 1.26 0 .696.532 1.258 1.192 1.258.66 0 1.193-.562 1.193-1.259.007-.696-.533-1.259-1.193-1.259z" fill="currentColor"></path>
                            </svg>
                            <input type="text" class="form-control" id="ship-address" name="ship-address" placeholder="Digite o endereço com número" required autocomplete="off">
                        </div>
                        
                        <input type="hidden" id="rua" name="rua" value="" required>
                        <input type="hidden" id="numero" name="numero" value="" required>
                        <input type="hidden" id="cep" name="cep" value="">
                        <input type="hidden" id="cidade" name="cidade" value="">
                        <input type="hidden" id="bairro" name="bairro" value="">
                        <input type="hidden" id="estado" name="estado" value="">

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
{% include 'partials/footer.twig.php' %}
{% endif %}

{% include 'partials/modalAlertSite.twig.php' %}

{% endblock %}
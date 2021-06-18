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

              
                                <div class="form-group col-md-12 p-0 mb-3 ">
                                    <label class="text-center">Endereço Principal <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="nome_endereco" name="nome_endereco" value="" required>
                                </div>


                                <div class="form-group col-md-12 p-0 mb-0 ">
                                    <label class="text-dark" for="cidade">Endereço Atual para entrega?</label>
                                    <select id="principal" name="principal" class="form-control select2-single" required>
                                    <option value="">Selecione</option>
                                        <option value="1" {% if enderecoAtivo.principal == 1 %}selected{% endif %}>Sim</option>
                                        <option value="0" {% if enderecoAtivo.principal == 0 %}selected{% endif %}>Não</option>
                                    </select>
                                </div>
               
                            <div class="form-row p-0 pb-0 m-0 mt-3 pb-3">
                                <div class="form-group col-md-8 pb-0 mb-0 cepL pl-0">
                                    <label class="text-center">Endereço <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="rua" name="rua" value="" required>
                                </div>
                                <div class="form-group col-md-2 pb-0 mb-0 pr-0 numL">
                                    <label class="text-center">Número <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="numero" name="numero" required>
                                </div>
                            </div>
                            <div class="form-row p-0 pb-3 pt-3 m-0 pt-0 pl-0">
                                <div class="form-group col-md-4 pb-0 pl-0 pr-0 mb-0">
                                    <label class="text-center">Complemento ou Referência <span
                                            style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="complemento" name="complemento">
                                </div>
                            </div>

                            <div id="endOK" class="form-row cinza p-3 pb-0 m-0 mb-2" style="display: none;">
                                <div class="form-group col-md-4 text-left pb-0 mb-0">
                                    <label class="text-left bold">Seu Endereço é? </label>
                                    <p class="mb-0 text-left color-theme-2 pb-2 full-width"><span id="endPrint"></span>
                                    </p>

                                </div>
                            </div>
                       

                        <input type="hidden" id="id_usuario" name="id_usuario" value="{{usuarioAtivo.id}}">
                        <input type="hidden" id="email" name="email" value="{{usuarioAtivo.email}}">
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
                        <div class="btn_acao"><div class="carrega"></div>
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
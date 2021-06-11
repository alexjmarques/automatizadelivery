{% extends 'partials/body.twig.php'  %}

{% block title %}Endereço - {{empresa.nome_fantasia }}{% endblock %}

{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Novo Endereço: {{enderecoAtivo.nome_endereco}}</h5>
        {% if resulEnderecos > 0 %}
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/"> Voltar</a>
        {% endif %}
    </div>

    <div class="p-3 osahan-cart-item osahan-home-page">
        <div class="p-3 osahan-profile">
            <div class="bg-white rounded shadow mt-n5">
                <div class="d-flex  border-bottom p-3">
                    <div class="right">
                    <h6 class="mb-1 font-weight-bold text-left">Endereço de entrega </h6>
                    {% if resulEnderecos == 0 %}
                    <p class="text-muted m-0">Para efetuar um pedido, e necessario o cadastro do seu endereço de entrega!</p>
                    {% endif %}
                    </div>
                </div>
                <div class="osahan-credits d-flex  p-3">
                    <form method="post" autocomplete="off" action="{{BASE}}{{empresa.link_site}}/endereco/u" id="form" enctype="multipart/form-data">
                        <p class="text-muted m-0 small">(Campos Obrigatório <span style="color:red;">*</span>)</p>
                        <div class="dados-usuario row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label class="text-dark" for="rua">Apelido (ex.: Minha Casa, Casa da minha mãe)<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" placeholder="ex.: Minha Casa, Casa da minha mãe..." value="{{enderecoAtivo.nome_endereco}}" disabled>
                            <input type="hidden" class="form-control" id="nome_endereco" name="nome_endereco" placeholder="ex.: Minha Casa, Casa da minha mãe..." value="{{enderecoAtivo.nome_endereco}}">
                        </div>
                        </div>

                        <div class="col-md-5">
                        <div class="form-group">
                            <label class="text-dark" for="cep">CEP <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP" value="{{enderecoAtivo.cep}}" maxlength="9" required>
                        </div>
                        </div>
                        
                        <div class="col-md-9">
                        <div class="form-group">
                            <label class="text-dark" for="rua">Rua <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="rua" name="rua" placeholder="Nome da rua" value="{{enderecoAtivo.rua}}" required>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <div class="form-group">
                            <label class="text-dark" for="numero">Número <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="numero" name="numero" placeholder="Número" value="{{enderecoAtivo.numero}}" required>
                        </div>
                        </div>

                        <div class="col-md-12">
                        <div class="form-group">
                            <label class="text-dark" for="complemento">Complemento ou referência <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="complemento" name="complemento" placeholder="ex.: casa, conj, portão azul..." value="{{enderecoAtivo.complemento}}" required>
                        </div>
                        </div>

                        <div class="col-md-7">
                        <div class="form-group">
                            <label class="text-dark" for="bairro">Bairro <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" value="{{enderecoAtivo.bairro}}" required>
                        </div>
                        </div>
                        
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-dark" for="cidade">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" value="{{enderecoAtivo.cidade}}" required>
                        </div>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-dark" for="cidade">Estado</label>
                            <select id="estado" name="estado" class="form-control select2-single">
                                {% for e in estadosSelecao %}
                                {% if e.id == enderecoAtivo.estado %}
                                    <option selected value="{{ e.id }}">{{ e.uf }}</option>
                                 {% else %}
                                    <option value="{{ e.id }}">{{ e.uf }}</option>
                                {% endif %}
                                {% endfor %}
                            </select>
                        </div>
                        </div>
                        </div>
                            <input type="hidden" id="id" name="id" value="{{enderecoAtivo.id}}">
                            <input type="hidden" id="id_usuario" name="id_usuario" value="{{enderecoAtivo.id_usuario}}">
                            <input type="hidden" id="email" name="email" value="{{enderecoAtivo.email}}">
                            <button id="btn-atualizar-end" class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnCadastro"><span>Atualizar</span></button>
                            
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
{% include 'partials/footerMotoboy.twig.php' %}


{% endblock %}
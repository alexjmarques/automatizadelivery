{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 id="titleBy" data-id="{{plano[':id']}}">Plano - {{plano[':nome']}}</h1>
            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                <ol class="breadcrumb pt-0">
                    <li class="breadcrumb-item">
                        <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{BASE}}{{empresa.link_site}}/admin/planos">Planos</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{plano[':nome']}}</li>
                </ol>
            </nav>
            <div class="separator mb-5"></div>



            <form method="post" id="form" class="form" action="{{BASE}}{{empresa.link_site}}/admin/plano/selecionado/contratar" autocomplete="off" enctype="multipart/form-data">
            <div class="card mb-4">
                        <div class="card-body">
                        <table style="width: 100%">
                        <tbody>
                        <tr>
                            <td style="vertical-align:middle; border-radius: 3px; padding:30px; background-color: #f9f9f9; border-right: 5px solid white;">
                                <h3>Plano - {{plano[':nome']}}</h3>
                                <p>{{plano[':descricao']}}.</p>
                            </td>
                            <td style="vertical-align:middle; border-radius: 3px; padding:30px; background-color: #f9f9f9; border-right: 5px solid white;">
                                <strong>Valor:</strong> {{ moeda[':simbolo }} {{ plano[':valor']|number_format(2, ',', '.') }} (Mensal)</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <h5 class="mb-4 mt-3">Dados de Cobrança</h5>
                                <div class="form-row mt-4">
                                  <div class="form-group col-md-6">
                                      <label for="nome">Nome</label>
                                      <input type="text" class="form-control" id="nome" name="nome">
                                  </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">E-mail</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="inputPassword4">CPF</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf">
                                    </div>

                                    <div class="form-group col-md-6">
                                    <label>(DDD) + Número de Telefone</label>
                                    <div class="clearfix"></div>
                                    <div class="col-md-2 m-0 p-0 float-left"><input type="text" class="form-control" id="ddd" name="ddd" placeholder="11"></div>
                                    <div class="col-md-7 m-0 p-0 pl-2 float-left"><input type="text" class="form-control" id="celular" name="celular" placeholder="00000-0000"></div>
                                  </div>
                                  
                                </div>

                                <h5 class="mb-4 mt-3">Endereço de Cobrança</h5>
                                <div class="form-row">
                                  <div class="form-group col-md-2">
                                      <label>CEP</label>
                                      <input type="text" class="form-control" id="cep" name="cep" value="{{cep}}">
                                  </div>
                                
                                
                                  <div class="form-group col-md-6">
                                      <label>Endereço</label>
                                      <input type="text" class="form-control" id="rua" name="rua" required>
                                  </div>
                                  <div class="form-group col-md-1">
                                      <label>Número</label>
                                      <input type="text" class="form-control" id="numero" name="numero" required>
                                  </div>
                                  <div class="form-group col-md-3">
                                      <label>Complemento</label>
                                      <input type="text" class="form-control" id="complemento" name="complemento" required>
                                  </div>
                                
                                  <div class="form-group col-md-4">
                                      <label>Bairro</label>
                                      <input type="text" class="form-control" id="bairro" name="bairro">
                                  </div>
                                  <div class="form-group col-md-4">
                                      <label>Cidade</label>
                                      <input type="text" class="form-control" id="cidade" name="cidade">
                                  </div>

                                  <div class="form-group col-md-2">
                                          <label for="estado">Estado</label>
                                          <select id="estado" name="estado" class="form-control select2-single">
                                          <option value="">Selecione</option>
                                          {% for e in estadosSelecao %}
                                            {% if e[':id'] == estado %}
                                                <option selected value="{{ e[':id }}">{{ e[':uf }}</option>
                                              {% else %}
                                                <option value="{{ e[':id }}">{{ e[':uf }}</option>
                                              {% endif %}
                                            {% endfor %}
                                          </select>
                                      </div>
                                </div>

                       </div>
                        
                    </div>

                <div class="checkout col-md-12">
                   

                    <div class="credit-card-box col-md-5 pt-5 left">
                        <div class="card-wrapper"></div>
                    </div>

                    <div class="col-md-7 pt-3 pl-3 left">
                    <fieldset>
                        <label for="card-number">Número do cartão</label>
                        <input type="num" id="number" name="number" class="form-control">
                    </fieldset>
                    <fieldset class="pr-1">
                        <label for="card-holder">Titular do cartão</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </fieldset>
                    <fieldset class="fieldset-expiration col-md-4">
                        <label for="card-expiration-month">Data de validade</label>
                        <input type="text" name="expiry" id="expiry" class="form-control" maxlength="7">
                    </fieldset>
                    <fieldset class="fieldset-ccv col-md-4 pl-3">
                        <label for="card-ccv">CVV</label>
                        <input type="number" name="cvc" id="cvc" maxlength="3" class="form-control">
                    </fieldset>


                    <div class="clearfix"></div>
                    <input type="hidden" id="planNome" name="planNome" value="Plano {{plano[':nome']}}" />
                    <input type="hidden" id="valor" name="valor" value="{{plano[':valor']}}" />
                    <input type="hidden" id="planId" name="planId" value="{{plano[':planId']}}" />
                    
<button class="btn"><i class="fa fa-lock"></i> Pagar</button>
                </div>

                    <div class="clearfix"></div>
                </div>


            </form>
        </div>

    </div>
</div>
</div>
{% endblock %}
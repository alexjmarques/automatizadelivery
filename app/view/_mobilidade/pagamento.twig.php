{% extends 'partials/bodyHome.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTopWhite.twig.php' %}
<section class="section pt-5 pb-5">
   <div class="container big-table combo">
      <form method="post" autocomplete="off" id="form" action="{{BASE}}cadastro/empresa/pagamento/i" enctype="multipart/form-data">
         <div class="row">
            <div class="col-md-9 mx-auto bg-white p-4 rounded">
               <h5 class="mb-0">Dados de Cobrança</h4>
                  <p class="mb-4">Vamos agora finalizar inserindo os dados do seu cartão</p>
                  <div class="form-row mt-4">
                     <div class="form-group col-md-6">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{usuario.nome}}">
                     </div>
                     <div class="form-group col-md-6">
                        <label for="inputEmail4">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{usuario.email}}">
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

                  <h5 class="mb-0 mt-4">Endereço de Cobrança</h4>
                     <p class="mb-4">Vamos agora finalizar inserindo os dados do seu cartão</p>
                     <div class="form-row">
                        <div class="form-group col-md-2">
                           <label>CEP</label>
                           <input type="text" class="form-control" id="cep" name="cep" value="{{endereco.cep}}">
                        </div>


                        <div class="form-group col-md-6">
                           <label>Endereço</label>
                           <input type="text" class="form-control" id="rua" name="rua" value="{{endereco.rua}}" required>
                        </div>
                        <div class="form-group col-md-1">
                           <label>Número</label>
                           <input type="text" class="form-control" id="numero" name="numero" value="{{endereco.numero}}" required>
                        </div>
                        <div class="form-group col-md-3">
                           <label>Complemento</label>
                           <input type="text" class="form-control" id="complemento" name="complemento" value="{{endereco.complemento}}">
                        </div>

                        <div class="form-group col-md-4">
                           <label>Bairro</label>
                           <input type="text" class="form-control" id="bairro" name="bairro" value="{{endereco.bairro}}" >
                        </div>
                        <div class="form-group col-md-4">
                           <label>Cidade</label>
                           <input type="text" class="form-control" id="cidade" name="cidade" value="{{endereco.cidade}}" >
                        </div>

                        <div class="form-group col-md-2">
                           <label for="estado">Estado</label>
                           <input type="text" class="form-control" id="estado" name="estado" value="{{endereco.estado}}" >

                        </div>
                     </div>

                     <h5 class="mb-0 mt-4">Endereço de Cobrança</h4>
                        <p class="mb-4">Vamos agora finalizar inserindo os dados do seu cartão</p>
                        <div class="checkout col-md-12 pt-0 pl-0">

                           <div class="credit-card-box left pt-0 pl-0 pt-4">
                              <div class="card-wrapper"></div>
                           </div>
                           <div class="left pt-0 pl-0 ">
                              <fieldset>
                                 <label for="card-number">Número do cartão</label>
                                 <input type="num" id="number" name="number" class="form-control">
                              </fieldset>
                              <fieldset class="pr-1">
                                 <label for="card-holder">Titular do cartão</label>
                                 <input type="text" name="name" id="name" class="form-control">
                              </fieldset>
                              <fieldset class="fieldset-expiration float-left">
                                 <label for="card-expiration-month">Data de validade</label>
                                 <input type="text" name="expiry" id="expiry" class="form-control" maxlength="7">
                              </fieldset>
                              <fieldset class="fieldset-ccv pl-3 float-left">
                                 <label for="card-ccv">CVV</label>
                                 <input type="number" name="cvc" id="cvc" maxlength="3" class="form-control">
                              </fieldset>
                              <input type="hidden" id="planNome" name="planNome" value="Plano {{plano.nome}}" />
                              <input type="hidden" id="valor" name="valor" value="{{plano.valor}}" />
                              <input type="hidden" id="planId" name="planId" value="{{plano.plano_id}}" />
                              <input type="hidden" id="linkSite" name="linkSite" value="{{empresa.link_site}}" />
                           </div>

                           <div class="clearfix"></div>
                        </div>

            </div>
            <div class="grid-table combo col-md-3 p-0 pt-4">
               <div class="table-header-plan mx-auto bg-plans p-2 pl-4 pr-4 rounded-right">
                  <h4 class="float-left p-0 m-0 pt-4">{{ plano.nome }}</h4>
                  <p class="float-left p-0 m-0 pb-3">{{ plano.descricao }}</p>
                  {% if plano.valor == 0.00 %}
                  Valor: Grátis
                  {% else %}
                  Valor: <strong class="mt-3 size20">{{ moeda.simbolo }} {{ plano.valor }}</strong> (Mensal)
                  {% endif %}
                  <div class="btn_acao"><div class="carrega"></div>
                  <button class="btn btn-info d-block mt-3 p-3 pl-4 pr-4 acaoBtn">Finalizar Pedido <i class="fa fa-chevron-circle-right"></i></button>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</section>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/desktop/footer.twig.php' %}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="{{BASE}}adm/js/card.js"></script>
<script>
   /**
    * Checkout
    */
   if ($(".card-wrapper").length === 1) {
      new Card({
         form: document.querySelector('form'),
         container: '.card-wrapper',
         placeholders: {
            number: '•••• •••• •••• ••••',
            name: 'NOME TITULAR',
            expiry: '••/••',
            cvc: '•••'
         },
         masks: {
            cardNumber: '•' // optional - mask card number
         },
      });
   }
</script>
{% endblock %}
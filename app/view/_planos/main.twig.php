{% extends 'partials/body.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTopWhite.twig.php' %}
<section class="section pt-5 pb-5">
   <div class="container big-table combo">
      <form method="post" autocomplete="off" id="form" action="{{BASE}}cadastro/empresa/i" enctype="multipart/form-data">
      <div class="row">
         <div class="col-md-9 mx-auto bg-white p-4 rounded">
            <h5 class="mb-0">Conte-nos sobre seu estabelecimento.</h4>
               <p class="mb-4">Para criar sua conta e utilizar o nosso sistema preciso de algumas informações.</p>
                  <div class="form-row">
                     <div class="form-group col-md-4">
                        <label for="nomeFantasia">Nome Fantasia <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputEmail4">Razão Social <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="razao_social" name="razao_social" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputPassword4">CNPJ <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" value="" required>
                     </div>
                  </div>

                  <h5 class="mt-5">Onde seu estabelecimento esta localizado?</h4>
                     <p class="mb-4">Endereço de Funcionamento do estabelecimento, este endereço será utilizado para calcular a taxa de entrega para seus clientes.</p>
                     <div class="form-row">
                        <div class="form-group col-md-3">
                           <label>CEP <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="cep_end" name="cep_end" value="" required>
                        </div>
                        <div class="form-group col-md-5">
                           <label>Endereço <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="rua_end" name="rua_end" value="" required>
                        </div>
                        <div class="form-group col-md-1">
                           <label>Nº <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="numero_end" name="numero_end" value="" required>
                        </div>
                        <div class="form-group col-md-3">
                           <label>Complemento</label>
                           <input type="text" class="form-control" id="complemento_end" name="complemento_end" value="">
                        </div>
                     </div>
                     <div class="form-row">
                        <div class="form-group col-md-3">
                           <label>Bairro <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="bairro_end" name="bairro_end" value="" required>
                        </div>
                        <div class="form-group col-md-4">
                           <label>Cidade <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="cidade_end" name="cidade_end" value="" required>
                        </div>

                        <div class="form-group col-md-2">
                           <label>Estado <span style="color:red;">*</span></label>
                           <input type="text" class="form-control" id="estado_end" name="estado_end" limit="2" value="" required>
                        </div>
                     </div>

                     <h5 class="mt-5">Me fale um pouco sobre você</h4>
                     <p class="mb-4">Estas informações serão usadas para seu acesso de administrador.</p>
                     
                     <div class="form-row">
                     <div class="form-group col-md-6">
                        <label for="nomeFantasia">Nome Completo <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputEmail4">Email <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputPassword4">Telefone <span style="color:red;">*</span></label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputPassword4">Senha <span style="color:red;">*</span></label>
                        <input type="password" class="form-control" id="senha" name="senha" value="" required>
                     </div>
                  </div>
                  <input type="hidden" id="link_site" name="link_site" value="">
                  <input type="hidden" id="plano_id" name="plano_id" value="{{ plano.id }}">
                  
               
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

              <button class="btn btn-info d-block mt-3 p-3 pl-4 pr-4 acaoBtn">Finalizar Pedido <i class="fa fa-chevron-circle-right"></i></button>
            </div>
         </div>
      </div>
   </form>
   </div>
</section>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/desktop/footer.twig.php' %}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
document.getElementById('cnpj').addEventListener('input', function(e) {
  var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
  e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
});
</script>
{% endblock %}
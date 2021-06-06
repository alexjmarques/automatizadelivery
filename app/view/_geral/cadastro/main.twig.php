{% extends 'partials/body.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTopWhite.twig.php' %}
<section class="section pt-5 pb-5">
   <div class="container">
      <div class="row">
         <div class="col-md-10 mx-auto bg-white p-5 rounded">
            <h5 class="mb-0">Conte-nos sobre seu estabelecimento.</h4>
               <p class="mb-4">Para criar sua conta e utilizar o nosso sistema preciso de algumas informações.</p>
               <form method="post" id="form" action="{{BASE}}cadastro/empresa/i" enctype="multipart/form-data">
                  <div class="form-row">
                     <div class="form-group col-md-4">
                        <label for="nomeFantasia">Nome Fantasia</label>
                        <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputEmail4">Razão Social</label>
                        <input type="text" class="form-control" id="razao_social" name="razao_social" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputPassword4">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" value="" required>
                     </div>
                  </div>

                  <h5 class="mt-5">Onde seu estabelecimento esta localizado?</h4>
                     <p class="mb-4">Endereço de Funcionamento do estabelecimento, este endereço será utilizado para calcular a taxa de entrega para seus clientes.</p>
                     <div class="form-row">
                        <div class="form-group col-md-3">
                           <label>CEP</label>
                           <input type="text" class="form-control" id="cep" name="cep" value="" required>
                        </div>
                        <div class="form-group col-md-5">
                           <label>Endereço</label>
                           <input type="text" class="form-control" id="rua" name="rua" value="" required>
                        </div>
                        <div class="form-group col-md-1">
                           <label>Número</label>
                           <input type="text" class="form-control" id="numero" name="numero" value="" required>
                        </div>
                        <div class="form-group col-md-3">
                           <label>Complemento</label>
                           <input type="text" class="form-control" id="complemento" name="complemento" value="" required>
                        </div>
                     </div>
                     <div class="form-row">
                        <div class="form-group col-md-3">
                           <label>Bairro</label>
                           <input type="text" class="form-control" id="bairro" name="bairro" value="" required>
                        </div>
                        <div class="form-group col-md-4">
                           <label>Cidade</label>
                           <input type="text" class="form-control" id="cidade" name="cidade" value="" required>
                        </div>

                        <div class="form-group col-md-2">
                           <label>Estado</label>
                           <input type="text" class="form-control" id="estado" name="estado" limit="2" value="" required>
                        </div>
                     </div>

                     <h5 class="mt-5">Me fale um pouco sobre você</h4>
                     <p class="mb-4">Estas informações serão usadas para seu acesso de administrador.</p>
                     
                     <div class="form-row">
                     <div class="form-group col-md-6">
                        <label for="nomeFantasia">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputEmail4">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputPassword4">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="" required>
                     </div>
                     <div class="form-group col-md-4">
                        <label for="inputPassword4">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" value="" required>
                     </div>
                  </div>
                  <input type="hidden" id="link_site" name="link_site" value="">
                  <button class="btn btn-info d-block mt-3 p-3 pl-4 pr-4 acaoBtn">Cadastrar</button>
               </form>
         </div>
      </div>
   </div>
</section>
{% include 'partials/desktop/footer.twig.php' %}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
document.getElementById('cnpj').addEventListener('input', function(e) {
  var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
  e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
});
</script>
{% endblock %}
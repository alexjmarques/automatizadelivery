{% extends 'partials/body.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTopWhite.twig.php' %}
<section class="section pt-0 pb-0 bg-white becomemember-section border-bottom">
   <div class="row ml-0 mr-0 overflow-hidden parallax-content position-relative">
      <img src="/img/bg-capa.jpg" alt="Automatiza Delivery e E-Moving Mobilidade Urbana">
      <div class="container position-absolute p-5 pl-0 align-center">
         <div class="section-header text-left white-text position-absolute text-white p-4 mt-4 bg-green">
            <h2 class="text-white">Pensando em Mobilidade</h2>
            <p class="text-white">Pensou <strong>Automatiza Delivery</strong> e <strong>E-Moving Mobilidade Urbana</strong> a primeira <br>empresa de assinatura de bicicletas elétricas e a única empresa <br>com gestão eficiente para seu Delivery do Brasil! </p>
            <p class="text-white">Solução para quem procura liberdade em suas entregas!</p>
         </div>
         <div class="clearfix"></div>
      </div>
   </div>
</section>

<section class="section pt-0 pb-0 bg-white becomemember-section border-bottom bg-city">
   <div class="row ml-0 mr-0 overflow-hidden">
      <div class="container">

         <div class="col-sm-6 float-left pt-5 pb-5">
            <div class="section-header text-left white-text">
               <h2>Mobilidade para seu Delivery</h2>
               <p>Soluções pensada de ponta a ponta</p>
               <span class="line"></span>
            </div>
            <p>Cliente liga, manda mensagem reclamando do tempo de entrega, e você do outro lado aguardando a chegado do entregador de Aplicativo!
               <br><br>Pensando nisso lançamos planos para sua empresa não precisar mais de entregadores tercerizados.
            </p>

            <p>Conheça o <strong>Delivery Mobilidade</strong>, com ele além de contar com nosso sistema de gestão eficiente, você pode contratar Bikes Elétricas para as entregas de seus pedidos.</p>

            <p>Tendo assim o controle total das entregas feitas, melhorando o tempo de entrega de cada pedido.</p>

            <div class="clearfix"></div>
         </div>
         <div class="col-sm-6 float-left parallax-content">
            <img src="/img/delivery-bike.png" alt="Automatiza Delivery e E-Moving Mobilidade Urbana">
         </div>
         <!-- <div class="row">
         <div class="col-sm-12 text-center">
            <a href="register.html" class="btn btn-success btn-lg">
               Create an Account <i class="fa fa-chevron-circle-right"></i>
            </a>
         </div>
      </div> -->

      </div>
   </div>
</section>

<section class="section pt-5 pb-5">
   <div class="container big-table combo">
      <div class="section-header text-center">
         <h2>Planos de Mobilidade</h2>
         <p>Escolha abaixo a opção que mais se encaixa na operação do seu estabelecimento</p>
         <span class="line"></span>
      </div>

      <div class="row mb-5">
         <div class="col-md-6">
            <div class=" mx-auto bg-white p-4 rounded">
               <h5 class="mb-0">Plano Start Mobilidade</h4>
                  <p class="mb-4">Pensado para empresas de pequeno porte com volume de até 200 pedidos no mês.</p>



                  <div class="form-row">

                     <div class="form-group col-md-7">
                        <div class="card-body pt-3">
                           <ul class="list-unstyled mb-4">
                              <li class="text-successs"><i class="fa fa-check"></i> Plano Inicial R$ 59,90</li>
                              <li class="text-successs"><i class="fa fa-check"></i> 1 Bicicleta Eletrica R$ 289,00</li>
                              <li class="text-successs"><i class="fa fa-check"></i> Seguro R$ 19,90</li>
                           </ul>
                        </div>
                     </div>

                     <div class="form-group col-md-5">
                        <div class="elementor-price-table__price price_ull">
                           <span class="elementor-price-table__currency elementor-currency--before">R$</span> <span class="elementor-price-table__integer-part">368</span>
                           <div class="elementor-price-table__after-price">
                              <span class="elementor-price-table__fractional-part">80</span>
                           </div>
                           <span class="elementor-price-table__period elementor-typo-excluded text-right pr-5 pt-2">Custo Mensal</span>
                        </div>

                     </div>


                  </div>

                  <a href="#" class="btn btn-success btn-lg mt-1 float-left">Eu quero <i class="fa fa-chevron-circle-right"></i></a>

            </div>
         </div>
         <div class="col-md-6">
            <div class="mx-auto bg-white p-4 rounded">
               <h5 class="mb-0">Plano Mobilidade a Mil</h4>
                  <p class="mb-4">Com esse plano você conta com mais de 1 Bike, indicado para empresas que necessita de mais entregadores.</p>
                  <div class="form-row">

                     <div class="form-group col-md-7">
                        <div class="card-body pt-3">
                           <ul class="list-unstyled mb-4">
                              <li class="text-successs"><i class="fa fa-check"></i> Plano Inicial R$ 129,90</li>
                              <li class="text-successs"><i class="fa fa-check"></i> 2 Bicicletas Eletrica R$ 558,00</li>
                              <li class="text-successs"><i class="fa fa-check"></i> Seguro R$ 19,90 (por bicicleta)</li>
                           </ul>
                        </div>
                     </div>

                     <div class="form-group col-md-5">
                        <div class="elementor-price-table__price price_ull">
                           <span class="elementor-price-table__currency elementor-currency--before">R$</span> <span class="elementor-price-table__integer-part">726</span>
                           <div class="elementor-price-table__after-price">
                              <span class="elementor-price-table__fractional-part">80</span>
                           </div>
                           <span class="elementor-price-table__period elementor-typo-excluded text-right pr-5 pt-2">Custo Mensal</span>
                        </div>

                     </div>


                  </div>

                  <a href="#" class="btn btn-success btn-lg mt-1 float-right">Eu quero <i class="fa fa-chevron-circle-right"></i></a>

            </div>
         </div>
      </div>
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
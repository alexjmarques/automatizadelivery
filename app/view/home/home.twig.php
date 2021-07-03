{% extends 'partials/bodyHome.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Sistema de Gestão de Pedidos') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
<div class="homepage-header">
      <div class="overlay"></div>
{% include 'partials/desktop/menuTop.twig.php' %}
<section class="pt-5 pb-5 homepage-search-block position-relative">
   <div class="banner-overlay"></div>
   <div class="container">
      <div class="row d-flex align-items-center py-lg-4 pt-5">
         <div class="navbar-nav col-lg-6 mx-auto">
            <div class="homepage-search-title text-center pb-5">
               <h1 class="mb-2 display-4 text-shadow text-white font-weight-normal"><span class="font-weight-bold">Sistema de Gestão de Pedidos</span></h1>
               <h5 class="mb-5 text-shadow text-white-50 font-weight-normal">Organize a operação do seu estabelecimento flexibilizando seu tempo, a sua gestão e o seu negócio!</h5>
               <a href="#inicio" class="btn btn-success btn-lg anchor">Saiba mais</a>
            </div>
         </div>
      </div>
   </div>
</section>
</div>
<section class="section pt-5 pb-5 bg-white homepage-add-section">
   <div class="container">
      <div class="row">
         {% for emp in empresas|sort|slice(2,6) %}
         <div class="col-md-4">
            <a href="{{BASE}}{{ emp.link_site }}">
               <div class="bg-white shadow-sm rounded align-items-center p-1 mb-4 flex-column">

                  <div class="col-md-4 p-1 float-left">
                  {% if emp.logo is null %}
                  <img src="{{BASE}}uploads/no-foto.png" class="img-float">
                  {% else %}
                     <img src="{{BASE}}uploads/{{ emp.logo }}" class="img-float">
                  {% endif %}
                  </div>
                  <div class="col-md-8 py-2 float-left pl-0">
                     <p class="mb-0 text-black font-weight-bold size18">{{ emp.nome_fantasia }}</p>
                     {# {% for cat in categoria %}
                     {% if cat.id == emp.id_categoria %}
                     <-- p class="small mb-1 text-dark">{{cat.nome }}</p-->
                     {% endif %}
                     {% endfor %} #}
                     <p class="small mb-1 text-dark">
                     Telefone: ({{ emp.telefone[:2] }}) {{ emp.telefone|slice(2, 5) }}-{{ emp.telefone|slice(7, 9) }}
                     </p>

                  </div>
                  <div class="clearfix"></div>
               </div>
            </a>
         </div>
         {% endfor %}
      </div>
   </div>
</section>

<section class="section homepage-add-section bg_full" id="inicio">
   <div class="container">
      <div class="row">
         <div class="col-md-7 col-6">
            <h2 class="pt-5 mt-4 text-white">Organize a operação do seu estabelecimento</h2>
            <p class="text-white size20 pt-3">A operação do seu restaurante esta desorganizada, pois você recebe pedidos via WhatsApp, Facebook, Instagram, Mesa, Balcão e Marketplaces (iFood, UberEats)?<br>Com a Automatiza.App, você centraliza seus pedidos em um só lugar e organiza toda a sua operação.</p>

            <a href="https://automatizadelivery.com.br/automatiza-delivery" target="_blank" class="elementor-button-vaz" role="button">
               <span class="elementor-button-content-wrapper"><span class="elementor-button-text">Conheça o Sistema</span></span>
            </a>
         </div>
         <div class="col-md-5 col-6 pt-5 pl-5 pr-5 image_effect">
            <img alt="" src="{{BASE}}img/capaSistema-e.png">
         </div>

      </div>
   </div>
</section>
<section class="section pt-5 pb-5 products-section">
   <div class="container">
      <div class="section-header text-center">
         <h2>Saiba como nosso sistema funciona!</h2>
         <p>Veja como e simples e prático o recebimento dos pedidos.</p>
         <span class="line"></span>
      </div>
      <div class="row">
         <div class="col-md-3 text-center">
            <div class="qodef-shortcode qodef-m  qodef-icon-with-text qodef-layout--top qodef--icon-pack qodef-alignment--center">
               <div class="qodef-m-icon-wrapper">
                  <span class="qodef-shortcode qodef-m  qodef-icon-holder qodef-size--medium qodef-layout--square" style="background-color: #880A1F;border-radius: 50px"> <span class="qodef-icon-font-awesome fa fa-link qodef-icon qodef-e" style="color: #FFFFFF"></span> </span>
               </div>
               <div class="qodef-m-content">
                  <h5 class="qodef-m-title mt-3 mb-2">
                     <span class="qodef-m-title-text">Cliente recebe o link</span>
                  </h5>
                  <p class="qodef-m-text">Você disponibiliza para seu cliente o link do seu cardápio através das Redes Sociais, Folder ou QrCode.</p>
               </div>
            </div>
         </div>

         <div class="col-md-3 text-center">
            <div class="qodef-shortcode qodef-m  qodef-icon-with-text qodef-layout--top qodef--icon-pack qodef-alignment--center">
               <div class="qodef-m-icon-wrapper">
                  <span class="qodef-shortcode qodef-m  qodef-icon-holder qodef-size--medium qodef-layout--square" style="background-color: #880A1F;border-radius: 50px"> <span class="qodef-icon-font-awesome fa fa-list-alt qodef-icon qodef-e" style="color: #FFFFFF"></span> </span>
               </div>
               <div class="qodef-m-content">
                  <h5 class="qodef-m-title mt-3 mb-2">
                     <span class="qodef-m-title-text">Cliente faz pedido</span>
                  </h5>
                  <p class="qodef-m-text">Com um processo rápido e prático seu cliente faz o pedido e em poucos minutos você recebe em seu painel.</p>
               </div>
            </div>
         </div>

         <div class="col-md-3 text-center">
            <div class="qodef-shortcode qodef-m  qodef-icon-with-text qodef-layout--top qodef--icon-pack qodef-alignment--center">
               <div class="qodef-m-icon-wrapper">
                  <span class="qodef-shortcode qodef-m  qodef-icon-holder qodef-size--medium qodef-layout--square" style="background-color: #880A1F;border-radius: 50px"> <span class="qodef-icon-font-awesome fa fa-utensils qodef-icon qodef-e" style="color: #FFFFFF"></span> </span>
               </div>
               <div class="qodef-m-content">
                  <h5 class="qodef-m-title mt-3 mb-2">
                     <span class="qodef-m-title-text">Interagindo com cliente</span>
                  </h5>
                  <p class="qodef-m-text">Informe seu cliente a cada passo da preparação do pedido.</p>
               </div>
            </div>
         </div>

         <div class="col-md-3 text-center">
            <div class="qodef-shortcode qodef-m  qodef-icon-with-text qodef-layout--top qodef--icon-pack qodef-alignment--center">
               <div class="qodef-m-icon-wrapper">
                  <span class="qodef-shortcode qodef-m  qodef-icon-holder qodef-size--medium qodef-layout--square" style="background-color: #880A1F; border-radius: 50px"> <span class="qodef-icon-font-awesome fa fa-truck qodef-icon qodef-e" style="color: #FFFFFF"></span> </span>
               </div>
               <div class="qodef-m-content">
                  <h5 class="qodef-m-title mt-3 mb-2">
                     <span class="qodef-m-title-text">Entrega e Retirada</span>
                  </h5>
                  <p class="qodef-m-text">Facilidade para o cliente e seu estabelecimento com opções de entrega e retirada do pedido.</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="section pt-5 pb-5 products-section bg-cian" id="planos">
   <div class="container">
      <div class="section-header text-center">
         <h2>Solução completa</h2>
         <p>Escolha abaixo a opção que mais se encaixa na operação do seu estabelecimento</p>
         <span class="line"></span>
      </div>
      <div class="row">

         <div class="pricing col-md-12 mb-3">
         <div class="col-md-3 float-left">
               <div class="card card-pricing text-center px-3 mb-4 ">
                  <div class="header_plan">
                     <h2>Grátis</h2>
                     <span>Conheça e profissionalize.</span>
                  </div>
                  <div class="bg-transparent card-header pt-4 border-0">
                     <div class="elementor-price-table__price">
                         <span class="elementor-price-table__integer-part text-success">Grátis</span>
                        
                     </div>
                  </div>
                  <div class="card-body pt-0">
                     <ul class="list-unstyled mb-4">
                        <li>50 Pedidos por mês</li>
                        <li>Hospedagem e SSL</li>
                     </ul>
                     <a class="elementor-price-table__button elementor-button elementor-size-md" href="{{BASE}}cadastro/empresa/gratis" rel="nofollow">Cadastrar</a>
                  </div>
               </div>
            </div>


            <div class="col-md-3 float-left">
               <div class="card card-pricing text-center px-3 mb-4 ">
                  <div class="header_plan">
                     <h2>Inicial</h2>
                     <span>Profissionalize seu atendimento.</span>
                  </div>
                  <div class="bg-transparent card-header pt-4 border-0">
                     <div class="elementor-price-table__price">
                        <div class="elementor-price-table__original-price elementor-typo-excluded">R$80</div>
                        <span class="elementor-price-table__currency elementor-currency--before">R$</span> <span class="elementor-price-table__integer-part">59</span>
                        <div class="elementor-price-table__after-price">
                           <span class="elementor-price-table__fractional-part">90</span>
                        </div>
                        <span class="elementor-price-table__period elementor-typo-excluded">Mensal</span>
                     </div>
                  </div>
                  <div class="card-body pt-0">
                     <ul class="list-unstyled mb-4">
                        <li>200 Pedidos por mês</li>
                        <li>Hospedagem e SSL</li>
                     </ul>
                     <a class="elementor-price-table__button elementor-button elementor-size-md" href="{{BASE}}cadastro/empresa/inicial" rel="nofollow">Tenho Interesse</a>
                  </div>
               </div>
            </div>

            <div class="col-md-3 float-left">
               <div class="card card-pricing popular shadow text-center px-3 mb-4">
                  <div class="header_plan gold">
                     <h2>Intermediario</h2>
                     <span>Muito mais eficiência.</span>
                  </div>
                  <div class="bg-transparent card-header pt-4 border-0">
                     <div class="elementor-price-table__price">
                        <div class="elementor-price-table__original-price elementor-typo-excluded">R$200</div>
                        <span class="elementor-price-table__currency elementor-currency--before">R$</span> <span class="elementor-price-table__integer-part">129</span>
                        <div class="elementor-price-table__after-price">
                           <span class="elementor-price-table__fractional-part">90</span>
                        </div>


                        <span class="elementor-price-table__period elementor-typo-excluded">Mensal</span>
                     </div>
                  </div>
                  <div class="card-body pt-0">
                     <ul class="list-unstyled mb-4">
                        <li>1000 Pedidos por mês</li>
                        <li>Hospedagem e SSL</li>
                        <li>Suporte Profissional</li>
                     </ul>
                     <a class="elementor-price-table__button elementor-button elementor-size-md gold" href="{{BASE}}cadastro/empresa/intermediario" rel="nofollow">Tenho Interesse</a>
                  </div>
               </div>
            </div>
            <div class="col-md-3 float-left">

               <div class="card card-pricing text-center px-3 mb-4">
                  <div class="header_plan">
                     <h2>Essencial</h2>
                     <span>Turbine seu atendimento.</span>
                  </div>
                  <div class="bg-transparent card-header pt-4 border-0">
                     <div class="elementor-price-table__price">
                        <div class="elementor-price-table__original-price elementor-typo-excluded">R$300</div>
                        <span class="elementor-price-table__currency elementor-currency--before">R$</span> <span class="elementor-price-table__integer-part">199</span>
                        <div class="elementor-price-table__after-price">
                           <span class="elementor-price-table__fractional-part">90</span>
                        </div>
                        <span class="elementor-price-table__period elementor-typo-excluded">Mensal</span>
                     </div>
                  </div>
                  <div class="card-body pt-0">
                     <ul class="list-unstyled mb-4">
                        <li>Pedidos Ilimitados</li>
                        <li>Hospedagem e SSL</li>
                        <li>Chat e Avaliação</li>
                        <li>Suporte Profissional</li>
                     </ul>
                     <a class="elementor-price-table__button elementor-button elementor-size-md" href="{{BASE}}cadastro/empresa/essencial" rel="nofollow">Tenho Interesse</a>
                  </div>
               </div>
            </div>

         </div>
         
      </div>
      <div class="container">
         <div class="col-sm-12 block-center bg-white text-center p-5 rounded">
                  <h5 class="m-0 mb-2">Procurando por uma solução completa?</h5>
                  <p class="mb-4">Pedidos Ilimitados, Hospedagem e SSL, Chat e Avaliação, Suporte Profissional, <br/>Integração com Marketplaces e muito mais</p>
                  <a href="https://api.whatsapp.com/send?phone=11980309212&text=Ol%C3%A1!%20Tenho%20Interesse%20na%20Solu%C3%A7%C3%A3o%20Completa" class="elementor-price-table__button elementor-button elementor-size-md gold" target="_blank">Consulte <i class="fa fa-chevron-circle-right"></i></a>
               </div>
</div>
   </div>
</section>


<section class="section pt-5 pb-5 products-section" id="recursos">
   <div class="container">
      <div class="section-header text-center">
         <h2>Lista de recursos</h2>
         <p>Confira os recursos de cada plano disponível.</p>
         <span class="line"></span>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="big-table combo">
               <div class="w-layout-grid grid-table combo">
                  <div id="w-node-_2b3e4311-3a77-c335-17b0-00285d56406f-4c9858f6" class="table-header">
                     <div class="box-plan border-left">
                        <div class="text-label">Inicial</div>
                     </div>
                     <div class="box-plan table-ss">
                        <div class="text-label essencial-combo">Intermediario</div>
                     </div>
                     <div class="box-plan border-right">
                        <div class="text-label">Essencial</div>
                     </div>
                     <div class="box-plan border-right">
                        <div class="text-label">Solução Completa</div>
                     </div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Cardápio virtual<br></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line negative">
                     <div class="label-line-table">Gestão de Produtos e categorias</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Pedidos de delivery via peinel personalizado</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line negative">
                     <div class="label-line-table">Pedidos via cardápio QR Code ou Link</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Personalizado com a marca do seu negócio</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line negative">
                     <div class="label-line-table">Gerenciamento dos Pedidos</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Acompanhamento de status do pedido pelo cliente</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line negative">
                     <div class="label-line-table">Modos de operação: Delivery e Balcão</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Customização de opcionais nos Produtos</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line negative">
                     <div class="label-line-table">Configuração de taxa de entrega por distância (km)</div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Gestão de Motoboys</div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>

                  <div class="table-line negative">
                     <div class="label-line-table">Gestão de entrega para os Motoboys</div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>

                  <div class="table-line">
                     <div class="label-line-table">Rota e dados do pedido para Motoboy</div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line negative">
                     <div class="label-line-table">Ação de Entrega ou cancelamento do pedido pelo Motoboy</div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Relatórios de Vendas</div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>

                  <div class="table-line negative">
                     <div class="label-line-table">Relatório de Entregas Feitas</div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Relatório dos pedidos do Delivery</div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line negative">
                     <div class="label-line-table">Cupom de Desconto e CashBack*</div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac528b5331320c0edbd231_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Gestão de Atendentes</div>
                     <div class="box-check"></div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line negative">
                     <div class="label-line-table">Impressão de pedidos</div>
                     <div class="box-check"></div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>
                  <div class="table-line">
                     <div class="label-line-table">Integração Ifood*</div>
                     <div class="box-check"></div>
                     <div class="box-check"></div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>

                  <div class="table-line negative">
                     <div class="label-line-table">Integração UberEats*</div>
                     <div class="box-check"></div>
                     <div class="box-check"></div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>

                  <div class="table-line">
                     <div class="label-line-table">Integração meios de Pagamento*</div>
                     <div class="box-check"></div>
                     <div class="box-check"></div>
                     <div class="box-check"></div>
                     <div class="box-check"><img src="{{BASE}}img/5fac1be1edab0b4a48172452_uil_check-combo.svg" loading="lazy" alt=""></div>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="section pt-0 pb-0 bg-white becomemember-section border-bottom">
   <div class="row ml-0 mr-0 overflow-hidden">
   <div class="container">
   
      <div class="col-sm-6 float-left pt-5 pb-5">
      <div class="section-header text-left white-text">
         <h2>Pensando em Mobilidade</h2>
         <p>Automatiza Delivery e E-Moving Mobilidade Urbana</p>
         <span class="line"></span>
      </div>
         <p>Em parceria com a E-Moving lançamos o plano Delivery mobilidade, com ele seu estabelecimento além de contar com nosso sitema de gestão conta também com Bicicletas elétricas para fazer as entregas! </p>

         <p>Conheça mas da <a href="https://e-moving.com.br/" target="_blank">E-Moving Mobilidade Urbana</a></p>
         <img src="{{BASE}}img/logo-e-moving-escuro.svg" class="float-left mt-4 mb-4" alt="E-Moving Mobilidade Urbana" width="200px">
<div class="clearfix"></div>
         <a href="{{BASE}}mobilidade/nossos-planos" class="btn btn-success btn-lg mt-3 float-left">Quero Mobilidade <i class="fa fa-chevron-circle-right"></i></a>
      </div>
      <div class="col-sm-6 float-left parallax-content">
         <img src="{{BASE}}img/delivery2.jpg" class="desk" alt="Automatiza Delivery e E-Moving Mobilidade Urbana">
         <img src="{{BASE}}img/delivery-bike.png" class="mobile" alt="Automatiza Delivery e E-Moving Mobilidade Urbana">
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
{% include 'partials/desktop/footer.twig.php' %}
{% endblock %}
{% extends 'partials/body.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTop.twig.php' %}
<section class="pt-5 pb-5 homepage-search-block position-relative">
   <div class="banner-overlay"></div>
   <div class="container">
      <div class="row d-flex align-items-center py-lg-4">
         <div class="col-lg-6 mx-auto">
            <div class="homepage-search-title text-center">
               <h1 class="mb-2 display-4 text-shadow text-white font-weight-normal"><span class="font-weight-bold">Sistema de Gestão de Pedidos</span></h1>
               <h5 class="mb-5 text-shadow text-white-50 font-weight-normal">Organize a operação do seu estabelecimento flexibilizando seu tempo, a sua gestão e o seu negócio!</h5>
               <a href="#" class="btn btn-success btn-lg">Saiba mais</a>
            </div>
         </div>
      </div>
   </div>
</section>
</div>
<section class="section pt-5 pb-5 bg-white homepage-add-section">
   <div class="container">
      <div class="row">
         <div class="col-md-3 col-6">
            <div class="products-box">
               <a href="listing.html"><img alt="" src="{{BASE}}img/pro1.jpg" class="img-fluid rounded"></a>
            </div>
         </div>
         <div class="col-md-3 col-6">
            <div class="products-box">
               <a href="listing.html"><img alt="" src="{{BASE}}img/pro2.jpg" class="img-fluid rounded"></a>
            </div>
         </div>
         <div class="col-md-3 col-6">
            <div class="products-box">
               <a href="listing.html"><img alt="" src="{{BASE}}img/pro3.jpg" class="img-fluid rounded"></a>
            </div>
         </div>
         <div class="col-md-3 col-6">
            <div class="products-box">
               <a href="listing.html"><img alt="" src="{{BASE}}img/pro4.jpg" class="img-fluid rounded"></a>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="section homepage-add-section bg_full">
   <div class="container">
      <div class="row">
         <div class="col-md-7 col-6">
            <h2 class="pt-5 mt-4 text-white">Organize a operação do seu estabelecimento</h2>
            <p class="text-white size20 pt-3">A operação do seu restaurante esta desorganizada, pois você recebe pedidos via WhatsApp, Facebook, Instagram, Mesa, Balcão e Marketplaces (iFood, UberEats)?<br>Com a Automatiza.App, você centraliza seus pedidos em um só lugar e organiza toda a sua operação.</p>

            <a href="https://automatizadelivery.com.br/teste" target="_blank" class="elementor-button-link elementor-button elementor-size-md" role="button">
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

<section class="section pt-5 pb-5 products-section bg-cian">
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
                     <a class="elementor-price-table__button elementor-button elementor-size-md" href="{{BASE}}plano/inicial" rel="nofollow">Tenho Interesse</a>
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
                     <a class="elementor-price-table__button elementor-button elementor-size-md gold" href="{{BASE}}plano/intermediario" rel="nofollow">Tenho Interesse</a>
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
                     <a class="elementor-price-table__button elementor-button elementor-size-md" href="{{BASE}}plano/essencial" rel="nofollow">Tenho Interesse</a>
                  </div>
               </div>
            </div>

            <div class="col-md-3 float-left">
               <div class="card card-pricing text-center px-3 mb-4">
                  <div class="header_plan">
                     <h2>Solução Completa</h2>
                     <span>Integre e receba todos os pedidos.</span>
                  </div>
                  <div class="bg-transparent card-header pt-4 border-0">
                     <div class="elementor-price-table__price">
                        
                        <span class="elementor-price-table__integer-part mb-2" style="font-size: 36px;">Consulte!</span>
                        
                        <span class="elementor-price-table__period elementor-typo-excluded">Entre em contato e saiba mais</span>
                     </div>
                  </div>
                  <div class="card-body pt-0">
                     <ul class="list-unstyled mb-4">
                        <li>Pedidos Ilimitados</li>
                        <li>Hospedagem e SSL</li>
                        <li>Chat e Avaliação</li>
                        <li>Suporte Profissional</li>
                     </ul>
                     <a class="elementor-price-table__button elementor-button elementor-size-md" href="{{BASE}}solucao-completa" rel="nofollow">Tenho Interesse</a>
                  </div>
               </div>

            </div>
         </div>
      </div>


   </div>
</section>

<section class="section pt-5 pb-5 products-section">
   <div class="container">
      <div class="section-header text-center">
         <h2>Lista de recursos</h2>
         <p>Confira os recursos de cada plano disponível.</p>
         <span class="line"></span>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="owl-carousel owl-carousel-four owl-theme">
               <div class="item">
                  <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                     <div class="list-card-image">
                        <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                        <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i class="icofont-heart"></i></a></div>
                        <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                        <a href="detail.html">
                           <img src="{{BASE}}img/list/1.png" class="img-fluid item-img">
                        </a>
                     </div>
                     <div class="p-3 position-relative">
                        <div class="list-card-body">
                           <h6 class="mb-1"><a href="detail.html" class="text-black">World Famous</a></h6>
                           <p class="text-gray mb-3">North Indian • American • Pure veg</p>
                           <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i> 20–25 min</span> <span class="float-right text-black-50"> $250 FOR TWO</span></p>
                        </div>
                        <div class="list-card-badge">
                           <span class="badge badge-success">OFFER</span> <small>65% off | Use Coupon OSAHAN50</small>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                     <div class="list-card-image">
                        <div class="star position-absolute"><span class="badge badge-warning"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                        <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i class="icofont-heart"></i></a></div>
                        <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                        <a href="detail.html">
                           <img src="{{BASE}}img/list/3.png" class="img-fluid item-img">
                        </a>
                     </div>
                     <div class="p-3 position-relative">
                        <div class="list-card-body">
                           <h6 class="mb-1"><a href="detail.html" class="text-black">Bite Me Sandwiches</a></h6>
                           <p class="text-gray mb-3">North Indian • Indian • Pure veg</p>
                           <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i> 15–25 min</span> <span class="float-right text-black-50"> $100 FOR TWO</span></p>
                        </div>
                        <div class="list-card-badge">
                           <span class="badge badge-danger">OFFER</span> <small>65% off | Use Coupon OSAHAN50</small>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                     <div class="list-card-image">
                        <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                        <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i class="icofont-heart"></i></a></div>
                        <div class="member-plan position-absolute"><span class="badge badge-danger">Promoted</span></div>
                        <a href="detail.html">
                           <img src="{{BASE}}img/list/6.png" class="img-fluid item-img">
                        </a>
                     </div>
                     <div class="p-3 position-relative">
                        <div class="list-card-body">
                           <h6 class="mb-1"><a href="detail.html" class="text-black">The osahan Restaurant
                              </a>
                           </h6>
                           <p class="text-gray mb-3">North • Hamburgers • Pure veg</p>
                           <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i> 15–25 min</span> <span class="float-right text-black-50"> $500 FOR TWO</span></p>
                        </div>
                        <div class="list-card-badge">
                           <span class="badge badge-danger">OFFER</span> <small>65% off | Use Coupon OSAHAN50</small>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                     <div class="list-card-image">
                        <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                        <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i class="icofont-heart"></i></a></div>
                        <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                        <a href="detail.html">
                           <img src="{{BASE}}img/list/8.png" class="img-fluid item-img">
                        </a>
                     </div>
                     <div class="p-3 position-relative">
                        <div class="list-card-body">
                           <h6 class="mb-1"><a href="detail.html" class="text-black">Polo Lounge
                              </a>
                           </h6>
                           <p class="text-gray mb-3">North Indian • Indian • Pure veg</p>
                           <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i> 15–25 min</span> <span class="float-right text-black-50"> $250 FOR TWO</span></p>
                        </div>
                        <div class="list-card-badge">
                           <span class="badge badge-danger">OFFER</span> <small>65% off | Use Coupon OSAHAN50</small>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                     <div class="list-card-image">
                        <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                        <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i class="icofont-heart"></i></a></div>
                        <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                        <a href="detail.html">
                           <img src="{{BASE}}img/list/9.png" class="img-fluid item-img">
                        </a>
                     </div>
                     <div class="p-3 position-relative">
                        <div class="list-card-body">
                           <h6 class="mb-1"><a href="detail.html" class="text-black">Jack Fry's
                              </a>
                           </h6>
                           <p class="text-gray mb-3">North Indian • Indian • Pure veg</p>
                           <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i> 15–25 min</span> <span class="float-right text-black-50"> $250 FOR TWO</span></p>
                        </div>
                        <div class="list-card-badge">
                           <span class="badge badge-danger">OFFER</span> <small>65% off | Use Coupon OSAHAN50</small>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="section pt-5 pb-5 bg-white becomemember-section border-bottom">
   <div class="container">
      <div class="section-header text-center white-text">
         <h2>Become a Member</h2>
         <p>Lorem Ipsum is simply dummy text of</p>
         <span class="line"></span>
      </div>
      <div class="row">
         <div class="col-sm-12 text-center">
            <a href="register.html" class="btn btn-success btn-lg">
               Create an Account <i class="fa fa-chevron-circle-right"></i>
            </a>
         </div>
      </div>
   </div>
</section>
<section class="section pt-5 pb-5 text-center bg-white">
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <h5 class="m-0">Operate food store or restaurants? <a href="login.html">Work With Us</a></h5>
         </div>
      </div>
   </div>
</section>
<section class="footer pt-5 pb-5">
   <div class="container">
      <div class="row">
         <div class="col-md-4 col-12 col-sm-12">
            <h6 class="mb-3">Subscribe to our Newsletter</h6>
            <form class="newsletter-form mb-1">
               <div class="input-group">
                  <input type="text" placeholder="Please enter your email" class="form-control">
                  <div class="input-group-append">
                     <button type="button" class="btn btn-primary">
                        Subscribe
                     </button>
                  </div>
               </div>
            </form>
            <p><a class="text-info" href="register.html">Register now</a> to get updates on <a href="offers.html">Offers and Coupons</a></p>
            <div class="app">
               <p class="mb-2">DOWNLOAD APP</p>
               <a href="#">
                  <img class="img-fluid" src="{{BASE}}img/google.png">
               </a>
               <a href="#">
                  <img class="img-fluid" src="{{BASE}}img/apple.png">
               </a>
            </div>
         </div>
         <div class="col-md-1 col-sm-6 mobile-none">
         </div>
         <div class="col-md-2 col-6 col-sm-4">
            <h6 class="mb-3">About OE</h6>
            <ul>
               <li><a href="#">About Us</a></li>
               <li><a href="#">Culture</a></li>
               <li><a href="#">Blog</a></li>
               <li><a href="#">Careers</a></li>
               <li><a href="#">Contact</a></li>
            </ul>
         </div>
         <div class="col-md-2 col-6 col-sm-4">
            <h6 class="mb-3">For Foodies</h6>
            <ul>
               <li><a href="#">Community</a></li>
               <li><a href="#">Developers</a></li>
               <li><a href="#">Blogger Help</a></li>
               <li><a href="#">Verified Users</a></li>
               <li><a href="#">Code of Conduct</a></li>
            </ul>
         </div>
         <div class="col-md-2 m-none col-4 col-sm-4">
            <h6 class="mb-3">For Restaurants</h6>
            <ul>
               <li><a href="#">Advertise</a></li>
               <li><a href="#">Add a Restaurant</a></li>
               <li><a href="#">Claim your Listing</a></li>
               <li><a href="#">For Businesses</a></li>
               <li><a href="#">Owner Guidelines</a></li>
            </ul>
         </div>
      </div>
   </div>
</section>
<section class="footer-bottom-search pt-5 pb-5 bg-white">
   <div class="container">
      <div class="row">
         <div class="col-xl-12">
            <p class="text-black">POPULAR COUNTRIES</p>
            <div class="search-links">
               <a href="#">Australia</a> | <a href="#">Brasil</a> | <a href="#">Canada</a> | <a href="#">Chile</a> | <a href="#">Czech Republic</a> | <a href="#">India</a> | <a href="#">Indonesia</a> | <a href="#">Ireland</a> | <a href="#">New Zealand</a> | <a href="#">United Kingdom</a> | <a href="#">Turkey</a> | <a href="#">Philippines</a> | <a href="#">Sri Lanka</a> | <a href="#">Australia</a> | <a href="#">Brasil</a> | <a href="#">Canada</a> | <a href="#">Chile</a> | <a href="#">Czech Republic</a> | <a href="#">India</a> | <a href="#">Indonesia</a> | <a href="#">Ireland</a> | <a href="#">New Zealand</a> | <a href="#">United Kingdom</a> | <a href="#">Turkey</a> | <a href="#">Philippines</a> | <a href="#">Sri Lanka</a><a href="#">Australia</a> | <a href="#">Brasil</a> | <a href="#">Canada</a> | <a href="#">Chile</a> | <a href="#">Czech Republic</a> | <a href="#">India</a> | <a href="#">Indonesia</a> | <a href="#">Ireland</a> | <a href="#">New Zealand</a> | <a href="#">United Kingdom</a> | <a href="#">Turkey</a> | <a href="#">Philippines</a> | <a href="#">Sri Lanka</a> | <a href="#">Australia</a> | <a href="#">Brasil</a> | <a href="#">Canada</a> | <a href="#">Chile</a> | <a href="#">Czech Republic</a> | <a href="#">India</a> | <a href="#">Indonesia</a> | <a href="#">Ireland</a> | <a href="#">New Zealand</a> | <a href="#">United Kingdom</a> | <a href="#">Turkey</a> | <a href="#">Philippines</a> | <a href="#">Sri Lanka</a>
            </div>
            <p class="mt-4 text-black">POPULAR FOOD</p>
            <div class="search-links">
               <a href="#">Fast Food</a> | <a href="#">Chinese</a> | <a href="#">Street Food</a> | <a href="#">Continental</a> | <a href="#">Mithai</a> | <a href="#">Cafe</a> | <a href="#">South Indian</a> | <a href="#">Punjabi Food</a> | <a href="#">Fast Food</a> | <a href="#">Chinese</a> | <a href="#">Street Food</a> | <a href="#">Continental</a> | <a href="#">Mithai</a> | <a href="#">Cafe</a> | <a href="#">South Indian</a> | <a href="#">Punjabi Food</a><a href="#">Fast Food</a> | <a href="#">Chinese</a> | <a href="#">Street Food</a> | <a href="#">Continental</a> | <a href="#">Mithai</a> | <a href="#">Cafe</a> | <a href="#">South Indian</a> | <a href="#">Punjabi Food</a> | <a href="#">Fast Food</a> | <a href="#">Chinese</a> | <a href="#">Street Food</a> | <a href="#">Continental</a> | <a href="#">Mithai</a> | <a href="#">Cafe</a> | <a href="#">South Indian</a> | <a href="#">Punjabi Food</a>
            </div>
         </div>
      </div>
   </div>
</section>

{% include 'partials/desktop/footer.twig.php' %}
{% endblock %}
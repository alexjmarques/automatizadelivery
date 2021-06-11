<section class="footer pt-5 pb-5">
   <div class="container">
      <div class="row">
         <div class="col-md-3 col-12 col-sm-12">
            <form class="newsletter-form mb-1">
               <div class="input-group">
                  <img src="{{BASE}}img/logo.png" alt="Automatiza Delivery" class="full-img">
               </div>
            </form>

            <!-- <div class="app">
               <p class="mb-2">DOWNLOAD APP</p>
               <a href="#">
                  <img class="img-fluid" src="{{BASE}}img/google.png">
               </a>
               <a href="#">
                  <img class="img-fluid" src="{{BASE}}img/apple.png">
               </a>
            </div> -->
         </div>
         <div class="col-md-2 col-sm-6 mobile-none">
         </div>
         <div class="col-md-2 col-6 col-sm-4">
            <h6 class="mb-3">Institucional</h6>
            <ul>
               <!-- <li><a href="{{BASE}}institucional/sobre-nos">Automatiza App</a></li>
               <li><a href="{{BASE}}institucional/visao-valores">Nossos Pilares</a></li> -->
               <!-- <li><a href="{{BASE}}institucional/trabalhe-conosco">Trabalhe Conosco</a></li> -->
               <li><a href="{{BASE}}institucional/contato">Fale Conosco</a></li>
               <li><a href="{{BASE}}admin/login">Login</a></li>
            </ul>
         </div>
         <div class="col-md-5 col-6 col-sm-4">
            <h6 class="mb-3">Termos da Plataforma</h6>
            <ul>
               {% for link in links %}
               <li><a href="{{BASE}}institucional/{{link.slug}}">{{link.titulo}}</a></li>
               {% endfor %}
            </ul>
         </div>
      </div>
   </div>
</section>
<section class="footer-bottom-search pt-0 pb-0 bg-white border-top">
</section>
<footer class="pt-4 pb-4 text-center">
         <div class="container">
            <p class="mt-0 mb-0">{{ "now"|date('Y')}} {{ trans.t('Automatiza Delivery') }}</p>
            <small class="mt-0 mb-0"> Desenvolvido e gerenciado  <i class="fas fa-heart heart-icon text-danger"></i> por
            <a class="text-danger" target="_blank" href="https://automatiza.app">Automatiza App</a>
            <br>CNPJ: 28.775.420/0001-69
            </small>
         </div>
      </footer>
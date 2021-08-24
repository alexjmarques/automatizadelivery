{% extends 'partials/bodyHome.twig.php'  %}
{% block title %}{{ trans.t('Automatiza Delivery - Automatiza.App') }}{% endblock %}
{% block body %}
{% block head %}
{% endblock %}
{% include 'partials/desktop/menuTopWhite.twig.php' %}
<section class="section pt-5 pb-5">
   <div class="container">
      <div class="row">
         <div class="col-md-6 mx-auto bg-white p-5 rounded">
            <div class="col-md-12 float-left">
               <h5 class="mb-0">Formulário de Interesse</h5>
               <p class="mb-4">Para entrar em contato e saber mais sobre os planos, preencha o formulário abaixo.</p>
               <form class="mt-3" method="post" action="{{BASE}}institucional/contato/i" id="form" enctype="multipart/form-data">
                  <div class="form-group">
                     <label for="exampleFormControlInput1" class="small font-weight-bold">Seu Nome <span style="color:red;">*</span></label>
                     <input type="text" class="form-control" id="nome" name="nome" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlInput2" class="small font-weight-bold">Email <span style="color:red;">*</span></label>
                     <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlInput3" class="small font-weight-bold">Telefone <span style="color:red;">*</span></label>
                     <input type="tel" class="form-control" id="telefone" name="telefone" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlInput3" class="small font-weight-bold">Nome Empresa <span style="color:red;">*</span></label>
                     <input type="text" class="form-control" id="empresa" name="empresa" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlInput3" class="small font-weight-bold">Plano Desejável <span style="color:red;">*</span></label>
                     <select class="form-control select2-single" name="plano" id="plano" required>
                        {% for plano in planos %}
                        <option value="{{ plano.nome }}">{{ plano.nome }}</option>
                        {% endfor %}
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlTextarea1" class="small font-weight-bold">Alguma observação? </label>
                     <textarea class="form-control" id="msn" name="msn" rows="4"></textarea>
                  </div>
                  <div id="mensagem"></div>
                  <div class="btn_acao"><div class="carrega"></div>
                  <button id="btn-atualizar-end" class="elementor-price-table__button elementor-button elementor-size-md gold"><span>Enviar</span></button>
                  </div>
               </form>
            </div>
            
         </div>
      </div>
   </div>
</section>
{% include 'partials/desktop/footer.twig.php' %}
{% endblock %}
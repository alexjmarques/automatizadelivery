{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Configurações do delivery</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
  <ol class="breadcrumb pt-0">
    <li class="breadcrumb-item">
      <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Configurações do delivery</li>
  </ol>
</nav>
<div class="separator mb-5"></div>
<div class="col-12 p-0">
  <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/conf/delivery/u" enctype="multipart/form-data" >
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="mb-4">Sobre o Delivery</h5>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="text-dark">Previsão Entrega em Minutos</label>
            <input type="text" class="form-control form-control-sm" id="previsao_minutos" name="previsao_minutos"
              value="{{retorno.previsao_minutos}}">
          </div>

        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="text-dark">Taxa Entrega</label>
            <input type="text" class="form-control form-control-sm" id="taxa_entrega" name="taxa_entrega"
              value="{{retorno.taxa_entrega}}">
          </div>
          <div class="form-group col-md-4">
            <label class="text-dark">Quilometragem de Entrega Padrão</label>
            <input type="text" class="form-control form-control-sm" id="km_entrega" name="km_entrega"
              value="{{retorno.km_entrega}}">
          </div>

          <div class="form-group col-md-4">
            <label class="text-dark">Até quantos quilometros pode exceder?</label>
            <input type="text" class="form-control form-control-sm" id="km_entrega_excedente" name="km_entrega_excedente"
              value="{{retorno.km_entrega_excedente}}">
          </div>

          <div class="form-group col-md-4">
            <label class="text-dark">Valor por Quilometro Excedido</label>
            <input type="text" class="form-control form-control-sm" id="valor_excedente" name="valor_excedente"
              value="{{retorno.valor_excedente}}">
          </div>

          <div class="form-group col-md-4">
            <label class="text-dark">Lucro sobre o Motoboy</label>
            <input type="text" class="form-control form-control-sm" id="taxa_entrega_motoboy" name="taxa_entrega_motoboy"
              value="{{retorno.taxa_entrega_motoboy}}">
          </div>
        </div>
      </div>
    </div>



    <div class="card mb-4">
      <div class="card-body">
        <h5 class="mb-4">Taxa de Entrega (Grátis)</h5>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="col-12 col-form-label" style="padding-left: 0;">Taxa de Entrega (Grátis)</label>
            <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left"
              title="Frete Grátis">
              {% if(retorno.frete_status == 1 ) %}
              <input class="custom-switch-input" id="frete_status" name="frete_status" value="1" type="checkbox" checked>
              {% else %}
              <input class="custom-switch-input" id="frete_status" name="frete_status" value="0" type="checkbox">
              {% endif %}
              <label class="custom-switch-btn" for="frete_status"></label>
            </div>
          </div>

          <div class="form-group col-md-8" id="freteQuantos">
            <label class="text-dark">A partir de quanto seu cliente terá a Taxa de Entrega (Grátis)?</label>
            <input type="text" class="form-control form-control-sm col-md-4" id="valor" name="valor" value="{{retorno.valor}}">
          </div>

          <div class="form-group col-md-12">
            <label class="col-12 col-form-label" style="padding-left: 0;">Frete grátis na primeira compra?</label>
            <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left"
              title="Frete grátis na primeira compra?">
              {% if(retorno.primeira_compra == 1 ) %}
              <input class="custom-switch-input" id="switch" name="switch" value="1" type="checkbox" checked>
              {% else %}
              <input class="custom-switch-input" id="switch" name="switch" value="0" type="checkbox">
              {% endif %}
              <label class="custom-switch-btn" for="switch"></label>
            </div>
          </div>
        </div>

        <input type="hidden" id="id" name="id" value="{{retorno.id}}">
        <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
<button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>

      </div>
    </div>

  </form>
</div>
{% endblock %}
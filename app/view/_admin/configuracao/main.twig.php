{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Configurações da empresa</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
  <ol class="breadcrumb pt-0">
    <li class="breadcrumb-item">
      <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Configurações da empresa</li>
  </ol>
</nav>
<div class="separator mb-5"></div>
<div class="col-12 p-0">
  <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/conf/u" enctype="multipart/form-data">
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="mb-4">Sobre a Empresa</h5>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="nomeFantasia">Nome Fantasia</label>
            <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia"
              value="{{empresa.nome_fantasia}}">
          </div>
          <div class="form-group col-md-4">
            <label for="inputEmail4">Razão Social</label>
            <input type="text" class="form-control" id="razaoSocial" name="razaoSocial"
              value="{{empresa.razao_social}}" disabled>
          </div>
          <div class="form-group col-md-4">
            <label for="inputPassword4">CNPJ</label>
            <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{empresa.cnpj}}" disabled>
          </div>
        </div>

        

        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="moeda">Moeda</label>
            <select id="moeda" name="moeda" class="form-control select2-single">
              <option value="">Selecione</option>
              {% for mod in moedas %}
              <option {% if mod.id == empresa.id_moeda %} selected {% endif %} value="{{ mod.id }}">{{ mod.nome }} - {{ mod.simbolo }}</option>
              {% endfor %}
            </select>
          </div>

          <div class="form-group col-md-4">
            <label>Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="{{empresa.telefone}}">
          </div>
          <div class="form-group row mb-1 col-md-4 pl-3">
            <label class="col-12 col-form-label" style="padding-left: 0;">NF Paulista</label>
            <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left"
              title="Seu estabelecimento fornece Nota Fiscal Paulista">
              {% if(empresa.nf_paulista == 1 ) %}
              <input class="custom-switch-input" id="switch" name="switch" value="1" type="checkbox" checked>
              {% else %}
              <input class="custom-switch-input" id="switch" name="switch" value="0" type="checkbox">
              {% endif %}
              <label class="custom-switch-btn" for="switch"></label>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="moeda">Link do Site</label>
            <input type="text" class="form-control" id="link_site" name="link_site" value="https://automatizadelivery.com.br/{{empresa.link_site}}" disabled>
          </div>
          <div class="form-group col-md-6">
            <label>Email de Contato</label>
            <input type="text" class="form-control" id="email_contato" name="email_contato"
              value="{{empresa.email_contato}}">
          </div>
        </div>


        <div class="form-group">
          <label>Sobre a Empresa</label>
          <textarea class="form-control" name="sobre" id="sobre" cols="30" rows="10">{{empresa.sobre}}</textarea>
        </div>

        <div class="form-group">
          <label for="inputLogo">Logo da Empresa (400px x 400px)</label>
          <div class="form-group col-md-12 form-gr-md" style="float: left;">
            <div class="image_area">
              <label for="upload_image">
                {% if(empresa.logo is empty ) %}
                <img src="{{BASE}}uploads/no-image.png" id="uploaded_image" class="img-responsive img-circle" />
                {% else %}
                <img src="{{BASE}}uploads/{{empresa.logo}}" id="uploaded_image" class="img-responsive img-circle" />
                {% endif %}
                <div class="overlay">
                  <div class="text">Selecione uma imagem</div>
                </div>
                <input type="file" name="image" class="image" id="upload_image" style="display:none" />
              </label>
              <input type="hidden" name="imagemNome" id="imagemNome" value="{{empresa.logo}}">
            </div>
          </div>
          <div class="form-group">
            <label for="inputCapa">Capa de apresentação (1600px x 300px)</label>
            <div class="custom-file">
              <input type="file" name="capa" id="capa" class="form-control">
            </div>
          </div>
          {% if(capa is not empty ) %}
          <div class="form-group">
            <img src="{{BASE}}uploads/{{empresa.capa}}" width="300">
          </div>
          {% endif %}
        </div>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <h5>Endereço Comercial</h5>
        <p class="mb-4">Endereço de Funcionamento do estabelecimento, este endereço será utilizado para calcular a taxa de entrega de seus clientes.</p>
       
          
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>CEP</label>
              <input type="text" class="form-control" id="cep_end" name="cep_end" value="{{endereco.cep}}">
            </div>
          
            <div class="form-group col-md-5">
              <label>Endereço</label>
              <input type="text" class="form-control" id="rua_end" name="rua_end" value="{{endereco.rua}}" required>
            </div>
            <div class="form-group col-md-1">
              <label>Número</label>
              <input type="text" class="form-control" id="numero_end" name="numero_end" value="{{endereco.numero}}" required>
            </div>
            <div class="form-group col-md-3">
              <label>Complemento</label>
              <input type="text" class="form-control" id="complemento_end" name="complemento_end" value="{{endereco.complemento}}">
            </div>
          </div>
  
          <div class="form-row">
            <div class="form-group col-md-3">
              <label>Bairro</label>
              <input type="text" class="form-control" id="bairro_end" name="bairro_end" value="{{endereco.bairro}}">
            </div>
            <div class="form-group col-md-4">
              <label>Cidade</label>
              <input type="text" class="form-control" id="cidade_end" name="cidade_end" value="{{endereco.cidade}}">
            </div>
  
            <div class="form-group col-md-2">
              <label for="estado">Estado</label>
              <input type="text" class="form-control" id="estado_end" name="estado_end" value="{{endereco.estado}}">
            </div>
          </div>




     
        
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <h5>Dias de atendimento</h5>
        <p class="mb-4">Dias que seu Delivery funciona, selecione os dias que nosso sistema cuida do restante.</p>
        <div class="form-row">
          {% for dia in dias %}
          {% if dia.id in empresa.dias_atendimento %}
          <div class="custom-control custom-checkbox mb-4">
            <input checked type="checkbox" id="dias{{ dia.id }}" name="dias[]" value="{{ dia.id }}" class="mp2">
            <label class="form-check-label" for="dias{{ dia.id }}">{{ dia.nome }}</label>
          </div>
          {% else %}
          <div class="custom-control custom-checkbox mb-4">
            <input type="checkbox" id="dias{{ dia.id }}" name="dias[]" value="{{ dia.id }}" class="mp2">
            <label class="form-check-label" for="dias{{ dia.id }}"> {{ dia.nome }}</label>
          </div>
          {% endif %}
          {% endfor %}
        </div>
        <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
        <input type="hidden" name="logoUpdate" id="logoUpdate" value="{{empresa.logo}}">
        <input type="hidden" name="capaUpdate" id="capaUpdate" value="{{empresa.capa}}">
        <div class="btn_acao"><div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
                </div>
      </div>
    </div>
  </form>
</div>
{% include 'partials/modalImagem.twig.php' %}
{% endblock %}
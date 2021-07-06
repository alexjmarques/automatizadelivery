{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Configurações da Impressora</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
  <ol class="breadcrumb pt-0">
    <li class="breadcrumb-item">
      <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Configurações da Impressora</li>
  </ol>
</nav>
<div class="separator mb-5"></div>
<div class="col-12 p-0">
  <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/conf/u" enctype="multipart/form-data">
    <div class="card mb-4">
      
      <div class="card-body">
        <h5 class="mb-4">Impressora</h5>
        <div class="form-row">

          <div class="form-group col-md-4">
            <label for="nomeFantasia">Nome da Impressora</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{impressora.nome}}">
          </div>

          <div class="form-group col-md-8">
            <label for="inputEmail4">Nome da Impressora na Rede</label>
            <input type="text" class="form-control" id="code" name="code" value="{{impressora.code}}">
          </div>
          
        </div>
        <input type="hidden" id="id_empresa" name="id_empresa" value="{{impressora.id_empresa}}">
        <div class="btn_acao"><div class="carrega"></div><button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button></div>

      </div>
      
  </form>
</div>
{% include 'partials/modalImagem.twig.php' %}
{% endblock %}
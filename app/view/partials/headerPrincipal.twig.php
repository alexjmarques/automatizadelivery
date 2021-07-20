{% if empresa.capa is null %}
<div class="top_read" style="background: url(/uploads/capa_modelo.jpg); background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;">
{% else %}
<div class="top_read" style="background: url(/uploads/{{empresa.capa}}); background-attachment: fixed;background-position: center;background-repeat: no-repeat;background-size: cover;">
{% endif %}
<div class="mdc-top-app-bar_title">
  <a class="brand" href="{{BASE}}{{empresa.link_site}}/delivery">
    {% if empresa.logo is null %}
    <img src="/uploads/logo_modelo.png" alt="{{empresa.nome_fantasia }}" title="{{empresa.nome_fantasia }}"/>
    {% else %}
    <img src="/uploads/{{empresa.logo}}" alt="{{empresa.nome_fantasia }}" title="{{empresa.nome_fantasia }}"/>
    {% endif %}
  </a>
</div>
</div>
<div class="mdc-top-app-bar relative">
    <div class="osahan-home-page home_h">
      <div class="titulos_he">
        <h2 class="title_prov">{{empresa.nome_fantasia }}</h2>
        <span class="title_mov">{{delivery.previsao_minutos}}</span>
        {% if delivery.status == 1 %}
          <span class="badge badge-success text-13"><i class="feather-clock"></i> Aberto</span>
          {% else %}
          <span class="badge badge-warning text-13"><i class="feather-clock"></i> Fechado</span>
        {% endif %}
        {% if isLogin == 0 or isLogin is empty %}
        <div class="btn_henv">
          <a href="{{BASE}}{{empresa.link_site}}/login" class="new__button"><i class="feather-user"></i> Login/Cadastro</a>
        </div>
        {% endif %}
      </div>
      <div class="clearfix"></div>
    </div>
</div>
<!-- {% if isLogin is empty %}
    <div class="busca-mt">
      <div class="input-group mt-3 rounded overflow-hidden ">
          <a class="border-0 btn btn-black text-dark btn-block" href="{{BASE}}{{empresa.link_site}}/intro"><i class="feather-info"></i> Veja como é fácil fazer seu pedido! </a>
    </div>
{% endif %} -->
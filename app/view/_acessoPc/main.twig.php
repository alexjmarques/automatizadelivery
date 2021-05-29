{% extends 'partials/bodyAcesso.twig.php'  %}
{% block title %}{{empresa[':nomeFantasia']}} - Sistema de Gerenciamento de Pedidos{% endblock %}
{% block body %}
<div class="container">
<div class="row align-items-center hv-100">
<div class="col-lg-6 text-center">
<img class="logo" src="{{BASE}}uploads/{{empresa[':logo']}}">
<h2 class="mb-0">{{empresa[':nomeFantasia']}}</h2>
<p class="mb-3">{{empresa[':rua']}}, {{empresa[':numero']}} {{empresa[':complemento']}} - {{empresa[':bairro']}} <br/>
 {{empresa[':cidade']}}/{{estado}} - CEP: {{empresa[':cep']}}</p>
<img class="mb-3 mt-4 qrcode" src="{{qrCode}}">

<p class="text-danger small mb-5">Aponte sua câmera para visualizar<br/> o sistema em seu celular
</p>
</div>
<div class="col-lg-6 text-center">
<div class="phone-screen">
<div class="f-r">
<iframe name="preview" src="{{empresa.link_site}}"></iframe>
</div>
</div>
</div>
</div>
</div>
{% endblock %}
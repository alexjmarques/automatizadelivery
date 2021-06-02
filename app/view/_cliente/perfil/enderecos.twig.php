{% extends 'partials/body.twig.php'  %}
{% block title %}Endereços - {{empresa.nome_fantasia }}{% endblock %}
{% block body %}
<div class="osahan-checkout">
    <div class="bg-primary border-bottom px-3 pt-3 pb-5 d-flex ">
        <a class="toggle" href="#"><span></span></a>
        <h5 class="font-weight-bold m-0 text-white">Endereços cadastrados</h5>
        <a class="text-white font-weight-bold ml-auto" href="{{BASE}}{{empresa.link_site}}/perfil"> Voltar</a>
    </div>
        {% set count = 0 %}
        {% for p in enderecos %}
        <div class="p-3 osahan-cart-item osahan-home-page">
            <div class="p-0 osahan-profile">
                <div class="bg-white rounded shadow {% if count == 0 %}mt-n5{% endif %}">
                {% set count = count + 1 %}
                    <div class="border-bottom p-3">
                        <div class="left col-md-8 p-0">
                            {% if p.principal == 1 %}<span class="badge badge-success right size13">Endereço de Entrega</span>{% endif%}
                            <h6 class="mb-1 font-weight-bold">{{p.nome_endereco}}</h6> 
                            <p class="text-muted m-0 __cf_email__">{{p.rua}}, {{p.numero}} - {{p.complemento}}</p>
                            <p class="text-muted m-0 __cf_email__">{{p.bairro}} -  {{p.cidade}} | 
                            {% for e in estados %}
                                {% if e.id == p.estado %}{{ e.uf }}{% endif %}
                            {% endfor %}</p>
                            <p class="text-muted m-0 __cf_email__">CEP {{p.cep}}</p>
                            <p class="text-muted m-0 __cf_email__"></p>
                        </div>
                        <div class="left col-md-4 p-0">
                            <a href="{{BASE}}{{empresa.link_site}}/endereco/{{p.id}}/editar" class="btnEnderecos btnEditarFloat espaco">Editar</a>
                            <a href="{{BASE}}{{empresa.link_site}}/endereco/d/{{p.id}}" class="btnEnderecos btnDeletarFloat">Deletar</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    {% if p.principal == 0 %} 
                        <a href="#" onclick="mudarEndereco({{p.id}})" class="btn btn-primary full_id">Definir como endereço principal</a>
                    {% endif%}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        {% endfor %}
    
    <div class="p-3 pt-0 osahan-cart-item osahan-home-page">
        <div class="p-0 pt-0 osahan-profile">
            <a href="{{BASE}}{{empresa.link_site}}/endereco/novo" class="btn btn-secundary btn-block btn-lg btnEditarFloat"><i class="feather-plus"></i> Novo Endereço</a>
        <div>
    </div>
</div>
{% include 'partials/modalAlertSite.twig.php' %}
{% include 'partials/footer.twig.php' %}
{% endblock %}
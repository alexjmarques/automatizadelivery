{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}

<div class="container-fluid">
    <div class="col-12">
        <h1>Gerenciar iFood</h1>
        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item active" aria-current="page">iFood</li>
            </ol>
        </nav>
        <div class="separator mb-5"></div>

    </div>

    <div class="reviews-performance">
       
        <div class="reviews-performance__section-body">
            <div class="reviews-performance-detail-body__section-body">
                <div class="col-md-12 col-lg-6 col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="reviews-performance-detail-section">
                                <div class="reviews-performance-detail-section__title">Integração com iFood</div>
                                <form method="post" action="{{BASE}}{{empresa.link_site}}/admin/conectar/ifood" id="formMk" enctype="multipart/form-data" class="full-width">
                                    <div class="dados-usuario full-width">
                                        <div class="col-md-12 pr-0 pl-0">
                                            <div class="form-group">
                                                <label class="text-dark" for="cep">Para conectar sua conta do iFood ao sistema e receber seus pedidos informe o ID da sua Loja na sequência clique no botão abaixo.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 pr-0 pl-0">
                                            <div class="form-group">
                                                
                                                {% if status == 1 %} 
                                                <label class="text-dark" for="rua">ID da loja: </label>
                                                <strong class="cian-rouded p-2 pl-4 pr-4">{{ statusiFood[':idLoja']}}</strong>
                                                {% else %}
                                                <label class="text-dark" for="rua">ID da loja <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="idLoja" name="idLoja" value="{{ statusiFood[':idLoja']}}" required>
                                                <span class="text-center mt-2 mb-2 full-width" style="color:red !important;">Você encontra o ID da Loja dados no painel do iFood no menu <strong>Perfil</strong></span>
                                                {% endif %}
                                            </div>
                                        </div>
                                    </div>
                                    {% if status != 1 %}
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="{{ statusiFood[':id']}}">
                                    
<button class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnCadastro"><span>Conectar ao iFood</span></button>
                                    {% endif %}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-lg-6 col-xl-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="reviews-performance-detail-section">
                                <div class="reviews-performance-detail-section__title"> Status</div>
                                {% if status == 1 %}
                                    <p class="col-md-12 p-2 mb-3 text-left size16 border-bottom cian-rouded">- Integração com API<i class="simple-icon-check text-success float-right size20"></i> </p>
                                    {% else %}
                                    <p class="col-md-12 p-2 mb-3 text-left size16 border-bottom cian-rouded">- Integração com API<i class="simple-icon-close text-danger float-right size20"></i> </p>
                                {% endif %}
                                {% if statusiFood[':idLoja'] is not null %}
                                {% if status == 1 %}
                                    <p class="col-md-12 p-2 mb-3 text-left size16 border-bottom cian-rouded">- Loja Conectada à rede do iFood <i class="simple-icon-check text-success float-right size20"></i> </p>
                                    {% else %}
                                    <p class="col-md-12 p-2 mb-3 text-left size16 border-bottom cian-rouded">- Loja Desconectada da rede do iFood <i class="simple-icon-close text-danger float-right size20"></i> </p>
                                {% endif %}
                                    {% else %}
                                    <p class="col-md-12 p-2 mb-3 text-left size16 border-bottom cian-rouded">- Loja Desconectada da rede do iFood <i class="simple-icon-close text-danger float-right size20"></i> </p>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>

        </div>

    </div>


</div>
{% endblock %}
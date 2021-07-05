{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}

<div class="container-fluid">
    <div class="col-12">
        <h1>Gerenciar Click Entregas</h1>
        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
            <ol class="breadcrumb pt-0">
                <li class="breadcrumb-item active" aria-current="page">Click Entregas</li>
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
                                <div class="reviews-performance-detail-section__title">Integração com Click Entregas</div>
                                <form method="post" autocomplete="off" action="{{BASE}}{{empresa.link_site}}/admin/conectar/clickentregas" id="" enctype="multipart/form-data" class="full-width">
                                    <div class="dados-usuario full-width">
                                        <div class="col-md-12 pr-0 pl-0">
                                            <div class="form-group">
                                                <label class="text-dark" for="cep">Conecte sua conta do Click Entregas para que seus pedidos sejam entregues a seus clientes atravês dos entregadores da Click Entregas.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 pr-0 pl-0">
                                            <div class="form-group">
                                                {% if status == 1 %} 
                                                <label class="text-dark" for="rua">Token: </label>
                                                <strong class="cian-rouded p-2 pl-4 pr-4">{{ statusClickEntregas[':token']}}</strong>
                                                {% else %}
                                                <label class="text-dark" for="rua">ID da loja <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" id="token" name="token" value="{{ statusClickEntregas[':token']}}" required>
                                                
                                                {% endif %}
                                            </div>
                                        </div>
                                    </div>
                                    {% if status != 1 %}
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="{{ statusClickEntregas[':id']}}">
                                    
<button class="btn btn-primary btn-lg btn-block acaoBtn acaoBtnCadastro"><span>Conectar ao Click Entregas</span></button>
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
                                {% if statusClickEntregas[':idLoja'] is not null %}
                                {% if status == 1 %}
                                    <p class="col-md-12 p-2 mb-3 text-left size16 border-bottom cian-rouded">- Loja Conectada à rede do ClickEntregas <i class="simple-icon-check text-success float-right size20"></i> </p>
                                    {% else %}
                                    <p class="col-md-12 p-2 mb-3 text-left size16 border-bottom cian-rouded">- Loja Desconectada da rede do ClickEntregas <i class="simple-icon-close text-danger float-right size20"></i> </p>
                                {% endif %}
                                    {% else %}
                                    <p class="col-md-12 p-2 mb-3 text-left size16 border-bottom cian-rouded">- Loja Desconectada da rede do ClickEntregas <i class="simple-icon-close text-danger float-right size20"></i> </p>
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
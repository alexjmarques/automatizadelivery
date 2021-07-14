{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1 id="titleBy" data-id="{{ catId }}">Atualizar Produto: <strong>{{ retorno.nome }}</strong></h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/produtos">Produtos</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/produto/u/{{ retorno.id }}" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-4" id="titleBy" data-id="{{retorno.id}}">Sobre o produto</h5>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ retorno.nome }}" required>
                </div>

                <div class="form-group col-md-3">
                    <label>Cód. PDV</label>
                    <input type="text" class="form-control" id="cod" name="cod" value="{{ retorno.cod }}">
                </div>
              

                <div class="form-group row mb-1 pl-3 col-md-3">

                    <div class="col-12">
                        <label class="col-12 col-form-label" style="padding-left: 0;">Status</label>
                        <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left" title="Status do seu produto na plataforma">
                            {% if(retorno.status == 1 ) %}
                            <input class="custom-switch-input" id="switch" name="switch" value="1" type="checkbox" checked>
                            {% else %}
                            <input class="custom-switch-input" id="switch" name="switch" value="0" type="checkbox">
                            {% endif %}
                            <label class="custom-switch-btn" for="switch"></label>
                        </div>
                    </div>

                </div>

            </div>

            <div class="form-row mb-4">

                <div class="col-md-12">
                    <label>Disponibilidade do Produto</label>
                </div>

                <div class="row col-md-12">
                    {% for dia in diaSelecao %}
                    <div class="col-md-21">
                        {% if dia.id in retorno.dias_disponiveis %}
                        <div class="custom-checkbox">
                            <input checked type="checkbox" id="dias{{ dia.id }}" name="dias_disponiveis[]" value="{{ dia.id }}" class="mp2">
                            <label class="form-check-label" for="dias{{ dia.id }}">{{ dia.nome }}</label>
                        </div>
                        {% else %}
                        <div class="custom-checkbox">
                            <input type="checkbox" id="dias{{ dia.id }}" name="dias_disponiveis[]" value="{{ dia.id }}" class="mp2">
                            <label class="form-check-label" for="dias{{ dia.id }}"> {{ dia.nome }}</label>
                        </div>
                        {% endif %}
                    </div>
                    {% endfor %}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" value="">{{ retorno.descricao }}</textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Observações (Ex.: Não enviamos molhos... Produto acompanha...)</label>
                    <textarea class="form-control" id="observacao" name="observacao" value="">{{ retorno.observacao }}</textarea>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-6 float-left pl-0">
        <div class="card mb-4 ">
            <div class="card-body">
                <h5>Tamanho</h5>
                <p class="mb-0">Este elemento serve para definir o valor de cada pizza de acordo com seu tamanho</p>
                <div class="form-row">
                    <div class="form-group col-md-12">
                            <div class="form-row">
                                {% for tam in tamanhos %}
                                {% for tamC in tamanhosCategorias %}
                                {% if tamC.id_categoria == retorno.id_categoria %}
                                {% if tam.id == tamC.id_tamanhos %}
                                <div class="col-md-12 linhaFooter pb-2">
                                    <div class="pt-2 pb-2 pl-0">
                                        <div class="col-md-6 float-left pl-0 bold text-left text-uppercase">Tamanho <input type="text" value="{{ tam.nome }}" class="p-2" disabled> </div>
                                        <div class="col-md-6 float-left pl-0 bold  text-left text-uppercase">Valor 
                                        <input class="p-2 valor" type="text" id="valor{{ tam.id }}" name="preco[valor][]" value="{% for valorProd in valorProduto %}{% if valorProd.id_tamanho == tam.id %}{{valorProd.valor|number_format(2, ',','.')}}{% endif %}{% endfor %}">
                                        <input class="p-2" type="hidden" id="id{{ tam.id }}" {% for valorProd in valorProduto %}{% if valorProd.id_tamanho == tam.id %}name="preco[id_valor][]" value="{{ valorProd.id }}"{% endif %}{% endfor %}>
                                        </div>
                                    </div>
                                </div>
                                {% endif %}
                                {% endif %}

                                {% endfor %}
                                {% endfor %}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 float-left pr-0">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Imagem do produto</h5>
                <img id="IMG_toll" src="{{BASE}}uploads{{retorno.imagem}}" />
                <div class="clearfix"></div>
            <button id="remove_img" class="btn btn-outline-danger mb-1">Remover Imagem</button>
                <div class="dropzone sc-gsTCUz sc-hJJQhR jRUqac fGBOdX {% if retorno.imagem is not null %}hide{% endif %}" id="myDropzone">
                {# Formatos: JPEG, JPG, PNG e HEIC
                Peso máximo: 5 MB
                Resolução mínima: 300x300 #}
                </div>

            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    {# <div class="card mb-4">
        <div class="card-body">
            <h5>Sabores</h5>
            <p class="mb-4">Este elemento serve para definir se seu produto possui complemento de escolha antes da
                adição do mesmo ao carrinho do cliente</p>
            {% if qtdSabores == 0 %}
            <div class="alert alert-warning" role="alert"> Para cadastrar um novo produdo com todos os detalhes e
                Sabores! <a href="{{BASE}}{{empresa.link_site}}/admin/produto-sabor/novo">Clique aqui</a> para Cadastrar.
            </div>
            {% else %}
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div id="prodSabor">
                        <label>Sabores para escolha</label>
                        <div class="form-row">
                            {% for sab in produtosSabores%}
                            {% if sab.id in retorno.sabores %}
                            <div class="col-md-4">
                                <div class="p-2 colAdc">
                                    <input type="checkbox" checked id="itemchecks{{ sab.id }}" name="sabores[]" value="{{ sab.id }}">
                                    <label class="form-check-label" for="itemchecks{{ sab.id }}">{{ sab.nome
                                        }}</label>
                                </div>
                            </div>
                            {% else %}
                            <div class="col-md-4">
                                <div class="p-2 colAdc">
                                    <input type="checkbox" id="itemchecks{{ sab.id }}" name="sabores[]" value="{{ sab.id }}">
                                    <label class="form-check-label" for="itemchecks{{ sab.id }}">{{ sab.nome
                                        }}</label>
                                </div>
                            </div>
                            {% endif %}
                            {% endfor %}
                        </div>
                    </div>
                </div>
            </div>
            {% endif %}
        </div>
    </div> #}

    <div class="card mb-4">
        <div class="card-body">
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <input type="hidden" id="categoriaCad" name="categoriaCad" value="{{retorno.id_categoria}}">
            <input type="hidden" id="categoria" name="categoria" value="{{retorno.id_categoria}}">
            <input type="hidden" id="imagemNome" name="imagemNome" value="{{retorno.imagem}}">
            <input type="hidden" id="id" name="id" value="{{ retorno.id }}">
            <input type="hidden" id="vendas" name="vendas" value="0">

            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-info d-block mt-0 acaoBtn acaoBtnAtualizar">Atualizar</button>
            </div>
        </div>
    </div>
</form>
{% include 'partials/modalImagem.twig.php' %}
{% endblock %}
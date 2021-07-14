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
                <div class="form-group col-md-4">
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ retorno.nome }}" required>
                </div>

                <div class="form-group col-md-3">
                    <label>Valor</label>
                    <input type="text" class="form-control" id="valor" placeholder="Insira o Valor " name="valor" value="{{ retorno.valor|number_format(2, ',', '.') }}" required>
                </div>

                <div class="form-group col-md-2">
                    <label>Valor Promocional</label>
                    <input type="text" class="form-control" id="valor_promocional" placeholder="Insira o Valor " name="valor_promocional" value="{% if(retorno.valor_promocional != 0.00) %}{{ retorno.valor_promocional|number_format(2, ',', '.') }}{% endif %}">
                </div>
    

                <div class="form-group row mb-1 pl-3 col-md-2">

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

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">Imagem de Capa do produto</h5>
            <img id="IMG_toll" src="{{BASE}}uploads{{retorno.imagem}}" />
            <button id="remove_img" class="btn btn-outline-danger mb-1">Remover Imagem</button>
            <div class="dropzone sc-gsTCUz sc-hJJQhR jRUqac fGBOdX dz-clickable {% if retorno.imagem is not null %}hide{% endif %}" id="myDropzone"></div>
            {# Formatos: JPEG, JPG, PNG e HEIC
            Peso máximo: 5 MB
            Resolução mínima: 300x300 #}
        </div>
    </div>

    <div class="card mb-4">
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
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Item Adicional</h5>
            <p class="mb-4">Este elemento serve para definir se seu produto possui complemento de escolha antes da
                adição do mesmo ao carrinho do cliente</p>
            {% if qtdProdutosAdicionais == 0 %}
            <div class="alert alert-warning" role="alert"> Para cadastrar um novo produdo com e inserir variações de
                escolhas cadastre um Produto Adicional! <a href="{{BASE}}{{empresa.link_site}}/admin/produto-adicional/novo">Clique aqui</a>
                para Cadastrar.</div>
            {% else %}
            <div class="form-row">

                <div class="form-group col-md-12">
                    <div id="prodAdicional">
                        {% for ta in tipoAdicional %}
                        <h6 class="clearfix mt-3">{{ ta.tipo }}</h6>
                        <div class="form-row">
                            {% for padici in produtosAdicionais %}
                            {% if ta.id == padici.tipo_adicional %}
                            {% if padici.id in retorno.adicional %}
                            <div class="col-md-4">
                                <div class="p-2 colAdc">
                                    <input type="checkbox" checked id="itemcheck{{ padici.id }}" name="adicional[]" value="{{ padici.id }}">
                                    <label class="form-check-label" for="itemcheck{{ padici.id }}">{{ padici.nome }}
                                        - <strong>{{ moeda.simbolo }} {{ padici.valor|number_format(2, ',',
                                        '.') }}</strong></label>
                                </div>
                            </div>
                            {% else %}
                            <div class="col-md-4">
                                <div class="p-2 colAdc">
                                    <input type="checkbox" id="itemcheck{{ padici.id }}" name="adicional[]" value="{{ padici.id }}">
                                    <label class="form-check-label" for="itemcheck{{ padici.id }}">{{ padici.nome }}
                                        - <strong>{{ moeda.simbolo }} {{ padici.valor|number_format(2, ',','.') }}</strong></label>
                                </div>
                            </div>
                            {% endif %}
                            {% endif %}

                            {% endfor %}
                        </div>
                        {% endfor %}
                    </div>
                </div>
            </div>
            {% endif %}

            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <input type="hidden" id="categoria" name="categoria" value="{{retorno.id_categoria}}">
            <input type="hidden" id="imagemNome" name="imagemNome" value="{{retorno.imagem}}">
            <input type="hidden" id="id" name="id" value="{{ retorno.id }}">
            <input type="hidden" id="vendas" name="vendas" value="0">

            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
            </div>
        </div>
    </div>
</form>
{% include 'partials/modalImagem.twig.php' %}
{% endblock %}
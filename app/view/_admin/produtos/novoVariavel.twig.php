{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Nova Pizza</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin/produtos">Produtos</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Novo</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/produto/i" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-4">Sobre a pizza</h5>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nome da Pizza</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="exampleFormControlSelect1">Categoria</label>
                    <select class="form-control select2-single" id="categoria" name="categoria">
                        {% for e in categoriaLista %}
                        <option value="{{ e.id }}">{{ e.nome }}</option>
                        {% endfor %}
                    </select>
                </div>

                <div class="form-group row mb-1 pl-3 col-md-3">
                    <div class="col-12">
                        <label class="col-12 col-form-label" style="padding-left: 0;">Status</label>
                        <div class="custom-switch custom-switch-primary mb-2" data-toggle="tooltip" data-placement="left" title="Status do seu produto na plataforma">
                            <input class="custom-switch-input" id="switch" name="switch" value="1" type="checkbox" checked>
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
                        <div class="custom-checkbox">
                            <input checked type="checkbox" id="dias{{ dia.id }}" name="dias_disponiveis[]" value="{{ dia.id }}" class="mp2">
                            <label class="form-check-label" for="dias{{ dia.id }}"> {{ dia.nome }}</label>
                        </div>
                    </div>
                    {% endfor %}
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" value=""></textarea>
                </div>

                <div class="form-group col-md-6">
                    <label>Observações (Ex.: Não enviamos molhos... Produto acompanha...)</label>
                    <textarea class="form-control" id="observacao" name="observacao" value=""></textarea>
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
                                <div class="col-md-12 linhaFooter pb-2">
                                    <div class="pt-2 pb-2 pl-0">
                                        <div class="col-md-6 float-left pl-0 bold text-left text-uppercase">Tamanho <input type="text" value="{{ tam.nome }}" class="p-2" disabled> </div>
                                        <div class="col-md-6 float-left pl-0 bold  text-left text-uppercase">Valor 
                                        <input class="p-2 valor" type="text" id="valor{{ tam.id }}" name="preco[valor][]" value="">
                                        <input class="p-2 valor" type="hidden" id="id{{ tam.id }}" name="preco[tamanho][]" value="{{ tam.id }}">
                                        </div>

                                    </div>
                                </div>
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
                <div class="dropzone sc-gsTCUz sc-hJJQhR jRUqac fGBOdX" id="myDropzone">
                {# Formatos: JPEG, JPG, PNG e HEIC
                Peso máximo: 5 MB
                Resolução mínima: 300x300 #}
                </div>

            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    {# <div class="card mb-4" id="IdSabores">
        <div class="card-body">

            <h5>Sabores</h5>
            <p class="mb-4">Este elemento serve para definir se seu produto possui complemento de escolha antes da adição do mesmo ao carrinho do cliente</p>

            {% if qtdSabores == 0 %}
            <div class="alert alert-warning" role="alert"> Para cadastrar um novo produdo com todos os detalhes e Sabores! <a href="{{BASE}}{{empresa.link_site}}/admin/produto-sabor/novo">Clique aqui</a> para Cadastrar.</div>
            {% else %}

            <div class="form-row">

                <div class="form-group col-md-12">
                    <div id="prodSabor">
                        <label>Sabores para escolha</label>
                        <div class="form-row">
                            {% for padici in produtosSabores %}
                            <div class="col-md-4">
                                <div class="p-2 colAdc">
                                    <input type="checkbox" id="itemchecks{{ padici.id }}" name="sabor[]" value="{{ padici.id }}">
                                    <label class="form-check-label" for="itemchecks{{ padici.id }}">{{ padici.nome }}</label>
                                </div>
                            </div>
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
            <input type="hidden" id="imagemNome" name="imagemNome" value="">
            <input type="hidden" id="vendas" name="vendas" value="0">
            <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
            <input type="hidden" class="form-control" id="valor" placeholder="Insira o Valor " name="valor" value="0" required>
            <input type="hidden" class="form-control" id="valor_promocional" placeholder="Insira o Valor " name="valor_promocional" value="0">
            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnCadastro">Cadastrar</button>
            </div>
        </div>
    </div>
</form>
{% include 'partials/modalImagem.twig.php'  %}
{% endblock %}
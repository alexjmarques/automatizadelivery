{% extends 'partials/bodySupAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Editar Página</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}admin">Painel</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{BASE}}admin/paginas">Páginas</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Editar Página</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<form method="post" autocomplete="off" id="form" action="{{BASE}}admin/pagina/u/{{retorno.id}}" enctype="multipart/form-data">
    <div class="card mb-4">
        <div class="card-body">

            <div class="form-row">
                <div class="form-group col-md-12 catProds">
                    <label>Título da Página</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{retorno.titulo}}" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Descrição</label>
                    <textarea class="form-control" id="conteudo" name="conteudo">{{retorno.conteudo}}</textarea>
                </div>
            </div>
            <input type="hidden" id="id" name="id" value="{{retorno.id}}">
            <input type="hidden" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{retorno.slug}}">
            <div class="btn_acao">
                <div class="carrega"></div>
                <button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button>
            </div>
        </div>
    </div>
</form>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        height: 700,
        setup: function(ed) {
            ed.on('change', function(e) {
                console.log('the content ' + ed.getContent());
                $("#conteudo").text(ed.getContent());
            });
        }
    });
</script>
{% endblock %}
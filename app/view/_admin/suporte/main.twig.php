{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Suporte</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Suporte</li>
    </ol>
</nav>

<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <p class="lead">Canal exclusivo para tirar dúvidas solicitar mudanças ou informar erro no sistema.</p>
                <p>Utilize este canal para solicitar qualquer informação pertinente a utilização de nosso sistema. o Tempo de resposta e de até 3hs e tempo de resolução e de até 72hs a contar da resposta ou gravidade da solicitação</p>

                <div class="col-6 center-block p-4" style="margin: 0 auto;">
                <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/shell.js"></script>
                <script>
                    hbspt.forms.create({
                        region: "na1",
                        portalId: "20431331",
                        formId: "4186dad8-0ed1-4542-80a9-a66e083ec6a2"
                    });
                </script>
                </div>

            </div>
        </div>
    </div>
</div>
{% endblock %}
{% extends 'partials/bodySupAdmin.twig.php' %}
{% block title %}Admin Automatiza.App{% endblock %}
{% block body %}
<h1>Empresas</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
    <ol class="breadcrumb pt-0">
        <li class="breadcrumb-item">
            <a href="{{BASE}}admin">Painel</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Empresas</li>
    </ol>
</nav>
<div class="separator mb-5"></div>
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <table class="data-table data-table-simple responsive nowrap">
                    <thead class="linhaTop">
                        <tr>
                            <th>Nome</th>
                            <th style="width: 50px !important;">CNPJ</th>
                            <th style="width: 50px !important;">Telefone</th>
                            <th style="width: 200px !important;">Email de Contato</th>
                            <th style="width: 200px !important;">Plano</th>
                            <th style="width: 200px !important;">Data Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for p in empresas %}
                        <tr>
                            <td><a href="https://automatizadelivery.com.br/{{ p.link_site }}" target="_blank">{{ p.nome_fantasia }}</a></td>
                            <td>{{ p.cnpj }}</td>
                            <td>({{ p.telefone[:2] }}) {{ p.telefone|slice(2, 5) }}-{{ p.telefone|slice(7, 9) }}</td>
                            <td>{{ p.email_contato }}</td>
                            <td>
                            {% for ass in assinatura %}    
                                {% if p.id == ass.id_empresa %}
                                {% for plan in planos %} 
                                    {% if ass.plano_id == plan.plano_id %}
                                        {{ plan.nome }}
                                    {% endif %}
                                {% endfor %}
                                {% endif %}
                            {% endfor %}
                        </td>
                            <td>{{ p.created_at|date('d/m/Y') }}</td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
                <div class="col-7 center-block text-center float-ceter">
                    {{paginacao|raw}}
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
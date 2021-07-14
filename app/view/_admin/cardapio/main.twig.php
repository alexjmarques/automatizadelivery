{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery
{% endblock %}
{% block body %}
	<h1>Cardápios</h1>
	<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
		<ol class="breadcrumb pt-0">
			<li class="breadcrumb-item">
				<a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">Cardápios</li>
		</ol>
	</nav>
	<div class="top-right-button-container">
		<a href="{{BASE}}{{empresa.link_site}}/admin/categoria/nova" class="btn btn-info btn-sm ml-2">
			<i class="simple-icon-plus"></i>
			Adicionar categoria</a>
	</div>

	<div class="separator mb-5"></div>
	<div class="row mb-4">
		<div class="col-12 data-tables-hide-filter">
			<div class="card">
				<div class="card-body">
					<div id="accordion">
                        {% set idCategoria = 0 %}
                        {% set idTamanhos = 0 %}
                        {% set indexCat = 0 %}
                        {% for c in categoria %}
                        {% for tc in tamanhosCategoria %}
                        {% if c.id == tc.id_categoria %}
                        {% set idCategoria = c.id %}
                        {% set idTamanhos = tc.id_tamanhos %}
                        {% endif %}
                        {% endfor %}
						<div class="border border-classic-big p-3 mb-3 pb-0x">
								{% set indexCat = indexCat + 1 %}
                                <div class="btn-link-collapse pb-2">
                                    <button id="cats{{ c.id }}" class="btn float-left buton-collapse" data-toggle="collapse" data-target="#categoria{{ c.id }}" aria-expanded="true" aria-controls="categoria{{ c.id }}">
                                        <i aria-hidden="true" class="icon category-group-header-options__icon fa fa-chevron-down fa fa-plus"></i>
                                    </button>
                                    <div class="float-left menu-list-category-actions">
                                        <a href="{{BASE}}{{empresa.link_site}}/admin/categoria/editar/{{ c.id }}">{{ c.nome }}</a>
                                    </div>
									<div class="top-right-button-container">
                                        {% if c.id != idCategoria %}
										<a href="{{BASE}}{{empresa.link_site}}/admin/produto/novo/{{ c.id }}" class="btn btn-info btn-sm btn-inverter">
											<i class="simple-icon-plus"></i>
											Adicionar produto</a>
                                            {% endif %}
                                        {% if c.id == idCategoria %}
                                        
										{% if empresa.id_categoria == 6 %}
											{% if qtdTamanho > 0 %}
												<a href="{{BASE}}{{empresa.link_site}}/admin/produto-pizza/novo/{{ c.id }}" class="btn btn-info btn-sm ml-2 btn-inverter">
													<i class="simple-icon-plus"></i>
													Adicionar pizza</a>
											{% endif %}
										{% endif %}
                                        {% endif %}
									</div>
                                    <div class="clearfix"></div>

                                </div>
								<div id="categoria{{ c.id }}" class="collapse {% if indexCat == 1 %}show{% endif %}" data-parent="#accordion">
									<table class="data-table data-table-simple responsive pt-2 pb-2 linha-top" data-order='[[ 2, "asc" ]]'>
										<thead class="linhaTop">
											<tr>
											<th style="width: 100px;">Cód. PDV</th>
												<th style="width: 100px;">Imagem</th>
												<th>Nome</th>
												<th style="width: 100px !important;">Valor</th>
												<th style="width: 100px !important;">Status</th>
												<th style="width: 120px;">Ações</th>
											</tr>
										</thead>
										<tbody>
											{% for p in produto %}
												{% if c.id == p.id_categoria %}
													<tr style="width: 100px;">
													<td><p>{{ p.cod }}</p></td>
														<td>
															{% if p.imagem is not empty %}
															{% if c.id == idCategoria %}
																<a href="{{BASE}}{{empresa.link_site}}/admin/produto-pizza/editar/{{ p.id }}">
																{% else %}
																<a href="{{BASE}}{{empresa.link_site}}/admin/produto/editar/{{ p.id }}">
															{% endif %}
																<img src="{{BASE}}uploads{{p.imagem}}" width="80px"/></a>
															{% endif %}
														</td>
														<td>
															<p>
															{% if c.id == idCategoria %}
																<a href="{{BASE}}{{empresa.link_site}}/admin/produto-pizza/editar/{{ p.id }}">
																{% else %}
																<a href="{{BASE}}{{empresa.link_site}}/admin/produto/editar/{{ p.id }}">
															{% endif %}{{ p.nome }}</a>
															</p>
														</td>

														<td>
															<p class="text-center">
																{% if p.valor == 0.00 %}
																	{% set maxValue = 0 %}-----
																{% else %}
																	{{ moeda.simbolo }}
																	{{ p.valor|number_format(2, ',', '.') }}
																{% endif %}
															</p>
														</td>
														<td>
															<p class="text-muted text-center">
																{% if p.status == 1 %}
																	<span class="text-success cartao text-center" data-toggle="tooltip" data-placement="top" title="Produto Ativo">
																		<i class="simple-icon-check"></i>
																	</span>
																{% else %}
																	<span class="text-danger cartao text-center" data-toggle="tooltip" data-placement="top" title="Produto Desativado">
																		<i class="simple-icon-close"></i>
																	</span>
																{% endif %}
															</p>
														</td>
														<td>
															{% if c.id == idCategoria %}
																<a href="{{BASE}}{{empresa.link_site}}/admin/produto-pizza/editar/{{ p.id }}" class="btn btn-outline-success mb-1" ata-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i></a>
															{% else %}
																<a href="{{BASE}}{{empresa.link_site}}/admin/produto/editar/{{ p.id }}" class="btn btn-outline-success mb-1" ata-toggle="modal" data-target="#rightModal"><i class="simple-icon-note"></i></a>
															{% endif %}
														</td>
													</tr>
												{% endif %}
											{% endfor %}
										</tbody>
									</table>
								</div>
                            </div>
							{% endfor %}
					</div>
				</div>
			</div>
		</div>
	</div>
{% endblock %}

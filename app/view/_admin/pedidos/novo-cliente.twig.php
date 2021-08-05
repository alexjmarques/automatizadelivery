{% extends 'partials/bodyAdmin.twig.php'  %}
{% block title %}Admin Automatiza Delivery
{% endblock %}
{% block body %}
<div class="containers row-wrap stretch">
	<div class="col-4 p-2 shadow bg-white">
		<div id="titleBy" data-id="{{cliente.id}}" class="resumo-pedido" data-cliente="{{cliente.id}}">
			<div class="mt-1 p-2 bloco-ops-cli mb-3">
				<strong>Cliente:</strong> {{cliente.nome}}<br />
				<strong>Telefone:</strong> ({{ cliente.telefone[:2] }}) {{ cliente.telefone|slice(2, 5) }}-{{ cliente.telefone|slice(7, 9) }}<br />
				<br />
				{% if enderecoAtivo.principal == 1 %}
				<strong>Endereço: </strong> {{ enderecoAtivo.rua }}, {{ enderecoAtivo.numero }} - {{ enderecoAtivo.bairro }}
				<br />
				<strong>Complemento: </strong>{{ enderecoAtivo.complemento }}
				{% endif %}
			</div>
			<div id="mostraCarrinhoItens"></div>
			<div id="carregaCarrinho"></div>
		</div>
	</div>

	<div class="mb-4 col-8 roll">
		<div id="step-1" class="tab-pane step-content" style="display: block;">
			{% if empresa.id_categoria == 6 %}
			<div class="px-3 pt-3 title">
				{% for tam in tamanhos %}
				<div class="osahan-slider-item col-3 float-left pb-4 pl-0 px-1">
					<div class=" h-100 overflow-hidden position-relative">
						<button class="p-2 position-relative btn-categoria pizza" data-toggle="modal" data-target="#modProduto" onclick="produtoPizzaModal({{ tam.id }}, {{cliente.id}})">
							<div class="list-card-body">
								<h6 class="mb-1">
									{{ tam.nome }}
								</h6>
							</div>
						</button>
					</div>
				</div>
				{% endfor %} <div class="clearfix"></div>
			</div>
			{% endif %}
			{% set idCategoria = 0 %}
			{% set idTamanhos = 0 %}
			{% for c in categoria %}
			{% for tc in tamanhosCategoria %}
			{% if c.id == tc.id_categoria %}
			{% set idCategoria = c.id %}
			{% set idTamanhos = tc.id_tamanhos %}
			{% endif %}
			{% endfor %}
			{% if c.id == idCategoria %}

			{# {% if c.produtos > 0 %}
                <div class="px-3 pt-0 title d-flex">
                    <h5 id="{{ c.slug }}" name="{{ c.slug }}" class="mt-1 bold">{{ c.nome }}</h5>
                    
                </div>
                <div class="px-3 pt-3 title">
                    {% for tc in tamanhosCategoria %}
                    {% if c.id == tc.id_categoria %}
                    {% for tam in tamanhos %}
                    {% if c.id == tc.id_categoria and tam.id == tc.id_tamanhos %}

                    {% for i in range(1, tam.qtd_sabores) %}
                    <div class="osahan-slider-item col-3 float-left pb-4 pl-0 px-1">
                        <div class="list-card h-100 overflow-hidden position-relative">
                            <button class="p-2 position-relative" data-toggle="modal" data-target="#modProduto" onclick="produtoPizzaModal('{{c.slug}}', {{tc.id}}, {{tam.id}}, {{i}}, {{cliente.id}})">
                                <div class="list-card-body">
                                    <h6 class="mb-1">

                                        Pizza {{tam.nome}} {% if i == 1 %}{{i}} SABOR {% else %}{{i}} SABORES {% endif %}

                                    </h6>
                                    <p class="text-gray mb-0 pb-0">Esta pizza tem {% if tam.qtd_pedacos == 1 %} {{tam.qtd_pedacos}} pedaço {% else %} {{tam.qtd_pedacos}} pedaços {% endif %}</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    {% endfor %}
                    {% endif %}
                    {% endfor %}
                    {% endif %}
                    {% endfor %}
                    <div class="clearfix"></div>
                </div>
                {% endif %} #}

			{% else %}


			{% if c.produtos > 0 %}
			<div class="px-3 pt-0 title d-flex">
				<h5 id="{{ c.slug }}" name="{{ c.slug }}" class="mt-1 bold">{{ c.nome }}</h5>
			</div>
			{% endif %}
			<ul class="lista">
				{% for p in produto %}
				{% if c.id == p.id_categoria %}
				<li class="col-md-4 disable-text-selection" data-toggle="modal" data-target="#modProduto" onclick="produtoModal({{p.id}}, {{cliente.id}})">
					<div class="col-md-12 mb-2 p-0">
						<div class="card" style="height: 93px;">
							<div class="card-body p-2">
								<div class="row">
									<div class="col-12">
										{% if p.imagem is not empty %}
										<img src="{{BASE}}uploads/{{p.imagem}}" class="card-img-top" style="float: left;width: 75px;margin: 0 5px 0 0;border-radius: 5px;">
										{% endif %}
										<h6 class="mb-1">
											<a href="#" class="text-black"><strong>{{p.nome}}</strong></a>
										</h6>

										{% if p.valor_promocional != '0.00' %}

										<p class="text-black mb-1 porquanto pmais"> <span class="float-left text-black-50"> {{moeda.simbolo}} {{
                                                    p.valor_promocional|number_format(2, ',', '.') }}</span></p>
										{% else %}
										<p class="text-black mb-1 porquanto pmais"> <span class="float-left text-black-50"> {{moeda.simbolo}} {{
                                                    p.valor|number_format(2, ',', '.') }}</span></p>
										{% endif %}
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>
				{% endif %}
				{% endfor %}
			</ul>

			{% endif %}
			{% endfor %}

		</div>

	</div>
</div>
<div class="modal fade modal-right" id="modProduto" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content pb-0">
			<form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/produto/addCarrinho/produto/{{produto.id}}" novalidate>
				<div class="modal-body p-0" id="mostrarProduto">
					<div class="text-center pb-3">
						<h4 class="text-center pt-5">Carregando...</h4>
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
							<path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none">
								<animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform>
							</path>
						</svg>
					</div>
				</div>
			</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>

			</div>
		</div>
	</div>

	{% include 'partials/modalNovoCliente.twig.php'  %}
	{% endblock %}
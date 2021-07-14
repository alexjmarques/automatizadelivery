{% if pedido.tipo_frete == 1 %}
<span class="bg-warning white-color codB">Cliente vai {{tipoFrete.tipo}}</span>
{% else %}
<span class="bg-success white-color codB">Pedido para {{tipoFrete.tipo}}</span>
{% endif %}
<div class="modal-header">

    <h5 class="modal-title"><strong>Pedido #{{pedido.numero_pedido}}</strong> 
    <br><span class="horas">Recebido {{pedido.data_pedido|date('d/m/Y')}} ás: {{pedido.hora|date('H:i')}}<span>
    {% if pedido.tipo_frete == 1 %}
    <br>Status: <span class="bg-{{status.class}} white-color p-1 ml-2">Pedido {{status.retirada}}</span>
{% else %}
<br>Status:<span class="bg-{{status.class}} white-color p-1 ml-2">Pedido {{status.delivery}}</span>
{% endif %}
    </h5>
    <div class="dropdown">
  <button class="dropdown-toggles" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="data:image/svg+xml,%3Csvg%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M12%208C13.1046%208%2014%207.10457%2014%206C14%204.89543%2013.1046%204%2012%204C10.8954%204%2010%204.89543%2010%206C10%207.10457%2010.8954%208%2012%208Z%22%20fill%3D%22%233E3E3E%22%2F%3E%3Cpath%20d%3D%22M12%2014C13.1046%2014%2014%2013.1046%2014%2012C14%2010.8954%2013.1046%2010%2012%2010C10.8954%2010%2010%2010.8954%2010%2012C10%2013.1046%2010.8954%2014%2012%2014Z%22%20fill%3D%22%233E3E3E%22%2F%3E%3Cpath%20d%3D%22M12%2020C13.1046%2020%2014%2019.1046%2014%2018C14%2016.8954%2013.1046%2016%2012%2016C10.8954%2016%2010%2016.8954%2010%2018C10%2019.1046%2010.8954%2020%2012%2020Z%22%20fill%3D%22%233E3E3E%22%2F%3E%3C%2Fsvg%3E" alt="">
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Editar Pedido</a>
    <a class="dropdown-item" href="#" onclick="cancelarPedido({{ pedido.id }})">Cancelar Pedido</a>
    <a class="dropdown-item" href="#" id="close-modal" type="button" class="closes" data-dismiss="modal" aria-label="Close">Fechar</a>
  </div>
</div>
</div>
<div class="modal-body">
    <content>
        <div class="env">
            <h5>Cliente: {{cliente.nome}}</h5>
            <strong>Telefone: </strong><a href="https://api.whatsapp.com/send?phone=55{{cliente.telefone}}" target="_Blank">({{ cliente.telefone[:2] }}) {{ cliente.telefone|slice(2, 5) }}-{{ cliente.telefone|slice(7, 9) }}</a>

            <div class="env cli_dados">
                {% if pedido.tipo_frete == 1 %}
                <h6>Cliente vai retirar</h6>
                {% else %}
                <h6>Dados para entrega:</h6>
                <strong>Endereço:</strong> {{endereco.rua}}, {{endereco.numero}} - {{endereco.bairro}} <br />
                {% if endereco.complemento is not null %}
                <strong>Complemento:</strong> {{endereco.complemento}}<br />
                {% endif %}
                <strong>CEP:</strong> {{endereco.cep}}
                {% endif %}
            </div>
        </div>

        <hr />
        <strong>Tipo pagamento:</strong> <span>{{pagamento.tipo}} </span> |
        {% if pedido.tipo_pagamento == 1 %}
        <strong>Troco para:</strong> <span>{{ moeda.simbolo }} {{ pedido.troco|number_format(2, ',', '.') }}</span> |
        {% endif %}
        <strong>KM:</strong> <span>{{ pedido.km }}</span> | <strong>Observação:</strong> <span>{{pedido.observacao}}</span>
        <hr />
        <div class="env">
            <h6>Item do Pedido:</h6>
            <ul class="list_prod">
                {% for car in carrinho %}
                {% for prod in  produtos %}
                {% if pedido.numero_pedido == car.numero_pedido %}
                {% if car.id_produto == prod.id %}
                <li class="odd"><strong>{{ car.quantidade}}x </strong>- {% if car.variacao is not null %}{% set foo = car.variacao|split(' - ') %}<strong>{{ foo[0] }}</strong><br />{% else %}<strong>{{ prod.nome }}</strong>{% endif %}
                    <span class="moeda_valor right rtt">{{ moeda.simbolo }} {{ (car.valor * car.quantidade)|number_format(2, ',', '.') }}</span>
                    {% if car.observacao != "" %}
                    <span>(<strong>Obs.:</strong> {{car.observacao}})</span>
                    {% endif %}

                    {% if car.variacao is not null %}
                    <p class="mb-0 mt-0"><strong>Borda:</strong>
                        {{ foo[1] }}<br />
                    </p>

                    <p class="mb-0 mt-0"><strong>Sabor: </strong>
                        {% if foo[2] %}{{ foo[2] }}{% endif %}
                        {% if foo[3] %} - {{ foo[3] }}{% endif %}
                        {% if foo[4] %} - {{ foo[4] }}{% endif %}
                        {% if foo[5] %} - {{ foo[5] }}{% endif %}
                    </p>
                    {% endif %}

                    {% for s in sabores %}
                    {% if s.id == car.id_sabores %}
                    <strong>- {{ s.nome }} </strong>
                    {% endif %}
                    {% endfor %}


                    {% for cartAd in carrinhoAdicional %}
                    {% if prod.id == cartAd.id_produto %}

                    {% for a in adicionais %}
                    {% if a.id == cartAd.id_adicional and prod.id == cartAd.id_produto and car.id == cartAd.id_carrinho %}
                    <p class="m-0 small subprice">
                        - <strong>{{ cartAd.quantidade }}
                            x </strong>{{ a.nome }} <span class="moeda_valor right rtt">{{ moeda.simbolo }} {{ (a.valor * cartAd.quantidade)|number_format(2, ',', '.') }}</span>
                    </p>
                    {% endif %}
                    {% endfor %}

                    {% endif %}
                    {% endfor %}
                </li>
                {% endif %}
                {% endif %}
                {% endfor %}
                {% endfor %}
            </ul>

            <hr />

            {% if pedido.tipo_pagamento == 1 %}
            <div class="env subtotal"><strong class="color-money-off">Pagamento em {{pagamento.tipo}} levar troco de:</strong><span class="color-money-off">{{ moeda.simbolo }} {{ (pedido.troco - pedido.total_pago)|number_format(2, ',', '.') }}</span></div>
            {% endif %}

            <div class="env subtotal"><strong>Subtotal:</strong><span>{{ moeda.simbolo }} {{ pedido.total|number_format(2, ',', '.') }}</span></div>
            
            <div class="env subtotal cupomLoad"><strong>Cupom Desconto:</strong><span> - {{ moeda.simbolo }} {{ cupomValor|number_format(2, ',', '.') }}</span></div>

            

            {% if pedido.tipo_frete == 2 %}
            <div class="env subtotal"><strong>Taxa de Entrega:</strong><span>{{ moeda.simbolo }} {{ pedido.valor_frete|number_format(2, ',', '.') }}</span></div>
            {% endif %}


            <div class="env total"><strong>Total:</strong><span>{{ moeda.simbolo }} {{ pedido.total_pago|number_format(2, ',', '.') }}</span></div>
            <hr />


            {% if pagamento.code == 7 %}
            Cliente vai pagar <strong>{{ moeda.simbolo }} {{clientePagamento.pag_dinheiro|number_format(2, ',', '.')}}</strong> em Dinheiro e <strong>{{ moeda.simbolo }} {{clientePagamento.pag_cartao|number_format(2, ',', '.')}} no Cartão</strong>

            <hr />
            {% endif %}


            {% if nf_paulista.numero_pedido is not null %}
            <div class="env subtotal">Cliente Pediu Nota Fiscal Paulista no CPF <strong>{{nf_paulista.cpf}}</strong></div>
            {% endif %}
            <hr />

            {% if pedido.status == 2 %}
            {% if pedido.tipo_frete == 1 %}
            {% else %}
            <input type="hidden" name="id_cliente" id="id_cliente" value="{{cliente.id}}">
            <input type="hidden" name="chave" id="chave" value="{{pedido.chave}}">
            <input type="hidden" name="numero_pedido" id="numero_pedido" value="{{pedido.numero_pedido}}">
            {% if planoAtivo > 2 %}
            <div class="env motoboy_select">
                <h6>Qual Motoboy vai entregar?</h6>
                <select class="form-control select2-single" id="motoboy-{{pedido.id}}" name="motoboy-{{pedido.id}}">
                    <option value="Selecione" selected>Selecione Motoboy</option>
                    {% for m in motoboys %}
                    {% for u in usuarios %}
                    {% if m.id_usuario == u.id %}
                    <option value="{{ m.id }}">{{ u.nome }}</option>
                    {% endif %}
                    {% endfor %}
                    {% endfor %}
                </select>
            </div>
            {% else %}

            <select class="form-control select2-single hidden" id="motoboy-{{pedido.id}}" name="motoboy-{{pedido.id}}">
                <option value="0" selected>Motoboy Sistema</option>
            </select>

            {% endif %}
            {% endif %}
            {% endif %}
        </div>


    </content>
    <footer>
        {% if pedido.status == 1 %}
        {% set count = pedido.status %}
        {% set count = count + 1 %}
        <button class="col-meio btn-processo bg-danger" onclick="mudarStatus({{pedido.id}}, {{count}}, {{estabelecimento}})" id="btn-carrinho">Colocar em produção<i class="simple-icon-arrow-right"></i></button>
        {% endif %}

        {% if pedido.status == 2 %}
        {% set count = pedido.status %}
        {% set count = count + 1 %}
        <button class="col-meio btn-processo bg-warning" onclick="mudarStatusEntrega({{pedido.id}}, {{count}}, {{estabelecimento}})" id="btn-carrinho">
            {% if pedido.tipo_frete == 1 %}
            Pronto para retirada
            {% else %}
            Entregar ao motoboy{% endif %}<i class="simple-icon-arrow-right"></i></button>
        {% endif %}

        {% if pedido.status == 3 %}
        {% set count = pedido.status %}
        {% set count = count + 1 %}
        <select class="form-control select2-single hidden" id="motoboy-{{pedido.id}}" name="motoboy-{{pedido.id}}">
            <option value="{{pedido.id_motoboy}}" selected>{{pedido.id_motoboy}}</option>
        </select>
        <button class="col-meio btn-processo bg-secondary" onclick="mudarStatusEntrega({{pedido.id}}, {{count}}, {{estabelecimento}})" id="btn-carrinho">Pedido entregue<i class="simple-icon-arrow-right"></i></button>
        {% endif %}

        {% if pedido.status >= 3 %}
        {% if pedido.status == 5 %}
        <span>Pedido Recusado</span><br />
        <span><strong>Motivo:</strong> {{ pedido.observacao }}</span><br />
        <span><strong>Hora:</strong> {{ pedido.hora|date('H:i') }}</span>
        {% endif %}
        {% if pedido.status == 6 %}
        <span>Pedido Cancelado pelo Cliente</span>
        {% endif %}
        {% endif %}

    </footer>
    <div id="mensagem{{pedido.id}}" class="text-center full_id mt-2"></div>
    <div class="serrilha"></div>
</div>
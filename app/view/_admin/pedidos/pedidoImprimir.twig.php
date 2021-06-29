<style>
    * {
    font-size: 12px;
    font-family: 'Times New Roman';
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 75px;
    max-width: 75px;
}

td.quantity,
th.quantity {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

td.price,
th.price {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
</style>

<div class="ticket">
            <img src="./logo.png" alt="Logo">
            <p class="centered">RECEIPT EXAMPLE
                <br>Address line 1
                <br>Address line 2</p>
            <table>
                <thead>
                    <tr>
                        <th class="quantity">Q.</th>
                        <th class="description">Description</th>
                        <th class="price">$$</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="quantity">1.00</td>
                        <td class="description">ARDUINO UNO R3</td>
                        <td class="price">$25.00</td>
                    </tr>
                    <tr>
                        <td class="quantity">2.00</td>
                        <td class="description">JAVASCRIPT BOOK</td>
                        <td class="price">$10.00</td>
                    </tr>
                    <tr>
                        <td class="quantity">1.00</td>
                        <td class="description">STICKER PACK</td>
                        <td class="price">$10.00</td>
                    </tr>
                    <tr>
                        <td class="quantity"></td>
                        <td class="description">TOTAL</td>
                        <td class="price">$55.00</td>
                    </tr>
                </tbody>
            </table>
            <p class="centered">Thanks for your purchase!
                <br>parzibyte.me/blog</p>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
    <script>

const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});
    </script>

{% if pedido[':status'] == 1 %}
        <span class="bg-danger white-color full_id">Recebido</span>
        {% endif %}
        {% if pedido[':status'] == 2 %}
        <span class="bg-warning white-color full_id">Em Produção</span>
        {% endif %}
        {% if pedido[':status'] == 3 %}
        {% if pedido[':tipo_frete'] == 1 %}
            <span class="bg-secondary white-color full_id">Pronto para retirar</span>
        {% else %}
            <span class="bg-secondary white-color full_id">Saiu para entregar</span>
        {% endif %}

        {% endif %}
        {% if pedido[':status'] == 4 %}
        <span class="bg-success white-color full_id">Entregue</span>
        {% endif %}
        {% if pedido[':status'] == 5 %}
        <span class="bg-danger white-color full_id">Recusado</span>
        {% endif %}
        {% if pedido[':status'] == 6 %}
        <span class="bg-secondary white-color full_id">Cancelado</span>
        {% endif %}
        
        <div class="modal-header">
        {% if frete[':id'] == 2 %}
            <span class="bg-success white-color codB">Pedido para {{frete[':tipo']}}</span>
        {% else %}
            <span class="bg-warning white-color codB">Cliente vai {{frete[':tipo']}}</span>
        {% endif %}
                <h5 class="modal-title"><strong>Pedido #{{pedido[':numero_pedido']}}</strong>
                <br><span class="horas">Recebido {{pedido[':data']|date('d/m/Y')}} ás: {{pedido[':hora']|date('H:i')}}<span>
                
                </h5>
                <button id="close-modal" type="button" class="closes" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
		<content>
		<div class="env">
                <h5>Cliente: {{cliente[':nome']}}</h5>
                <strong>Telefone: </strong><a href="https://api.whatsapp.com/send?phone=55{{cliente.telefone}}" target="_Blank">({{ cliente.telefone[:2] }}) {{ cliente.telefone|slice(2, 5) }}-{{ cliente.telefone|slice(7, 9) }}</a>

                <div class="env cli_dados">
				{% if pedido[':tipo_frete'] == 1 %}
					<h6>Cliente vai retirar</h6>
                    {% else %}
                    <h6>Dados para entrega:</h6>
				    <strong>Endereço:</strong> {{endereco[':rua']}}, {{endereco[':numero']}} - {{endereco[':bairro']}} <br/>
                    {% if endereco[':complemento'] is not null %}
				    <strong>Complemento:</strong> {{endereco[':complemento']}}<br/>
                    {% endif %}
				    <strong>CEP:</strong> {{endereco[':cep']}}
                {% endif %}
			</div>
	    </div>
		
		<hr/>
		<strong>Tipo pagamento:</strong> <span>{{pagamento[':tipo']}}</span> | 
        {% if pedido[':tipo_pagamento'] == 1 %}
		<strong>Troco para:</strong>  <span>{{ moeda[':simbolo }} {{ pedido[':troco']|number_format(2, ',', '.') }}</span> | 
        {% endif %}
		<strong>KM:</strong>  <span>{{pedido[':km']}}</span>
        <hr/>
		<div class="env">
		<h6>Item do Pedido:</h6>
		<ul class="list_prod">
        {% for car in  carrinho %}
            {% for prod in  produtos %}
                {% if car[':id_produto'] == prod[':id'] %}

                <li class="odd"><strong>{{ car[':quantidade']}}x - {{ prod[':nome }}</strong>
                <span class="moeda_valor right rtt">{{ moeda[':simbolo }} {{ (car[':valor'] * car[':quantidade'])|number_format(2, ',', '.') }}</span>
                {% if car[':observacao'] != "" %}
                    <span>(<strong>Obs.:</strong> {{car[':observacao']}})</span>
                {% endif %}

                    {% for s in sabores %}
                    {% if s[':id'] == car[':id_sabores'] %}
                    <strong>- {{ s[':nome }} </strong>
                    {% endif %}
                    {% endfor %}


                    {% for cartAd in carrinhoAdicional %}
                            {% if prod[':id'] == cartAd[':id_produto'] %}
                                {% for a in adicionais %}
                                    {% if a[':id'] == cartAd[':id_adicional'] %}
                                    <p class="m-0 small subprice">
                                    - <strong>{{ cartAd[':quantidade }}
                                    x </strong>{{ a[':nome }} <span class="moeda_valor right rtt">{{ moeda[':simbolo }} {{ (a[':valor'] * cartAd[':quantidade'])|number_format(2, ',', '.') }}</span>
                                    </p>
                                    {% endif %}
                                {% endfor %}
                            {% endif %}
                        {% endfor %}


                </li>
                {% endif %}
            {% endfor %}
        {% endfor %}
        </ul>
        
	<hr/>
    {% if pedido[':tipo_pagamento'] == 1 %}
    <div class="env subtotal"><strong class="color-money">Pagamento em {{pagamento[':tipo']}} levar troco de:</strong><span class="color-money">{{ moeda[':simbolo }} {{ (pedido[':troco'] - pedido[':total_pago'])|number_format(2, ',', '.') }}</span></div>
    {% endif %}
    
    <div class="env subtotal"><strong>Subtotal:</strong><span>{{ moeda[':simbolo }} {{ pedido[':total']|number_format(2, ',', '.') }}</span></div>
    <div class="env subtotal"><strong>Frete:</strong><span>{{ moeda[':simbolo }} {{ pedido[':valor_frete']|number_format(2, ',', '.') }}</span></div>
	<div class="env total"><strong>Total:</strong><span>{{ moeda[':simbolo }} {{ pedido[':total_pago']|number_format(2, ',', '.') }}</span></div>
	<hr/>
    {% if pedido[':status'] == 2 %}
    {% if pedido[':tipo_frete'] == 1 %}
    {% else %}
    <div class="env motoboy_select">
        <h6>Qual Motoboy vai entregar?</h6>
            <input type="hidden" name="id_cliente" id="id_cliente" value="{{cliente[':id']}}">
            <input type="hidden" name="chave" id="chave" value="{{pedido[':chave']}}">
            <input type="hidden" name="numero_pedido" id="numero_pedido" value="{{pedido[':numero_pedido']}}">

                <select class="form-control select2-single" id="motoboy-{{pedido[':id']}}" name="motoboy-{{pedido[':id']}}">
                    <option value="0" selected>Selecione Motoboy</option>
                    {% for m in motoboy %}
					<option value="{{ m[':id }}">{{ m[':nome }}</option>
                    {% endfor %}
	            </select>
        </div>
        {% endif %}
    {% endif %}
</div>
</content>
<footer>
{% if pedido[':status'] == 1 %}
    {% set count = pedido[':status'] %}
    {% set count = count + 1 %}
    <div class="btn_acao"><div class="carrega"></div>
        <button class="col-meio btn-processo bg-danger" onclick="mudarStatus({{pedido[':id']}}, {{count}}, {{caixa[':id']}})" id="btn-carrinho">Colocar em produção<i class="simple-icon-arrow-right"></i></button>
    </div>
{% endif %}
{% if pedido[':status'] == 2 %}
    {% set count = pedido[':status'] %}
    {% set count = count + 1 %}
    <div class="btn_acao"><div class="carrega"></div>
        <button class="col-meio btn-processo bg-warning" onclick="mudarStatusEntrega({{pedido[':id']}}, {{count}}, {{caixa[':id']}})" id="btn-carrinho">

    {% if pedido[':tipo_frete'] == 1 %}
    Pronto para retirada
    {% else %}
    Entregar ao motoboy{% endif %}<i class="simple-icon-arrow-right"></i></button>
    </div>
{% endif %}

{% if pedido[':status'] == 3 %}
    {% set count = pedido[':status'] %}
    {% set count = count + 1 %}
    <div class="btn_acao"><div class="carrega"></div>
        <button class="col-meio btn-processo bg-secondary" onclick="mudarStatus({{pedido[':id']}}, {{count}}, {{caixa[':id']}})" id="btn-carrinho">Pedido entregue<i class="simple-icon-arrow-right"></i></button>
    </div>
        {% endif %}


{% if pedido[':status'] >= 3 %}
{% if pedido[':status'] == 5 %}
        <span>Pedido Recusado</span><br/>
        <span><strong>Motivo:</strong> {{ pedido[':observacao }}</span><br/>
        <span><strong>Hora:</strong> {{ pedido[':hora']|date('H:i') }}</span>
{% endif %}
        {% if pedido[':status'] == 6 %}
        <span>Pedido Cancelado pelo Cliente</span>
{% endif %}
{% endif %}


 </footer>
 <div id="mensagem{{pedido[':id']}}" class="text-center full_id mt-2"></div>
 <div class="serrilha"></div>
</div>

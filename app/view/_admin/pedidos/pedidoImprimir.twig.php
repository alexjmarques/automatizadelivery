<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Automatiza Delivery</title>
</head>

<body>
    <script>
        window.onload = function() {
            window.print();
        }
        window.addEventListener('afterprint', (event) => {
            window.close();
        });
        window.onafterprint = (event) => {
            window.close();
        };
        window.onafterprint = function() {
            window.close();
        }
    </script>
    <div style="width: 100%; font-family: sans-serif; font-size: 14px;">
        <table style="width:100%;">
            <tr align="center">
                <td style="text-align:center;"><span style="text-transform: uppercase;">PEDIDO DE VENDA</span></td>
            </tr>
        </table>

        <table style="width:100%; font-family: sans-serif; font-size: 12px;">
            <tr>
                <td align="center">{% if pedido.tipo_frete == 1 %}
                    <span style="text-transform: uppercase;">Cliente vai {{tipoFrete.tipo}}</span>
                    {% else %}
                    <span style="text-transform: uppercase;">Pedido para {{tipoFrete.tipo}}</span>
                    {% endif %}
                </td>
            </tr>
        </table>
        <table style="width:100%; margin-top:0px;">
            <tr>
                <td align="center">
                    <h4 style="font-family: sans-serif; font-size: 22px;">Nº {{pedido.numero_pedido}}</h4>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <p style="font-family: sans-serif; font-size: 14px;">Data pedido {{pedido.data_pedido|date("d/m/Y")}}</p>
                </td>
            </tr>
        </table>

        <table style="width:100%;  margin-top:10px; border-top: 2px double #000; font-family: sans-serif; font-size: 14px;">
            <tr>
                <td align="left" style="padding-top:10px;"><strong>DADOS CLIENTE</strong></td>
            </tr>

        </table>
        <table style="width:100%;  margin-top:5px; font-family: sans-serif; font-size: 13px;">
            <tr>
                <td align="left">Cliente: {{cliente.nome}}</td>

            </tr>
            <tr>
                <td align="left" style="padding-bottom: 10px;">Telefone: ({{ cliente.telefone[:2] }}) {{ cliente.telefone|slice(2, 5) }}-{{ cliente.telefone|slice(7, 9) }}</td>
            </tr>

            <tr>
                <td align="left" style="border-top: 1px dotted #000; border-bottom: 1px solid #ccc; padding-bottom: 10px; font-family: sans-serif; font-size: 13px;">
                    {% if pedido.tipo_frete == 1 %}
                    <h4 style="margin: 15px 0 3px 0; padding:0;">Cliente vai retirar</h4>
                    {% else %}
                    <h4 style="margin: 15px 0 3px 0; padding:0;">Dados para entrega:</h4>
                    <strong>Endereço:</strong> {{endereco.rua}}, {{endereco.numero}}<br />
                    {% if endereco.complemento is not null %}
                    <strong>Complemento:</strong> {{endereco.complemento}}<br />
                    {% endif %}
                    <strong>Bairro:</strong> {{endereco.bairro}} <br />
                    <strong>CEP:</strong> {{endereco.cep}}
                    {% endif %}

                </td>
            </tr>
        </table>

        <table style="width:100%;  margin-top:5px; border-top: 2px double #000; font-family: sans-serif; font-size: 14px;">
            <tr>
                <td align="left" style="padding-top:10px;"><strong>ITENS DO PEDIDO</strong></td>
            </tr>

        </table>

        <table style="width:100%; margin-top:5px;">

            {% for car in carrinho %}
            {% for prod in  produtos %}
            {% if pedido.numero_pedido == car.numero_pedido %}
            {% if car.id_produto == prod.id %}
            <tr>
                <td style="border-bottom: 1px dotted #000; padding-top:5px; padding-bottom:5px; font-family: sans-serif; font-size: 13px;"><strong>{{ car.quantidade}}x </strong>- {% if car.variacao is not null %}{% set foo = car.variacao|split(' - ') %}<strong>{{ foo[0] }}</strong><br />{% else %}<strong>{{ prod.nome }}</strong>{% endif %}
                    <span>{{ moeda.simbolo }} {{ (car.valor * car.quantidade)|number_format(2, ',', '.') }}</span>
                    {% if car.observacao != "" %}
                    <span>(<strong>Obs.:</strong> {{car.observacao}})</span>
                    {% endif %}

                    {% if car.variacao is not null %}
                    <p class="mb-0 mt-0"><strong>Borda:</strong>
                        {{ foo[1] }}<br />
                    </p>

                    <p class="mb-0 mt-0"><strong>Sabor: </strong>
                        {% if foo[2] %}{{ foo[2] }}{% endif %}
                        {% if foo[3] %}<br> - {{ foo[3] }}{% endif %}
                        {% if foo[4] %}<br> - {{ foo[4] }}{% endif %}
                        {% if foo[5] %}<br> - {{ foo[5] }}{% endif %}
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
                    <br />- <strong>{{ cartAd.quantidade }}
                        x </strong>{{ a.nome }} <span style="width: 100%;">{{ moeda.simbolo }} {{ (a.valor * cartAd.quantidade)|number_format(2, ',', '.') }}</span>
                    {% endif %}
                    {% endfor %}

                    {% endif %}
                    {% endfor %}
                </td>
            </tr>
            {% endif %}
            {% endif %}
            {% endfor %}
            {% endfor %}
        </table>
        <table style="width:100%;  margin-top:5px; font-family: sans-serif; font-size: 13px;">
            {% if pedido.tipo_pagamento == 1 %}
            <tr>
                <td><strong class="color-money-off">Pagamento em {{pagamento.tipo}} levar troco de:</strong></td>
                <td><span class="color-money-off">{{ moeda.simbolo }} {{ (pedido.troco - pedido.total_pago)|number_format(2, ',', '.') }}</span></td>
            </tr>
            {% endif %}
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td><span>{{ moeda.simbolo }} {{ pedido.total|number_format(2, ',', '.') }}</span></td>
            </tr>

            {% if cupomValor %}
            <tr>
                <td><strong>Cupom Desconto:</strong></td>
                <td><span> - {{ moeda.simbolo }} {{ cupomValor|number_format(2, ',', '.') }}</span></td>
            </tr>
            {% endif %}

            {% if pedido.desconto %}
            <tr>
                <td><strong>Desconto:</strong></td>
                <td><span> - {{ moeda.simbolo }} {{ pedido.desconto|number_format(2, ',', '.') }}</span></td>
            </tr>
            {% endif %}

            {% if pedido.tipo_frete == 2 %}
            <tr>
                <td><strong>Taxa de Entrega:</strong></td>
                <td><span>{{ moeda.simbolo }} {{ pedido.valor_frete|number_format(2, ',', '.') }}</span></td>
            </tr>
            {% endif %}

            <tr>
                <td><strong>Total:</strong></td>
                <td><span>{{ moeda.simbolo }} {{ pedido.total_pago|number_format(2, ',', '.') }}</span></td>
            </tr>

            {% if pagamento.code == 7 %}
            <hr />
            <tr>
                <td>Cliente vai pagar <strong>{{ moeda.simbolo }} {{clientePagamento.pag_dinheiro|number_format(2, ',', '.')}}</strong> em Dinheiro e <strong>{{ moeda.simbolo }} {{clientePagamento.pag_cartao|number_format(2, ',', '.')}} no Cartão</strong></td>
            </tr>
            {% endif %}
            {% if nf_paulista.numero_pedido is not null %}
            <hr />
            <tr>
                <td>Cliente Pediu Nota Fiscal Paulista no CPF <strong>{{nf_paulista.cpf}}</strong></td>
            </tr>
            {% endif %}
        </table>

        <table style="width:100%;  margin-top:10px; border-top: 2px double #000; font-family: sans-serif; font-size: 14px;">
            <tr>
                <td align="left" style="padding-top:10px;"><strong>TIPO PAGAMENTO</strong></td>
            </tr>
        </table>

        <table style="width:100%;  margin-top:5px; font-family: sans-serif; font-size: 13px;">
        {% if pedido.tipo_pagamento == 1 %}
            <tr>
                <td align="left">Pagamento em {{pagamento.tipo}} levar troco de: {{ moeda.simbolo }} {{ (pedido.troco - pedido.total_pago)|number_format(2, ',', '.') }}</td>
            </tr>
            {% else %}
            <tr>
                <td align="left">Pagamento em {{pagamento.tipo}}</td>

            </tr>
            {% endif %}
        </table>
        <table style="width:100%;margin-top:5px; text-align:center; font-family: sans-serif; font-size: 11px;">
            <tr>
                <td align="center">{{empresa.nome_fantasia}}</td>
            </tr>
            <tr>
                <td align="center">({{ empresa.telefone[:2] }}) {{ empresa.telefone|slice(2, 5) }}-{{ empresa.telefone|slice(7, 9) }}</td>
            </tr>
        </table>

        <table style="width:100%;margin-top:5px; text-align:center; font-family: sans-serif; font-size: 9px;">
            <tr>
                <td align="center">Automatiza Delivery</td>
            </tr>
        </table>
    </div>
</body>

</html>
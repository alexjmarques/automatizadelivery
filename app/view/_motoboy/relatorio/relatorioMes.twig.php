
<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th scope="col">Data</th>
            
            <th scope="col">Valor</th>
            <th scope="col">Pago</th>
        </tr>
    </thead>
    <tbody>
    {% for en in busca %}
        {% if en.data|date("m") == dataEscolhida %}
        {% if en.id_motoboy == usuarioAtivo.id %}
            <tr>
                <td>
                {{en.data|date('d/m/Y')}}
                </td>
                <td>
                {% for p in pedidos %}
                    {% if p.numero_pedido == en.numero_pedido %}
                        {{ moeda.simbolo }} {{ (p.valor_frete - frete.taxa_entrega_motoboy)|number_format(2, ',', '.')}}
                    {% endif %}
                {% endfor %}
                </td>
                <td>
                    {% if en.pago is not null %}
                    <span class="text-success cartao text-center size14"><i class="feather-check-circle"></i></span>
                    {% else %}
                    <span class="text-danger cartao text-center size14"><i class="feather-x-circle"></i></span>
                    {% endif %}
                </td>
            </tr>
            {% endif %}
            {% endif %}
        {% endfor %}
    </tbody>
</table>
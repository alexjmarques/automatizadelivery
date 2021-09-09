
{{en.id_motoboy}}
<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th scope="col">Data</th>
            <th scope="col">nº Pedido</th>
            <th scope="col">KM</th>
        </tr>
    </thead>
    <tbody>
    {% for en in busca %}
        {% if en.data_pedido|date("m") == dataEscolhida %}
        {% if en.id_motoboy == usuarioAtivo.id %}
            <tr>
                <td>
                {{en.data_pedido|date('d/m/Y')}}
                </td>
                <td>
                    {{en.numero_pedido}}
                
                </td>
                <td>

                {{en.km}}
                    
                </td>
            </tr>
            {% endif %}
            {% endif %}
        {% endfor %}
    </tbody>
</table>
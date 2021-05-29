{% for p in pedidos|sort|reverse %}
{% if p.status >= 3 %}
{% if caixaId == p.id_caixa %}
<li data-status="{{p.status}}">
    <content data-toggle="modal" data-target="#modPedido" onclick="produtosModal({{p.id}}, {{p.numero_pedido}} )">
    {% if p.status == 3 %}
        {% if p.tipo_frete == 1 %}
            <div class="bg-secondary white-color full_id">Pronto para retirar</div>
        {% else %}
            <div class="bg-secondary white-color full_id">Saiu para entregar</div>
        {% endif %}
    {% endif %}
    {% if p.status == 4 %}
        <div class="bg-success white-color full_id">Entregue</div>
    {% endif %}
    {% if p.status == 5 %}
        <div class="bg-danger white-color full_id">Recusado</div>
    {% endif %}
    {% if p.status == 6 %}
        <div class="bg-secondary white-color full_id">Cancelado</div>
    {% endif %}</h6>

        <div class="col-meio-in">
        {% for c in clientes %}
            {% if p.id_cliente == c.id %}
                <strong>Cliente: {{c.nome}}</strong><br>
                <strong>Telefone: </strong><a href="https://api.whatsapp.com/send?phone=55{{c.telefone|replace({' ':"", '(': "", ')': "", '-': ""})}}" target="_Blank">{{c.telefone}}</a>
            {% endif %}
        {% endfor %}
        </div>
        <div class="col-meio right">
            <h5>Pedido #{{p.numero_pedido}}</h5>
                Hora: {{p.hora|date('H:i')}}
        </div>
	</content>
</li>
{% endif %}
{% endif %}

{% endfor %}
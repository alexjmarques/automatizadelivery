
{% for p in pedidos %}
{% if p.status == 2 %}
<li data-status="{{p.status}}">
<content data-toggle="modal" data-target="#modPedido" onclick="produtosModal({{p.id}}, {{p.numero_pedido}} )">
        <div class="col-meio-in">
        {% for c in clientes %}
        {% if p.id_cliente == c.id %}
                <strong>Cliente: {{c.nome}}</strong><br>
                <strong>Telefone: </strong><a href="https://api.whatsapp.com/send?phone=55{{c.telefone}}" target="_Blank">({{ c.telefone[:2] }}) {{ c.telefone|slice(2, 5) }}-{{ c.telefone|slice(7, 9) }}</a>
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
{% endfor %}
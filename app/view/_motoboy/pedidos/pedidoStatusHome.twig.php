

{% for ul in ultimaVenda %}
{% if ul.status == 1 or ul.status == 2 %}
<a class="status producao {{ ul.status }}" href="{{BASE}}{{empresa.link_site}}/meu-pedido/{{ ul.chave }}">
        <div class="col-12">
                <div class="d-flex list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                    
                    <div class="col-3 pedido_n">
                        <span>Nº Pedido</span>
                        <h4 class="numero">#{{ ul.numero_pedido }}</h4>
                    </div>

                    <div class="col-9 p-3 position-relative">
                        <div class="list-card-body">
                            <h6 class="mb-1">Fique Atento seu pedido chegará em breve</h6>
                            <p class="text-gray">Status Atual: <strong>
                                
                            {% if ul.status == 1 %}
                            <span class="badge badge-info">Recebido</span>
                            {% endif %}

                            {% if ul.status == 2 %}
                            <span class="badge badge-warning">Produção</span>
                            {% endif %}

                            {% if ul.status == 3 %}
                                {% if ul.tipo_frete == 1 %}
                                <span class="badge badge-secondary">Pronto para retirar</span>
                                {% else %}
                                <span class="badge badge-secondary">Saiu para entregar</span>
                                {% endif %}
                            {% endif %}

                            {% if ul.status == 4 %}
                            <span class="badge badge-success">Entregue</span>
                            {% endif %}

                            {% if ul.status == 5 %}
                            <span class="badge badge-danger">Recusado</span>
                            {% endif %}

                            {% if ul.status == 6 %}
                            <span class="badge badge-secondary">Cancelado</span>
                            {% endif %}</strong></p>
                        </div>
                    </div>
                </div>
        </div>
</a>
{% endif %}
{% endfor %}




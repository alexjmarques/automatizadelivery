
{% for ul in ultimaVenda %}
{% if ul[':status'] > 0 %}
{% if ul[':status'] < 4 %} 
<a data-status="{{ul[':status']}}" class="status {% if ul[':status'] == 1 %}recebido{% endif %} {% if ul[':status'] == 2 %}producao{% endif %} {% if ul[':status'] == 3 %}saiu-entregar{% endif %} {{ ul[':status }}" href="{{BASE}}{{empresa.link_site}}/meu-pedido/{{ ul[':chave }}">
        <div class="col-12">
                <div class="d-flex list-card bg-white h-100 overflow-hidden position-relative shadow-sm">
                    <div class="col-4 pedido_n p-2">
                        <span class="pt-0 mt-2">Nº Pedido</span>
                        <h4 class="numero">#{{ ul[':numero_pedido }}</h4>
                    </div>
                    <div class="col-8 p-2 position-relative">
                        <div class="list-card-body">
                            <h6 class="mb-1 fttHome">Fique Atento seu pedido chegará em breve</h6>
                            <p class="text-gray">Status Atual: <strong>
                                
                            {% if ul[':status'] == 1 %}
                            <span class="statusSpan">Recebido</span>
                            {% endif %}

                            {% if ul[':status'] == 2 %}
                            <span class="statusSpan">Em Produção</span>
                            {% endif %}

                            {% if ul[':status'] == 3 %}
                                {% if ul[':tipo_frete'] == 1 %}
                                <span class="statusSpan">Pronto para retirar</span>
                                {% else %}
                                <span class="statusSpan">Saiu para entregar</span>
                                {% endif %}
                            {% endif %}
                            </strong></p>
                        </div>
                    </div>
                </div>
        </div>
</a>
{% endif %}
{% endif %}
{% endfor %}




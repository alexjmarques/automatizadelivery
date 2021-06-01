{% if ultimaVenda.status > 0 %}
{% if ultimaVenda.status < 4 %} 
<a data-status="{{ultimaVenda.status}}" class="status {% if ultimaVenda.status == 1 %}recebido{% endif %} {% if ultimaVenda.status == 2 %}producao{% endif %} {% if ultimaVenda.status == 3 %}saiu-entregar{% endif %} {{ ultimaVenda.status }}" href="{{BASE}}{{empresa.link_site}}/meu-pedido/{{ ultimaVenda.chave }}">
        <div class="col-12">
                <div class="d-flex list-card bg-white h-100 overflow-hidden position-relative shadow-sm">
                    <div class="col-4 pedido_n p-2">
                        <span class="pt-0 mt-2">Nº Pedido</span>
                        <h4 class="numero">#{{ ultimaVenda.numero_pedido }}</h4>
                    </div>
                    <div class="col-8 p-2 position-relative">
                        <div class="list-card-body">
                            <h6 class="mb-1 fttHome">Fique Atento seu pedido chegará em breve</h6>
                            <p class="text-gray">Status Atual: <strong>
                            {% for st in status %}
                                {% if st.id == ultimaVenda.status %}
                                {% if ultimaVenda.tipo_frete == 1 %}
                                <span class="statusSpan bg-{{st.class}}">{{st.retirada}}</span>
                                {% else %}
                                <span class="statusSpan bg-{{st.class}}">{{st.delivery}}</span>
                                {% endif %}
                                {% endif %}
                            {% endfor %}
                            </strong>
                            </p>
                        </div>
                    </div>
                </div>
        </div>
</a>
{% endif %}
{% endif %}




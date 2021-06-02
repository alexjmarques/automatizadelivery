<div class="bg-primary border-bottom px-3 pt-3  d-flex ">
    <div class="col-md-7 float-left pl-0">
        <h3 class="font-weight-bold m-0 text-white pb-3">Sacola de Itens</h3>
    </div>
    <div class="col-md-5 float-left pr-0">
        
    </div>
</div>
{% for c in carrinho %}
        {% for p in produtos %}
            {% if p.id == c.id_produto %}
                <div class="gold-members d-flex justify-content-between px-3 py-2 border-bottom">
                    <div class="media full-width">
                            <div class="media-body">
                            <a href="{{BASE}}{{empresa.link_site}}/admin/carrinho/deletar/{{c.id_produto}}/{{c.id}}" class="btn excluir_prod"><i class="simple-icon-close"></i></a>
                                <p class="m-0 small-mais"><strong>{{c.quantidade}}x {{ p.nome }}</strong>
                                    <span class="text-gray mb-0 float-right ml-2 text-muted text-bold-18"><strong>{{ moeda.simbolo }} {{ (c.quantidade * c.valor)|number_format(2, ',', '.') }}</strong></span>
                                </p>
                                {% if c.id_sabores != '' %}
                                <p class="m-0 mt-0"><strong>Sabor: </strong>
                                {{c.id_sabores|length}}
                                {% for s in sabores %}
                                    {% if s.id in c.id_sabores %}
                                        {{ s.nome }}{% if c.id_sabores|length > 1 %}, {% endif %}
                                    {% endif %}
                                {% endfor %}
                                </p>
                                {% endif %}
            
                                {% if c.observacao != '' %}
                                    <p class="mb-0 mt-0"><strong>Observação: </strong>
                                        {{c.observacao}}
                                    </p>
                                {% endif %}

                                {% for cartAd in carrinhoAdicional %}
                                    {% if p.id == cartAd.id_produto %}
                                        {% for a in adicionais %}
                                        {% if a.id == cartAd.id_adicional and p.id == cartAd.id_produto and c.id == cartAd.id_carrinho %}
                                            <p class="m-0 small subprice">
                                            - <strong>{{ cartAd.quantidade }}
                                            x </strong>{{ a.nome }} 
                                            {% if cartAd.valor == 0.00 %}
                                                <span class="moeda_valor right text-bold-18">-</span><br />
                                                {% else %}
                                                <span class="moeda_valor right text-bold-18">{{ moeda.simbolo }} {{ (a.valor * cartAd.quantidade)|number_format(2, ',', '.') }}</span><br />
                                                {% endif %}
                                        </p>
                                            {% endif %}
                                        {% endfor %}
                                        
                                    {% endif %}
                                {% endfor %}
                                
                            </div>
                    </div>
                </div>
            {% endif %}
        {% endfor %}
    {% endfor %}

    <h6 class="font-weight-bold mb-0 p-3 pt-2 pb-2">Total <span class="float-right"> <span id="total">{{ moeda.simbolo }} {{ valorPedido|number_format(2, ',', '.') }}</span></span></h6>
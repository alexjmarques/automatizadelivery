<h2 class="bold">{{ cliente.nome }}</h2>
<p>({{ cliente.telefone[:2] }}) {{ cliente.telefone|slice(2, 5) }}-{{ cliente.telefone|slice(7, 9) }}
<div class="containersTabela">
<div class="containers row-wrap row">
    <div class="tt col-6 p-1">Cliente desde:</div><div class="cont col-6 p-1">{{ cliente.created_at|date('d/m/Y') }}</div>
</div>
<div class="containers row-wrap row">
    <div class="tt col-6 p-1">Último pedido feito:</div><div class="cont col-6 p-1">{{pedidosUltimo.data_pedido|date('d/m/Y')}}</div>
</div>
<div class="containers row-wrap row">
    <div class="tt col-6 p-1">Quantidade de pedidos:</div><div class="cont col-6 p-1">{{ pedidosFeito }}</div>
    </div>
<!-- <div class="containers row-wrap row">
    <div class="tt col-6 p-1">Pagamento mais utilizado:</div><div class="cont col-6 p-1">{% for tipoPag in tipoPagamento %}{% if tipoPagamento == tipoPag.code %}{{ tipoPag.tipo }}{% endif %}{% endfor %}</div>
    </div> -->
<div class="containers row-wrap row">
    <div class="tt col-6 p-1">Pedidos cancelados:</div><div class="cont col-6 p-1">{{ totalCancelados }}</div>
    </div>
    <div class="containers row-wrap row">
    <div class="tt col-6 p-1">Pedidos Recusado:</div><div class="cont col-6 p-1">{{ totalRecusado }}</div>
    </div>
<div class="containers row-wrap row">
    <div class="tt col-6 p-1">Total em pedidos:</div><div class="cont col-6 p-1">{{moeda.simbolo}} {{vendas.total|number_format(2, ',', '.')}}</div>
    </div>
<div class="containers row-wrap row">
    <div class="tt col-6 p-1">Total em pedidos concluídos:</div><div class="cont col-6 p-1 text-success bold">{{moeda.simbolo}} {{totalFinal.total|number_format(2, ',', '.')}}</div>
    </div>
</div>
    

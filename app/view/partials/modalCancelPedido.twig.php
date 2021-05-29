<div id="cancelarPedido" class="modal fade" tabindex="-1" aria-labelledby="cancelarPedido" aria-hidden="true" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p id="mensagem" class="mb-3 text-center">Deseja realmente cancelar seu pedido?<p>
        <div class="mt-3">
        <form method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/meu-pedido/cancelar" novalidate>
            <input type="hidden" id="id" name="id" value="{{venda[':id']}}">
            <input type="hidden" id="numero_pedido" name="numero_pedido" value="{{venda[':numero_pedido']}}">
            <button class="mt-3 btn btn-lg btn-block btn-continuar">Sim Cancelar</button>
        </form>
        <a href="#" class="mt-3 btn btn-primary btn-lg btn-block" data-dismiss="modal" aria-label="Close">Não Cancelar</a>
        </div>
      </div>
    </div>
  </div>
</div>
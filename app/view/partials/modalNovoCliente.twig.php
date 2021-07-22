<div id="modalNovoCliente" class="modal fade" tabindex="-1" aria-labelledby="modalNovoCliente" aria-hidden="true" role="dialog" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form method="post" autocomplete="off" id="formCliente" action="{{BASE}}{{empresa.link_site}}/admin/novo/cliente" enctype="multipart/form-data">
          <div class="bg-white mb-3">
            <h2>Novo Cliente</h2>
            <p class="mb-0 text-left pl-1 p-0 pb-0"> <strong>Informe os dados de seu cliente</strong></p>

            <p class="text-muted m-0 small pl-1">(Campos Obrigatório <span style="color:red;">*</span>)</p>
            <div class="form-row pt-2 pb-0 m-0">

              <div class="form-group col-md-8 pb-0 mb-0">
                <label class="text-center">Seu nome <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="nome" name="nome" value="" required>
              </div>

              <div class="form-group col-md-4 pb-0 mb-0">
                <label class="text-center">Seu Telefone <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="" required>
              </div>
            </div>
          </div>

          <div class="bg-white mb-3 border-top mt-1 pt-2 ">
            <label class="col-12 col-form-label" style="padding-left: 0;"><strong>Pedido para Entrega</strong></label>
            <select id="entrega" name="entrega" class="form-control select2-single">
              <option value="1" selected>Pedido para Entrega</option>
              <option value="0">Cliente vai Retirar</option>
            </select>
          </div>

          <div id="endereco" class="bg-white mb-3 border-top mt-1 pt-2 ">

            <h6 class="mt-4 pb-2 bold">Endereço para entrega <span style="color:red;">*</span></h6>
            <p class="text-dark text-50">Ao digitar seu endereço e número, aparecerá um campo confirmando seu endereço completo. <strong style="color:red;">Clique nele para confirmar!</strong></p>
            <div class="form-group enderecoCampo">
              <svg class="landing-v2-address-search__pin-icon" width="22" height="23" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.835 17.274c-.555 0-1.058-.324-1.313-.855L4.305 9.635a5.985 5.985 0 0 1 .105-5.289c.81-1.56 2.22-2.557 3.855-2.731.367-.04.757-.04 1.125 0 1.635.174 3.037 1.172 3.855 2.731a5.96 5.96 0 0 1 .105 5.289.556.556 0 0 1-.758.269.62.62 0 0 1-.255-.8 4.726 4.726 0 0 0-.09-4.188c-.607-1.211-1.695-1.987-2.962-2.121a4.274 4.274 0 0 0-.9 0c-1.26.134-2.348.91-2.978 2.121a4.726 4.726 0 0 0-.082 4.188l3.217 6.785c.083.174.24.198.3.198s.218-.016.3-.198l1.613-3.412a.558.558 0 0 1 .757-.27.62.62 0 0 1 .255.8l-1.612 3.412c-.255.523-.758.855-1.32.855z" fill="currentColor"></path>
                <path d="M8.835 9.555c-1.275 0-2.317-1.1-2.317-2.446 0-1.354 1.042-2.446 2.317-2.446 1.275 0 2.318 1.1 2.318 2.446.007 1.354-1.035 2.446-2.318 2.446zm0-3.705c-.66 0-1.192.563-1.192 1.26 0 .696.532 1.258 1.192 1.258.66 0 1.193-.562 1.193-1.259.007-.696-.533-1.259-1.193-1.259z" fill="currentColor"></path>
              </svg>
              <input type="text" class="form-control" id="ship-address" name="ship-address" placeholder="Digite o endereço com número" required autocomplete="off">
            </div>

            <input type="hidden" id="rua" name="rua" value="" required>
            <input type="hidden" id="numero" name="numero" value="" required>
            <input type="hidden" id="cep" name="cep" value="">
            <input type="hidden" id="cidade" name="cidade" value="">
            <input type="hidden" id="bairro" name="bairro" value="">
            <input type="hidden" id="estado" name="estado" value="">

            <div class="form-group">
              <label for="telefone" class="text-dark">Complemento ou referência <span style="color:red;">*</span></label>
              <input type="text" class="form-control" id="complemento" name="complemento" required autocomplete="off">
            </div>
          </div>


          <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
          <button class="btn btn-info btn-sm acaoBtn btnValida">Cadastrar</button>
        </form>

      </div>
    </div>
  </div>
</div>
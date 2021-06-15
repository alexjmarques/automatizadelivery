<div id="modalNovoCliente" class="modal fade" tabindex="-1" aria-labelledby="modalNovoCliente" aria-hidden="true"
  role="dialog" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form method="post" autocomplete="off" id="formCliente" action="{{BASE}}{{empresa.link_site}}/admin/novo/cliente"
          enctype="multipart/form-data">
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
            <p class="mb-0 text-left pl-1 p-0 pb-0 pb-4"><strong> Endereço para entrega</strong></p>
            <div class="clearfix form-row pl-1 p-0 pb-0 m-0 pb-3">
              <div class="form-group col-md-8 pb-0 mb-0 cepL pl-0">
                <label class="text-center">Endereço <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="rua" name="rua" value="" required>
              </div>
              <div class="form-group col-md-4 pb-0 mb-0 pr-0 numL">
                <label class="text-center">Número <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="numero" name="numero" required>
              </div>
            </div>
            <div class="form-row p-0 pb-3 pt-3 m-0 pt-0 pl-0">
              <div class="form-group col-md-12 pb-0 pl-0 pr-0 mb-0">
                <label class="text-center">Complemento ou Referência <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="complemento" name="complemento">
              </div>
            </div>

            <div id="endOK" class="form-row cinza p-3 pb-0 m-0 mb-2" style="display: none;">
              <div class="form-group col-md-4 text-left pb-0 mb-0">
                <label class="text-left bold">Seu Endereço é? </label>
                <p class="mb-0 text-left color-theme-2 pb-2 full-width"><span id="endPrint"></span>
                </p>

              </div>
            </div>

            <input type="hidden" id="cep" name="cep">
            <input type="hidden" id="bairro" name="bairro">
            <input type="hidden" id="cidade" name="cidade">
            <input type="hidden" id="principal" name="principal" value="1">
            <input type="hidden" id="nome_endereco" name="nome_endereco" value="Principal">
            <input type="hidden" id="estado" name="estado" value="">

            <input type="hidden" id="cidadePrinc" name="cidadePrinc" value="{{ empresa.cidade }}">
            {% for end in estadosSelecao %}
            {% if end.id == empresa.estado %}
            <input type="hidden" id="estadoPrinc" name="estadoPrinc" value="{{ end.uf }}">
            {% endif %}
            {% endfor %}
          </div>


          <input type="hidden" id="id_empresa" name="id_empresa" value="{{empresa.id}}">
          <button class="btn btn-info btn-sm acaoBtn btnValida">Cadastrar</button>
        </form>
        
          </div>
        </div>
      </div>
    </div>
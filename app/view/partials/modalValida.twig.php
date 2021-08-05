<div id="ValidaCode" class="modal fade" tabindex="-1" aria-labelledby="ValidaCode" aria-hidden="true" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body osahan-verification p-5">
      <h4 class="mb-3 p-0">Verifique em seu telefone!</h4>
      <p>O código que enviamos para validar seu acesso.</p>
      <div class="row mx-0 mb-4 mt-3">
      <div class="col pr-1 pl-0 ">
      <input type="number" value="" name="codeValida" id="codeValida" class="form-control form-control-lg">
      <input type="hidden" id="id" name="id" value="{{usuario.id}}">
      </div>
      </div>
      <div class="btn_acao"><div class="carrega"></div>
      <button id="btnValidarCode" class="btn btn-success btn-block btn-lg btnValidarCode">VALIDAR</button>
      </div>
      </div>
    </div>
  </div>
</div>
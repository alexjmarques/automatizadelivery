{% extends 'partials/bodyAdmin.twig.php' %}
{% block title %}Admin Automatiza Delivery{% endblock %}
{% block body %}
<h1>Configurações da Impressora</h1>
<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
  <ol class="breadcrumb pt-0">
    <li class="breadcrumb-item">
      <a href="{{BASE}}{{empresa.link_site}}/admin">Painel</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Configurações da Impressora</li>
  </ol>
</nav>
<div class="separator mb-5"></div>
<div class="col-12 p-0">
  <form method="post" autocomplete="off" id="form" action="{{BASE}}{{empresa.link_site}}/admin/conf/u" enctype="multipart/form-data">
    <div class="card mb-4">
      
      <div class="card-body">
        <h5 class="mb-4">Impressora</h5>
        <div class="form-row">

          <div class="form-group col-md-4">
            <label for="nomeFantasia">Nome da Impressora</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{impressora.nome}}">
          </div>

          <div class="form-group col-md-8">
            <label for="inputEmail4">Nome da Impressora na Rede</label>
            <input type="text" class="form-control" id="code" name="code" value="{{impressora.code}}">
          </div>
          
        </div>
        <input type="hidden" id="id_empresa" name="id_empresa" value="{{impressora.id_empresa}}">
        <div class="btn_acao"><div class="carrega"></div><button class="btn btn-info d-block mt-3 acaoBtn acaoBtnAtualizar">Atualizar</button></div>

      </div>
      
  </form>


  <form>
  <input type="button" onclick="directPrintBytes(printSocket, [0x1b, 0x40, 0x48, 0x65, 0x6c, 0x6c, 0x6f, 0x20, 0x77, 0x6f, 0x72, 0x6c, 0x64, 0x0a, 0x1d, 0x56, 0x41, 0x03]);" value="Print test string"/>
  <input type="button" onclick="directPrintFile(printSocket, 'example.bin');" value="Load and print 'example.bin'" />
</form>

<script type="text/javascript">
/**
 * Retrieve binary data via XMLHttpRequest and print it.
 */
function directPrintFile(socket, path) {
  // Get binary data
  var oReq = new XMLHttpRequest();
  oReq.open("GET", path, true);
  oReq.responseType = "arraybuffer";
  console.log("directPrintFile(): Making request for binary file");

  oReq.onload = function (oEvent) {
    console.log("directPrintFile(): Response received");
    var arrayBuffer = oReq.response; // Note: not oReq.responseText
    if (arrayBuffer) {
      var byteArray = new Uint8Array(arrayBuffer);
      var result = directPrint(socket, byteArray);
      if(!result) {
        alert('Failed, check the console for more info.');
      }
    }
  };
  oReq.send(null);
}

/**
 * Extract binary data from a byte array print it.
 */
function directPrintBytes(socket, bytes) {
  var data = new ArrayBuffer(bytes.length);
  var dataView = new Uint8Array(data, 0, bytes.length);
  dataView.set(bytes, 0);
  var result = directPrint(socket, dataView);
  if(!result) {
    alert('Failed, check the console for more info.');
  }
}

/**
 * Serialise and send a Uint8Array of binary data.
 */
function directPrint(socket, printData) {
  // Type check
  if (!(printData instanceof Uint8Array)) {
    console.log("directPrint(): Argument type must be Uint8Array.")
    return false;
  }
  if(printSocket.readyState !== printSocket.OPEN) {
    console.log("directPrint(): Socket is not open!");
    return false;
  }
  // Serialise, send.
  var payloadString = JSON.stringify(Array.apply(null, printData));
  console.log("Sending " + printData.length + " bytes of print data.");
  printSocket.send(payloadString);
  return true;
}

/**
 * Connect to print server on startup.
 */
var printSocket = new WebSocket("ws://localhost:5555", ["protocolOne", "protocolTwo"]);
printSocket.onopen = function (event) {
  console.log("Socket is connected.");
}
printSocket.onerror = function(event) {
  console.log('Socket error', event);
};
printSocket.onclose = function(event) {
  console.log('Socket is closed');
}
</script>
</div>
{% include 'partials/modalImagem.twig.php' %}
{% endblock %}
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4">Dados Motoboy </h5>
                <strong>Nome:</strong>   {{ usuario.nome }}</br>
                <strong>Email:</strong> {{ usuario.email }}</br>
                <strong>Telefone:</strong> ({{ usuario.telefone[:2] }}) {{ usuario.telefone|slice(2, 5) }}-{{ usuario.telefone|slice(7, 9) }}</br> 
            </div>
        </div>
    </div>
</div>
<form  method="get" id="formInfoPagamento">
<div class="row mb-4">
    <div class="col-12 data-tables-hide-filter">
       <div class="card">
            <div class="card-body">
                <h5 class="mb-4 left">Entregas Feitas</h5>
                    <div class="top-right-button-container">
                            <div class="btn-group">
                                <div class="btn btn-primary btn-lg pl-4 pr-0">
                                <span class="pt1">Selecionar todos</span>
                                    <label class="custom-control custom-checkbox mb-0 align-self-center mr-0 mb-0 check-button p22d">
                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                        <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                </div>
                                <button type="button"
                                    class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split border-left"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ação
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <button class="dropdown-item" href="#">Informar Pagamento</button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 pl-0 ml-0">
                        <p class="text-left">Para informar que os valores já foram pagos ao Motoboy {{ usuario.nome}}, selecione o item desejado. Após isso no menu "Ação", selecione a opção "Informar Pagamento".</p>
                        </div>
                        
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Número Pedido</th>
                                        <th scope="col">Data e Hora</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Observação</th>
                                        <th scope="col">Pago</th>
                                        <th scope="col">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                

                                {% set count = 0 %}
                                {% for en in busca %}

                                {% if en.id_motoboy == motoboy.id %}
                                {% if data_inicio >= en.created_at|date('d/m/Y') %}
                                    {% if en.created_at|date('d/m/Y') <= dataTermino %}
                                        <tr>
                                        <th scope="row">
                                        {% if en.pago is null %}
                                                <label class="custom-control custom-checkbox mb-0 align-self-center mr-4 mb-1 check-button">
                                                    <input type="checkbox" class="custom-control-input checkItem" name="pago[]" id="pago{{en.id}}" value="{{en.id}}">
                                                    <span class="custom-control-label">&nbsp;</span>
                                                </label>
                                                {% endif %}

                                                
                                            </th>
                                            <td>
                                                #{{en.numero_pedido}}
                                            </td>
                                            <td>
                                                {{en.created_at|date('d/m/Y')}} {{en.created_at|date('H:i')}}
                                            </td>
                                            <td>
                                                {% if en.status == 4 %}
                                                <span class="badge badge-success white-color">Entregue</span>
                                                {% endif %}
                                                {% if en.status == 5 %}
                                                <span class="badge badge-danger white-color">Recusado</span>
                                                {% endif %}
                                                {% if en.status == 6 %}
                                                <span class="badge badge-secondary white-color">Cancelado</span>
                                                {% endif %}
                                            </td>

                                            <td>
                                                <p class="text-left">{{ en.observacao }}</p>
                                            </td>
                                            <td>
                                                {% if en.pago is not null %}
                                                <span class="text-success cartao text-center" data-toggle="tooltip" data-placement="top" title="Pago ao Motoboy {{ motoboy.nome}}"><i class="simple-icon-check"></i></span>
                                                {% else %}
                                                <span class="text-danger cartao text-center" data-toggle="tooltip" data-placement="top" title="Motoboy {{ motoboy.nome}} aguardando Pagamento"><i class="simple-icon-close"></i></span>
                                                {% endif %}
                                            </td>
                                            <td>
                                            {% for p in pedidos %}
                                                {% if en.numero_pedido in p.numero_pedido %}
                                                    <span class="sum" data-valor="{{ (p.valor_frete - frete.taxa_entrega_motoboy)}}">{{ moeda.simbolo }} {{ (p.valor_frete - frete.taxa_entrega_motoboy)|number_format(2, ',', '.')}}<span>
                                                {% endif %}
                                            {% endfor %}

                                            </td>
                                        </tr>
                                        {% set count = count + 1 %}


                                        {% endif %}
                                        {% endif %}
                                        {% endif %}
                                    {% endfor %}
                                    <tr>
                                        
                                            <td colspan="4">
                                                <p class="text-left">Foram <strong>{{ count }} entregas</strong> encontradas para esta consulta</p>
                                            </td>
                                           

                                            <td>
                                            </td>
                                            <td class="text-right">
                                                <strong>Total</strong>
                                            </td>
                                            <td>
                                            <strong id="valorTotal"></strong>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
        </form>
</div>
<script>
var sum1 = 0;

$.each($('.sum'),function(){
    var num = parseFloat($(this).attr('data-valor'));
    sum1 += num;
});
var valorFormatado = sum1.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
$('#valorTotal').text(valorFormatado);

$('#checkAll').click(function () {$(':checkbox.checkItem').prop('checked', this.checked)});
$("#formInfoPagamento").submit(function () {
    var checkeds = new Array();
    $("input[name='pago[]:checked").each(function ()
    {
        checkeds.push(parseInt($(this).val()));
    })
    var formData = {checkeds}
        $.ajax({
          url: "{{BASE}}{{empresa.link_site}}/admin/informar/pagamento/entregas",
          type: 'get',
          data: formData,
          success: function (dd) {
            console.log(dd);
            $.post("{{BASE}}{{empresa.link_site}}/admin/buscar/entregas", function (dd) {
              var id_motoboy = $(`#id_motoboy option:selected`).val();
              var inicio = $(`#inicio`).val();
              var hora_inicio = $(`#hora_inicio`).val();
              var termino = $(`#termino`).val();
              var horaFim = $(`#horaFim`).val();
              var formData = { id_motoboy, inicio, hora_inicio, termino, horaFim }
              if (parseInt(id_motoboy) === 0) {
                $('#mensagem').html(`<div class="alert alert-danger" role="alert">Para efetuar uma busca selecione um Motoboy as Data e Hora de Início e Fim para que o sistema possa carregar os dados</div>`)
              } else {
                    $.post({
                    url: "{{BASE}}{{empresa.link_site}}/admin/buscar/entregas",
                    type: 'get',
                    data: formData,
                    beforeSend: function () {$('.carregar').html('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>');},
                    complete: function (dd) {
                        $('.carregar').html('');
                    },
                    success: function (dd) {
                        $('#buscaResultado').html(dd);
                    }
                    });
              }
              $('#buscaResultado').html(dd);
              $('#mensagem').html('')
            })
          }
        });
  return false;
});
</script>

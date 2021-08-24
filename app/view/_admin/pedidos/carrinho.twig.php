<form class="mt-4 mb-4" method="post" id="formFinish" action="{{BASE}}{{empresa.link_site}}/admin/carrinho/finaliza" autocomplete="off">
<table id="customers" class="data-table">
    <thead class="linhaTop">
        <tr>
            <th style="width: 20px;">#</th>
            <th>Item</th>
        </tr>
    </thead>
    <tbody>
        {% for c in carrinho %}
        {% for p in produtos %}
        {% if p.id == c.id_produto %}
        <tr>
            <td>
                <button onclick="deletarProduto({{c.id_produto}}, {{c.id}})" class="btn excluir_prod"><i class="simple-icon-close"></i></button>
            </td>
            <td>
                <div class="media full-width">
                    <div class="media-body">

                        <p class="m-0 small-mais"><strong>{{c.quantidade}}x
                                {% if c.variacao is not null %}
                                {% set foo = c.variacao|split(' - ') %}<strong>{{ foo[0] }}</strong><br />{% else %}<strong>{{ p.nome }}</strong>{% endif %}
                                <span class="text-gray mb-0 float-right ml-2 text-muted text-bold-18"><strong>{{ moeda.simbolo }} {{ (c.quantidade * c.valor)|number_format(2,',', '.') }}</strong></span>
                        </p>
                        {% if c.variacao is not null %}
                        <p class="mb-0 mt-0"><strong>Borda:</strong>
                            {{ foo[1] }}<br />
                        </p>

                        <p class="mb-0 mt-0"><strong>Sabor: </strong>
                            {% if foo[2] %}{{ foo[2] }}{% endif %}
                            {% if foo[3] %} - {{ foo[3] }}{% endif %}
                            {% if foo[4] %} - {{ foo[4] }}{% endif %}
                            {% if foo[5] %} - {{ foo[5] }}{% endif %}
                        </p>
                        {% endif %}
                        {% if c.id_sabores != '' %}
                        {% for s in sabores %}
                        {% if s.id == c.id_sabores %}
                        {{ s.nome }}{% if c.id_sabores|length > 1 %}, {% endif %}
                        {% endif %}
                        {% endfor %}

                        {% endif %}

                        </p>

                        {% for cartAd in carrinhoAdicional %}
                        {% if p.id == cartAd.id_produto %}
                        {% for a in adicionais %}
                        {% if a.id == cartAd.id_adicional and p.id == cartAd.id_produto and c.id ==
                                            cartAd.id_carrinho %}
                        <p class="m-0 small subprice">
                            - <strong>{{ cartAd.quantidade }}
                                x </strong>{{ a.nome }} <span class="moeda_valor right text-bold-18">{{ moeda.simbolo }} {{
                                                    (a.valor * cartAd.quantidade)|number_format(2, ',', '.') }}</span>
                        </p>
                        {% endif %}
                        {% endfor %}
                        {% endif %}
                        {% endfor %}

                        {% if c.observacao != '' %}
                        <p class="mb-0 mt-0"><strong>Observação: </strong>
                            {{c.observacao}}
                        </p>
                        {% endif %}
                    </div>
                </div>
            </td>
        </tr>
        {% endif %}
        {% endfor %}
        {% endfor %}
    </tbody>
</table>

<div class="cinza p-2 mt-4">
    <h5 class="full-width pb-0 bold">Entrega ou Retirada?</h5>
    <div class="mb-0 input-group full-width mt-0">
        <select id="tipo_frete" name="tipo_frete" class="form-control" required>
            {% if km > km_entrega_excedente %}
            {% for t in tipo %}
            {% if t.status == 1 and t.code == 1 %}
            <option value="1" selected>Retirada</option>
            {% endif %}
            {% endfor %}
            {% else %}
            <option value="" {% if enderecoAtivo is null %}selected{% endif %}>Selecione
            </option>
            {% for t in tipo %}
            <option value="{{t.code}}" {% if enderecoAtivo is not null %}{% if t.code == 2 %}selected{%
                                            endif %}{% endif %}>{{t.tipo}}</option>
            {% endfor %}
            {% endif %}
        </select>
    </div>

    {% if km > km_entrega_excedente %}

    {% endif %}
    <hr>
    <div class="mb-0 input-group full-width mt-2 position-relative  col-6 float-left p-0">
        <h5 class="full-width pb-0 bold">Desconto</h5>
        <div class="input-group-sm mb-2 input-group full-width mt-0 desconto_cli">
            <span class="moedaSimb position-absolute">{{ moeda.simbolo }}</span> <input type="text" class="form-control valor pl-4" id="desconto" name="desconto" value="">
            {# <div class="input-group-append">
                <button id="button-desconto" type="button" class="btn btn-primary"> Aplicar</button>
            </div> #}
        </div>
    </div>
    <div class="mb-0 input-group full-width mt-2 col-6 float-left pr-0">
        <h5 class="full-width pb-0 bold">Formas de Pagamento</h5>
        <select id="tipo_pagamento" name="tipo_pagamento" class="form-control">
            <option value="">Selecione</option>
            {% for pag in pagamento %}
            <option value="{{pag.code}}">{{pag.tipo}}</option>
            {% endfor %}
        </select>
    </div>
    

    <div id="trocoMod" class="mt-1">
            <p class=" mt-3">Total em Dinheiro para calcular o seu Troco</p>
            <input type="text" class="form-control" id="trocoCli" placeholder="Total em Dinheiro" name="trocoCli">
            {# <a class="btn btn-primary full-btn mt-2" href="#" id="calcularTroco"> Calcular Troco </a> #}

    </div>
    <div class="clearfix"></div>
    <hr>
    <div class="mb-0 input-group full-width mt-0">
        <h5 class="full-width pb-0 bold">Observações do pedido</h5>
        <div class="clearfix"></div>
        <textarea name="observacao" id="observacao" placeholder="" aria-label="With textarea" class="form-control"></textarea>
    </div>

    {% if empresa.nfPaulista is not null %}

    <div class="mb-0 input-group full-width mt-0">
        <h5 class="full-width pb-0 bold">CPF na nota?</h5>
        <p class="full-width mb-1">Informe no campo a baixo!</p>
        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF">
    </div>

    {% endif %}
    <div class="full-width pt-4 pb-4">
        <input type="hidden" name="valorProduto" id="valorProduto" value="{% if p.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">

        <p class="mb-1">Subtotal<span class="float-right text-dark">{{ moeda.simbolo }} {{
                                            valorPedido|number_format(2, ',', '.') }}</span></p>
        {% if km <= km_entrega_excedente %} <p class="mb-1" id="freteCal">Taxa de
            Entrega<span class="float-right text-dark">{{ moeda.simbolo }} {{
                                            calculoFrete|number_format(2, ',', '.') }}</span></p>
        {% endif %}
        <!-- {% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}</span></p> -->
        <p class="mb-1 text-danger" id="descontoCliente" style="display:none;">Desconto<span class="float-right text-danger"> </span></p>
        <p class="mb-1 text-success" id="trocoCliente" style="display:none;">Seu Troco<span class="float-right text-success"> </span></p>
        <hr>
        {% if km > km_entrega_excedente %}
        <input type="hidden" name="total_pago" id="total_pago" value="{{ valorPedido }}">
        <input type="hidden" name="valor_frete" id="valor_frete" value="0">
        {% else %}
        <input type="hidden" name="total_pago" id="total_pago" value="{{ calculoFrete + valorPedido }}">
        <input type="hidden" name="valor_frete" id="valor_frete" value="{{ calculoFrete }}">
        {% endif %}
        <input type="hidden" name="numero_pedido" id="numero_pedido" value="{{ numero_pedido }}">
        <input type="hidden" name="troco" id="troco" value="0">
        <input type="hidden" name="total" id="total" value="{{ valorPedido }}">
        <input type="hidden" name="idCliente" id="idCliente" value="{{cliente.id}}">

        <input type="hidden" name="km" id="km" value="{{km}}">
        {% if km > km_entrega_excedente %}
        {% for t in tipo %}
        {% if t.status == 1 and t.code == 1 %}
        <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="valorProdutoMostra">{{ moeda.simbolo }} {{
                                                    (valorPedido)|number_format(2, ',', '.') }}</span></span></h6>
        {% endif %}
        {% endfor %}
        {% else %}
        <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="valorProdutoMostra">{{ moeda.simbolo }} {{ (calculoFrete +
                                                    valorPedido)|number_format(2, ',', '.') }}</span></span></h6>
        {% endif %}
        {#<!--{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional|number_format(2, ',', '.') }}{% else %}{{ produto.valor|number_format(2, ',', '.') }}{% endif %}--> #}
    </div>
    {% if km > km_entrega_excedente %}
    {% for t in tipo %}
    {% if t.status == 1 and t.code == 1 %}
    <button class="btn btn-success btn-block btn-lg acaoBtn btnValida p-4" type="submit">FINALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></button>
    {% endif %}
    {% endfor %}
    {% else %}
    <button class="btn btn-success btn-block btn-lg acaoBtn btnValida p-4" type="submit">FINALIZAR PEDIDO<i class="icofont-long-arrow-right"></i></button>
    {% endif %}
    <div class="clearfix"></div>
</div>
</form>
<script>
    var link_site = $('body').attr('data-link_site');
    var estado_site = $('body').attr('data-estado_site');
    $('.valor, #valor, #valor_promocional, #taxa_entrega, #valor_excedente, #taxa_entrega_motoboy, #taxa_entrega2, #taxa_entrega3, #diaria, #taxa').mask('#.##0,00', {
    reverse: true
});
    $('#trocoMod, #mp, #entrega_end').hide();

    $('#tipo_pagamento').on('change', function() {
    $('#tipo_pagamento').css("border", "1px solid #ced4da");
    if (parseInt($(this).val()) === 1) {
        $('#trocoMod').show();
        $('.btnValida').hide();
        $('.tipo_pagamento').hide();
    } else {
        $('#trocoMod').hide();
        $('#trocoCliente').hide();
        $('.btnValida').show();
        $('.tipo_pagamento').show();
    }

    if (parseInt($(this).val()) === 7) {
        $('#dinMod').show();
    } else {
        $('#dinMod').hide();
    }
});

$('#trocoCli').on('blur', function() {
    let acao = $(this).val();
    if (acao != "") {
    let valor = parseFloat($('#trocoCli').val());
    let total_pago = parseFloat($('#total_pago').val());
    let totalFinal = valor - total_pago

    if (valor === "" || valor < total_pago) {
        $('#mensagem').html('O troco do cliente precisa ser maior que o total do pedido!');
        $('.errorSup, .buttonAlert').show();
        $('.successSup').hide();
        $('#alerta').modal("show");
        return false
    } else {
        $('#troco').val(valor)
        $('.btnValida').show()
        $('#trocoCliente').show();
        $('#trocoCliente span').text(formatter.format(totalFinal))
            // $("html, body").animate({
            //   scrollTop: $('.acaoBtn').height()
            // }, "slow");
        return false
    }
}
});


$('#tipo_frete').on('change', function() {
    if (parseInt($(this).val()) === 2) {
        $('#entrega_end').hide();
        $('#entregaForm').show();
        $('#freteCal').show();
        $('#taxa_mod').show();

        var a = $('#total_pago').val();
        var b = $('#valor_frete').val();
        var d = (parseFloat(a) + parseFloat(b));

        $('#valorProdutoMostra').text(formatter.format(d));
        $('#total_pago').val(d);

    } else if (parseInt($(this).val()) === 1) {
        $('#entrega_end').show();
        $('#entregaForm').hide();
        $('#freteCal').hide();
        $('#taxa_mod').hide();

        var a = $('#total_pago').val();
        var b = $('#valor_frete').val();
        var d = (parseFloat(a) - parseFloat(b));

        $('#valorProdutoMostra').text(formatter.format(d));
        $('#total_pago').val(d);
    }
});
var formatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
    minimumFractionDigits: 2
});
jQuery.fn.shake = function(interval, distance, times) {
    interval = typeof interval == "undefined" ? 100 : interval;
    distance = typeof distance == "undefined" ? 10 : distance;
    times = typeof times == "undefined" ? 3 : times;
    var jTarget = $(this);
    jTarget.css('position', 'relative');
    for (var iter = 0; iter < (times + 1); iter++) {
        jTarget.animate({
            left: ((iter % 2 == 0 ? distance : distance * -1))
        }, interval);
    }
    return jTarget.animate({
        left: 0
    }, interval);
}
$('.select2-single, .select2-multiple').select2();
$(".selectMes").select2({
    minimumResultsForSearch: -1
});
$('#cpf').mask('000.000.000-00', {
    reverse: true
});
$('#trocoCli').mask('#.##0,00', {
    reverse: true
});


    $('#desconto').on('blur', function() {
        let acao = $(this).val();
        if (acao != "") {
    let troco = parseFloat($('#trocoCli').val());
    let valor = parseFloat($('#desconto').val());
    let total_pago = parseFloat($('#total_pago').val());
    let totalFinal = total_pago - valor
    let totalFinalDesconto = troco - total_pago

    if (troco) {
        $('#troco').val(troco)
        $('.btnValida').show()
        $('#trocoCliente').show();
        $('#trocoCliente span').text(formatter.format(totalFinalDesconto))
    }

    $('#total_pago').val(totalFinal)
    $('.btnValida').show()
    $('#descontoCliente').show();
    $('#descontoCliente span').text(formatter.format(valor))
    $('#valorProdutoMostra').text(formatter.format(totalFinal))
}
    return false
});


$("#formFinish").submit(function() {
    var formData = new FormData(this);
    var idProd = $('#chave').val();
    var t_pg = $('#tipo_pagamento').val();
    var t_ft = $('#tipo_frete').val();
    if (t_ft == "") {
        $('#tipo_frete').shake();
        $('#acoes_carrinho').show();
        $('#carregando_carrinho').hide();
        exit();
    } else if (t_pg == "") {
        $('#tipo_pagamento').shake();
        $('#acoes_carrinho').show();
        $('#carregando_carrinho').hide();
    } else {
        $.ajax({
            url: $('#formFinish').attr('action'),
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $(".btn_acao a, .btn_acao button").addClass('hide');
                $('.btn_acao .carrega').html('<div class="env"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path><br/>Aguarde processando informações!</div>');
            },
            complete: function() {
                $(".btn_acao a, .btn_acao button").removeClass('hide');
                $('.btn_acao .carrega').html('')
            },
            success: function(dd) {
                $(".btn_acao a, .btn_acao button").removeClass('hide');
                $('.btn_acao .carrega').html('')
                console.log(dd);
                switch (dd.mensagem) {
                    case 'Pedido finalizado com sucesso':
                        $('#mensagem').html(`Pedido Finalizado! Número do pedido: ${dd.pedido}`);
                        $('.successSup').show();
                        $('.errorSup').hide();
                        $('#alerta').modal("show");
                        if (dd.url) {
                            $(".buttonAlert").on('click', function() {
                                window.location = `/${link_site}/${dd.url}`;
                            });
                        }
                        break;
                    case 'Pedido editado com sucesso':
                        $('#mensagem').html(`Pedido editado com sucesso`);
                        $('.successSup').show();
                        $('.errorSup').hide();
                        $('#alerta').modal("show");
                        if (dd.url) {
                            $(".buttonAlert").on('click', function() {
                                window.location = `/${link_site}/${dd.url}`;
                            });
                        }
                        break;
                    default:
                        $('.errorSup').show();
                        $('#alerta').modal("show");
                        $('#mensagem').html(dd.mensagem);
                        break;
                }
                $(".btnValida").prop("disabled", false);
                $('.btnValida').html('FINALIZAR PEDIDO');
            },
            error: function(data) {
                $('#mensagem').html(`<div class="alert alert-danger" role="alert">Opss tivemos um problema com seu pedido</div>`)
            },
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', function() {}, false);
                }
                return myXhr;
            }
        });
    }
    return false;
});
</script>
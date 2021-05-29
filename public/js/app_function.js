var formatter = new Intl.NumberFormat('pt-BR', {style: 'currency',currency: 'BRL',minimumFractionDigits: 2});
function goBack() {window.history.back();}
jQuery.fn.shake = function(interval,distance,times){interval = typeof interval == "undefined" ? 100 : interval;distance = typeof distance == "undefined" ? 10 : distance;times = typeof times == "undefined" ? 3 : times;var jTarget = $(this);jTarget.css('position','relative');
    for(var iter=0;iter<(times+1);iter++){jTarget.animate({ left: ((iter%2==0 ? distance : distance*-1))}, interval);}
    return jTarget.animate({ left: 0},interval);
 }
$(document).on('ready', function () {$("#carregar").delay(1000).fadeOut("slow");$("#carregando_carrinho").hide();$("#carregar").removeClass('hide');
    $.ajax({
        url: "carrinho/listar-carrinho.php",
        method: "post",
        data: $('#frm').serialize(),
        dataType: "html",
        success: function (result) {
            $('#carregar').addClass('hide')
            $('#listar-carrinho').html(result)
        },
    })
})
function atualizarCarrinho() {$("#carregar").removeClass('hide');
    $.ajax({
        url: "carrinho/listar-carrinho.php",
        method: "post",
        data: $('#frm').serialize(),
        dataType: "html",
        success: function (result) {
            $('#carregar').addClass('hide')
            $('#listar-carrinho').html(result);
        },
    })
}

function deletarCarrinho(id) {
    console.log('oi aqui');
    event.preventDefault();
    $("#carregar").removeClass('hide');
    $('#acoes_carrinho').hide();
    $('#carregando_carrinho').show();
    $.ajax({
        url: "carrinho/excluir-carrinho.php",
        method: "post",
        data: { id },
        dataType: "text",
        success: function (mensagem) {
            $('#carregar').addClass('hide')
            $('#mensagem').removeClass()
            atualizarCarrinho();
            $('#mensagem').text(mensagem)
            console.log(mensagem);
            $('#acoes_carrinho').show('fade');
            $('#carregando_carrinho').hide('fade');
        },
    })
}
function editarCarrinho(id) {
    var quantidade_atual = 'quantidade'+id;
    var quantidade = document.getElementById(quantidade_atual).value;
    $("#carregar").removeClass('hide');
    event.preventDefault();
    $('#acoes_carrinho').hide();
    $('#carregando_carrinho').show();
    console.log('oi');
    $.ajax({
        url: "carrinho/editar-carrinho.php",
        method: "post",
        data: { id, quantidade },
        dataType: "text",
        success: function (mensagem) {
            $('#carregar').addClass('hide')
            $('#mensagem').removeClass()
            atualizarCarrinho()
            $('#mensagem').text(mensagem)
            $('#acoes_carrinho').show('fade');
            $('#carregando_carrinho').hide('fade');
        },
    })
}
$("#abrirCarrinhoModal").on('click', function () {
    $("#modal-carrinho").modal("show");
});
$('#troco_mod, #entrega_form, #mp, #entrega_end').hide();

$('#tipo').on('change',function () {
    if ($(this).val() === 'Dinheiro') {
        $('#troco_mod').show();
    } else {
        $('#troco_mod').hide();
    }
});
$('#tipo_frete').on('change', function () {
    var ka = $('#km_atual_cliente').val();
    var kb = $('#km_entrega_excedente').val();
    if ($(this).val() === 'Entrega') {
        $('#entrega_end').hide();
        $('#entrega_form').show();
        var b = $('#taxa_entrega').val();
        $('#taxa_mod').show();
        if(b == 0){
            var a = $('#total').val();
            var b = $('#taxa_entrega').val();
            var c = $('#taxa_entrega_old').val();
            var d = parseInt(a) + parseInt(c);

            $('.total_full').text(formatter.format(d));
            if(parseInt(kb) <= parseInt(ka)  ){}else{$('#total').val(d);}
            $('#taxa_entrega_old').val(c);
            $('#taxa_entrega').val(c);
        }
    } else if ($(this).val() === 'Retirada') {
        $('#entrega_end').show();
        $('#entrega_form').hide();
        var a = $('#total').val();
        var b = $('#taxa_entrega').val();
        var d = parseInt(a) - parseInt(b);

        //console.log(parseInt(a))
        //console.log(parseInt(b))
        $('#taxa_mod').hide();
        $('.total_full').text(formatter.format(d));
        $('#total').val(d);
        $('#taxa_entrega').val(0);

    }
});

$(document).on('ready', function () {

$('#valor_prod').val($('#valor_bd').val());

$('.adicional_item_ok').hide();
var vi = $("#add_itens").length;
var qb = $("#add_itens #itens_value").text();

if(qb === "8"){
    $('.adicional_item').hide();
    $('.adicional_item_ok').hide();
    $('#add-cart').show();
}else{

if(vi !== 0){
    $('#add-cart').hide();
    $('#add-cart').on('click', false );
    var iqb = $("#add_itens #itens_value").text();
    //console.log(iqb);

    $('input[type=checkbox]').on('change', function(e) {
        e.preventDefault();
        var a = $('input[type=checkbox]:checked').length;
        var $this = $(this);

        var adv = $('input[type=checkbox]:checked').val();
        
        var vrec =  $("#id_adc"+adv ).val();
        var vb =  $('#valor_bd').val();
        
        
        if ($(this).is(":checked")) {
            var vc = parseFloat(vb) + parseFloat(vrec);
            $('#valor_bd').val(parseFloat(vc));
            //console.log(vc);

            $('#val_d_prod').text(formatter.format(vc));
            $('#valor_prod').val(vc);
          } else {
            var vc = parseFloat(vb) - parseFloat(vrec);
            $('#valor_bd').val(parseFloat(vc));
            //console.log(formatter.format(vc));

            $('#val_d_prod').text(formatter.format(vc));
            $('#valor_prod').val(vc);
          }

        if (a == iqb){
            $('.adicional_item').hide();
            $('.adicional_item_ok').show();
            $('#add-cart').show();
            $('#val_d_prod').text(formatter.format(vc));
            $('#valor_prod').val(vc);
        }else{
            $('.adicional_item').show();
            $('.adicional_item_ok').hide();
        }
        if (a > iqb) {
            $this.prop('checked', false);
            $this.closest('label').removeClass('active');
            alert("Você só pode selecionar "+iqb+" itens");
            $('.adicional_item').hide();
            $('.adicional_item_ok').show();
            return;
        }
        $(this).closest('.hovereffect').toggleClass('clic');
        
    });

    $('input[type=radio]').on('change', function(e) {
        e.preventDefault();
        var a = $('input[type=radio]:checked').length;
        var $this = $(this);

        var adv = $('input[name="adicional[]"]:checked').val();
        var vrec =  $("#id_adc"+adv ).val();
        var vb =  $('#valor_bd').val();

        if ($(this).is(":checked")) {
            var vc = parseFloat(vb) + parseFloat(vrec);
            $('#valor_bd').val(parseFloat(vc));
            //console.log(vc);

            $('#val_d_prod').text(formatter.format(vc));
            $('#valor_prod').val(vc);
          } else {
            var vc = parseFloat(vb) - parseFloat(vrec);
            $('#valor_bd').val(parseFloat(vc));
            //console.log(formatter.format(vc));

            $('#val_d_prod').text(formatter.format(vc));
            $('#valor_prod').val(vc);
          }

        if (a == iqb){
            $('.adicional_item').hide();
            $('.adicional_item_ok').show();
            $('#add-cart').show();
            $('#val_d_prod').text(formatter.format(vc));
            $('#valor_prod').val(vc);
        }else{
            $('.adicional_item').show();
            $('.adicional_item_ok').hide();
        }
        if (a > iqb) {
            $this.prop('checked', false);
            $this.closest('label').removeClass('active');
            alert("Você só pode selecionar "+iqb+" itens");
            $('.adicional_item').hide();
            $('.adicional_item_ok').show();
            return;
        }
        $(this).closest('.hovereffect').toggleClass('clic');
    });
    
}}

});

function carrinhoModal(id_produto) {
    $("#carregar").removeClass('hide');
    var observacao = document.getElementById('observacao').value;
    var adicional = $('input[name="adicional[]"]:checked').val();
    var valor_prod = document.getElementById('valor_prod').value;
    event.preventDefault();
    $.ajax({
        url: "carrinho/inserir-carrinho.php",
        method: "post",
        data: { id_produto, adicional, valor_prod, observacao },
        dataType: "text",
        success: function (mensagem) {
            $('#mensagem').removeClass();
            atualizarCarrinho();
            $("#modal-carrinho").modal("show");
            if (mensagem == 'Cadastrado com Sucesso!!') {
                $("#modal-carrinho").modal("show");
                $("#carregar").addClass('hide');
            } else {
            }
            $('#mensagem').text(mensagem)
        },
    })
}

function editarProduto(id_produto) {
    $("#carregar").removeClass('hide');
    var observacao = document.getElementById('observacao').value;
    var adicional = $('input[name="adicional[]"]:checked').val();
    event.preventDefault();
    $.ajax({
        url: "carrinho/editar-produto.php",
        method: "post",
        data: { id_produto, observacao, adicional },
        dataType: "text",
        success: function (mensagem) {
            $('#mensagem').removeClass();
            atualizarCarrinho();
            $("#modal-carrinho").modal("show");
            if (mensagem == 'Atualizado com sucesso!!') {
                $("#modal-carrinho").modal("show");
                $("#carregar").addClass('hide');
                console.log(mensagem)
            } else {
                console.log(mensagem)
            }
            $('#mensagem').text(mensagem)
        },
    })
}

$(document).on('ready', function () {
$('#btn-finalizar').on('click',function (event) {
        event.preventDefault();
        $('#acoes_carrinho').hide();
        $('#carregando_carrinho').show();

        var t_pg = $('#tipo').val();
        var t_ft = $('#tipo_frete').val();

        if(t_ft == ""){
            $('#tipo_frete').shake();
            $('#acoes_carrinho').show();
            $('#carregando_carrinho').hide();
            exit();
        }else if(t_pg == ""){
            $('#tipo').shake();
            $('#acoes_carrinho').show();
            $('#carregando_carrinho').hide();
        }else{

        $.ajax({
            url: "carrinho/finalizar.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (mensagem) {
                $('#mensagem').removeClass()
                if (mensagem == 'Cadastrado com Sucesso!!') {
                    $('#mensagem').addClass('alert alert-success');
                    window.location = 'confirmacao-compra.php';
                    $('#acoes_carrinho').show();
                    $('#carregando_carrinho').hide();
                } else if (mensagem == 'Mercado Pago!!') {
                    atualizarUltimaVenda();
                    $("#modal-mp").modal("show");
                } else {
                    $('#mensagem').addClass('alert alert-danger');
                    $('#acoes_carrinho').show();
                    $('#carregando_carrinho').hide();
                }
                $('#mensagem').text(mensagem)
                $('#acoes_carrinho').show();
                $('#carregando_carrinho').hide();
            },
        })
    }
    })

    $('#btn-atualizar-end').on('click', function (event) {
        event.preventDefault();
        $.ajax({
            url: "carrinho/atualizar-end.php",
            method: "post",
            data: $('form').serialize(),
            dataType: "text",
            success: function (mensagem) {
                $('#mensagem').removeClass()
                if (mensagem == 'Cadastrado com Sucesso!!') {
                    $('#mensagem').addClass('alert alert-success');
                    window.location = 'index.php';
                }
                $('#mensagem').text(mensagem)
            },
        })
    })  
})
function atualizarUltimaVenda() {
    $.ajax({
        url: "carrinho/listar-ultima-venda.php",
        method: "post",
        data: $('#frm').serialize(),
        dataType: "html",
        success: function (result) {
            $('#ultima-venda').html(result)
        },
    })
}
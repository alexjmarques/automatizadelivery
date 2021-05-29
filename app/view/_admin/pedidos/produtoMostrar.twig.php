<form  method="post" id="form"  action="{{BASE}}{{empresa.link_site}}/admin/produto/addCarrinho/produto/{{produto[':id']}}" novalidate>
<div class="bg-primary border-bottom px-3 pt-3  d-flex ">
<div class="col-md-7 float-left pl-0">
    <h3 class="font-weight-bold m-0 text-white">{{ produto[':nome }}</h3>
    <p class=" text-white">{{ produto[':descricao }}</p>
</div>
<div class="col-md-5 float-left pr-0">
    <div class="quantidade">
        <div class="input-group">
            <span class="input-group-btn">
                <button type="button" class="btn btn-danger btn-number quantity-left-minus"  data-type="minus" data-field=""><span class="simple-icon-minus"></span></button>
            </span>
                <input type="text" id="quantity" name="quantity" class="count-number-input input-number" value="0" min="1" max="100">
                
            <span class="input-group-btn">
                <button type="button" class="btn btn-success btn-number quantity-right-plus" data-type="plus" data-field=""><span class="simple-icon-plus"></span></button>
            </span>
        </div>
   </div>
</div>
    </div>

<div class="col-md-12 pt-3 pb-3">
    {% if produto[':sabores'] is not null %}
        <div class="col-md-12 pl-0">
            <div class="mdc-card" id="add_itenSabores">
                <h5>Sabores </h5>
                    {% for padici in produtoSabores %}
                        {% if padici[':id'] in produto[':sabores'] %}
                        <div class="custom-control custom-radio border-bottom py-2">
                            <input class="custom-control-input" type="radio" id="id_sabor{{padici[':id']}}" name="sabores[]" value="{{padici[':id']}}">
                            <label class="custom-control-label" for="id_sabor{{padici[':id']}}">{{padici[':nome']}}</label>
                        </div>
                        {% endif%}
                    {% endfor%}
                </div>
                <hr>
            </div>
            
    {% endif%}

    
    <div class="clearfix"></div>

    {% if produto[':adicional'] is not null %}
    <div class="bg-cian turbine">
        <div class="col-md-12 p-0">
            <div class="mdc-card" id="add_itens">
                <h5>Turbinar pedido
                    {% if produto[':tipoAdicional'] == 1 %}
                    <span class="adicional_item"> (escolha {{produto[':tipoAdicional']}} item) </span> <span class="adicional_item_ok"> {{produto[':tipoAdicional']}} item selecionado </span>
                    {% else %}
                    <span class="adicional_item"> (escolha {{produto[':tipoAdicional']}} itens) </span> <span class="adicional_item_ok"> {{produto[':tipoAdicional']}} itens selecionados </span>
                    {% endif%}   
                </h5>
                <p>Complementos para o pedido!</p>
                <div id="itens_value" class="hide">{{produto[':tipoAdicional']}}</div>
                {% if produto[':tipoAdicional'] == 1 %}
                    {% for padici in produtoAdicional %}
                    {% if padici[':id'] in produto[':adicional'] %}
                    <div class="custom-control custom-radio col-md-9 border-bottom py-2">
                        <input class="custom-control-input" type="radio" id="id_adicional{{padici[':id']}}" name="adicional[]" value="{{padici[':id']}}" valor="{% if padici[':valor'] is null %}0.00{% else %}{{padici[':valor']}}{% endif %}">
                        <label class="custom-control-label" for="id_adicional{{padici[':id']}}">{{padici[':nome']}} 
                        {% if padici[':valor'] == 0.00 %}
                        <span class="text-muted">Gratis</span>
                        {% else %}
                        <span class="text-muted">{{moeda[':simbolo']}} {{padici[':valor']|number_format(2, ',', '.')}}</span>
                        <input type="hidden" id="valor{{padici[':id']}}" name="valor{{padici[':id']}}" value="{{padici[':valor']}}">
                        {% endif %}
                    </label>

                    <div class="input-group plus-minus-input boRight col-md-3 p-0 id_adicional{{padici[':id']}}" style="display:none;">
                            <div class="input-group-button">
                                <button type="button" class="btn btn-danger btn-number minuss" id-select="{{padici[':id']}}" data-quantity="minus" data-field="qtd_ad{{padici[':id']}}">
                                <i class="simple-icon-minus"></i>
                                </button>
                            </div>
                            <input type="number" id="qtd_ad{{padici[':id']}}" min="1" name="qtd_ad{{padici[':id']}}" class="input-group-field qtd-control id_adicional{{padici[':id']}}"  value="0">
                            <div class="input-group-button">
                                <button type="button" class="btn btn-success btn-number" id-select="{{padici[':id']}}" data-quantity="plus" data-field="qtd_ad{{padici[':id']}}">
                                <i class="simple-icon-plus"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    {% endif%}
                    {% endfor%}

                {% else %}
                {% for padici in produtoAdicional %}
                    {% if padici[':id'] in produto[':adicional'] %}
                    <div class="custom-control border-bottom py-2">
                        <input class="custom-control-input" type="checkbox" id="id_adicional{{padici[':id']}}" name="adicional[]" value="{{padici[':id']}}" valor="{% if padici[':valor'] is null %}0.00{% else %}{{padici[':valor']}}{% endif %}">

                    <label class="custom-control-label col-md-9" for="id_adicional{{padici[':id']}}">{{padici[':nome']}} 
                        {% if padici[':valor'] == 0.00 %}
                        <br/><span class="text-success">Grátis</span>
                        {% else %}
                        <br/><span class="text-muted">{{moeda[':simbolo']}} {{padici[':valor']|number_format(2, ',', '.')}}</span>
                        <input type="hidden" id="valor{{padici[':id']}}" name="valor{{padici[':id']}}" value="{{padici[':valor']}}">
                        {% endif %}
                    </label>
                    
                        <div class="input-group boRight plus-minus-input col-md-3 id_adicional{{padici[':id']}}" style="display:none;">
                            <div class="input-group-button">
                                <button type="button" class="btn btn-danger btn-number minuss" id-select="{{padici[':id']}}" data-quantity="minus" data-field="qtd_ad{{padici[':id']}}">
                                <i class="simple-icon-minus"></i>
                                </button>
                            </div>
                            <input type="number" id="qtd_ad{{padici[':id']}}" min="1" name="qtd_ad{{padici[':id']}}" class="input-group-field qtd-control id_adicional{{padici[':id']}}"  value="0">
                            <div class="input-group-button">
                                <button type="button" class="btn btn-success btn-number" id-select="{{padici[':id']}}" data-quantity="plus" data-field="qtd_ad{{padici[':id']}}">
                                <i class="simple-icon-plus"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    {% endif%}
                    {% endfor%}
                {% endif%}
                </div>
            </div>
            <hr>
        </div>
    {% endif%}

   
    <div class="clearfix"></div>
    <label for="observacao">Alguma observação no pedido?</label>
            <div class="mb-0 input-group full-width">
                <div class="input-group-prepend"><span class="input-group-text"><i class="simple-icon-info"></i></span></div>
                <textarea name="observacao" id="observacao" placeholder="" aria-label="With textarea" class="form-control"></textarea>
            </div>

    <hr>
    <div class="clearfix"></div>

        {% if produto[':sabores'] is null %}
            <input type="hidden" name="id_adicional" id="id_adicional" value="0">
        {% else %}
            <input type="hidden" name="id_adicional" id="id_adicional" value="1">
        {% endif %}
        <input type="hidden" name="id_produto" id="id_produto" value="{{produto[':id']}}">
        <input type="hidden" name="tipoAdicional" id="tipoAdicional" value="{{produto[':tipoAdicional']}}">

        <input type="hidden" name="valorFinal" id="valorFinal" value="{{ produto[':valor }}">

        <input type="hidden" name="chave" id="chave" value="{{chave}}">
        <input type="hidden" name="id_cliente" id="id_cliente" value="{{id_cliente}}">

        <input type="hidden" name="id_carrinho" id="id_carrinho" value="">
        
        
        <input type="hidden" name="valor" id="valor" value="{% if produto[':valor_promocional'] != '0.00' %}{{ produto[':valor_promocional }}{% else %}{{ produto[':valor }}{% endif %}">

        <p class="mb-1">Valor unitário <span class="float-right text-dark">{{ moeda[':simbolo }} 
        {% if produto[':valor_promocional'] != '0.00' %}{{ produto[':valor_promocional']|number_format(2, ',', '.') }}{% else %}{{ produto[':valor']|number_format(2, ',', '.') }}{% endif %}</span></p>
        <hr>
        <h6 class="font-weight-bold mb-0">Total <span class="float-right"> <span id="total">{{ moeda[':simbolo }} {% if produto[':valor_promocional'] != '0.00' %}{{ produto[':valor_promocional']|number_format(2, ',', '.') }}{% else %}{{ produto[':valor']|number_format(2, ',', '.') }}{% endif %}</span></span></h6>


        {% if produto[':status_produto'] == 1 %}
                
<button class="btn btn-success btn-block btn-lg addStyle mt-4">ADICIONAR AO PEDIDO <i class="feather-shopping-cart"></i></button>
        {% endif %}

</div>
</form>

<script>
    $('#add_itenSabores').hide();
var formatter = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 2 });

$('.adicional_item_ok, .sabor_item_ok').hide();
var vi = $("#add_itens").length;
var qb = $("#add_itens #itens_value").text();
var vi2 = $("#add_itenSabores").length;
var qb2 = $("#add_itenSabores #itens_value").text();
var iqba = $("#add_itens #itens_value").text();

(qb2 === "0") ? $('.sabor_item, .sabor_item_ok').hide() : $('.sabor_item').show();
(qb === "0") ? $('.adicional_item, .adicional_item_ok').hide() : $('.adicional_item').show();

var iqb2 = $("#add_itenSabores #itensSabores_value").text();

$('#add_itenSabores input[type=checkbox]').on('change', function (e) {
    e.preventDefault();
    $('#add_itenSabores').show();
    if($('#add_itenSabores input[type=radio]').length == 0){
        $('.turbine').show();
    }
    var a2 = $('#add_itenSabores input[type=checkbox]:checked').length;
    var $this = $(this);
    if (a2 == iqb2) {
        $('.sabor_item').hide();
        $('.sabor_item_ok').show();
        $(".addStyle").show()
    } else {
        $('.sabor_item').show();
        $('.sabor_item_ok').hide();
        $(".addStyle").hide()
    }
    if (a2 > iqb) {
        $this.prop('checked', false);
        $this.closest('label').removeClass('active');
        alert("Você só pode selecionar " + iqb2 + " itens");
        $('.sabor_item').hide();
        $('.sabor_item_ok').show();
        $(".addStyle").show()
        return;
    }
    $(this).closest('.hovereffect').toggleClass('clic');
});

if($('#add_itenSabores input[type=radio]').length == 0){
        $('.turbine').hide();
    }

if($('#add_itenSabores input[type=radio]').length > 0){
    $('.turbine').hide();
}

$('#add_itenSabores input[type=radio]').on('change', function (e) {
    e.preventDefault();
    var a2 = $('#add_itenSabores input[type=radio]:checked').length;
    var $this = $(this);
    $('#add_itenSabores').show();
    if($('#add_itenSabores input[type=radio]').length == 0){
        $('.turbine').show();
    }

    if (a2 == iqb2) {
        $('.sabor_item').hide();
        $('.sabor_item_ok').show();
        $(".addStyle").show()
        $('.turbine').show();
    } else {
        $('.sabor_item').show();
        $('.sabor_item_ok').hide();
        $(".addStyle").hide()
        $('.turbine').hide();
        
    }
    if (a2 > iqb2) {
        $this.prop('checked', false);
        $this.closest('label').removeClass('active');
        alert("Você só pode selecionar " + iqb2 + " itens");
        $('.sabor_item').hide();
        $('.sabor_item_ok').show();
        $(".addStyle").show()
        return;
    }
    $(this).closest('.hovereffect').toggleClass('clic');
});
//Produto Adicional
var iqb = $("#add_itens #itens_value").text();

$('#add_itens input[type=checkbox]').on('change', function (e) {
    e.preventDefault();

    var a = $('#add_itens input[type=checkbox]:checked').length;
    var adv = $(this).val();
    var adv_att = $(this).attr('id'); //Get Id do item selecionado
    var vrec = $(this).attr('valor'); //Coloca em uma variavel e pega o valor em R$
    var vb = $('#valorFinal').val(); // Valor do Produto    
    if ($(this).is(":checked")) {
        $(`.${adv_att}`).show();
        var vc = parseFloat(vb) + parseFloat(vrec);
        $(".addStyle").hide();
        $(`#qtd_ad${adv}`).val(0);
        $(".addStyleMod").hide();
        $(".addStyleModT").hide();
        $(".quantity-left-minus").attr("disabled", true);
        $(".quantity-right-plus").attr("disabled", true);
        $(`#${adv_att}`).attr("disabled", true);
    } else {
        $(`.${adv_att}`).hide();
        var vc = parseFloat(vb) - parseFloat(vrec);
        $(`.${adv}`).hide();
        $(".addStyle").show();
        $(".addStyleMod").show();
        $(".addStyleModT").show();

        $(".quantity-left-minus").attr("disabled", false);
        $(".quantity-right-plus").attr("disabled", false);
        $(`#${adv_att}`).attr("disabled", false);

        var chave = $('#chave').val();
        var id_carrinho = $('#id_carrinho').val();
        var id_cliente = $('#id_cliente').val();

        $.ajax({
            url: `{{BASE}}admin/produto/removeCarrinho/adicionalis/${chave}`,
            type: 'get',
            data: {
                chave: chave,
                id_carrinho: id_carrinho,
                id_adicional: adv,
                id_cliente: id_cliente
            },
            success: function (dd) {
                var novoValor = (parseFloat(vb) - parseFloat(dd));
                if(!isNaN(novoValor) ){
                    $('#total').text(formatter.format(novoValor));
                    $(`#id_adicional${advS}`).attr("disabled", false);
                }
            }, error: function (xhr) {
            }
        });
        $(".addStyle").show();

    }

    if (iqb == 0) {

    } else {
        if (a == iqb) {
            $('.adicional_item').hide();
            $('.adicional_item_ok').show();
            if (vi > 0) {
                var a = $('#add_itens input[type=checkbox]:checked').length;
            }
        } else {
            $('.adicional_item').show();
            $('.adicional_item_ok').hide();
        }
        if (a > iqb) {
            $this.prop('checked', false);
            $this.closest('label').removeClass('active');
            if (qb != 0) {
                alert("Você só pode selecionar " + iqb + " itens");
            }
            $('.adicional_item').hide();
            $('.adicional_item_ok').show();
            return;
        }
    }
    $(this).closest('.hovereffect').toggleClass('clic');
});

//Radio Buttom
$('#add_itens input[type=radio]').on('change', function (e) {
    e.preventDefault();
    var a = $('#add_itens input[type=radio]:checked').length;
    var $this = $(this);

    var adv = $('input[name="adicional[]"]:checked').attr('id');
    var vrec = $("#" + adv).attr('valor');
    var adv_att = $(this).attr('id');
    var vb = $('#valor').val();
    var qtd_i = $('#quantity').val();

    $('#valor_bd').val(parseFloat(vc));
    if ($(this).is(":checked")) {
        if (vrec === "") {
            var vc = parseFloat(qtd_i) * parseFloat(vb);
        } else {
            var vc = (parseFloat(qtd_i) * parseFloat(vb)) + parseFloat(vrec);
        }
        $(".addStyleMod").hide();
        $(".addStyleModT").hide();
        $(".quantity-left-minus").attr("disabled", true);
        $(".quantity-right-plus").attr("disabled", true);
        $(`#${adv_att}`).attr("disabled", true);
    } else {
        if (vrec === "") {
            var vc = parseFloat(qtd_i) * parseFloat(vb);
        } else {
            var vc = (parseFloat(qtd_i) * parseFloat(vb)) + parseFloat(vrec);
        }
        $(`.${adv}`).show();
        $(".addStyleMod").show();
        $(".addStyleModT").show();
        $(".quantity-left-minus").attr("disabled", false);
        $(".quantity-right-plus").attr("disabled", false);
        $(`#${adv_att}`).attr("disabled", false);
    }

    if (a == iqb) {
        $('.adicional_item').hide();
        $('.adicional_item_ok').show();
        $(`.${adv}`).show();
    } else {
        $('.adicional_item').show();
        $('.adicional_item_ok').hide();
        $(`.${adv}`).hide();
    }
    if (a > iqb) {
        $this.prop('checked', false);
        $this.closest('label').removeClass('active');
        if (qb != 0) {
            alert("Você só pode selecionar " + iqb + " itens");
        }
        $('.adicional_item').hide();
        $('.adicional_item_ok').show();
        $(`.${adv}`).show();
        return;
    }
    $(this).closest('.hovereffect').toggleClass('clic');
    $(".addStyle").hide()
});


$('[data-quantity="plus"]').click(function (e) {
    e.preventDefault();
    $('.minuss').prop("disabled", false);
    $('#add_itenSabores').show();
    if($('#add_itenSabores input[type=radio]').length == 0){
        $('.turbine').show();
    }

    fieldName = $(this).attr('data-field');
    var currentVal = parseInt($('input[name=' + fieldName + ']').val());

    if (!isNaN(currentVal)) {
        $('input[name=' + fieldName + ']').val(currentVal + 1);

        var advS = $(this).attr('id-select');
        var vrecAd = $(`#id_adicional${advS}`).attr('valor');

        let vbA = $('#valorFinal').val();

        let vAdicional = parseFloat(vrecAd) + parseFloat(vbA);;
        $('#total').text(formatter.format(vAdicional));
        $('#valorFinal').val(vAdicional);

    } else {
        $('input[name=' + fieldName + ']').val(0);
    }

    var id_adicional = $(`#id_adicional${advS}`).val();
    var quantidade = $(`#qtd_ad${advS}`).val();
    var numero_pedido = $('#numero_pedido').val();
    var id_produto = $('#id_produto').val();
    var id_carrinho = $('#id_carrinho').val();
    var id_cliente = $('#id_cliente').val();
    var valor = $(`#valor${advS}`).val();
    var chave = $('#chave').val();
    $.ajax({
        url: `{{BASE}}admin/produto/addCarrinho/adicionalis/${chave}`,
        type: 'get',
        data: {
            id_adicional: id_adicional,
            id_produto: id_produto,
            id_cliente: id_cliente,
            id_carrinho: id_carrinho,
            valor: valor,
            quantidade: quantidade,
            numero_pedido: numero_pedido,
            chave: chave
        },
        success: function (response) {
            //console.log(response)
        }, error: function (xhr) {
        }
    });
    $(".addStyle").show()
});

$('.addFavorito').click(function (e) {
    e.preventDefault();
    let id = $(this).attr('data-favorito');

    $.ajax({
        url: `favorito/${id}`,
        type: 'get',
        data: {
            id: id
        },
        success: function (response) {
            //console.log(response)

            switch (response) {
                case 'Favorito Cadastrado':
                    $(`#itFavorito${id}`).removeClass('fa-heart-o')
                    $(`#itFavorito${id}`).addClass('fa-heart')
                    break;
                default:
                    $(`#itFavorito${id}`).removeClass('fa-heart')
                    $(`#itFavorito${id}`).addClass('fa-heart-o')
                    break;
            }

        }, error: function (xhr) {
        }
    });
});


//Radio Buttom
$('.radioMoto input[type=radio]').on('change', function (e) {
    e.preventDefault();
    var status = $(this).val();

    if ($(this).is(":checked")) {
        if (status === "4") {
            $('.status4').addClass('border-primary')
            $('.status5').removeClass('border-primary')
            $('.recusaInfo').hide()
            $("#observacao").attr("required", "false");
            $("#fullBtnNac").text("INFORMAR AO RESTAURANTE");
        } else if (status === "5") {
            $('.status4').removeClass('border-primary')
            $('.status5').addClass('border-primary')
            $('.recusaInfo').show()
            $("#observacao").attr("required", "true");
            $("#fullBtnNac").text("INFORMAR RECUSA DO CLIENTE");
        }
    }
});


// This button will decrement the value till 0
$('[data-quantity="minus"]').click(function (e) {
    e.preventDefault();

    fieldName = $(this).attr('data-field');
    var currentVal = parseInt($('input[name=' + fieldName + ']').val());

    if (!isNaN(currentVal) && currentVal > 0) {
        $('input[name=' + fieldName + ']').val(currentVal - 1);
        var advS = $(this).attr('id-select');
        var vrecAd = $(`#id_adicional${advS}`).attr('valor');
        let vbA = $('#valorFinal').val();
        let vAdicional = parseFloat(vbA) - parseFloat(vrecAd);
        $('#total').text(formatter.format(vAdicional));
        $('#valorFinal').val(vAdicional);

    } else {
        $('input[name=' + fieldName + ']').val(0);
    }
    var currentVal = parseInt($('input[name=' + fieldName + ']').val());

    if (currentVal === 0) {
        $(`#id_adicional${advS}`).prop('checked', false);
        $(`.id_adicional${advS}`).hide();
        $(".addStyle").show();
        var chave = $('#chave').val();
        var id_carrinho = $('#id_carrinho').val();
        var id_cliente = $('#id_cliente').val();
        $.ajax({
            url: `{{BASE}}admin/produto/removeCarrinho/adicionalis/${chave}`,
            type: 'get',
            data: {
                chave: chave,
                id_carrinho: id_carrinho,
                id_adicional: advS,
                id_cliente: id_cliente
            },
            success: function (dd) {
                //console.log(dd);
                $(`#id_adicional${advS}`).attr("disabled", false);
            }, error: function (xhr) {
            }
        });
    }

    var id_adicional = $(`#id_adicional${advS}`).val();
    var quantidade = $(`#qtd_ad${advS}`).val();
    var numero_pedido = $('#numero_pedido').val();
    var id_produto = $('#id_produto').val();
    var id_carrinho = $('#id_carrinho').val();
    var id_cliente = $('#id_cliente').val();
    var valor = $(`#valor${advS}`).val();
    var chave = $('#chave').val();

    $.ajax({
        url: `{{BASE}}admin/produto/addCarrinho/adicionalis/${chave}`,
        type: 'get',
        data: {
            id_adicional: id_adicional,
            id_produto: id_produto,
            id_carrinho: id_carrinho,
            id_cliente: id_cliente,
            valor: valor,
            quantidade: quantidade,
            numero_pedido: numero_pedido,
            chave: chave
        },
        success: function (response) {
            //console.log(response)
        }, error: function (xhr) {
        }
    });

});


$('.quantity-left-minus, .minuss').prop("disabled", true);


$('.quantity-right-plus').click(function (e) {
    e.preventDefault();
    $('#add_itenSabores').show();
    //console.log(this)
    if($('#add_itenSabores input[type=radio]').length == 0){
        $('.turbine').show();
    }

    var a = $('#add_itens input[type=checkbox]:checked').length;
    var b = $('#add_itens input[type=radio]:checked').length;

    var adv = $('input[name="adicional[]"]:checked').attr('id'); //Get Id do item selecionado
    var vrec = $("#" + adv).attr('valor'); //Coloca em uma variavel e pega o valor em R$
    var vb = $('#valor').val(); // Valor do Produto

    var quantity = parseInt($('#quantity').val());
    var valor = parseFloat($('#valor').val());
    var valorFinalAtual = parseInt($('#valorFinal').val());
    if (quantity === 1) {
        $('.quantity-left-minus').prop("disabled", true);
    }

    $('#quantity').val(quantity + 1);
    var quantityAtual = parseInt($('#quantity').val());
    var valorAdicional = quantityAtual * valor - valorFinalAtual;

    console.log(valorAdicional);

    

    $('.quantity-left-minus').prop("disabled", false);

    var qtd_i = $('#quantity').val();

    if (a || b !== 0) {

        $('#valor_bd').val(parseFloat(vc));
        if ($(this).is(":checked")) {

            var vc = parseFloat(qtd_i) * parseFloat(vb);
            $('#total').text(formatter.format(vc));
            $('#valorFinal').val(vc);
        } else {
            var vc = parseFloat(qtd_i) * parseFloat(vb);

            $('#total').text(formatter.format(vc));
            $('#valorFinal').val(vc);
        }

    }

    var id_produto = $('#id_produto').val();
    var id_cliente = $('#id_cliente').val();
    var id_carrinho = $('#id_carrinho').val();
    var valor = $('#valor').val();
    var quantidade = $('#quantity').val();
    var chave = $('#chave').val();

    $.ajax({
        url: `{{BASE}}admin/produto/addCarrinho/${id_produto}`,
        type: 'get',
        data: {
            id_produto: id_produto,
            id_cliente: id_cliente,
            id_carrinho: id_carrinho,
            valor: valor,
            quantidade: quantidade,
            chave: chave
        },
        success: function (dd) {
            if(dd != ''){
                $('#id_carrinho').val(dd);
            }else{
                //console.log('Vazio')
            }
        }, error: function (xhr) {
        }
    });
    
    var advS = $('#add_itens input[type=checkbox]:checked').val();
    var bdvS = $('#add_itens input[type=radio]:checked').val();

    var vrecAd = $(`#id_adicional${advS}`).attr('valor');
    var vrecQtd = $(`#qtd_ad${advS}`).val();
    var ValorMaisAdicional = parseFloat(vrecAd) * parseFloat(vrecQtd)

    if(advS != undefined ){
        console.log("aqui "+ValorMaisAdicional);

        $('#total').text(formatter.format(quantityAtual * valor + ValorMaisAdicional));
        $('#valorFinal').val(parseFloat(quantityAtual * valor + ValorMaisAdicional))
    }

    if(bdvS != undefined ){
        var vrecAd = $(`#id_adicional${bdvS}`).attr('valor');
        var vrecQtd = $(`#qtd_ad${bdvS}`).val();
        var ValorMaisAdicional = parseFloat(vrecAd) * parseFloat(vrecQtd)

        $('#total').text(formatter.format(quantityAtual * valor + ValorMaisAdicional));
        $('#valorFinal').val(parseFloat(quantityAtual * valor + ValorMaisAdicional))
    }

    if(bdvS == undefined && advS == undefined ){
        $('#total').text(formatter.format(quantityAtual * valor));
        $('#valorFinal').val(parseFloat(quantityAtual * valor))
    }

});

$('.quantity-left-minus').click(function (e) {
    e.preventDefault();
    console.log(this)

    var a = $('#add_itens input[type=checkbox]:checked').length;
    var b = $('#add_itens input[type=radio]:checked').length;

    var adv = $('input[name="adicional[]"]:checked').attr('id'); //Get Id do item selecionado
    var vrec = $("#" + adv).attr('valor'); //Coloca em uma variavel e pega o valor em R$
    var vb = $('#valor').val(); // Valor do Produto

    var quantity = parseInt($('#quantity').val());
    var valorFinalAtual = parseInt($('#valorFinal').val());
    var valor = parseFloat($('#valor').val());

    
    if (parseInt($('#quantity').val()) === 1) {
        $('.quantity-left-minus').prop("disabled", true);
    } else {
        $('.quantity-left-minus').prop("disabled", false);
    }

    var qtd_i = $('#quantity').val();

    if (a || b !== 0) {
        $('#valor_bd').val(parseFloat(vc));
        if ($(this).is(":checked")) {

            var vc = parseFloat(qtd_i) * parseFloat(vb);
            $('#total').text(formatter.format(vc));
            $('#valorFinal').val(vc);
        } else {
            var vc = parseFloat(qtd_i) * parseFloat(vb);
            $('#total').text(formatter.format(vc));
            $('#valorFinal').val(vc);
        }

    }

    var id_produto = $('#id_produto').val();
    var id_cliente = $('#id_cliente').val();
    var id_carrinho = $('#id_carrinho').val();
    var valor = $('#valor').val();
    var quantidade = $('#quantity').val();
    var chave = $('#chave').val();

    $.ajax({
        url: `{{BASE}}admin/produto/addCarrinho/${id_produto}`,
        type: 'get',
        data: {
            id_produto: id_produto,
            id_cliente: id_cliente,
            id_carrinho: id_carrinho,
            valor: valor,
            quantidade: quantidade,
            chave: chave
        },
        success: function (dd) {
            if(dd != ''){
                $('#id_carrinho').val(dd);
            }else{
                console.log('Vazio')
            }
        }, error: function (xhr) {
        }
    });

    if (quantity > 1) {
        $('#quantity').val(quantity - 1);
        var quantityAtual = parseInt($('#quantity').val());

        var advS = $('#add_itens input[type=checkbox]:checked').val();
        var bdvS = $('#add_itens input[type=radio]:checked').val();
        var vrecAd = $(`#id_adicional${advS}`).attr('valor');
        var vrecQtd = $(`#qtd_ad${advS}`).val();
        var ValorMaisAdicional = parseFloat(vrecAd) * parseFloat(vrecQtd)

        if(advS != undefined ){
            console.log("aqui Menos"+ValorMaisAdicional);

            $('#total').text(formatter.format(quantityAtual * valor + ValorMaisAdicional));
            $('#valorFinal').val(parseFloat(quantityAtual * valor + ValorMaisAdicional))
        }

        if(bdvS != undefined ){
            $('#total').text(formatter.format(quantityAtual * valor + ValorMaisAdicional));
            $('#valorFinal').val(parseFloat(quantityAtual * valor + ValorMaisAdicional))
        }

        if(bdvS == undefined && advS == undefined ){
            $('#total').text(formatter.format(quantityAtual * valor));
            $('#valorFinal').val(parseFloat(quantityAtual * valor))
        }
    }

    
});

$("#form").submit(function () {
  var formData = new FormData(this);
  $.ajax({
    url: $('#form').attr('action'),
    type: 'POST',
    data: formData,
    beforeSend: function () {
      $(".addStyle").prop("disabled", true);
      $('.addStyle').html('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>');
    },
    complete: function () {
      $('.addStyle').hide();
    },
    success: function (data) {
      console.log(data)
      switch (data) {
        case 'Produto Adicionado ao carrinho':
          window.location = '{{BASE}}admin/pedido/novo/produtos';
          break;
        default:
          $('.errorSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data);
          break;
      }
    },
    error: function (data) {
      $('.errorSup').show();
      $('#alerta').modal("show");
      $('#mensagem').html('Opss tivemos um problema!');
    },
    cache: false,
    contentType: false,
    processData: false,
    xhr: function () {
      var myXhr = $.ajaxSettings.xhr();
      if (myXhr.upload) {
        myXhr.upload.addEventListener('progress', function () {}, false);
      }
      return myXhr;
    }
  });
  return false;
});

$("#formFinish").submit(function () {
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
          beforeSend: function () {
              $(".btnValida").prop("disabled", true);
              
          },
          complete: function () {
              $(".btnValida").prop("disabled", false);
              $('.btnValida').html('FINALIZAR PEDIDO');
          },
          success: function (data) {
              console.log(data);
              switch (data) {
                  case 'Pedido Finalizado com sucesso!':
                      $('#mensagem').html(data);
                      $('#FinalizarPedidoOK').addClass('show');
                      $('#FinalizarPedidoOK').show();
                      break;
                  default:
                      $('#mensagem').html(`<div class="alert alert-danger" role="alert">${data}</div>`);
                      break;
              }
              $(".btnValida").prop("disabled", false);
              $('.btnValida').html('FINALIZAR PEDIDO');
          }, error: function (data) {
              $('#mensagem').html(`<div class="alert alert-danger" role="alert">Opss tivemos um problema com seu pedido</div>`)
          },
          cache: false,
          contentType: false,
          processData: false,
          xhr: function () {
              var myXhr = $.ajaxSettings.xhr();
              if (myXhr.upload) {
                  myXhr.upload.addEventListener('progress', function () {
                  }, false);
              }
              return myXhr;
          }
      });
  }
  return false;
});
    </script>
<form method="post" id="formAddProd" action="{{BASE}}{{empresa.link_site}}/admin/produto/addCarrinho/produto/{{ produto.id }}" novalidate>
    <div class="bg-primary border-bottom px-3 pt-3  d-flex ">
        <div class="col-md-7 float-left pl-0">
            <h3 class="font-weight-bold m-0 text-white">{{ produto.nome }}</h3>
            <p class=" text-white">{{ produto.descricao }}</p>
        </div>
        <div class="col-md-5 float-left pr-0">
            <div class="quantidade">
                <div class="input-group" style="width: 127px;">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number quantity-left-minus" data-type="minus" data-field=""><span class="fa fa-minus"></span></button>
                    </span>
                    <input type="text" id="quantity" name="quantity" class="count-number-input input-number" value="1" min="1" max="100">

                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-number quantity-right-plus" data-type="plus" data-field=""><span class="fa fa-plus"></span></button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 pt-3 pb-3">
        {% if produto.sabores is not null %}
        <div class="col-md-12 pl-0">
            <div class="mdc-card" id="add_itenSabores">
                <h5>Sabores <span style="color:red;">*</span></h5>
                {% for padici in produtoSabores %}
                {% if padici.id in produto.sabores %}
                <div class="custom-control custom-radio border-bottom py-2">
                    <input class="custom-control-input" type="radio" id="id_sabor{{padici.id}}" name="sabores[]" value="{{padici.id}}" required>
                    <label class="custom-control-label" for="id_sabor{{padici.id}}">{{padici.nome}}</label>
                </div>
                {% endif%}
                {% endfor%}
            </div>
            <hr>
        </div>

        {% endif%}


        <div class="clearfix"></div>

        {% if produto.adicional is not null %}
        <div class="bg-cian turbine">
            <div class="col-md-12 p-0">
                <div class="mdc-card" id="add_itens">
                    <h5>Turbinar pedido</h5>
                    <p>Complementos para o pedido!</p>
                    {% for ta in tipoAdicional %}
                        <div id="{{ ta.slug }}" data-tipo="{{ ta.slug }}"
                            data-tipo_escolha="{{ ta.tipo_escolha}}" data-qtd="{{ ta.qtd }}">
                            <h6 class="clearfix mt-3 bold">{{ ta.tipo}}
                                {% if ta.tipo_escolha == 2 %}
                                {% if ta.qtd == 1 %}
                                <span class="adicional_item"> ({{ta.qtd}} item Obrigatório) </span> <span
                                    class="adicional_item_ok"> {{ta.qtd}} selecionado </span>
                                {% else %}
                                <span class="adicional_item"> ({{ta.qtd}} itens Obrigatórios) </span> <span
                                    class="adicional_item_ok"> {{ta.qtd}} selecionados </span>
                                {% endif %}
                                {% endif %}
                                {% if ta.tipo_escolha == 3 %}
                                <span class="adicional_item"> (escolha até {{ta.qtd}} itens) </span> <span
                                    class="adicional_item_ok"></span>
                                {% endif%}
                            </h6>

                            {% for padici in produtoAdicional %}
                            {% if ta.id == padici.tipo_adicional %}
                            {% if padici.id in produto.adicional %}
                            <div class="custom-control border-bottom py-3">
                                <input class="custom-control-input" type="checkbox" data-tipoSlug="{{ ta.slug}}"
                                    id="id_adicional{{padici.id}}" name="adicional[]" value="{{padici.id}}"
                                    valor="{% if padici.valor is null %}0.00{% else %}{{padici.valor}}{% endif %}">
                                <label class="custom-control-label"
                                    for="id_adicional{{padici.id}}">{{padici.nome}}
                                    {% if padici.valor == 0.00 %}
                                    <span class="text-success">Grátis</span>
                                    {% else %}
                                    <span class="text-muted">{{moeda.simbolo}}
                                        {{padici.valor|number_format(2, ',', '.')}}</span>
                                    <input type="hidden" id="valor{{padici.id}}" name="valor{{padici.id}}"
                                        value="{{padici.valor}}">
                                    {% endif %}
                                </label>

                                <div class="input-group plus-minus-input id_adicional{{padici.id}}"
                                    style="display:none;">
                                    <div class="input-group-button">
                                        <button type="button" class="btn btn-danger btn-number minuss"
                                            id-select="{{padici.id}}" data-quantity="minus"
                                            data-field="qtd_ad{{padici.id}}">
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <input type="number" id="qtd_ad{{padici.id}}" min="1"
                                        name="qtd_ad{{padici.id}}"
                                        class="input-group-field qtd-control id_adicional{{padici.id}}" value="1">
                                    <div class="input-group-button">
                                        <button type="button" class="btn btn-success btn-number"
                                            id-select="{{padici.id}}" data-quantity="plus"
                                            data-field="qtd_ad{{padici.id}}">
                                            <i class="fa fa-chevron-up"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {% endif%}
                            {% endif%}
                            {% endfor%}
                        </div>
                        {% endfor%}

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

        <input type="hidden" name="id_adicional" id="id_adicional" value="{{ produto.adicional }}">
        <input type="hidden" name="chave" id="chave" value="{{chave}}">
        <input type="hidden" name="numero_pedido" id="numero_pedido" value="{{numero_pedido}}">
        <input type="hidden" name="id_cliente_{{produto.id}}" id="id_cliente_{{produto.id}}" value="{{idCliente}}">
        <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
        <input type="hidden" name="valor" id="valor" value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">

        {% if produto.status == 1 %}
        <button class="btn btn-success btn-block btn-lg addStyle mt-4">ADICIONAR AO PEDIDO <i class="feather-shopping-cart"></i></button>
        {% endif %}

    </div>
</form>


<script>
    var link_site = $('body').attr('data-link_site');
    var estado_site = $('body').attr('data-estado_site');

    $(document).ready(function() {
        if ($(document).find(`[data-tipo_escolha='2']`).length > 0) {
            $(`.addStyleMod, .addStyleModT, .addStyle`).hide();
        }
        $('#add_itenSabores').each(function() {
            if (parseInt($(`#add_itenSabores`).length) > 0) {
                $(`.addStyle`).hide();
            }
        });
        $('[data-tipo]').each(function(i, ele) {
            let verifica = $(`#${ele['id']} .custom-control`).length
            if (parseInt(verifica) === 0) {
                $(`#${ele['id']}`).remove();
            }
        });
    });

    $('.quantity-left-minus, .minuss').prop("disabled", true);
    $('.quantity-right-plus').click(function(e) {

        var a = $('#add_itens input[type=checkbox]:checked').length;
        var b = $('#add_itens input[type=radio]:checked').length;

        var adv = $('input[name="adicional[]"]:checked').attr('id'); //Get Id do item selecionado
        var vrec = $("#" + adv).attr('valor'); //Coloca em uma variavel e pega o valor em R$
        var vb = $('#valor').val(); // Valor do Produto

        var quantity = parseInt($('#quantity').val());
        var valor = parseFloat($('#valor').val());
        if (quantity === 1) {
            $('.quantity-left-minus').prop("disabled", true);
        }

        $('#quantity').val(quantity + 1);
        var quantityAtual = parseInt($('#quantity').val());
        $('#valorFinal').val(parseFloat(quantityAtual * valor))
        $('#total').text(formatter.format(quantityAtual * valor));

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
    });

    $('.quantity-left-minus').click(function(e) {

        var a = $('#add_itens input[type=checkbox]:checked').length;
        var b = $('#add_itens input[type=radio]:checked').length;

        var adv = $('input[name="adicional[]"]:checked').attr('id'); //Get Id do item selecionado
        var vrec = $("#" + adv).attr('valor'); //Coloca em uma variavel e pega o valor em R$
        var vb = $('#valor').val(); // Valor do Produto

        var quantity = parseInt($('#quantity').val());
        var valor = parseFloat($('#valor').val());

        if (quantity > 1) {
            $('#quantity').val(quantity - 1);
            var quantityAtual = parseInt($('#quantity').val());
            $('#total').text(formatter.format(quantityAtual * valor));
            //console.log(quantityAtual * valor)
            $('#valorFinal').val(parseFloat(quantityAtual * valor))
        }
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
    });



    /**
     * 
     * Carrinho de Compra produtos
     */
    $('.adicional_item_ok').hide();
    var vi = $("#add_itens").length;
    var qb = $("#add_itens #itens_value").text();
    var iqba = $("#add_itens #itens_value").text();

    (qb === "0") ? $('.adicional_item, .adicional_item_ok').hide(): $('.adicional_item').show();

    $('#add_itenSabores input[type=radio]').on('change', function(e) {
        if ($(this).is(":checked")) {
            $(".addStyle").show()
        } else {
            $(".addStyle").hide()
        }
        $(this).closest('.hovereffect').toggleClass('clic');
    });

    //Produto Adicional
    // $('input[type=checkbox]').on('change', function(e1) {
    //     let tipoSlug = $(this).attr('data-tiposlug')
    //     let idEnvBlock = $(`#${tipoSlug}`).attr('id')
    //     let tipo_escolha = $(`#${idEnvBlock}`).attr('data-tipo_escolha')
    //     let tipo_escolhaQtd = $(`#${idEnvBlock}`).attr('data-qtd')
    //     var a = $(`#${idEnvBlock} input[type=checkbox]:checked`).length;
    //     var adv = $(this).val();
    //     let adv_att = $(this).attr('id');
    //     let vrec = $(this).attr('valor');
    //     let vb = $('#valorFinal').val();
    //     var a = $(`#${idEnvBlock} input[type=checkbox]:checked`).length;

    //     if (parseInt(tipo_escolha) === 2) {
    //         if (parseInt(a) === parseInt(tipo_escolhaQtd)) {
    //             $(`#${idEnvBlock} .adicional_item, .addStyleMod, .addStyleModT`).hide();
    //             $(`#${idEnvBlock} .adicional_item_ok, .addStyle`).show();
    //             if (parseInt(a) === 1) {
    //                 $(`#${idEnvBlock} .adicional_item_ok`).text(`${a} de ${tipo_escolhaQtd} selecionado`);
    //             }
    //             if (parseInt(a) <= parseInt(tipo_escolhaQtd)) {
    //                 $(`#${idEnvBlock} .adicional_item_ok`).text(`${a} de ${tipo_escolhaQtd} selecionados`);
    //             }
    //         } else {
    //             $(`#${idEnvBlock} .adicional_item`).show();
    //             $(`#${idEnvBlock} .adicional_item_ok, .addStyle, .addStyleMod, .addStyleModT`).hide();
    //         }

    //         if (parseInt(a) > parseInt(tipo_escolhaQtd)) {
    //             $(this).prop('checked', false);
    //             $(this).closest('label').removeClass('active');
    //             if (parseInt(tipo_escolhaQtd) > 1) {
    //                 alert("Você só pode selecionar " + parseInt(tipo_escolhaQtd) + " itens");
    //                 return;
    //             } else {
    //                 alert("Você só pode selecionar " + parseInt(tipo_escolhaQtd) + " item");
    //                 return;
    //             }
    //         }
    //     }

    //     if (parseInt(tipo_escolha) === 3) {
    //         if (parseInt(a) > 0 && parseInt(a) <= parseInt(tipo_escolhaQtd)) {
    //             $(`#${idEnvBlock} .adicional_item, .addStyleMod, .addStyleModT`).hide();
    //             $(`#${idEnvBlock} .adicional_item_ok`).show();
    //             if (parseInt(a) === 1) {
    //                 $(`#${idEnvBlock} .adicional_item_ok`).text(`${a} de ${tipo_escolhaQtd} selecionado`);
    //             }
    //             if (parseInt(a) <= parseInt(tipo_escolhaQtd)) {
    //                 $(`#${idEnvBlock} .adicional_item_ok`).text(`${a} de ${tipo_escolhaQtd} selecionados`);
    //             }
    //             $(".addStyle").show()
    //         } else {
    //             $(`#${idEnvBlock} .adicional_item`).show();
    //             $(`#${idEnvBlock} .adicional_item_ok`).hide();
    //         }

    //         if (parseInt(a) > parseInt(tipo_escolhaQtd)) {
    //             $(this).prop('checked', false);
    //             $(this).closest('label').removeClass('active');
    //             if (parseInt(tipo_escolhaQtd) > 1) {
    //                 alert("Você só pode selecionar " + parseInt(tipo_escolhaQtd) + " itens");
    //                 return;
    //             } else {
    //                 alert("Você só pode selecionar " + parseInt(tipo_escolhaQtd) + " item");
    //                 return;
    //             }
    //         }
    //     }
    //     $(this).closest('.hovereffect').toggleClass('clic');
    //     var valorAdicional = $(`#id_adicional${adv}`).attr('valor');
    //     if (parseFloat(valorAdicional) === 0.00) {
    //         $(`.id_adicional${adv}`).hide();
    //     }

    //     var total = 0;
    //     $('[data-qtd]').each(function(i, ele) {
    //         let tipo_escolha = $(`#${ele['id']}`).attr('data-tipo_escolha')
    //         let tipoQtd = $(`#${ele['id']}`).attr('data-qtd')
    //         if (parseInt(tipo_escolha) === 2) {
    //             var valor = Number(tipoQtd);
    //             if (!isNaN(valor)) total += valor;
    //         }
    //         if (parseInt(tipo_escolha) === 3) {
    //             total = total + 1;
    //         }
    //     });

    //     total = total

    //     let c = $(`input[type=checkbox]:checked`).length;
    //     if (parseInt(c) >= total) {
    //         $(`.addStyle`).show()
    //     } else {
    //         $(`.addStyle`).hide()
    //     }

    //     if (parseInt(tipo_escolha) === 1) {
    //         $(`.addStyleMod, .addStyleModT`).hide();
    //         $(`.addStyle`).show();
    //     }
    // });


    $('.mdc-card input[type=checkbox]').on('change', function(e1) {
    //loadTeachers($(e1.target).val());
    //console.log(e1);
    let tipoSlug = $(this).attr('data-tiposlug')
    let idEnvBlock = $(`#${tipoSlug}`).attr('id')
    let tipo_escolha = $(`#${idEnvBlock}`).attr('data-tipo_escolha')
    let tipo_escolhaQtd = $(`#${idEnvBlock}`).attr('data-qtd')
    var a = $(`#${idEnvBlock} input[type=checkbox]:checked`).length;
    var adv = $(this).val();
    //console.log(adv);
    let adv_att = $(this).attr('id');
    let vrec = $(this).attr('valor');
    let vb = $('#valorFinal').val();
    var a = $(`#${idEnvBlock} input[type=checkbox]:checked`).length;

    if (parseInt(tipo_escolha) === 2) {
        if (parseInt(a) === parseInt(tipo_escolhaQtd)) {
            $(`#${idEnvBlock} .adicional_item, .addStyleMod, .addStyleModT`).hide();
            $(`#${idEnvBlock} .adicional_item_ok, .addStyle`).show();
            if (parseInt(a) === 1) {
                $(`#${idEnvBlock} .adicional_item_ok`).text(`${a} de ${tipo_escolhaQtd} selecionado`);
            }
            if (parseInt(a) <= parseInt(tipo_escolhaQtd)) {
                $(`#${idEnvBlock} .adicional_item_ok`).text(`${a} de ${tipo_escolhaQtd} selecionados`);
            }
        } else {
            $(`#${idEnvBlock} .adicional_item`).show();
            $(`#${idEnvBlock} .adicional_item_ok, .addStyle, .addStyleMod, .addStyleModT`).hide();
        }

        if (parseInt(a) > parseInt(tipo_escolhaQtd)) {
            $(this).prop('checked', false);
            $(this).closest('label').removeClass('active');
            if (parseInt(tipo_escolhaQtd) > 1) {
                alert("Você só pode selecionar " + parseInt(tipo_escolhaQtd) + " itens");
                return;
            } else {
                alert("Você só pode selecionar " + parseInt(tipo_escolhaQtd) + " item");
                return;
            }
        }
    }

    if (parseInt(tipo_escolha) === 3) {
        if (parseInt(a) > 0 && parseInt(a) <= parseInt(tipo_escolhaQtd)) {
            $(`#${idEnvBlock} .adicional_item, .addStyleMod, .addStyleModT`).hide();
            $(`#${idEnvBlock} .adicional_item_ok`).show();
            if (parseInt(a) === 1) {
                $(`#${idEnvBlock} .adicional_item_ok`).text(`${a} de ${tipo_escolhaQtd} selecionado`);
            }
            if (parseInt(a) <= parseInt(tipo_escolhaQtd)) {
                $(`#${idEnvBlock} .adicional_item_ok`).text(`${a} de ${tipo_escolhaQtd} selecionados`);
            }
            $(".addStyle").show()
        } else {
            $(`#${idEnvBlock} .adicional_item`).show();
            $(`#${idEnvBlock} .adicional_item_ok`).hide();
        }

        if (parseInt(a) > parseInt(tipo_escolhaQtd)) {
            $(this).prop('checked', false);
            $(this).closest('label').removeClass('active');
            if (parseInt(tipo_escolhaQtd) > 1) {
                alert("Você só pode selecionar " + parseInt(tipo_escolhaQtd) + " itens");
                return;
            } else {
                alert("Você só pode selecionar " + parseInt(tipo_escolhaQtd) + " item");
                return;
            }
        }
    }

    if ($(this).is(":checked")) {
        $(`.${adv_att}`).show();
        var vc = parseFloat(vb) + parseFloat(vrec);
        var id_adicional = $(`#id_adicional${adv}`).val();
        var quantidade = 1;
        var numero_pedido = $('#numero_pedido').val();
        var id_produto = $('#id_produto').val();
        var id_carrinho = $('#id_carrinho').val();
        var id_empresa = $('#id_empresa').val();
        var id_cliente = $(`#id_cliente_${id_produto}`).val();
        var valor = $(`#valor${adv}`).val();
        $.ajax({
            url: `/${link_site}/produto/addCarrinho/adicionais`,
            type: 'post',
            data: {
                id_adicional: id_adicional,
                id_produto: id_produto,
                id_cliente: id_cliente,
                id_carrinho: id_carrinho,
                valor: valor,
                quantidade: quantidade,
                numero_pedido: numero_pedido,
                id_empresa: id_empresa,
                chave: chave
            },
            success: function(dd) {
                console.log(dd)
                var valorAdicional = $(`#id_adicional${adv}`).attr('valor');
                var novoValor = (parseFloat(vb) + parseFloat(valorAdicional));
                $('#total').text(formatter.format(novoValor));
                $('#valorFinal').val(novoValor);
            },
            error: function(xhr) {}
        });
    } else {
        $(`.${adv_att}`).hide();
        $(`.${adv}`).hide();
        $(".addStyle").show();

        var chave = $('#chave').val();
        var id_carrinho = $('#id_carrinho').val();
        var id_empresa = $('#id_empresa').val();
        var id_cliente = $(`#id_cliente_${id_produto}`).val();

        $.ajax({
            url: `/${link_site}/produto/removeCarrinho/adicionais`,
            type: 'get',
            data: {
                chave: chave,
                id_carrinho: id_carrinho,
                id_adicional: adv,
                id_empresa: id_empresa,
                id_cliente: id_cliente
            },
            success: function(dd) {
                console.log(dd)
                var novoValor = (parseFloat(vb) - parseFloat(vrec));
                if (!isNaN(novoValor)) {
                    $('#total').text(formatter.format(novoValor));
                }
                $(`#qtd_ad${adv}`).val(1);
            },
            error: function(xhr) {}
        });
        $(".addStyle").show()
    }
    $(this).closest('.hovereffect').toggleClass('clic');
    var valorAdicional = $(`#id_adicional${adv}`).attr('valor');
    if (parseFloat(valorAdicional) === 0.00) {
        $(`.id_adicional${adv}`).hide();
    }

    var total = 0;
    $('[data-qtd]').each(function(i, ele) {
        let tipo_escolha = $(`#${ele['id']}`).attr('data-tipo_escolha')
        let tipoQtd = $(`#${ele['id']}`).attr('data-qtd')
        if (parseInt(tipo_escolha) === 2) {
            var valor = Number(tipoQtd);
            if (!isNaN(valor)) total += valor;
        }
        if (parseInt(tipo_escolha) === 3) {
            total = total + 1;
        }
    });

    total = total

    let c = $(`input[type=checkbox]:checked`).length;
    if (parseInt(c) >= total) {
        $(`.addStyle`).show()
    } else {
        $(`.addStyle`).hide()
    }

    if (parseInt(tipo_escolha) === 1) {
        $(`.addStyleMod, .addStyleModT`).hide();
        $(`.addStyle`).show();
    }
});


    $('[data-quantity="plus"]').click(function(e) {
        console.log(e);
        $('.minuss').prop("disabled", false);
        fieldName = $(this).attr('data-field');
        var currentVal = parseInt($('input[name=' + fieldName + ']').val());

        if (!isNaN(currentVal)) {
            $('input[name=' + fieldName + ']').val(currentVal + 1);
            var advS = $(this).attr('id-select');
            var vbA = $('#valorFinal').val();
        } else {
            $('input[name=' + fieldName + ']').val(0);
        }
        $(".addStyle").show()
    });

    function customersProdutosEditar() {
    let id = $('.resumo-pedido').attr("data-cliente");
    let pedido_cliente = $('.resumo-pedido').attr("data-pedido-cliente");
    $.ajax({
        url: `/${link_site}/admin/pedido/produtos/carrinho/${id}/${pedido_cliente}`,
        method: "get",
        beforeSend: function() {
            $('#carregaCarrinhoEditar').html(`<div class="text-center" id="carregaRecebido"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path></svg></div>`);
        },
        complete: function() {
            $('#carregaCarrinhoEditar').html('');
        },
        success: function(dd) {
            //console.log(dd);
            if (parseInt(dd) === 0) {
                $('#mostraCarrinhoItensEditar').html('<div class="empty text-center"><i class="simple-icon-basket"></i><br/>Adicione Produtos para continuar</div>');
            } else {
                $('#mostraCarrinhoItensEditar').html(dd);
            }
        },
    })
}



    $("#formAddProd").submit(function() {
        var formData = new FormData(this);
        $.ajax({
            url: $("#formAddProd").attr('action'),
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
            success: function(data) {
                $(".btn_acao a, .btn_acao button").removeClass('hide');
                $('.btn_acao .carrega').html('')
                console.log(data)
                if (data.id > 0) {
                    $(function() {
                        customersProdutosEditar();
                    });
                    $('#modProdutoCarrinho').removeClass("hide");
                    $('.btnFPedido').removeClass("hide");
                    $('#modProduto').modal("hide");
                    // $('#mensagem').html(data.mensagem);
                    // $('.successSup').show();
                    // $('.errorSup').hide();
                    // $('#alerta').modal("show");
                    //     if (data.url) {
                    //         $(".buttonAlert").on('click', function () {
                    //             window.location = `/${link_site}/${data.url}`;
                    //     });
                    // }
                } else {
                    $('#modProduto').modal("hide");
                    $('.errorSup').show();
                    $('.successSup').hide();
                    $('#alertGeralSite').modal("show");
                    $('#mensagem').html(data.error);

                }
            },
            error: function(data) {
                $('.errorSup').show();
                $('#alerta').modal("show");
                $('#mensagem').html('Opss tivemos um problema!');
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
        return false;
    });

    $('#button-desconto').on('click', function() {
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
    return false
});
</script>
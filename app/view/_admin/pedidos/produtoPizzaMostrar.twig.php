<form method="post" id="form" action="{{BASE}}{{empresa.link_site}}/admin/produto/addCarrinho/produto-pizza/{{tamanho.id}}" novalidate>
    <div class="bg-primary border-bottom px-3 pt-3 pb-3 d-flex ">
        <div class="col-md-8 float-left pl-0 pt-2">
            <h3 class="font-weight-bold m-0 text-white text-uppercase pb-2 ">{{tamanho.nome}}</h3>
        </div>
        <div class="col-md-4 float-left pr-0">
            <div class="quantidade">
                <div class="input-group" style="width: 127px;">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number quantity-left-minus"  data-type="minus" data-field=""><span class="fa fa-minus"></span></button>
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
        <div class="col-md-12 pl-0">
            <div class="form-group col-md-12 col-pedido">
                <label for="tipo">Tipo</label>
                <select class="form-control select2-single select-box" id="tipo" name="tipo">
                    <option value="1">Inteira</option>
                    <option value="2">Meio a Meio</option>
                    <option value="3">1/3</option>
                    <option value="4">1/4</option>
                </select>
            </div>
            <div class="form-group col-md-12 col-pedido">
                <label for="borda">Borda</label>
                <select class="form-control select2-single select-box" id="borda" name="borda">
                    {% for mass in pizzaMassas %}
                    <option value="{{mass.id}}" data-valor="{{ mass.valor }}">{{mass.nome}} {% if mass.valor != 0.00 %}+ {{moeda.simbolo}} {{ mass.valor|number_format(2, ',', '.')}}{% endif %}</option>
                    {% endfor %}
                </select>
            </div>

            <div class="form-group col-md-12 col-pedido">
                <label for="pizza">Pizzas</label>
                <select class="form-control select2-single select-box" id="pizza" name="pizza[]" multiple="multiple">
                    {% for p in produtos %}
                    {% if p.cod is not null %}
                    <option value="{{p.id}}" data-valor="{% for prodVal in produtoValor %}{% if prodVal.id_produto == p.id and prodVal.id_tamanho == tamanho.id %}{{ prodVal.valor }}</span>{% endif %}{% endfor %}">{{ p.cod }} - {{ p.nome }} - {% for prodVal in produtoValor %}{% if prodVal.id_produto == p.id and prodVal.id_tamanho == tamanho.id %}{{moeda.simbolo}} {{ (prodVal.valor)|number_format(2, ',', '.')}}{% endif %}{% endfor %}</option>
                    {% endif %}
                    {% endfor %}
                </select>
            </div>


            <div class="clearfix"></div>
            <div class="form-group col-md-12 col-pedido">
            <label for="observacao">Alguma observação no pedido?</label>
            <div class="mb-0 input-group full-width">
                <div class="input-group-prepend"><span class="input-group-text"><i class="simple-icon-info"></i></span></div>
                <textarea name="observacao" id="observacao" placeholder="" aria-label="With textarea" class="form-control"></textarea>
            </div>
        </div>

            <hr>
            <div class="clearfix"></div>

            <input type="hidden" name="id_adicional" id="id_adicional" value="{{ produto.adicional }}">
            <input type="hidden" name="chave" id="chave" value="{{chave}}">
            <input type="hidden" name="id_empresa" id="id_empresa" value="{{empresa.id}}">
            <input type="hidden" name="id_cliente_{{produto.id}}" id="id_cliente_{{produto.id}}" value="{{idCliente}}"> 
            <input type="hidden" name="valor" id="valor" value="{% if produto.valor_promocional != '0.00' %}{{ produto.valor_promocional }}{% else %}{{ produto.valor }}{% endif %}">

            <button class="btn btn-success btn-block btn-lg addStyle mt-4 p-4">ADICIONAR AO PEDIDO <i class="feather-shopping-cart"></i></button>

        </div>
</form>


<script>
    $(document).ready(function() {
        $('.select2-single').select2({
            theme: "classic"
        });

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
    $('input[type=checkbox]').on('change', function(e1) {
        let tipoSlug = $(this).attr('data-tiposlug')
        let idEnvBlock = $(`#${tipoSlug}`).attr('id')
        let tipo_escolha = $(`#${idEnvBlock}`).attr('data-tipo_escolha')
        let tipo_escolhaQtd = $(`#${idEnvBlock}`).attr('data-qtd')
        var a = $(`#${idEnvBlock} input[type=checkbox]:checked`).length;
        var adv = $(this).val();
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



    $("#form").submit(function() {
        var formData = new FormData(this);
        $.ajax({
            url: $("#form").attr('action'),
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
                    $('#modProdutoCarrinho').removeClass("hide");
                    $('.btnFPedido').removeClass("hide");
                    $('#modProduto').modal("hide");
                    $('#mensagem').html(data.mensagem);
                    $('.successSup').show();
                    $('.errorSup').hide();
                    $('#alerta').modal("show");
                    if (data.url) {
                        $(".buttonAlert").on('click', function() {
                            window.location = `/${link_site}/${data.url}`;
                        });
                    }
                } else {
                    $('#modProduto').modal("hide");
                    $('.errorSup').show();
                    $('.successSup').hide();
                    $('#alertGeralSite').modal("show");
                    $('#mensagem').html(data.error);

                }

                if (data.id > 0) {
                    $('.successSup').show();
                    $('#alerta').modal("show");
                    $('#mensagem').html(data.mensagem);
                    if (data.url) {
                        $(".buttonAlert").on('click', function() {
                            window.location = `/${link_site}/admin/${data.url}`;
                        });
                    }
                } else {
                    $('.errorSup').show();
                    $('#alerta').modal("show");
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
</script>
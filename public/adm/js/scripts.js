'use strict';

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

var query = location.search.slice(1);
var partes = query.split('&');
var datal = {};
partes.forEach(function(parte) {
    var chaveValor = parte.split('=');
    var chave = chaveValor[0];
    var valor = chaveValor[1];
    datal[chave] = valor;
});
var link_site = $('body').attr('data-link_site');
$('input.timepicker').timepicker({
    showInputs: false,
    showMeridian: false,
    timeFormat: 'HH:mm'
});
$('#telefone').mask('(00) 00000-0000');
var mask = "HH:MM",
    pattern = {
        'translation': {
            'H': {
                pattern: /[0-23]/
            },
            'M': {
                pattern: /[0-59]/
            }
        }
    };

$(".timepicker").mask(mask, pattern);
$('.valor, #valor, #valor_promocional, #taxa_entrega, #valor_excedente, #taxa_entrega_motoboy, #taxa_entrega2, #taxa_entrega3, #diaria, #taxa').mask('#.##0,00', {
    reverse: true
});

$("#buscarCli").on('click blur touchleave touchcancel', function() {
    let telefone = $('#telefone').val();
    let formData = {
            telefone
        }
        //console.log(telefone);
    $.ajax({
        url: `/${link_site}/admin/pedido/pesquisa`,
        type: 'post',
        data: formData,
        beforeSend: function() {
            $('.carregar').html(`<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path><div class="mb-3 osahan-cart-item osahan-home-page"><div class="p-3 osahan-profile"><div class="osahan-text text-center mt-3"><p class="small mb-0">Estamos processando a sua busca aguarde um momento.</p></div></div></div>`);
        },
        complete: function(data) {
            $('.carregar').html('');
        },
        success: function(data) {
            console.log(data.id);
            if (data.id > 0) {
                $('#mostrarCliente').html(`<div class="mt-3 p-2 bloco-ops flex-container"><div class="p-2"><input type="radio" id="cliente" name="cliente" checked value="${data.id}"></div><label for="cliente" class="p-2">Nome: ${data.nome}<br/>Telefone: ${data.telefone}</label></div>`);
            } else {
                $('#mostrarCliente').html(`<div class="alert alert-danger" role="alert">${data.mensagem}</div>`);
            }

        },
        error: function(data) {
            $('.carregar').html(`<div class="mb-3 osahan-cart-item osahan-home-page"><div class="p-3 osahan-profile"><div class="osahan-text text-center mt-3"><h4 class="text-primary">Nenhum pedido foi encontrado.</h4><p class="small mb-0">Verifique o número digitado ou tente novamente.</p></div></div></div>`);
        }
    });
    // $.get(`/${link_site}/admin/pedido/pesquisa`, function (dd) {
    //   console.log(dd);

    //     var buscaCliente = $('#buscaCliente').val();
    //     var id_empresa = $(`#id_empresa`).val();

    //     if (parseInt(numero_pedido) === 0) {
    //         $('#mensagem').html(`<div class="alert alert-danger" role="alert">Para efetuar informe o numero do pedido</div>`)
    //     } else {

    //     }
    //     $('#pesquisaEntregasMotoboy').html(dd);
    //     $('#mensagem').html('')
    // })
    return false;
});

$('#valor_cupom').mask('##00%', {
    reverse: true
});
$('#tipo_cupom').on('change', function() {
    if (parseInt($(this).val()) === 2) {
        $('#valor_cupom').mask('#.##0,00', {
            reverse: true
        });
    }
    if (parseInt($(this).val()) === 1) {
        $('#valor_cupom').mask('##00%', {
            reverse: true
        });
    }
});

$('#nome_cupom').on('blur touchleave touchcancel', function() {
    $(this).val($(this).val().replace(" ", '').toUpperCase())
});



$(document).ready(function() {
    var mediaDevices = navigator.mediaDevices;
    let mediaRecorder
    mediaDevices.getUserMedia({
            audio: true
        })
        .then(stream => {
            mediaRecorder = new MediaRecorder(stream)
            mediaRecorder.ondataavailable = data => {
                //console.log(data)
            }
            mediaRecorder.onstop = () => {
                //console.log('stop')
            }
            mediaRecorder.start()
                //setTimeOut(() => mediaRecorder.stop(), 3000)
        }, err => {
            //console.log(err)
        })
})
$('#trocoMod, #mp, #entrega_end').hide();

$(document).ready(function() {
    $('#freteQuantos').hide();
    if ($('#frete_status').val() == 1) {
        $('#freteQuantos').show();
    }
    $(".close").on("click", function(event) {
        event.preventDefault();
        $('#data-notify').remove();
    });
});

$('#switch').change(function() {
    if ($(this).val() == 0) {
        $('#switch').val("1");
    } else {
        $('#switch').val("0");
    }
});

$('#frete_status').change(function() {
    if ($(this).val() == 0) {
        $('#frete_status').val("1");
        $('#freteQuantos').show();
        $('#valor').val(0);
    } else {
        $('#frete_status').val("0");
        $('#freteQuantos').hide();
        $('#valor').val(0);
    }
});

/** 
 * Formularios
 */

$("#form, #formIfood, #formCliente").submit(function() {
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
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
            switch (data.code) {
                case 3:
                    $('#ValidaCode').modal("show");
                    break;
                case 2:
                    $('#mensagem').html(data.mensagem);
                    $('.successSup').show();
                    $('.errorSup').hide();
                    $('#alerta').modal("show");

                    if (data.id > 0) {
                        if (data.url) {
                            $(".buttonAlert").on('click', function() {
                                window.location = `/${link_site}/${data.url}`;
                            });
                        }
                    }
                    break;
                case 1:
                    $('#alerta').modal("hide");
                    $('#alertGeralSite').modal("hide");
                    if (data.id > 0) {
                        window.location = `/${link_site}/${data.url}`;
                    }
                    break;
                case 4:
                    $('#mensagem').html(data.mensagem);
                    $('#mensagem').removeClass('m-0').removeClass('b-0').removeClass('p-0');
                    if (data.id > 0) {
                        $('#mensagem').removeClass('alert-danger').addClass('alert-success');
                        window.location = data.url;
                    }
                    break;
                case 5:
                    $('#modalNovoCliente').modal("hide");
                    $('#mensagem').html(data.mensagem);
                    $('.successSup').show();
                    $('.errorSup').hide();
                    $('#alerta').modal("show");

                    if (data.id > 0) {
                        if (data.url) {
                            $(".buttonAlert").on('click', function() {
                                window.location = `/${link_site}/${data.url}`;
                            });
                        }
                    }
                    break;
                default:
                    $('#mensagem').html(data.mensagem);
                    $('#modalNovoCliente').modal("hide");
                    $('.successSup').show();
                    $('.errorSup').hide();
                    $('#alerta').modal("show");
                    atualizar()
                    atualizaCart()
                    if (data.id > 0) {
                        if (data.url) {
                            $(".buttonAlert").on('click', function() {
                                atualizar();
                                window.location = `/${link_site}/${data.url}`;
                            });
                        }
                    }
                    break;
            }
        },
        error: function(data) {
            console.log(data);
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


$("#formMk").submit(function() {
    var formData = new FormData(this);
    $.ajax({
        url: $('#formMk').attr('action'),
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
            switch (data) {
                case 'Não foi possível Cadastar os dados do iFood':
                    $('.errorSup').show();
                    $('#alerta').modal("show");
                    $('#mensagem').html(data + '!');
                    $(".buttonAlert").on('click', function() {});
                    break;
                default:
                    let resultado = data.substring(data.indexOf("=") + 1);
                    $('#alertaIfood').modal("show");
                    $('#codeLink').html(`<a href="${data}" target="_blank">Clique aqui</a>`);
                    $('#codeOpen').html(resultado);
                    $(".buttonAlert").on('click', function() {});
                    break;
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


$("#formAtendimento").submit(function() {
    var formData = new FormData(this);
    $.ajax({
        url: $('#formAtendimento').attr('action'),
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
            switch (data.mensagem) {
                case 'Atendimento iniciado com sucesso':
                    $('.modal, .modal-backdrop, .atendimento').hide();
                    //$('<button type="button" class="atendimento on" data-toggle="modal" data-target="#caixa"><p>Seu restaurante encontra-se ativo para receber pedidos. <span class="botao">Deseja finalizar o atendimento de hoje?</span></p></button>').insertBefore("nav");
                    window.location.reload();
                    break;
                case 'Atendimento finalizado com sucesso':
                    $('.modal, .modal-backdrop, .atendimento').hide();
                    //$('<button type="button" class="atendimento" data-toggle="modal" data-target="#caixa"><p>Seu restaurante encontra-se desativado para receber pedidos. <span class="botao">Deseja iniciar o atendimento do restaurante?</span></p></button>').insertBefore("nav");
                    window.location.reload();
                    break;
                case 'Você não possuí um plano contratado':
                    $('.mensagem').html(`<div class="alert alert-danger" role="alert">Contrate um plano para iniciar o atendimento!</div>`);
                    window.location = `/${link_site}/${data.url}`;
                    break;
                case 'Não foi possível processar seu pagamento, atualize os dados de seu cartão!':
                    $('.mensagem').html(`<div class="alert alert-danger" role="alert">${data.mensagem}</div>`);
                    window.location = `/${link_site}/${data.url}`;
                    break;
                default:
                    $('#mensagem').html(`<div class="alert alert-danger" role="alert">${data.mensagem}</div>`);
                    break;
            }

        },
        error: function(data) {
            $('#mensagem').html(`<div class="alert alert-danger" role="alert">Opss tivemos um problema </div>`)

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


$("#formBusca").submit(function() {
    $.post(`/${link_site}/admin/buscar/entregas`, function(dd) {
        var id_motoboy = $(`#id_motoboy option:selected`).val();
        var inicio = $(`#inicio`).val();
        var hora_inicio = $(`#hora_inicio`).val();
        var termino = $(`#termino`).val();
        var horaFim = $(`#horaFim`).val();

        var formData = {
            id_motoboy,
            inicio,
            hora_inicio,
            termino,
            horaFim
        }

        if (parseInt(id_motoboy) === 0) {
            $('#mensagem').html(`<div class="alert alert-danger" role="alert">Para efetuar uma busca selecione um Motoboy as Data e Hora de Início e Fim para que o sistema possa carregar os dados</div>`)
        } else {

            $.ajax({
                url: `/${link_site}/admin/buscar/entregas`,
                type: 'post',
                data: formData,
                beforeSend: function() {
                    $('.carregar').html('<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>');
                },
                complete: function(data) {
                    $('.carregar').html('');
                },
                success: function(data) {
                    $('#buscaResultado').html(data);

                }
            });
        }
        $('#buscaResultado').html(dd);
        $('#mensagem').html('')
    })


    return false;
});

$('#txtbuscar').keyup(function() {
    $('#btn-buscar').click();
})
$('#cbbuscar').keyup(function() {
    $('#btn-buscar').click();
})
$('#modal-deletar').modal("show");


function produtosModal(id, numero_pedido) {
    $("#id").text(id);
    $("#numero_pedido").text(numero_pedido);

    $.ajax({
        url: `/${link_site}/admin/pedido/mostrar/${id}/${numero_pedido}`,
        method: "get",
        data: {
            id,
            numero_pedido
        },
        dataType: "html",
        beforeSend: function() {
            $('#mostrarPedido').html(
                `<div class="text-center pb-3">
                <h4 class="text-center pt-5">Carregando...</h4>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px"
                    height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none">
                        <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite"
                            keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform>
                    </path>
                </svg>
            </div>
        `);
        },
        complete: function() {
            $('#mostrarPedido').html();
        },
        success: function(result) {
            $('#mostrarPedido').html(result)
        },
    })
}


function loadStyle(href, callback) {
    for (var i = 0; i < document.styleSheets.length; i++) {
        if (document.styleSheets[i].href == href) {
            return;
        }
    }
    var head = document.getElementsByTagName("head")[0];
    var link = document.createElement("link");
    link.rel = "stylesheet";
    link.type = "text/css";
    link.href = href;
    if (callback) {
        link.onload = function() {
            callback();
        };
    }
    var mainCss = $(head).find('[href$="main.css"]');
    if (mainCss.length !== 0) {
        mainCss[0].before(link);
    } else {
        head.appendChild(link);
    }
}

function atualizaCart() {
    $.get(`/${link_site}/admin/carrinho/qtd`, function(dd) {
        $('#modProdutoCarrinho .qtd').html(dd);
    })
}

// $(function () {
//   atualizaCart();
// });

function atualizar() {
    $.ajax({
        url: `/${link_site}/admin/pedidos/recebido`,
        method: "get",
        beforeSend: function() {
            $('#carregaRecebido').html(`<div class="text-center" id="carregaRecebido"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path></svg></div>`);
        },
        complete: function() {
            $('#carregaRecebido').html('');
        },
        success: function(dd) {
            if (parseInt(dd) === 0) {
                $('#recebido').html('<div class="text-center block"><span class="iconsminds-digital-drawing size20"></span><p>Sem Pedidos no momento</p></div>');
            } else {
                let orderDay = localStorage.getItem("sttInit")
                let newOrder = new Audio('/audio/newOrder.mp3');

                let cancelOrder = new Audio('/audio/cancelOrder.mp3');
                if (parseInt($(dd).attr('data-status')) === 6) {
                    console.log('Cancelado')
                    cancelOrder.play();
                }

                if (orderDay === null) {
                    localStorage.setItem("sttInit", $(dd).attr('data-qtd'));
                    newOrder.play();
                    $('#recebido').html(dd);
                } else {
                    if (parseInt($(dd).attr('data-qtd')) > parseInt(orderDay)) {
                        localStorage.setItem("sttInit", $(dd).attr('data-qtd'));
                        newOrder.play();
                        $('#recebido').html(dd);
                    } else {
                        $('#recebido').html(dd);
                    }
                }
            }
        },
    })

    $.ajax({
        url: `/${link_site}/admin/pedidos/producao`,
        method: "get",
        success: function(dd) {
            if (parseInt(dd) === 0) {
                $('#producao').html('<div class="text-center block"><span class="iconsminds-digital-drawing size20"></span><p>Sem Pedidos no momento</p></div>');
            } else {
                let cancelOrder = new Audio('/audio/cancelOrder.mp3');
                if (parseInt($(dd).attr('data-status')) === 6) {
                    console.log('Cancelado')
                    cancelOrder.play();
                }
                $('#producao').html(dd);
            }
        },
    })

    $.ajax({
        url: `/${link_site}/admin/pedidos/geral`,
        method: "get",
        success: function(dd) {
            if (parseInt(dd) === 0) {
                $('#geral').html('<div class="text-center block"><span class="iconsminds-digital-drawing size20"></span><p>Sem Pedidos no momento</p></div>');
            } else {
                $('#geral').html(dd);
            }
        }
    })

    $.get(`/admin/pedidos/ifood`, function(dd) {
        if (parseInt(dd) === 0) {
            $('#producao').html('Sem Pedidos no momento');
        } else {
            if (parseInt($('#atendimentoOn').length) === 1) {
                if (204 === parseInt(dd)) {
                    console.log('No pending events found.');
                } else if (200 === parseInt(dd)) {
                    console.log('OK');
                } else {
                    console.log('Bad Request ' + dd);
                }
            }
        }

    })
}
setInterval(atualizar, 30000);
$(function() {
    atualizar();
});

$("#inpFiltro").on("keyup", function() {
    var value = this.value.toLowerCase().trim();
    $(".filtro li").show().filter(function() {
        return $(this).text().toLowerCase().trim().indexOf(value) == -1;
    }).hide();
});


function cancelarPedido(id) {
    let valores = {
        id
    }
    $.ajax({
        url: `/${link_site}/admin/pedido/cancelar`,
        method: "POST",
        data: valores,
        dataType: "text",
        success: function(dd) {
            //console.log(dd);
            $("#modPedido").modal('hide');
            atualizar();
        },
    })
}


function mudarStatus(id, status, id_caixa) {
    var id_motoboy = 0
    var id_empresa = $('#id_empresa').val();
    let valores = {
        id,
        status,
        id_caixa,
        id_empresa,
        id_motoboy
    }

    $.ajax({
            url: `/${link_site}/admin/pedido/mudar/${id}/${status}/${id_caixa}/${id_motoboy}`,
            method: "POST",
            data: valores,
            dataType: "text",
            beforeSend: function() {
                $(".btn_acao a, .btn_acao button").addClass('hide');
                $('.btn_acao .carrega').html('<div class="env"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path><br/>Aguarde processando informações!</div>');
            },
            complete: function() {
                $(".btn_acao a, .btn_acao button").removeClass('hide');
                $('.btn_acao .carrega').html('')
                $('#btn-carrinho').html('Pedido entregue <i class="simple-icon-arrow-right"></i>');
            },
            success: function(dd) {
                console.log(dd);
                $(".btn_acao a, .btn_acao button").removeClass('hide');
                $('.btn_acao .carrega').html('')
                if (dd == 'Status alterado com sucesso') {
                    atualizar();
                    $('#close-modal').trigger('click');

                    varWindow = window.open(`https://automatizadelivery.com.br/${link_site}/admin/pedido/imprimirPDF/${id}`, 'popup')
                } else {}

            },
        })
        // var newWin = window.open();
        // $.ajax({
        //   type: "GET", url: `https://automatizadelivery.com.br/${link_site}/admin/pedido/imprimirPDF/${id}`, data: {},
        //   success: function (data) {
        //     newWin.document.write(data);
        //     newWin.document.close();
        //     newWin.focus();
        //     newWin.print();
        //     newWin.close();
        //   },
        //   error: function () {
        //   }
        // });
}

function updateItem(id_empresa, id_categoria, id_tamanhos) {
    var tamanhos_categoria = $(`#categorias${id_categoria}`).attr('data-idcat');
    if (tamanhos_categoria) {
        var valores = {
            id_empresa,
            id_categoria,
            id_tamanhos,
            tamanhos_categoria
        }
    } else {
        var valores = {
            id_empresa,
            id_categoria,
            id_tamanhos
        }
    }
    $.ajax({
        url: `/${link_site}/admin/tamanho/u/item`,
        method: "POST",
        data: valores,
        dataType: "text",
        success: function(dd) {
            console.log(dd);
        },
    })
}

function updateItemMassa(id_empresa, id_tamanhos, id_massas) {
    let tamanhos_categoria = $(`#tamanhos${id_tamanhos}`).attr('data-idcat');
    if (tamanhos_categoria) {
        var valores = {
            id_empresa,
            id_massas,
            id_tamanhos,
            tamanhos_categoria
        }
    } else {
        var valores = {
            id_empresa,
            id_massas,
            id_tamanhos
        }
    }
    console.log(valores);
    $.ajax({
        url: `/${link_site}/admin/massas/u/item`,
        method: "POST",
        data: valores,
        dataType: "text",
        success: function(dd) {
            console.log(dd);
        },
    })
}

function mudarStatusEntrega(id, status, id_caixa) {
    var id_motoboy = $(`#motoboy-${id} option:selected`).val();
    if (id_motoboy === "Selecione") {
        $('.select2-single').shake().addClass('bc-danger');

        $(`#mensagem${id}`).html(`<div class="alert alert-danger" role="alert">Selecione um Motoboy antes de mudar de Status!</div>`);
        setTimeout(function() {
            $(`#mensagem${id}`).html(``)
        }, 2000);
    } else {
        var id_motoboy = $(`#motoboy-${id} option:selected`).val();
        var numero_pedido = $('#numero_pedido').val();
        var chave = $('#chave').val();
        var id_cliente = $('#id_cliente').val();
        var id_empresa = $('#id_empresa').val();
        let valores = {
            id,
            status,
            id_caixa,
            id_motoboy,
            numero_pedido,
            id_empresa,
            id_cliente,
            chave
        }
        $.ajax({
            url: `/${link_site}/admin/pedido/mudar/${id}/${status}/${id_caixa}/${id_motoboy}`,
            method: "post",
            data: valores,
            dataType: "text",
            beforeSend: function() {
                $(".btn_acao a, .btn_acao button").addClass('hide');
                $('.btn_acao .carrega').html('<div class="env"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path><br/>Aguarde processando informações!</div>');
            },
            complete: function() {
                $(".btn_acao a, .btn_acao button").removeClass('hide');
                $('.btn_acao .carrega').html('')
                $('#btn-carrinho').html('Pedido entregue <i class="simple-icon-arrow-right"></i>');
            },
            success: function(dd) {
                $(".btn_acao a, .btn_acao button").removeClass('hide');
                $('.btn_acao .carrega').html('')
                if (dd == 'Status alterado com sucesso') {
                    atualizar();
                    $('#close-modal').trigger('click');
                } else {
                    console.log('aqui');
                }
            },
        })
    }
}

function syncIfood(id, tipo) {
    let id_empresa = $('#id_empresa').val();
    let valores = {
        id,
        id_empresa
    }
    $.ajax({
        url: `/${link_site}/admin/sync/${tipo}/ifood`,
        method: "post",
        data: valores,
        dataType: "text",
        beforeSend: function() {
            $(`#btnSync${id}`).removeClass('iconsminds-repeat-3');
            $(`#btnSync${id}`).html(`<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>`);
        },
        success: function(dd) {
            $(`#btnSync${id}`).html('');
            $(`#btnSync${id}`).addClass('iconsminds-repeat-3');
            $(`#${id}pdtr`).html('<i class="simple-icon-check text-success size20"></i>');
            console.log(dd);
        },
    })
}




/* 02. Theme Selector, Layout Direction And Initializer */
(function($) {
    //$("body").append(themeColorsDom);


    /* Default Theme Color, Border Radius and  Direction */
    var theme = "dore.light.red.min.css";
    var direction = "ltr";
    var radius = "rounded";

    if (typeof Storage !== "undefined") {
        if (localStorage.getItem("dore-theme")) {
            theme = localStorage.getItem("dore-theme");
        } else {
            localStorage.setItem("dore-theme", theme);
        }
        if (localStorage.getItem("dore-direction")) {
            direction = localStorage.getItem("dore-direction");
        } else {
            localStorage.setItem("dore-direction", direction);
        }
        if (localStorage.getItem("dore-radius")) {
            radius = localStorage.getItem("dore-radius");
        } else {
            localStorage.setItem("dore-radius", radius);
        }
    }

    $(".theme-color[data-theme='" + theme + "']").addClass("active");
    $(".direction-radio[data-direction='" + direction + "']").attr("checked", true);
    $(".radius-radio[data-radius='" + radius + "']").attr("checked", true);
    $("#switchDark").attr("checked", theme.indexOf("dark") > 0 ? true : false);

    loadStyle("/adm/css/" + theme, onStyleComplete);

    function onStyleComplete() {
        setTimeout(onStyleCompleteDelayed, 300);
    }

    function onStyleCompleteDelayed() {
        $("body").addClass(direction);
        $("html").attr("dir", direction);
        $("body").addClass(radius);
        $("body").dore();
    }

    $("body").on("click", ".theme-color", function(event) {
        event.preventDefault();
        var dataTheme = $(this).data("theme");
        if (typeof Storage !== "undefined") {
            localStorage.setItem("dore-theme", dataTheme);
            window.location.reload();
        }
    });

    $("#remove_img").on("click", function(event) {
        event.preventDefault();
        $('#Nova_capa, #myDropzone').removeClass('hide');
        $('#IMG_toll, #remove_img').addClass('hide');
        $('#IMG_tollw').addClass('hide');
        $('#inputImagem').val('');
        $('#imagemNome').val('');
    });

    $("#remove_img2").on("click", function(event) {
        event.preventDefault();
        $('#NovaCapa').removeClass('hide');
        $('#IMG_toll2, #remove_img2').addClass('hide');
        $('#IMG_tollw2').addClass('hide');
        $('#imagemNomeCapa').val('');
    });



    $("input[name='directionRadio']").on("change", function(event) {
        var direction = $(event.currentTarget).data("direction");
        if (typeof Storage !== "undefined") {
            localStorage.setItem("dore-direction", direction);
            window.location.reload();
        }
    });

    $("input[name='radiusRadio']").on("change", function(event) {
        var radius = $(event.currentTarget).data("radius");
        if (typeof Storage !== "undefined") {
            localStorage.setItem("dore-radius", radius);
            window.location.reload();
        }
    });

    $("#switchDark").on("change", function(event) {
        var mode = $(event.currentTarget)[0].checked ? "dark" : "light";
        if (mode == "dark") {
            theme = theme.replace("light", "dark");
        } else if (mode == "light") {
            theme = theme.replace("dark", "light");
        }
        if (typeof Storage !== "undefined") {
            localStorage.setItem("dore-theme", theme);
            window.location.reload();
        }
    });

    $(".theme-button").on("click", function(event) {
        event.preventDefault();
        $(this)
            .parents(".theme-colors")
            .toggleClass("shown");
    });

    $(document).on("click", function(event) {
        if (!(
                $(event.target)
                .parents()
                .hasClass("theme-colors") ||
                $(event.target)
                .parents()
                .hasClass("theme-button") ||
                $(event.target).hasClass("theme-button") ||
                $(event.target).hasClass("theme-colors")
            )) {
            if ($(".theme-colors").hasClass("shown")) {
                $(".theme-colors").removeClass("shown");
            }
        }
    });

})(jQuery);


$(document).ready(function() {
    var $modal = $('#modal');
    var image = document.getElementById('sample_image');
    var cropper;

    $('#upload_image').change(function(event) {
        var files = event.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };

        if (files && files.length > 0) {
            var reader = new FileReader();
            reader.onload = function(event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 2,
            responsive: true,
            preview: '.preview',
            minCanvasWidth: 400,
            autoCropArea: 0.5,
            minCanvasHeight: 400,
            minCropBoxWidth: 400,
            minCropBoxHeight: 400,
            minContainerWidth: 400,
            minContainerHeight: 400
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $('#crop').click(function() {
        var canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400
        });

        canvas.toBlob(function(blob) {
            var url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $.ajax({
                    url: `/${link_site}/admin/upload`,
                    method: 'POST',
                    data: {
                        image: base64data
                    },
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
                        $modal.modal('hide');
                        $('#uploaded_image').attr('src', `/uploads/${data}`);
                        $('#imagemNome').val(data);
                    }
                });
            };
        });
    });

});


$('#cep, #cep_end').mask('00000-000');
// $("#rua").on('blur touchleave touchcancel', function () {
//   var estado = $('#estadoPrinc').val();
//   var cidade = $('#cidadePrinc').val();
//   var rua = $(this).val();
//   if (rua != "") {
//     $.getJSON(`https://maps.google.com/maps/api/geocode/json?address=${rua},${cidade}-${estado}/&key=AIzaSyAxhvl-7RHUThhX4dNvCGEkPuOoT6qbuDQ`, function (dados) {
//       console.log(dados);
//       if (dados.status === "OK") {
//         $("#endOK").show();
//         $('.btnValida').attr("disabled", true);
//         $("#endPrint").text(dados.results[0].formatted_address);

//         if (dados.results[0].address_components[0].types[0] === "street_number") {
//           $("#rua").val(dados.results[0].address_components[1].long_name);
//           $("#bairro").val(dados.results[0].address_components[2].long_name);
//           $("#cidade").val(dados.results[0].address_components[3].long_name);
//           $("#estado").val(dados.results[0].address_components[4].short_name);
//           $("#cep").val(dados.results[0].address_components[6].long_name);
//         } else {
//           $("#rua").val(dados.results[0].address_components[0].long_name);
//           $("#bairro").val(dados.results[0].address_components[1].long_name);
//           $("#cidade").val(dados.results[0].address_components[2].long_name);
//           $("#estado").val(dados.results[0].address_components[3].short_name);
//           $("#cep").val(dados.results[0].address_components[5].long_name);
//         }

//         $("#numero").on('blur touchleave touchcancel', function () {
//           $("#numeroPrint").text($(this).val());
//         });

//         $("#complemento").on('blur touchleave touchcancel', function () {
//           $("#complementoPrint").text($(this).val());
//           $('.btnValida').attr("disabled", false);
//         });

//         if (dados.results[0].geometry.location_type === "APPROXIMATE") {
//           $("#alertGeralSite").modal("show");
//           $(".errorSup").show();
//           $("#mensagem").text("O Endereço informado é APROXIMADO, verifique se confere com sua localização antes de prosseguir!");
//         }
//       } else {
//         $("#alertGeralSite").modal("show");
//         $(".errorSup").show();
//         $("#mensagem").text("O Endereço informado não foi encontrado, verifique se digitou corretamente e tente novamente!");
//       }
//     });

//   }
// });





$("#cep_end").on('blur touchleave touchcancel', function() {
    var cep = $(this).val().replace(/\D/g, '');
    if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if (validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $("#rua_end").val("...");
            $("#bairro_end").val("...");
            $("#cidade_end").val("...");
            $("#estado_end").val("...");
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    $("#rua_end").val(dados.logradouro);
                    $("#bairro_end").val(dados.bairro);
                    $("#cidade_end").val(dados.localidade);
                    $("#estado_end").val(dados.uf);
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    $("#alertGeralSite").modal("show");
                    $(".errorSup").show();
                    $("#mensagem").text("O Endereço informado não foi encontrado, verifique se digitou corretamente e tente novamente!");
                }
            });
        } //end if.
        else {
            $("#alertGeralSite").modal("show");
            $(".errorSup").show();
            $("#mensagem").text("Formato de CEP inválido.");
        }
    }
});

$(".catProds #nome, .catProds #tipo, #titulo").blur(function() {
    const str = $(this).val();
    const parsed = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/\s+/g, '-').toLowerCase();

    $('#slug, #slug').val(parsed);
});


$('#tipo_escolhaQtd').hide();
$('.show').show();
$('#tipo_escolha').on('change', function() {
    if (parseInt($(this).val()) === 2 || parseInt($(this).val()) === 3) {
        $('#tipo_escolhaQtd').show();
    } else {
        $('#tipo_escolhaQtd').hide();
        $('#qtd').val("");
    }

});
/**
 * Link ativo Admin
 */
var active_link = window.location.pathname;
var activeId = $('#titleBy').attr('data-id');
switch (active_link) {
    case `/${link_site}/admin/pedidos`:
        $('#collapseMenuTypes').addClass('show')
        $('#menuPedido .primaryMenu').removeClass('collapsed')
        $('#subPd').addClass('active')
        break;
    case `/${link_site}/admin/pedido/novo/produtos`:
        $('#collapseMenuTypes').addClass('show')
        $('#menuPedido .primaryMenu').removeClass('collapsed')
        $('#subPn').addClass('active')
        break;
    case `/${link_site}/admin/pedido/novo/produtos/detalhes`:
        $('#collapseMenuTypes').addClass('show')
        $('#menuPedido .primaryMenu').removeClass('collapsed')
        $('#subPn').addClass('active')
        break;
    case `/${link_site}/admin/pedido/novo`:
        $('#collapseMenuTypes').addClass('show')
        $('#menuPedido .primaryMenu').removeClass('collapsed')
        $('#subPn').addClass('active')
        break;
    case `/${link_site}/admin/caixa/visao-geral`:
        $('#collapseCaixaTypes').addClass('show')
        $('#menuCaixa .primaryMenu').removeClass('collapsed')
        $('#caiVg').addClass('active')
        break;
    case `/${link_site}/admin/avaliacao`:
        $('#menuAvaliacao').addClass('active')
        break;
    case `/${link_site}/admin/suporte`:
        $('#menuChat').addClass('active')
        break;
    case `/${link_site}/admin/caixa/relatorio`:
        $('#collapseCaixaTypes').addClass('show')
        $('#menuCaixa .primaryMenu').removeClass('collapsed')
        $('#caiRel').addClass('active')
        break;
    case `/${link_site}/admin/clientes/relatorio`:
        $('#collapseCaixaTypes').addClass('show')
        $('#menuCaixa .primaryMenu').removeClass('collapsed')
        $('#caiCli').addClass('active')
        break;
    case `/${link_site}/admin/caixa/dia/${activeId}`:
        $('#collapseCaixaTypes').addClass('show')
        $('#menuCaixa .primaryMenu').removeClass('collapsed')
        $('#caiRel').addClass('active')
        break;
    case `/${link_site}/admin/pedidos-finalizados`:
        $('#collapseMenuTypes').addClass('show')
        $('#menuPedido .primaryMenu').removeClass('collapsed')
        $('#subPf').addClass('active')
        break;
    case `/${link_site}/admin/pedidos-cancelados`:
        $('#collapseMenuTypes').addClass('show')
        $('#menuPedido .primaryMenu').removeClass('collapsed')
        $('#subPc').addClass('active')
        break;
    case `/${link_site}/admin/motoboys`:
        $('#collapseMenuMotoboys').addClass('show')
        $('#menuMotoboys .primaryMenu').removeClass('collapsed')
        $('#subMt').addClass('active')
        break;
    case `/${link_site}/admin/entregas`:
        $('#collapseMenuMotoboys').addClass('show')
        $('#menuMotoboys .primaryMenu').removeClass('collapsed')
        $('#subEn').addClass('active')
        break;
    case `/${link_site}/admin/produtos`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProd').addClass('active')
        break;
    case `/${link_site}/admin/cardapio`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProd').addClass('active')
        break;

    case `/${link_site}/admin/produto/novo/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProd').addClass('active')
        break;
    case `/${link_site}/admin/produto/editar/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProd').addClass('active')
        break;
    case `/${link_site}/admin/produto-pizza/novo/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProd').addClass('active')
        break;
    case `/${link_site}/admin/produto-pizza/editar/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProd').addClass('active')
        break;

    case `/${link_site}/admin/tipo-adicionais`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subTipoA').addClass('active')
        break;
    case `/${link_site}/admin/tipo-adicional/editar/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subTipoA').addClass('active')
        break;
    case `/${link_site}/admin/tipo-adicional/nova`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subTipoA').addClass('active')
        break;
    case `/${link_site}/admin/produtos-adicionais`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProdA').addClass('active')
        break;
    case `/admin/produto-adicional/editar/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProdA').addClass('active')
        break;
    case `/${link_site}/admin/produto-adicional/novo/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subProdA').addClass('active')
        break;

    case `/${link_site}/admin/produtos-sabores`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subSabores').addClass('active')
        break;

    case `/${link_site}/admin/produto-sabor/editar/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subSabores').addClass('active')
        break;

    case `/${link_site}/admin/produto-sabor/novo`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subSabores').addClass('active')
        break;
    case `/${link_site}/admin/categorias`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subCat').addClass('active')
        break;
    case `/${link_site}/admin/categoria/editar/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subCat').addClass('active')
        break;
    case `/${link_site}/admin/categoria/nova`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subCat').addClass('active')
        break;


    case `/${link_site}/admin/massas`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subMass').addClass('active')
        break;
    case `/${link_site}/admin/massa/editar/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subMass').addClass('active')
        break;
    case `/${link_site}/admin/massa/nova`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subMass').addClass('active')
        break;


    case `/${link_site}/admin/tamanhos`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subTam').addClass('active')
        break;
    case `/${link_site}/admin/tamanho/editar/${activeId}`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subTam').addClass('active')
        break;
    case `/${link_site}/admin/tamanho/novo`:
        $('#collapseProdutos').addClass('show')
        $('#menuProdutos .primaryMenu').removeClass('collapsed')
        $('#subTam').addClass('active')
        break;



    case `/${link_site}/admin/atendentes`:
        $('#collapseMenuUsuarios').addClass('show')
        $('#menuUsuarios .primaryMenu').removeClass('collapsed')
        $('#subAt').addClass('active')
        break;
    case `/${link_site}/admin/clientes`:
        $('#collapseMenuUsuarios').addClass('show')
        $('#menuUsuarios .primaryMenu').removeClass('collapsed')
        $('#subCli').addClass('active')
        break;

    case `/${link_site}/admin/cliente/novo`:
        $('#collapseMenuUsuarios').addClass('show')
        $('#menuUsuarios .primaryMenu').removeClass('collapsed')
        $('#subCli').addClass('active')
        break;

    case `/${link_site}/admin/cliente/editar/${activeId}`:
        $('#collapseMenuUsuarios').addClass('show')
        $('#menuUsuarios .primaryMenu').removeClass('collapsed')
        $('#subCli').addClass('active')
        break;

    case `/${link_site}/admin/administradores`:
        $('#collapseMenuUsuarios').addClass('show')
        $('#menuUsuarios .primaryMenu').removeClass('collapsed')
        $('#subUn').addClass('active')
        break;
    case `/${link_site}/admin/meu-perfil`:
        $('#collapseMenuUsuarios').addClass('show')
        $('#menuUsuarios .primaryMenu').removeClass('collapsed')
        $('#subPer').addClass('active')
        break;
    case `/${link_site}/admin/administrador/novo`:
        $('#collapseMenuUsuarios').addClass('show')
        $('#menuUsuarios .primaryMenu').removeClass('collapsed')
        $('#subUn').addClass('active')
        break;
    case `/${link_site}/admin/administrador/editar/${activeId}`:
        $('#collapseMenuUsuarios').addClass('show')
        $('#menuUsuarios .primaryMenu').removeClass('collapsed')
        $('#subUn').addClass('active')
        break;

        // case `/${link_site}/admin/planos`:
        // $('#collapseMenuConfiguracoes').addClass('show')
        // $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        // $('#subMp').addClass('active')
        // break;


    case `/${link_site}/admin/planos`:
        $('#collapseMenuConfiguracoes').addClass('show')
        $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        $('#subMp').addClass('active')
        break;
    case `/${link_site}/admin/ifood`:
        $('#collapseMenuIntegracao').addClass('show')
        $('#menuIntegracao .primaryMenu').removeClass('collapsed')
        $('#subIfood').addClass('active')
        break;
    case `/${link_site}/admin/ubereats`:
        $('#collapseMenuIntegracao').addClass('show')
        $('#menuIntegracao .primaryMenu').removeClass('collapsed')
        $('#subUberEats').addClass('active')
        break;
    case `/${link_site}/admin/click-entregas`:
        $('#collapseMenuIntegracao').addClass('show')
        $('#menuIntegracao .primaryMenu').removeClass('collapsed')
        $('#subClickEntregas').addClass('active')
        break;
    case `/${link_site}/admin/conf/e`:
        $('#collapseMenuConfiguracoes').addClass('show')
        $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        $('#subEmp').addClass('active')
        break;
    case `/${link_site}/admin/delivery`:
        $('#collapseMenuAuxiliares').addClass('show')
        $('#menuAuxiliares .primaryMenu').removeClass('collapsed')
        $('#subDeliTip').addClass('active')
        break;
    case `/${link_site}/admin/delivery/editar/${activeId}`:
        $('#collapseMenuAuxiliares').addClass('show')
        $('#menuAuxiliares .primaryMenu').removeClass('collapsed')
        $('#subDeliTip').addClass('active')
        break;
    case `/${link_site}/admin/conf/delivery/e`:
        $('#collapseMenuConfiguracoes').addClass('show')
        $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        $('#subDeli').addClass('active')
        break;
    case `/${link_site}/admin/conf/impressora/e`:
        $('#collapseMenuConfiguracoes').addClass('show')
        $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        $('#subImp').addClass('active')
        break;

    case `/${link_site}/admin/conf/atendimento`:
        $('#collapseMenuConfiguracoes').addClass('show')
        $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        $('#subHor').addClass('active')
        break;
    case `/${link_site}/admin/conf/atendimento/novo`:
        $('#collapseMenuConfiguracoes').addClass('show')
        $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        $('#subHor').addClass('active')
        break;
    case `/${link_site}/admin/cupons`:
        $('#collapseMenuConfiguracoes').addClass('show')
        $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        $('#subCu').addClass('active')
        break;
    case `/${link_site}/admin/cupom/novo`:
        $('#collapseMenuConfiguracoes').addClass('show')
        $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
        $('#subCu').addClass('active')
        break;


    case `/${link_site}/admin/formas-pagamento`:
        $('#collapseMenuAuxiliares').addClass('show')
        $('#menuAuxiliares .primaryMenu').removeClass('collapsed')
        $('#subFp').addClass('active')
        break;
    case `/${link_site}/admin/formas-pagamento/editar/${activeId}`:
        $('#collapseMenuAuxiliares').addClass('show')
        $('#menuAuxiliares .primaryMenu').removeClass('collapsed')
        $('#subFp').addClass('active')
        break;

    case `/${link_site}/admin/status`:
        $('#collapseMenuAuxiliares').addClass('show')
        $('#menuAuxiliares .primaryMenu').removeClass('collapsed')
        $('#subStatus').addClass('active')
        break;
    case `/${link_site}/admin/status/editar/${activeId}`:
        $('#collapseMenuAuxiliares').addClass('show')
        $('#menuAuxiliares .primaryMenu').removeClass('collapsed')
        $('#subStatus').addClass('active')
        break;

    case `/${link_site}/admin/formas-pagamento/nova`:
        $('#collapseMenuAuxiliares').addClass('show')
        $('#menuAuxiliares .primaryMenu').removeClass('collapsed')
        $('#subFp').addClass('active')
        break;
    case `/${link_site}/admin/docs`:
        $('#menuDocs').addClass('active')
        break;
    case `/admin/empresas`:
        $('#menuEmpresa').addClass('active')
        break;
    case `/admin/empresas?page=${activeId}`:
        $('#menuEmpresa').addClass('active')
        break;
    case `/admin/paginas`:
        $('#menuPaginas').addClass('active')
        break;
    case `/admin/pagina/nova`:
        $('#menuPaginas').addClass('active')
        break;
    case `/admin/paginas/editar/${activeId}`:
        $('#menuPaginas').addClass('active')
        break;
    default:
        $('#menuPainel').addClass('active')
}

$('.enderecoCad').hide();
$("#switchEnd").on("change", function() {
    if ($(this).is(":checked")) {
        $('.enderecoCad').show();
        $("#cep, #numero, #complemento, #bairro, #rua").prop("required", true);
    } else {
        $('.enderecoCad').hide();
        $("#cep, #numero, #complemento, #bairro, #rua").prop("required", false);
    }
});

function produtoModal(id) {
    $("#id").text(id);
    console.log('dd');
    $.ajax({
        url: `/${link_site}/admin/produto/novo/mostrar/${id}`,
        method: "get",
        data: {
            id
        },
        dataType: "html",
        beforeSend: function() {
            $('#mostrarProduto').html(
                `<div class="text-center pb-3">
                <h4 class="text-center pt-5">Carregando...</h4>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px"
                    height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none">
                        <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite"
                            keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform>
                    </path>
                </svg>
            </div>
        `);
        },
        complete: function() {
            $('#mostrarProduto').html();
        },
        success: function(dd) {
            $('#mostrarProduto').html(dd)
        },
    })
}

function produtoModalEditar(id, numero_pedido) {
    $("#id").text(id);
    console.log('dd');
    $.ajax({
        url: `/${link_site}/admin/produto/editar/mostrar/${id}/${numero_pedido}`,
        method: "get",
        data: {
            id,
            numero_pedido
        },
        dataType: "html",
        beforeSend: function() {
            $('#mostrarProduto').html(
                `<div class="text-center pb-3">
                <h4 class="text-center pt-5">Carregando...</h4>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px"
                    height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none">
                        <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite"
                            keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform>
                    </path>
                </svg>
            </div>
        `);
        },
        complete: function() {
            $('#mostrarProduto').html();
        },
        success: function(dd) {
            $('#mostrarProduto').html(dd)
        },
    })
}



function produtoPizzaModal(tamanho) {
    console.log('aqui');
    $.ajax({
        url: `/${link_site}/admin/produto/novo/mostrar-pizza/${tamanho}`,
        method: "get",
        data: {
            tamanho
        },
        dataType: "html",
        beforeSend: function() {
            $('#mostrarProduto').html(
                `<div class="text-center pb-3">
                <h4 class="text-center pt-5">Carregando...</h4>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px"
                    height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none">
                        <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite"
                            keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform>
                    </path>
                </svg>
            </div>
        `);
        },
        complete: function() {
            $('#mostrarProduto').html();
        },
        success: function(dd) {
            $('#mostrarProduto').html(dd)
        },
    })
}


function verEndereco(id) {
    //$("#modProdutoCarrinho").on("click", function () {
    $.get(`/${link_site}/admin/endereco/${id}`, function(dd) {
        $('#mensagem').html(`<div class="dados-cli text-left"><h2>Dados do Cliente</h2><ul style='width:100%'>
        <li><strong>Cliente:</strong> ${dd.nome}</li>
        <li><strong>Endereço:</strong> ${dd.rua} ${dd.numero}, ${dd.complemento} CEP: ${dd.cep}</li></ul></div>`);
        $('.buttonAlert').text('Fechar').show();
    })
}

function produtoPizzaModalEditar(tamanho, numero_pedido) {
    console.log('aqui');
    $.ajax({
        url: `/${link_site}/admin/produto/editar/mostrar-pizza/${tamanho}/${numero_pedido}`,
        method: "get",
        data: {
            tamanho,
            numero_pedido
        },
        dataType: "html",
        beforeSend: function() {
            $('#mostrarProduto').html(
                `<div class="text-center pb-3">
                <h4 class="text-center pt-5">Carregando...</h4>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px"
                    height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none">
                        <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite"
                            keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform>
                    </path>
                </svg>
            </div>
        `);
        },
        complete: function() {
            $('#mostrarProduto').html();
        },
        success: function(dd) {
            $('#mostrarProduto').html(dd)
        },
    })
}


$("#modProdutoCarrinho").on("click", function() {
    console.log('dd aqui');
    $.get(`/${link_site}/admin/carrinho`, function(dd) {
        $('#mostrarProduto').html(dd)
    })
})


$("#abrirCarrinhoModal").on('click', function() {
    $("#modal-carrinho").modal("show");
});
$('#trocoMod, #mp, #entrega_end').hide();

$('#tipo_pagamento').on('change', function() {
    if (parseInt($(this).val()) === 1) {
        $('#trocoMod').show();
        $('.btnValida').hide();
    } else {
        $('#trocoMod').hide();
        $('#trocoCliente').hide();
        $('.btnValida').show();
    }
});

$('#calcularTroco').on('click', function() {
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


// $('.buton-collapse').on('toggle', function () {
//   let cats = $(this).attr('id');
//   if ($(this).is(".show")) {
//     $(`#${cats} i`).removeClass('fa-chevron-up').addClass('fa-chevron-down')
//   }else{
//     $(`#${cats} i`).addClass('fa-chevron-up').removeClass('fa-chevron-down')
//   }


// });

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

let autocomplete;
let address1Field;

$("#ship-address").on('click touchleave touchcancel',

    function initAutocomplete() {
        address1Field = document.querySelector("#ship-address");
        autocomplete = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: {
                country: ["br", "br"]
            },
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        address1Field.focus();
        autocomplete.addListener("place_changed", fillInAddress);
    },

    function fillInAddress() {
        const place = autocomplete.getPlace();

        for (const component of place.address_components) {
            const componentType = component.types[0];
            switch (componentType) {
                case "street_number":
                    {
                        $("#numero").val(component.long_name);
                        break;
                    }
                case "route":
                    {
                        $("#rua").val(component.long_name);
                        break;
                    }
                case "postal_code":
                    {
                        $("#cep").val(component.long_name);
                        break;
                    }
                case "administrative_area_level_2":
                    {
                        $("#cidade").val(component.long_name);
                        break;
                    }
                case "administrative_area_level_1":
                    {
                        $("#estado").val(component.short_name);
                        break;
                    }
                case "sublocality_level_1":
                    $("#bairro").val(component.short_name);
                    break;
            }
        }
    }
)

$('#entrega').on('change', function() {
    if (parseInt($(this).val()) === 1) {
        $('#endereco').show();
    } else {
        $('#endereco').hide();
        $("#ship-address, #rua, #numero, #cep, #cidade, #bairro, #estado, #complemento").prop("required", false);
    }
});



Dropzone.options.myDropzone = {
    dictDefaultMessage: `<div class="sc-exiMuG daagyf">
  <div class="sc-eishCr kYjbTi">
      <div class="sc-fubCfw cqjzZd"><svg viewBox="0 0 50 50" fill="none" width="50px" height="50px">
              <path d="M19.3413 20.7821C19.3413 19.9867 19.9862 19.3418 20.7817 19.3418H40.5349C41.3304 19.3418 41.9753 19.9867 41.9753 20.7821V40.5354C41.9753 41.3309 41.3304 41.9758 40.5349 41.9758H20.7817C19.9862 41.9758 19.3413 41.3309 19.3413 40.5354V20.7821Z" fill="#DCDCDC"></path>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M1.64586 0C0.736743 0 -0.000244141 0.736987 -0.000244141 1.64611V4.59538C-0.000244141 5.5045 0.736743 6.24149 1.64586 6.24149C2.55498 6.24149 3.29197 5.5045 3.29197 4.59538V3.29222H4.59514C5.50426 3.29222 6.24125 2.55523 6.24125 1.64611C6.24125 0.736987 5.50426 0 4.59514 0H1.64586ZM10.4937 0C9.58457 0 8.84758 0.736987 8.84758 1.64611C8.84758 2.55523 9.58457 3.29222 10.4937 3.29222H16.3922C17.3014 3.29222 18.0384 2.55523 18.0384 1.64611C18.0384 0.736987 17.3014 0 16.3922 0H10.4937ZM22.2908 0C21.3817 0 20.6447 0.736987 20.6447 1.64611C20.6447 2.55523 21.3817 3.29222 22.2908 3.29222H28.1893C29.0985 3.29222 29.8355 2.55523 29.8355 1.64611C29.8355 0.736987 29.0985 0 28.1893 0H22.2908ZM34.0879 0C33.1788 0 32.4418 0.736987 32.4418 1.64611C32.4418 2.55523 33.1788 3.29222 34.0879 3.29222H35.3911V4.42235C35.3911 5.33147 36.1281 6.06846 37.0372 6.06846C37.9463 6.06846 38.6833 5.33147 38.6833 4.42235V1.64611C38.6833 0.736987 37.9463 0 37.0372 0H34.0879ZM38.6833 9.97968C38.6833 9.07056 37.9463 8.33357 37.0372 8.33357C36.1281 8.33357 35.3911 9.07056 35.3911 9.97968V11.3167H16.255C13.5277 11.3167 11.3167 13.5277 11.3167 16.255V35.3913H10.0564C9.14732 35.3913 8.41034 36.1283 8.41034 37.0374C8.41034 37.9465 9.14732 38.6835 10.0564 38.6835H11.3167V45.0619C11.3167 47.7893 13.5277 50.0002 16.255 50.0002H45.0619C47.7893 50.0002 50.0002 47.7893 50.0002 45.0619V16.255C50.0002 13.5277 47.7893 11.3167 45.0619 11.3167H38.6833V9.97968ZM3.29197 10.4939C3.29197 9.58482 2.55498 8.84783 1.64586 8.84783C0.736743 8.84783 -0.000244141 9.58482 -0.000244141 10.4939V16.3925C-0.000244141 17.3016 0.736743 18.0386 1.64586 18.0386C2.55498 18.0386 3.29197 17.3016 3.29197 16.3925V10.4939ZM3.29197 22.291C3.29197 21.3819 2.55498 20.6449 1.64586 20.6449C0.736743 20.6449 -0.000244141 21.3819 -0.000244141 22.291V28.1896C-0.000244141 29.0987 0.736743 29.8357 1.64586 29.8357C2.55498 29.8357 3.29197 29.0987 3.29197 28.1896V22.291ZM3.29197 34.0881C3.29197 33.179 2.55498 32.442 1.64586 32.442C0.736743 32.442 -0.000244141 33.179 -0.000244141 34.0881V37.0374C-0.000244141 37.9465 0.736743 38.6835 1.64586 38.6835H4.44939C5.35851 38.6835 6.0955 37.9465 6.0955 37.0374C6.0955 36.1283 5.35851 35.3913 4.44939 35.3913H3.29197V34.0881ZM14.6089 16.255C14.6089 15.3459 15.3459 14.6089 16.255 14.6089H45.0619C45.971 14.6089 46.708 15.3459 46.708 16.255V45.0619C46.708 45.971 45.971 46.708 45.0619 46.708H16.255C15.3459 46.708 14.6089 45.971 14.6089 45.0619V16.255Z" fill="#3E3E3E"></path>
          </svg></div>
  </div>
  <h3 class="sc-dkaWxM fyJEKv pt-2">Adicione ou arraste uma foto pra cá</h3><span class="sc-idOhPF isZjgk sc-cVkrFx hhbVN">Você pode buscar no seu dispositivo ou arrastar a foto até aqui pra carregar automaticamente.</span>
</div>`,
    url: `/${link_site}/admin/upload`,
    parallelUploads: 1,
    paramName: "image",
    fileName: true,
    uploadMultiple: false,
    acceptFiles: 'image/jpeg,image/png,image/gif,image/jpg',
    acceptedMimeTypes: 'image/jpeg,image/png,image/gif,image/jpg',
    autoProcessQueue: true,
    transformFile: function(file, done) {
        var myDropZone = this;
        var editor = document.createElement('div');
        editor.style.position = 'fixed';
        editor.style.left = 0;
        editor.style.right = 0;
        editor.style.top = 0;
        editor.style.bottom = 0;
        editor.style.zIndex = 9999;
        editor.style.backgroundColor = '#000';
        document.body.appendChild(editor);

        // Create the confirm button
        var confirm = document.createElement('button');
        confirm.style.position = 'absolute';
        confirm.style.left = '10px';
        confirm.style.top = '10px';
        confirm.style.zIndex = 9999;
        confirm.textContent = 'Cortar Imagem';
        confirm.addEventListener('click', function() {

            // Get the output file data from Croppie
            croppie.result({
                type: 'blob',
                size: {
                    width: 300,
                    height: 300
                }
            }).then(function(blob) {

                // Update the image thumbnail with the new image data
                myDropZone.createThumbnail(
                    blob,
                    myDropZone.options.thumbnailWidth,
                    myDropZone.options.thumbnailHeight,
                    myDropZone.options.thumbnailMethod,
                    false,
                    function(dataURL) {

                        // Update the Dropzone file thumbnail
                        myDropZone.emit('thumbnail', file, dataURL);

                        // Return modified file to dropzone
                        done(blob);
                    }
                );
            });
            editor.parentNode.removeChild(editor);

        });
        editor.appendChild(confirm);
        var croppie = new Croppie(editor, {
            enableResize: true
        });
        croppie.bind({
            url: URL.createObjectURL(file)
        });
    },
    init: function() {
        this.on("success", function(file, response) {
            //console.log("Response :" + myDropZone);
            $('#imagemNome').val(response);
        });
        this.processQueue();
    },
    thumbnailWidth: 300,
    previewTemplate: '<div class="dz-preview dz-file-preview mb-3"><div class=""><div class="p-0 w-100 position-relative"><div class="dz-error-mark"><span><i></i></span></div><div class="dz-success-mark"><span><i></i></span></div><div class="preview-container"><img data-dz-thumbnail class="img-thumbnail border-0" /><i class="simple-icon-doc preview-icon" ></i></div></div><div class="pl-3 pt-2 pr-2 pb-1 w-70 dz-details position-relative"><div><span data-dz-name></span></div><div class="text-primary text-extra-small" data-dz-size /><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div></div><a href="#/" class="remove" data-dz-remove><i class="glyph-icon simple-icon-trash"></i></a></div>'
};


/**
 * Checkout
 */
if ($(".card-wrapper").length === 1) {

    new Card({
        form: document.querySelector('form'),
        container: '.card-wrapper',
        placeholders: {
            number: '•••• •••• •••• ••••',
            name: 'NOME TITULAR',
            expiry: '••/••',
            cvc: '•••'
        },
        masks: {
            cardNumber: '•' // optional - mask card number
        },
    });
}
'use strict';

jQuery.fn.shake = function (interval, distance, times) {
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
partes.forEach(function (parte) {
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

$('#valor, #valor_promocional, #taxa_entrega, #valor_excedente, #taxa_entrega_motoboy').mask('#.##0,00', {
  reverse: true
});
$('#valor_cupom').mask('##00%', {
  reverse: true
});
$('#tipo_cupom').on('change', function () {
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

$('#nome_cupom').on('blur touchleave touchcancel', function () {
  $(this).val($(this).val().replace(" ", '').toUpperCase())
});



$(document).ready(function () {
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

$(document).ready(function () {
  $('#freteQuantos').hide();
  if ($('#frete_status').val() == 1) {
    $('#freteQuantos').show();
  }
  $(".close").on("click", function (event) {
    event.preventDefault();
    $('#data-notify').remove();
  });
});

$('#switch').change(function () {
  if ($(this).val() == 0) {
    $('#switch').val("1");
  } else {
    $('#switch').val("0");
  }
});

$('#frete_status').change(function () {
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

$("#form, #formIfood").submit(function () {
  var formData = new FormData(this);
  $.ajax({
    url: $('#form').attr('action'),
    type: 'POST',
    data: formData,
    beforeSend: function () {
      $(".acaoBtn").prop("disabled", true);
      $('.acaoBtn, .acaoBtnLogin').html('<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>');
    },
    complete: function () {
      $(".acaoBtn").prop("disabled", false);
      $('.acaoBtnCadastro').html('Cadastrar');
      $('.acaoBtnAtualizar').html('Atualizar');
      $('.acaoBtnAutorizar').html('Autorizar');
      $('.acaoBtnLogin').html('Login');

    },
    success: function (data) {
      console.log(data)
      switch (data) {
        case 'Sua conta foi criada com sucesso! Enviamos um email com informações de acesso.':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html('Cliente cadastrado com sucesso! Enviamos um email com informações de acesso!');
          break;
        case 'Opss! Não foi possível cadastrar o cliente, cliente já cadastrado na plataforma!':
          $('.errorSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html('Usuário cadastrado com sucesso! Enviamos um email com informações de acesso!');
          break;
        case 'Produto Adicional cadastrado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/produtos-adicionais`;
          });
          break;
        case 'Cupom cadastrada com sucesso':
          $('#mensagem').html(data + '!');
          $('.successSup').show();
          $('#alerta').modal("show");
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/cupons`;
          });
          break;
        case 'Tipo de Delivery cadastrado com sucesso':
          $('#mensagem').html(data + '!');
          $('.successSup').show();
          $('#alerta').modal("show");
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/delivery`;
          });
          break;

          case 'Tipo de Delivery atualizado com sucesso':
            $('#mensagem').html(data + '!');
            $('.successSup').show();
            $('#alerta').modal("show");
            $(".buttonAlert").on('click', function () {
              window.location = `/${link_site}/admin/delivery`;
            });
            break;

        case 'Sabor cadastrado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/produtos-sabores`;
          });
          break;
        case 'Tipo Adicional cadastrado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/tipo-adicionais`;
          });
          break;
        case 'Tipo Adicional atualizar com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/tipo-adicionais`;
          });
          break;
        case 'Plano contratado com sucesso!':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data);
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/planos`;
          });
          break;
        case 'Aguarde! Estamos aguardando o processamento do seu pagamento!':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data);
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/planos`;
          });
          break;

        case 'Usuário cadastrado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/usuarios`;
          });
          break;
        case 'Produto cadastrado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/produtos`;
          });
          break;
        case 'Produto Adicional atualizado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/produtos-adicionais`;
          });
          break;
        case 'Aguarde estamos redirecionando para a pagina inicial':
          console.log(data)
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!').removeClass('alert-danger').removeClass('p-0').addClass('alert-success');
          // if(data.link == null){
          //   window.location = `/${data.link}/admin/`;
          // }else{
          //   window.location = `/admin/`;
          // }

          break;
        case 'Sabor atualizar com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/produtos-sabores`;
          });
          break;
        case 'Categoria atualizar com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/categorias`;
          });
          break;
        case 'Configurações atualizar com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          break;
        case 'Usuário atualizado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          break;
        case 'Motoboy atualizado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          break;
        case 'Forma de Pagamento cadastrada com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/formas-pagamento`;
          });
          break;
        case 'Forma de Pagamento atualizar com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/formas-pagamento`;
          });
          break;
        case 'Produto atualizado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/produtos`;
          });
          break;
        case 'Configurações do Delivery atualizar com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          break;
        case 'Motoboy cadastrado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/motoboys`;
          });
          break;
        case 'Categoria cadastrada com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/categorias`;
          });
          break;
        case 'Cliente cadastrado com sucesso':
          $('.successSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/pedido/novo`;
          });
          break;
        case 'Code OK':
          $('.successSup').show();
          $('#alertaIfood').modal("hide");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/ifood`;
          });
          break;
        case 'Não foi possível atualizar Code':
          $('.errorSup').show();
          $('#alertaIfood').modal("hide");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {
            window.location = `/${link_site}/admin/ifood`;
          });
          break;
        case 'Carrinho Interno iniciado':
          window.location = `/${link_site}/admin/pedido/novo/produtos`;
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


$("#formMk").submit(function () {
  var formData = new FormData(this);
  $.ajax({
    url: $('#formMk').attr('action'),
    type: 'POST',
    data: formData,
    beforeSend: function () {
      $(".acaoBtn").prop("disabled", true);
      $('.acaoBtn, .acaoBtnLogin').html('<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>');
    },
    complete: function () {
      $(".acaoBtn").prop("disabled", false);
      $('.acaoBtnCadastro').html('Cadastrar');
      $('.acaoBtnAtualizar').html('Atualizar');
      $('.acaoBtnLogin').html('Login');
    },
    success: function (data) {
      console.log(data)
      switch (data) {
        case 'Não foi possível Cadastar os dados do iFood':
          $('.errorSup').show();
          $('#alerta').modal("show");
          $('#mensagem').html(data + '!');
          $(".buttonAlert").on('click', function () {});
          break;
        default:
          let resultado = data.substring(data.indexOf("=") + 1);
          $('#alertaIfood').modal("show");
          $('#codeLink').html(`<a href="${data}" target="_blank">Clique aqui</a>`);
          $('#codeOpen').html(resultado);
          $(".buttonAlert").on('click', function () {});
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


$("#formAtendimento").submit(function () {
  var formData = new FormData(this);
  $.ajax({
    url: $('#formAtendimento').attr('action'),
    type: 'POST',
    data: formData,
    beforeSend: function () {
      $(".acaoBtn").prop("disabled", true);
      $('.acaoBtn').html('<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>');
    },
    complete: function () {
      $(".acaoBtn").prop("disabled", false);
      $('.acaoBtnCadastro').html('Cadastrar');
      $('.acaoBtnAtualizar').html('Atualizar');
    },
    success: function (data) {
      console.log(data)
      switch (data) {
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
        case 'Cliente não contratou plano':
          $('.mensagem').html(`<div class="alert alert-danger" role="alert">Contrate um plano para iniciar o atendimento!</div>`);
          window.location = `/${link_site}/admin/planos`;
          break;
        case 'Não foi possível processar seu pagamento, atualize os dados de seu cartão!':
          $('.mensagem').html(`<div class="alert alert-danger" role="alert">${data}</div>`);
          window.location = `/${link_site}/admin/planos`;
          break;

        default:
          $('#mensagem').html(`<div class="alert alert-danger" role="alert">${data}</div>`);
          break;
      }


    },
    error: function (data) {
      $('#mensagem').html(`<div class="alert alert-danger" role="alert">Opss tivemos um problema </div>`)

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

$("#formBusca").submit(function () {
  $.get("/admin/buscar/entregas", function (dd) {
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
        type: 'get',
        data: formData,
        beforeSend: function () {
          $('.carregar').html('<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>');
        },
        complete: function (data) {
          //console.log(data)
          $('.carregar').html('');
        },
        success: function (data) {
          $('#buscaResultado').html(data);

        }
      });
    }
    $('#buscaResultado').html(dd);
    $('#mensagem').html('')
  })


  return false;
});

$('#txtbuscar').keyup(function () {
  $('#btn-buscar').click();
})
$('#cbbuscar').keyup(function () {
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
    success: function (result) {
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
    link.onload = function () {
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

function atualizar() {
  $.get(`/${link_site}/admin/pedidos/recebido`, function (dd) {
    let orderDay = localStorage.getItem("sttInit")
    let newOrder = new Audio('/audio/newOrder.mp3');

    let cancelOrder = new Audio('/audio/cancelOrder.mp3');
    if (parseInt($(dd).attr('data-status')) === 6) {
      console.log('Cancelado')
      cancelOrder.play();
    }

    if (orderDay === null) {
      //console.log('aqui')
      localStorage.setItem("sttInit", $(dd).attr('data-qtd'));
      newOrder.play();
      $('#recebido').html(dd);
    } else {
      if (parseInt($(dd).attr('data-qtd')) > parseInt(orderDay)) {
        localStorage.setItem("sttInit", $(dd).attr('data-qtd'));
        newOrder.play();
        $('#recebido').html(dd);
        //console.log('subiu mais 1')
      } else {
        $('#recebido').html(dd);
        //console.log('Não subiu pedido')
      }
    }
  })

  $.get(`/${link_site}/admin/pedidos/producao`, function (dd) {
    let cancelOrder = new Audio('/audio/cancelOrder.mp3');
    if (parseInt($(dd).attr('data-status')) === 6) {
      console.log('Cancelado')
      cancelOrder.play();
    }
    $('#producao').html(dd);
  })
  $.get(`/${link_site}/admin/pedidos/geral`, function (dd) {
    $('#geral').html(dd);
  })

  $.get(`/${link_site}/admin/pedidos/ifood`, function (dd) {
    if (parseInt($('#atendimentoOn').length) === 1) {
      if (204 === parseInt(dd)) {
        console.log('Sem novos pedidos no iFood');
      } else {
        console.log('Pedido Novo');
        //$('#geral').html(dd);
      }
    }
  })
}
setInterval(atualizar, 30000);
$(function () {
  atualizar();
});

$("#inpFiltro").on("keyup", function () {
  var value = this.value.toLowerCase().trim();
  $(".filtro li").show().filter(function () {
    return $(this).text().toLowerCase().trim().indexOf(value) == -1;
  }).hide();
});



function mudarStatus(id, status, id_caixa) {
  var id_motoboy = 0
  var id_empresa = $('#id_empresa').val();
  let valores = {id,status,id_caixa,id_empresa,id_motoboy}
  $.ajax({
    url: `/${link_site}/admin/pedido/mudar/${id}/${status}/${id_caixa}/${id_motoboy}`,
    method: "POST",
    data: valores,
    dataType: "text",
    success: function (dd) {
      console.log(dd)
      if (dd == 'Status alterado com sucesso') {
        atualizar();
        $('#close-modal').trigger('click');
      } else {}

    },
  })
}

function mudarStatusEntrega(id, status, id_caixa) {
  var id_motoboy = $(`#motoboy-${id} option:selected`).val();
  if (parseFloat(id_motoboy) === 0) {
    $('.select2-single').shake().addClass('bc-danger');

    $(`#mensagem${id}`).html(`<div class="alert alert-danger" role="alert">Selecione um Motoboy antes de mudar de Status!</div>`);
    setTimeout(function () {
      $(`#mensagem${id}`).html(``);
      //$('.select2-single').removeClass('bc-danger');
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
    console.log(valores);
    $.ajax({
      url: `/${link_site}/admin/pedido/mudar/${id}/${status}/${id_caixa}/${id_motoboy}`,
      method: "post",
      data: valores,
      dataType: "text",
      success: function (dd) {
        console.log(dd)
        if (dd == 'Status alterado com sucesso') {
          atualizar();
          $('#close-modal').trigger('click');
        } else {
          console.log(dd);
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
    beforeSend: function () {
      $(`#btnSync${id}`).removeClass('iconsminds-repeat-3');
      $(`#btnSync${id}`).html(`<?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>`);
    },
    success: function (dd) {
      $(`#btnSync${id}`).html('');
      $(`#btnSync${id}`).addClass('iconsminds-repeat-3');
      $(`#${id}pdtr`).html('<i class="simple-icon-check text-success size20"></i>');
      console.log(dd);
    },
  })
}




/* 02. Theme Selector, Layout Direction And Initializer */
(function ($) {
  if ($().dropzone) {
    Dropzone.autoDiscover = false;
  }
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

  $("body").on("click", ".theme-color", function (event) {
    event.preventDefault();
    var dataTheme = $(this).data("theme");
    if (typeof Storage !== "undefined") {
      localStorage.setItem("dore-theme", dataTheme);
      window.location.reload();
    }
  });



  $("#remove_img").on("click", function (event) {
    event.preventDefault();
    $('#Nova_capa').removeClass('hide');
    $('#IMG_toll').addClass('hide');
    $('#IMG_tollw').addClass('hide');
    $('#inputImagem').val('');
  });



  $("input[name='directionRadio']").on("change", function (event) {
    var direction = $(event.currentTarget).data("direction");
    if (typeof Storage !== "undefined") {
      localStorage.setItem("dore-direction", direction);
      window.location.reload();
    }
  });

  $("input[name='radiusRadio']").on("change", function (event) {
    var radius = $(event.currentTarget).data("radius");
    if (typeof Storage !== "undefined") {
      localStorage.setItem("dore-radius", radius);
      window.location.reload();
    }
  });

  $("#switchDark").on("change", function (event) {
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

  $(".theme-button").on("click", function (event) {
    event.preventDefault();
    $(this)
      .parents(".theme-colors")
      .toggleClass("shown");
  });

  $(document).on("click", function (event) {
    if (
      !(
        $(event.target)
        .parents()
        .hasClass("theme-colors") ||
        $(event.target)
        .parents()
        .hasClass("theme-button") ||
        $(event.target).hasClass("theme-button") ||
        $(event.target).hasClass("theme-colors")
      )
    ) {
      if ($(".theme-colors").hasClass("shown")) {
        $(".theme-colors").removeClass("shown");
      }
    }
  });

})(jQuery);


$(document).ready(function () {
  var $modal = $('#modal');
  var image = document.getElementById('sample_image');
  var cropper;

  $('#upload_image').change(function (event) {
    var files = event.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal('show');
    };

    if (files && files.length > 0) {
      var reader = new FileReader();
      reader.onload = function (event) {
        done(reader.result);
      };
      reader.readAsDataURL(files[0]);
    }
  });

  $modal.on('shown.bs.modal', function () {
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
  }).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
  });

  $('#crop').click(function () {
    var canvas = cropper.getCroppedCanvas({
      width: 400,
      height: 400
    });

    canvas.toBlob(function (blob) {
      var url = URL.createObjectURL(blob);
      var reader = new FileReader();
      reader.readAsDataURL(blob);
      reader.onloadend = function () {
        var base64data = reader.result;
        $.ajax({
          url: `/${link_site}/admin/upload`,
          method: 'POST',
          data: {
            image: base64data
          },
          success: function (data) {
            //console.log(data)
            $modal.modal('hide');
            $('#uploaded_image').attr('src', `/uploads/${data}`);
            $('#imagemNome').val(data);
          }
        });
      };
    });
  });

});


$('#cep').mask('00000-000');
$("#cep").blur(function () {
  var cep = $(this).val().replace(/\D/g, '');
  if (cep != "") {
    var validacep = /^[0-9]{8}$/;
    if (validacep.test(cep)) {
      $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
        if (!("erro" in dados)) {
          $("#rua").val(dados.logradouro);
          $("#bairro").val(dados.bairro);
          $("#cidade").val(dados.localidade);
          $(`#estado option:contains(${dados.uf})`).attr('selected', true);
          $(`#select2-estado-container`).html(dados.uf).prop('title', dados.uf);
        } else {
          alert("O CEP digitado não foi encontrado! Verifique e tente novamente");
        }
      });
    } else {
      alert("Formato de CEP esta inválido.");
    }
  }
});

$(".catProds #nome, .catProds #tipo").blur(function () {
  const str = $(this).val();
  const parsed = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/\s+/g, '-').toLowerCase();

  $('#slug, #slug').val(parsed);
});


$('#tipo_escolhaQtd').hide();
$('.show').show();
$('#tipo_escolha').on('change', function () {
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
  case `/${link_site}/admin/caixa/relatorio`:
    $('#collapseCaixaTypes').addClass('show')
    $('#menuCaixa .primaryMenu').removeClass('collapsed')
    $('#caiRel').addClass('active')
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
  case `/${link_site}/admin/produto/novo`:
    $('#collapseProdutos').addClass('show')
    $('#menuProdutos .primaryMenu').removeClass('collapsed')
    $('#subProd').addClass('active')
    break;
  case `/${link_site}/admin/produto/editar/${activeId}`:
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
  case `/${link_site}/admin/produto-adicional/novo`:
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
  case `/${link_site}/admin/usuario/novo`:
    $('#collapseMenuUsuarios').addClass('show')
    $('#menuUsuarios .primaryMenu').removeClass('collapsed')
    $('#subUn').addClass('active')
    break;
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
    $('#collapseMenuConfiguracoes').addClass('show')
    $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
    $('#subDeliTip').addClass('active')
    break;
  case `/${link_site}/admin/delivery/editar/${activeId}`:
    $('#collapseMenuConfiguracoes').addClass('show')
    $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
    $('#subDeliTip').addClass('active')
    break;
  case `/${link_site}/admin/conf/delivery/e`:
    $('#collapseMenuConfiguracoes').addClass('show')
    $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
    $('#subDeli').addClass('active')
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
    $('#collapseMenuConfiguracoes').addClass('show')
    $('#menuConfiguracoes .primaryMenu').removeClass('collapsed')
    $('#subFp').addClass('active')
    break;
  case `/${link_site}/admin/docs`:
    $('#menuDocs').addClass('active')
    break;
  default:
    $('#menuPainel').addClass('active')
}

$('.enderecoCad').hide();
$("#switchEnd").on("change", function () {
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
    success: function (dd) {
      $('#mostrarProduto').html(dd)
    },
  })
}

$("#modProdutoCarrinho").on("click", function () {
  console.log('dd aqui');
  $.get("/admin/carrinho", function (dd) {
    $('#mostrarProduto').html(dd)
  })
})


$("#abrirCarrinhoModal").on('click', function () {
  $("#modal-carrinho").modal("show");
});
$('#trocoMod, #mp, #entrega_end').hide();

$('#tipo_pagamento').on('change', function () {
  if (parseInt($(this).val()) === 1) {
    $('#trocoMod').show();
    $('.btnValida').hide();
  } else {
    $('#trocoMod').hide();
    $('#trocoCliente').hide();
    $('.btnValida').show();
  }
});

$('#calcularTroco').on('click', function () {
  let valor = parseFloat($('#trocoCli').val());
  let total_pago = parseFloat($('#total_pago').val());
  let totalFinal = valor - total_pago

  if ($('#trocoCli').val() === "") {
    alert('O seu troco precisa ser maior que o total do seu pedido')
    return false
  } else {
    $('#troco').val(valor)
    $('.btnValida').show()
    $('#trocoCliente').show();
    $('#trocoCliente span').text(formatter.format(totalFinal))
    $("html, body").animate({
      scrollTop: $(document).height()
    }, "slow");
    return false
  }
});


$('#tipo_frete').on('change', function () {
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
jQuery.fn.shake = function (interval, distance, times) {
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
$('.select2-single').select2();
$(".selectMes").select2({
  minimumResultsForSearch: -1
});
$('#cpf').mask('000.000.000-00', {
  reverse: true
});
$('#trocoCli').mask('#.##0,00', {
  reverse: true
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
        $('.btnValida').html('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path>');
      },
      complete: function () {
        $(".btnValida").prop("disabled", false);
        $('.btnValida').html('FINALIZAR PEDIDO');
      },
      success: function (data) {
        console.log(data);
        switch (data) {
          case 'Pedido Finalizado com sucesso!':
            $('.successSup').show();
            $('#alerta').modal("show");
            $('#mensagem').html(data);
            window.location = `/${link_site}/admin/pedidos`;
            break;
          default:
            $('.errorSup').show();
            $('#alerta').modal("show");
            $('#mensagem').html(data);
            break;
        }
        $(".btnValida").prop("disabled", false);
        $('.btnValida').html('FINALIZAR PEDIDO');
      },
      error: function (data) {
        $('#mensagem').html(`<div class="alert alert-danger" role="alert">Opss tivemos um problema com seu pedido</div>`)
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
  }
  return false;
});



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
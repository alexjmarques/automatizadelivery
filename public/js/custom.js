(function ($) {
  "use strict";
  $('select').select2();

  const menuItems = document.querySelectorAll('.anchor[href^="#"]');

  menuItems.forEach(item => {
    item.addEventListener('click', scrollToIdOnClick);
  })



  function getScrollTopByHref(element) {
    const id = element.getAttribute('href');
    return document.querySelector(id).offsetTop;
  }

  function scrollToIdOnClick(event) {
    event.preventDefault();
    const to = getScrollTopByHref(event.target) - 0;
    scrollToPosition(to);
  }

  function scrollToPosition(to) {
    // window.scroll({
    //   top: to,
    //   behavior: "smooth",
    // });
    smoothScrollTo(60, to);
  }

  /**
   * Smooth scroll animation
   * @param {int} endX: destination x coordinate
   * @param {int} endY: destination y coordinate
   * @param {int} duration: animation duration in ms
   */
  function smoothScrollTo(endX, endY, duration) {
    const startX = window.scrollX || window.pageXOffset;
    const startY = window.scrollY || window.pageYOffset;
    const distanceX = endX - startX;
    const distanceY = endY - startY;
    const startTime = new Date().getTime();

    duration = typeof duration !== 'undefined' ? duration : 400;

    // Easing function
    const easeInOutQuart = (time, from, distance, duration) => {
      if ((time /= duration / 2) < 1) return distance / 2 * time * time * time * time + from;
      return -distance / 2 * ((time -= 2) * time * time * time - 2) + from;
    };

    const timer = setInterval(() => {
      const time = new Date().getTime() - startTime;
      const newX = easeInOutQuart(time, startX, distanceX, duration);
      const newY = easeInOutQuart(time, startY, distanceY, duration);
      if (time >= duration) {
        clearInterval(timer);
      }
      window.scroll(newX, newY);
    }, 1000 / 60); // 60 fps
  };
  $('#telefone').mask('(00) 00000-0000');
  $('#cep, #cep_end').mask('00000-000');
  $("#rua").on('blur touchleave touchcancel', function () {
    var estado = $('#estadoPrinc').val();
    var cidade = $('#cidadePrinc').val();
    var rua = $(this).val();
    if (rua != "") {
      $.getJSON(`https://maps.google.com/maps/api/geocode/json?address=${rua},${cidade}-${estado}/&key=AIzaSyAHQnNSFjLAJUQ6Y869H9uZ0AIsqAed1Fc`, function (dados) {
        console.log(dados);
        if (dados.status === "OK") {
          $("#endOK").show();
          $('.btnValida').attr("disabled", true);
          $("#endPrint").text(dados.results[0].formatted_address);

          if (dados.results[0].address_components[0].types[0] === "street_number") {
            $("#rua").val(dados.results[0].address_components[1].long_name);
            $("#bairro").val(dados.results[0].address_components[2].long_name);
            $("#cidade").val(dados.results[0].address_components[3].long_name);
            $("#estado").val(dados.results[0].address_components[4].short_name);
            $("#cep").val(dados.results[0].address_components[6].long_name);
          } else {
            $("#rua").val(dados.results[0].address_components[0].long_name);
            $("#bairro").val(dados.results[0].address_components[1].long_name);
            $("#cidade").val(dados.results[0].address_components[2].long_name);
            $("#estado").val(dados.results[0].address_components[3].short_name);
            $("#cep").val(dados.results[0].address_components[5].long_name);
          }

          $("#numero").on('blur touchleave touchcancel', function () {
            $("#numeroPrint").text($(this).val());
          });

          $("#complemento").on('blur touchleave touchcancel', function () {
            $("#complementoPrint").text($(this).val());
            $('.btnValida').attr("disabled", false);
          });

          if (dados.results[0].geometry.location_type === "APPROXIMATE") {
            $("#alertGeralSite").modal("show");
            $(".errorSup").show();
            $("#mensagem").text("O Endereço informado é APROXIMADO, verifique se confere com sua localização antes de prosseguir!");
          }
        } else {
          $("#alertGeralSite").modal("show");
          $(".errorSup").show();
          $("#mensagem").text("O Endereço informado não foi encontrado, verifique se digitou corretamente e tente novamente!");
        }
      });

    }
  });

  $("#cep_end").on('blur touchleave touchcancel', function () {
    var cep = $(this).val().replace(/\D/g, '');
    if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $("#rua_end").val("...");
            $("#bairro_end").val("...");
            $("#cidade_end").val("...");
            $("#estado_end").val("...");
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

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

  $("#form").submit(function (e) {
    var formData = new FormData(this);
    $.ajax({
      url: $('#form').attr('action'),
      type: 'POST',
      data: formData,
      beforeSend: function () {
        $(".btn_acao a, .btn_acao button").hide();
        $('.btn_acao').html('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: transparent; display: block; shape-rendering: auto;" width="30px" height="30px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#a90e19" stroke="none"><animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform></path><br/>Aguarde processando informações! ');
      },
      complete: function () {
        $(".btn_acao a, .btn_acao button").show();
      },
      success: function (data) {
        $(".btn_acao a, .btn_acao button").show();
        console.log(data);
        if (data.id > 0) {
          switch (data.code) {
            case 9:
              $('#mensagem').html(data.mensagem);
              $('.successSup').hide();
              $('.errorSup').show();
              $('#alertGeralSite').modal("show");
              break;
            case 10:
              $('#mensagem').html(data.mensagem);
              $('.successSup').show();
              $('.errorSup').hide();
              $('#alertGeralSite').modal("show");
              if (data.url) {
                $(".buttonAlert").on('click', function () {
                  window.location = `/${data.url}`;
                });
              }
              break;
              
            case 11:
              window.location = `/${data.url}`;
              break;
              case 12:
              $('#mensagem').html(`<div class="alert alert-success" role="alert">${data.mensagem}</div>`);
              
              break;
          }
        } else {
          switch (data.code) {
            case 9:
              $('#mensagem').html(data.mensagem);
              $('.successSup').hide();
              $('.errorSup').show();
              $('#alertGeralSite').modal("show");
              break;
            case 10:
              $('#mensagem').html(data.mensagem);
              $('.successSup').show();
              $('.errorSup').hide();
              $('#alertGeralSite').modal("show");
              if (data.url) {
                $(".buttonAlert").on('click', function () {
                  window.location = `/${data.url}`;
                });
              }
              break;
            case 11:
              window.location = `/${data.url}`;
              break;
              case 12:
              $('#mensagem').html(`<div class="alert alert-danger" role="alert">${data.mensagem}</div>`);
              break;
          }
          
        }
      },
      error: function (data) {
        $('#mensagem').html(`<div class="alert alert-danger" role="alert">Opss tivemos um problema</div>`)
      },
      cache: false,
      processData: false,
      contentType: false,
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

  $("#nome_fantasia").blur(function () {
    const str = $(this).val();
    const parsed = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/\s+/g, '-').toLowerCase();

    $('#link_site').val(parsed);
  });

  // ===========My Account Tabs============
  $(window).on('hashchange', function () {
    var url = document.location.toString();
    if (url.match('#')) {
      //$('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
      $('a[href="' + window.location.hash + '"]').trigger('click');
    }
    $('.nav-tabs a').on('shown', function (e) {
      window.location.hash = e.target.hash;
    })
  });
  var url = document.location.toString();
  if (url.match('#')) {
    //$('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
    $('a[href="' + window.location.hash + '"]').trigger('click');
  }
  // Change hash for page-reload
  $('.nav-tabs a').on('shown', function (e) {
    window.location.hash = e.target.hash;
  })

  // Category Owl Carousel
  const objowlcarousel = $('.owl-carousel-category');
  if (objowlcarousel.length > 0) {
    objowlcarousel.owlCarousel({
      responsive: {
        0: {
          items: 3,
        },
        600: {
          items: 4,
        },
        1000: {
          items: 6,
        },
        1200: {
          items: 8,
        },
      },
      loop: true,
      lazyLoad: true,
      autoplay: true,
      dots: false,
      autoplaySpeed: 1000,
      autoplayTimeout: 2000,
      autoplayHoverPause: true,
      nav: true,
      navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
    });
  }




  // Homepage Owl Carousel  
  var fiveobjowlcarousel = $(".owl-carousel-four");
  if (fiveobjowlcarousel.length > 0) {
    fiveobjowlcarousel.owlCarousel({
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 4,
        },
        1200: {
          items: 4,
        },
      },

      lazyLoad: true,
      pagination: false,
      loop: true,
      dots: false,
      autoPlay: 2000,
      nav: true,
      stopOnHover: true,
      navText: ["<i class='icofont-thin-left'></i>", "<i class='icofont-thin-right'></i>"]
    });
  }

  // Owl Carousel Five
  var fiveobjowlcarousel = $(".owl-carousel-five");
  if (fiveobjowlcarousel.length > 0) {
    fiveobjowlcarousel.owlCarousel({
      responsive: {
        0: {
          items: 2,
        },
        600: {
          items: 3,
        },
        1000: {
          items: 4,
        },
        1200: {
          items: 5,
        },
      },
      lazyLoad: true,
      pagination: false,
      loop: true,
      dots: false,
      autoPlay: 2000,
      nav: true,
      stopOnHover: true,
      navText: ["<i class='icofont-thin-left'></i>", "<i class='icofont-thin-right'></i>"]
    });
  }

  // Homepage Ad Owl Carousel
  const mainslider = $('.homepage-ad');
  if (mainslider.length > 0) {
    mainslider.owlCarousel({
      responsive: {
        0: {
          items: 2,
        },
        764: {
          items: 2,
        },
        765: {
          items: 1,
        },
        1200: {
          items: 1,
        },
      },
      lazyLoad: true,
      loop: true,
      autoplay: true,
      autoplaySpeed: 1000,
      dots: false,
      autoplayTimeout: 2000,
      nav: true,
      navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      autoplayHoverPause: true,
    });
  }

  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();

})(jQuery); // End of use strict
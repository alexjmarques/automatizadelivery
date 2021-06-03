<!DOCTYPE html>
<html lang="pt-BR">
  
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Automatiza App - Alex Marques">
  <link rel="apple-touch-icon" sizes="57x57" href="{{BASE}}icone/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="{{BASE}}icone/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="{{BASE}}icone/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="{{BASE}}icone/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="{{BASE}}icone/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="{{BASE}}icone/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="{{BASE}}icone/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="{{BASE}}icone/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="{{BASE}}icone/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="{{BASE}}icone/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="{{BASE}}icone/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="{{BASE}}icone/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="{{BASE}}icone/favicon-16x16.png">
  <link rel="manifest" href="{{BASE}}icone/manifest.json">
  <meta name="msapplication-TileColor" content="#fff">
  <meta name="msapplication-TileImage" content="{{BASE}}icone/ms-icon-144x144.png">
  <meta name="theme-color" content="#741224">
  <title>{% block title %}{% endblock %}</title>
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-H85LB3TTM9"></script>

{% if detect.isMobile() %}
<link href="{{BASE}}css/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="{{BASE}}css/slick.min.css" rel="stylesheet" type="text/css" />
    <link href="{{BASE}}css/slick-theme.min.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300;1,300&display=swap" rel="stylesheet" />
    <link href="{{BASE}}css/star-rating-svg.css" rel="stylesheet" type="text/css" />
    <link href="{{BASE}}css/slick.min.css" rel="stylesheet" type="text/css" />
    <link href="{{BASE}}css/slick-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="{{BASE}}css/feather.css" rel="stylesheet" type="text/css">
    <link href="{{BASE}}css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="{{BASE}}css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{BASE}}css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="{{BASE}}css/style.css" rel="stylesheet" type="text/css">
    <link href="{{BASE}}css/automatiza.css" rel="stylesheet" type="text/css">
  {% else %}
  <!-- Bootstrap core CSS-->
  <link href="{{BASE}}css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome-->
      <link href="{{BASE}}css/vendor/fontawesome/css/all.min.css" rel="stylesheet">
      <!-- Font Awesome-->
      <link href="{{BASE}}css/vendor/icofont/icofont.min.css" rel="stylesheet">
      <!-- Select2 CSS-->
      <link href="{{BASE}}css/vendor/select2/css/select2.min.css" rel="stylesheet">
      <!-- Custom styles for this template-->
      <link href="{{BASE}}css/osahan.css" rel="stylesheet">
  {% endif %}

  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-P14WHHWPWF');
  </script>
  {# {% if detect.isMobile() %} #}
  <style>
    #overlayer {
      width: 100%;
      height: 100%;
      position: absolute;
      z-index: 9999
    }

    .lds-roller {
      display: inline-block;
      position: absolute;
      top: 50%;
      left: 50%;
      margin-left: -40px;
      margin-top: -40px;
      z-index: 9999;
      width: 40px;
      height: 40px
    }

    .lds-roller div {
      animation: lds-roller 1.2s cubic-bezier(.5, 0, .5, 1) infinite;
      transform-origin: 40px 40px
    }

    .lds-roller div:after {
      content: " ";
      display: block;
      position: absolute;
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: #fff;
      margin: -4px 0 0 -4px
    }

    .lds-roller div:nth-child(1) {
      animation-delay: -36ms
    }

    .lds-roller div:nth-child(1):after {
      top: 63px;
      left: 63px
    }

    .lds-roller div:nth-child(2) {
      animation-delay: -72ms
    }

    .lds-roller div:nth-child(2):after {
      top: 68px;
      left: 56px
    }

    .lds-roller div:nth-child(3) {
      animation-delay: -108ms
    }

    .lds-roller div:nth-child(3):after {
      top: 71px;
      left: 48px
    }

    .lds-roller div:nth-child(4) {
      animation-delay: -144ms
    }

    .lds-roller div:nth-child(4):after {
      top: 72px;
      left: 40px
    }

    .lds-roller div:nth-child(5) {
      animation-delay: -.18s
    }

    .lds-roller div:nth-child(5):after {
      top: 71px;
      left: 32px
    }

    .lds-roller div:nth-child(6) {
      animation-delay: -216ms
    }

    .lds-roller div:nth-child(6):after {
      top: 68px;
      left: 24px
    }

    .lds-roller div:nth-child(7) {
      animation-delay: -252ms
    }

    .lds-roller div:nth-child(7):after {
      top: 63px;
      left: 17px
    }

    .lds-roller div:nth-child(8) {
      animation-delay: -288ms
    }

    .lds-roller div:nth-child(8):after {
      top: 56px;
      left: 12px
    }

    @keyframes lds-roller {
      0% {
        transform: rotate(0)
      }

      100% {
        transform: rotate(360deg)
      }
    }
  </style>
  {# {% endif %} #}



</head>
{% if detect.isMobile() %}
<body class="fixed-bottom-bar" data-link_site="{{empresa.link_site}}">
  <div id="overlayer"></div>
  <div class="lds-roller">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>
{% else %}
  <body id="page-top" data-link_site="{{empresa.link_site}}">
  <div class="homepage-header">
      <div class="overlay"></div>
    {% endif %}
    {% block body %}{% endblock %}
{% if detect.isMobile() %}
    <script src="{{BASE}}js/jquery.min.js" type="text/javascript"></script>
    <script src="{{BASE}}js/jquery-ui.js"></script>
    <script src="{{BASE}}js/jquery.complexify.js"></script>
    <script src="{{BASE}}js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="{{BASE}}js/slick.min.js" type="text/javascript"></script>
    <script src="{{BASE}}js/jquery.star-rating-svg.js"></script>
    <script src="{{BASE}}js/osahan.js" type="text/javascript"></script>
    <script src="{{BASE}}js/rocket-loader.min.js" defer=""></script>
    <script src="{{BASE}}js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="{{BASE}}js/jquery.select2.js" type="text/javascript"></script>
    <script src="{{BASE}}js/function.js" type="text/javascript"></script>
 {% else %}
   
    <!-- jQuery -->
    <script src="{{BASE}}js/vendor/jquery/jquery-3.3.1.slim.min.js"></script>
      <!-- Bootstrap core JavaScript-->
      <script src="{{BASE}}js/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Select2 JavaScript-->
      <script src="{{BASE}}js/vendor/select2/js/select2.min.js"></script>
      <!-- Owl Carousel -->
      <script src="{{BASE}}js/vendor/owl-carousel/owl.carousel.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="{{BASE}}js/custom.js"></script>
    {% endif %}
  </body>

</html>
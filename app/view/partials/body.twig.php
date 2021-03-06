<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=0"/>
  <meta name="facebook-domain-verification" content="j35dpuvh7qnbwv0yx6zsedo37ufgq8" />
  <meta name="author" content="Automatiza App - Alex Marques">
  <link rel="apple-touch-icon" href="{{BASE}}uploads/{{empresa.logo}}">
  <link rel="icon" type="image/png" href="{{BASE}}uploads/{{empresa.logo}}">
  <link rel="manifest" href="{{BASE}}manifest/{{empresa.link_site}}-manifest.json">
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
    <link href="{{BASE}}css/bootstrap.min.css" rel="stylesheet">
    <link href="{{BASE}}css/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="{{BASE}}css/icofont/icofont.min.css" rel="stylesheet">
    <link href="{{BASE}}css/select2.min.css" rel="stylesheet">
    <link href="{{BASE}}css/osahan.css" rel="stylesheet">
  {% endif %}
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-201209024-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-201209024-1');
</script>
 {% if detect.isMobile() %}
  <style>
    .pac-item {
    padding: 9px 4px !important;
    background: #f5f5f5  !important;
    border-bottom: 1px solid #000  !important;
}
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
{% endif %}
</head>
{% if detect.isMobile() %}
<body class="fixed-bottom-bar" data-link_site="{{empresa.link_site}}" data-estado_site="{{endEmp.estado}}">
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
<body id="page-top" data-link_site="{{empresa.link_site}}" data-estado_site="{{endEmp.estado}}">
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
  <script src="{{BASE}}index.js"></script>
  <script src="{{BASE}}js/function.js?v=2" type="text/javascript"></script>
{% else %}
  <script src="{{BASE}}js/jquery.min.js" type="text/javascript"></script>
  <script src="{{BASE}}js/jquery-ui.js" type="text/javascript"></script>
  <script src="{{BASE}}js/jquery.mask.min.js" type="text/javascript"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="{{BASE}}js/bootstrap.bundle.min.js"></script>
  <script src="{{BASE}}js/jquery.mask.min.js" type="text/javascript"></script>
  <script src="{{BASE}}js/jquery.select2.js" type="text/javascript"></script>
  <script src="{{BASE}}js/owl-carousel/owl.carousel.js"></script>
  <script src="{{BASE}}js/custom.js"></script>
{% endif %}
</body>
</html>
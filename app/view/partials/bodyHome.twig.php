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


  <link href="{{BASE}}css/bootstrap.min.css" rel="stylesheet">
  <link href="{{BASE}}css/fontawesome/css/all.min.css" rel="stylesheet">
  <link href="{{BASE}}css/icofont/icofont.min.css" rel="stylesheet">
  <link href="{{BASE}}css/select2.min.css" rel="stylesheet">
  <link href="{{BASE}}css/osahan.css" rel="stylesheet">

  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-P14WHHWPWF');
  </script>
</head>

<body id="page-top" data-link_site="{{empresa.link_site}}">
  {% block body %}{% endblock %}
  <script src="{{BASE}}js/jquery.min.js" type="text/javascript"></script>
  <script src="{{BASE}}js/jquery-ui.js" type="text/javascript"></script>
  <script src="{{BASE}}js/jquery.mask.min.js" type="text/javascript"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="{{BASE}}js/bootstrap.bundle.min.js"></script>
  <script src="{{BASE}}js/jquery.mask.min.js" type="text/javascript"></script>
  <script src="{{BASE}}js/jquery.select2.js" type="text/javascript"></script>
  <script src="{{BASE}}js/owl-carousel/owl.carousel.js"></script>
  <script src="{{BASE}}js/custom.js"></script>
</body>

</html>
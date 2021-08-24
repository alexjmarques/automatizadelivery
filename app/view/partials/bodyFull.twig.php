<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=0"/>
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
<link rel="icon" type="image/png" sizes="192x192"  href="{{BASE}}icone/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{BASE}}icone/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{{BASE}}icone/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{BASE}}icone/favicon-16x16.png">
<link rel="manifest" href="{{BASE}}icone/manifest.json">
<meta name="msapplication-TileColor" content="#fff">
<meta name="msapplication-TileImage" content="{{BASE}}icone/ms-icon-144x144.png">
<meta name="theme-color" content="#741224">
<title>{% block title %}{% endblock %}</title>
<link href="{{BASE}}css/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="{{BASE}}css/slick.min.css" rel="stylesheet" type="text/css" />
<link href="{{BASE}}css/slick-theme.min.css" rel="stylesheet" type="text/css" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
<link href="{{BASE}}css/slick.min.css" rel="stylesheet" type="text/css"/>
<link href="{{BASE}}css/slick-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="{{BASE}}css/feather.css" rel="stylesheet" type="text/css">
<link href="{{BASE}}css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="{{BASE}}css/bootstrap.min.css" rel="stylesheet" type="text/css" >
<link href="{{BASE}}css/select2.min.css" rel="stylesheet" type="text/css" >
<link href="{{BASE}}css/style.css" rel="stylesheet" type="text/css" >
<link href="{{BASE}}css/automatiza.css" rel="stylesheet" type="text/css" >
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H85LB3TTM9"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-201209024-1">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-201209024-1');
</script>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '169843661727356'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=169843661727356&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
</head>
<body data-link_site="{{empresa.link_site}}" data-estado_site="{{endEmp.estado}}">
{% block body %}{% endblock %}
<script src="{{BASE}}js/jquery.min.js" type="text/javascript"></script>
<script src="{{BASE}}js/jquery-ui.js"></script>
<script src="{{BASE}}js/jquery.complexify.js"></script>
<script src="{{BASE}}js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="{{BASE}}js/slick.min.js" type="text/javascript"></script>
<!-- <script src="{{BASE}}js/hc-offcanvas-nav.js" type="text/javascript" ></script> -->
<script src="{{BASE}}js/osahan.js" type="text/javascript"></script>
<script src="{{BASE}}js/jquery.mask.min.js" type="text/javascript"></script>
<script src="{{BASE}}js/jquery.select2.js" type="text/javascript"></script>
<script src="{{BASE}}js/function.js" type="text/javascript"></script>
</body>
</html>
	
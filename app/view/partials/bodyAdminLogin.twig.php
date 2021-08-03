<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{% block title %}{% endblock %}</title>
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
    <link rel="stylesheet" href="{{BASE}}adm/font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="{{BASE}}adm/font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="{{BASE}}adm/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="{{BASE}}adm/css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="{{BASE}}adm/css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="{{BASE}}adm/css/main.css" />
</head>

<body class="background show-spinner no-footer" data-link_site="{{empresa.link_site}}">
<div class="fixed-background"></div>
    <main>
        {% block body %}{% endblock %}
    </main>
    <script src="{{BASE}}adm/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/jquery.dataTables.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/Chart.bundle.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/chartjs-plugin-datalabels.js"></script>
    <script src="{{BASE}}adm/js/vendor/moment.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/fullcalendar.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/datatables.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/glide.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/progressbar.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/jquery.barrating.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/select2.full.js"></script>
    <script src="{{BASE}}adm/js/vendor/nouislider.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/bootstrap-datepicker.js"></script>
    <script src="{{BASE}}adm/js/vendor/Sortable.js"></script>
    <script src="{{BASE}}adm/js/vendor/mousetrap.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/jquery.contextMenu.min.js"></script>
    <script src="{{BASE}}adm/js/dore.script.js"></script>
    <script src="{{BASE}}js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="{{BASE}}adm/js/vendor/bootstrap-notify.min.js"></script>
    <script src="{{BASE}}adm/js/vendor/typeahead.bundle.js"></script>
    <script src="{{BASE}}adm/js/dore-plugins/select.from.library.js"></script>
    <script src="{{BASE}}adm/js/jquery.timepicker.min.js"></script>
	<script src="https://unpkg.com/dropzone"></script>
	<script src="https://unpkg.com/cropperjs"></script>
    <script src="{{BASE}}adm/js/scripts.js"></script>
</body>

</html>
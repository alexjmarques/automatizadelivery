<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
session_start();
define('BASE', '/');

define('UNSET_URI_COUNT', 0);
define('DEBUG_URI', true);

$online = true;
if($online){
    $client = 'temakicampolimpo';
    define('UPLOADS_BASE', '/var/www/automatizadelivery.com.br/public_html/public/uploads/');
    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => "159.65.220.187",
        "port" => "9889",
        "dbname" => "automatiza_delivery",
        "username" => "root",
        "passwd" => "02W@9889forev",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);

}else{
    define('UPLOADS_BASE', '/Users/alexmarques/Localhost/automatiza/public/uploads/');
    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "8889",
        "dbname" => "automatiza_app",
        "username" => "root",
        "passwd" => "iNew98-89",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
}


define('IFOOD', [
    "URL" => "https://merchant-api.ifood.com.br",
    "VERSION" => "v1.0",
    "LANG" => "pt-br",
    "CLIENT_ID" => "1681c9a8-6c64-4868-891d-8ce7a0877d29",
    "CLIENT_SECRET" => "13uze1cwav3ca1no8o68h1ewzwsoao4x528i3lxc7pjpk3mtfi39333huw861nl9yifv6ykqkeuqpuzywva6im3766gg0r57n91d"
]);

$live = true;
if($live){
    define('pagarme_api_key', 'ak_live_kYgEGMeWd702Qx1xsXXBip43F5MANs');
}else{
    define('pagarme_api_key', 'ak_test_grvCpbW9zYWe8R8d0ByEimTzcmaOCC');
}
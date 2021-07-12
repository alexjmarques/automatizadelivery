<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
session_start();
define('BASE', '/');

define('UNSET_URI_COUNT', 0);
define('DEBUG_URI', true);

$live = false;
if($live){
    define('UPLOADS_BASE', '/var/www/automatizadelivery.com.br/public_html/public/uploads');
    define("DATA_LAYER_CONFIG", [
        "driver" => "pgsql",
        "host" => "localhost",
        "port" => "5432",
        "dbname" => "automatiza_delivery",
        "username" => "postgres",
        "passwd" => "02W@9889forev",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
    define("TWILIO",['account_sid' => 'AC3891f3248b6bd5bd3f299c1a89886814','auth_token' => '3ce669b5e06e3a12578e1824dc75f132', 'number' => '+19096555675']);
    define('pagarme_api_key', 'ak_live_kYgEGMeWd702Qx1xsXXBip43F5MANs');

}else{
    define('UPLOADS_BASE', '/Volumes/Localhost/automatizadelivery/public/uploads');
    define("DATA_LAYER_CONFIG", [
        "driver" => "pgsql",
        "host" => "localhost",
        "port" => "5432",
        "dbname" => "automatiza_homologacao",
        "username" => "postgres",
        "passwd" => "",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
    define('pagarme_api_key', 'ak_test_grvCpbW9zYWe8R8d0ByEimTzcmaOCC');
    define("TWILIO",['account_sid' => 'AC3891f3248b6bd5bd3f299c1a89886814','auth_token' => '3ce669b5e06e3a12578e1824dc75f132', 'number' => '+19096555675']);
}


define('IFOOD', [
    "URL" => "https://merchant-api.ifood.com.br",
    "VERSION" => "v1.0",
    "LANG" => "pt-br",
    "CLIENT_ID" => "64f0da36-3e2d-4812-a471-0deb9e67556e",
    "CLIENT_SECRET" => "gd77w5vyrnwzg4fk8sf64l1zbrfve4cu9nn9k6z0i3666yd2fuo4k4f50tpy7i9xebj2ok9iyabhc82bxr920ofjqtpm6v54zhy"
]);
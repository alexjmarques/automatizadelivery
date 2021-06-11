<?php

require_once('../vendor/autoload.php');
require_once('../vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php');
require_once('../app/functions/functions.php');
require_once('../app/config/config.php');
require_once('../app/config/Router.php');

use CoffeeCode\DataLayer\Connect;

$conn = Connect::getInstance();
$error = Connect::getError();

if($error){
    dd($error->getMessage());
}
$detect = new Mobile_Detect;

$session_factory = new \Aura\Session\SessionFactory;
$session = $session_factory->newInstance($_COOKIE);

$segment = $session->getSegment('Vendor\Aura\Segment');
$csrf_value = $session->getCsrfToken()->getValue();


$session->setCookieParams(array('path' => BASE .'cache/session'));

$session->setCookieParams(array('secure' => $csrf_value));

$SessionIdUsuario = $segment->get('id_usuario');
$SessionUsuarioEmail = $segment->get('usuario');
$SessionNivel = $segment->get('nivel');


$router->dispatch();




// if ($router->error()) {
//     $router->redirect("/{$router->error()}");
// }
?>

<?php
function dd($params = [], $die = true)
{
    echo '<pre>';
    print_r($params);
    echo '</pre>';

    if ($die) die();
}

/**
 * Redireciona o usuario para a URL informada e finaliza a operação
 * 
 * @param string $url URL a ser redirecionada
 * @return void
 */
function redirect(string $url){
    header('Location: ' . $url);
    exit;
}


function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
{
    // Start session
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_cache_expire(4320000);
        session_start();
    }

    $user = $this->twig->getEnvironment()->getGlobals()['user'];

    // Set global twig variables
    $user->id= $_SESSION['id'] ?? null;
       
    return $handler->handle($request);
}

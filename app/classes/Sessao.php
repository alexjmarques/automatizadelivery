<?php

namespace app\classes;

use Aura\Session\SessionFactory;


class Sessao
{
    private $sessao;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->sessao = new SessionFactory();
    }

    public function getUser()
    {
        $session = $this->sessao->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        return $segment->get('id_usuario');
    }

    public function getNivel()
    {
        $session = $this->sessao->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        return $segment->get('nivel');
    }

    public function getEmail()
    {
        $session = $this->sessao->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        return $segment->get('usuario');
    }

    public function add(int $id, string $email, int $nivel)
    {
        $session = $this->sessao->newInstance($_COOKIE);
        $session->setCookieParams(array('lifetime' => '2592000'));
        $session->setCookieParams(array('path' => BASE . 'cache/session'));
        $session->setCookieParams(array('domain' => 'automatizadelivery.com.br'));

        $_SESSION = array(
            'Vendor\Aura\Segment' => array(
                'id_usuario' => $id,
                'usuario' => $email,
                'nivel' => $nivel,
            ),
        );
    }
}

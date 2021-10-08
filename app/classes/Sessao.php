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

        return $_SESSION = array(
            'Vendor\Aura\Segment' => array(
                'id_usuario' => $id,
                'usuario' => $email,
                'nivel' => $nivel,
            ),
        );
    }

    public function getSessao(string $field)
    {
        $session = $this->sessao->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        return $segment->get($field);
    }

    public function sessaoNew(string $field,string $valor)
    {
        $session = $this->sessao->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        return $segment->set($field, $valor);
        exit;
    }

    public function sair(string $empresa)
    {
        $session = $this->sessao->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        switch ($segment->get('nivel')) {
            case 0:
                $session->destroy();
                redirect(BASE . "{$empresa}/admin/login");
                break;
            case 1:
                $session->destroy();
                redirect(BASE . "{$empresa}/motoboy/login");
                break;
            case 2:
                $session->destroy();
                redirect(BASE . "{$empresa}/admin/login");
                break;
            case 3:
                $session->destroy();
                redirect(BASE . "{$empresa}/login");
                break;
            default :
                $session->destroy();
                redirect(BASE);
                break;
        }
        
    }
}

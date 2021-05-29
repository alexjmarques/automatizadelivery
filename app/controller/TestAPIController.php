<?php

namespace app\controller;

use app\core\Controller;
use app\classes\ClickEntregas;
use app\api\iFood\Authetication;
use app\classes\Preferencias;

class TestAPIController extends Controller
{
    private $clickEntrega;

    /**
     * 
     * Metodo Construtor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->preferencias = new Preferencias();
        $this->clickEntrega = new ClickEntregas();
    }

    public function index($data)
    {
        //dd('Teste');
        //d($this->clickEntrega->conecao());
        dd($this->clickEntrega->calculateOrder('Av. Paulista, 1439 - 12 - Bela Vista, São Paulo - SP, 01310-100'));
        
    }

    
}

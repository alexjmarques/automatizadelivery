<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class Assinatura
 * @package app\Models
 */
class Imprimir extends DataLayer
{
    public function __construct()
    {
        parent::__construct("aux_print", []);
    }

    public function add(Empresa $empresa, string $nome, string $code)
    {
        $this->id_empresa = $empresa->id;
        $this->nome = $nome;
        $this->code = $code;

        $this->save();
        return $this;
    }

}
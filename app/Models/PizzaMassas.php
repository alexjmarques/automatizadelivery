<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class Tamanhos
 * @package app\Models
 */
class PizzaMassas extends DataLayer
{
    public function __construct()
    {
        parent::__construct("pizza_massas", []);
    }

    public function add(Empresa $empresa, string $nome, int $valor)
    {
        $this->id_empresa = $empresa->id;
        $this->nome = $nome;
        $this->valor = $valor;

        $this->save();
        return $this;
    }
}
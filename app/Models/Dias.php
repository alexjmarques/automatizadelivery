<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class IfoodPedidos
 * @package app\Models
 */
class Dias extends DataLayer
{
    public function __construct()
    {
        parent::__construct("auxDias", ["nome"]);
    }

    public function add($nome)
    {
        $this->nome = $nome;

        $this->save();
        return $this;
    }
}
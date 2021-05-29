<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class IfoodPedidos
 * @package app\Models
 */
class Moeda extends DataLayer
{
    public function __construct()
    {
        parent::__construct("auxMoeda", []);
    }

    public function add($nome, $simbolo)
    {
        $this->nome = $nome;
        $this->simbolo = $simbolo;

        $this->save();
        return $this;
    }
}
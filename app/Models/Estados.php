<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class IfoodPedidos
 * @package app\Models
 */
class Estados extends DataLayer
{
    public function __construct()
    {
        parent::__construct("auxEstados", []);
    }

    public function add($nome, $uf)
    {
        $this->nome = $nome;
        $this->uf = $uf;

        $this->save();
        return $this;
    }
}
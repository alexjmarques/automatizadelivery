<?php

namespace app\Models;

use app\Models\CategoriaSeguimento;
use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package app\Models
 */
class CategoriaSeguimentoSub extends DataLayer
{
    public function __construct()
    {
        parent::__construct("auxCategoriaSub", ["nome"]);
    }

    public function add(CategoriaSeguimento $categoria, string $nome, string $slug)
    {
        $this->id_categoria = $categoria->id;
        $this->nome = $nome;
        $this->slug = $slug;

        $this->save();
        return $this;
    }
}
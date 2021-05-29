<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package app\Models
 */
class CategoriaSeguimento extends DataLayer
{
    public function __construct()
    {
        parent::__construct("auxCategoria", ["nome"]);
    }

    public function add(string $nome, string $slug)
    {
        $this->nome = $nome;
        $this->slug = $slug;

        $this->save();
        return $this;
    }
}
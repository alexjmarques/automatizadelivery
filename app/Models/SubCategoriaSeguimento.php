<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\CategoriaSeguimento;
/**
 * Class User
 * @package app\Models
 */
class SubCategoriaSeguimento extends DataLayer
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
<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class Categorias
 * @package app\Models
 */
class Categorias extends DataLayer
{
    public function __construct()
    {
        parent::__construct("categorias", ["nome"]);
    }

    public function add(Empresa $empresa, string $nome, string $descricao, string $slug, string $produtos, string $posicao)
    {
        $this->id_empresa = $empresa->id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->slug = $slug;
        $this->produtos = $produtos;
        $this->posicao = $posicao;

        $this->save();
        return $this;
    }
}
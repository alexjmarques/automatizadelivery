<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package app\Models
 */
class Planos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("apd_planos", ["nome"]);
    }

    public function add(string $nome, string $slug, string $descricao, int $limite, string $valor, int $plano_id)
    {
        $this->nome = $nome;
        $this->slug = $slug;
        $this->descricao = $descricao;
        $this->limite = $limite;
        $this->valor = $valor;
        $this->plano_id = $plano_id;

        $this->save();
        return $this;
    }
}
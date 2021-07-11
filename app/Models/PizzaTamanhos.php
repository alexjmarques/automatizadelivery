<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class Tamanhos
 * @package app\Models
 */
class PizzaTamanhos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("pizza_tamanhos", []);
    }

    public function add(Empresa $empresa, string $nome, int $qtd_sabores, int $qtd_pedacos)
    {
        $this->id_empresa = $empresa->id;
        $this->nome = $nome;
        $this->qtd_sabores = $qtd_sabores;
        $this->qtd_pedacos = $qtd_pedacos;

        $this->save();
        return $this;
    }
}
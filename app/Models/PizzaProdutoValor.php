<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Tamanhos;
use app\Models\Produtos;

/**
 * Class Tamanhos
 * @package app\Models
 */
class PizzaProdutoValor extends DataLayer
{
    public function __construct()
    {
        parent::__construct("pizza_produtos_valor", []);
    }

    public function add(Empresa $empresa, PizzaTamanhos $tamanho, Produtos $produto, string $valor)
    {
        $this->id_empresa = $empresa->id;
        $this->id_tamanho = $tamanho->id;
        $this->id_produto = $produto->id;
        $this->valor = $valor;

        $this->save();
        return $this;
    }
}
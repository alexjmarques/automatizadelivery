<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
/**
 * Class Avaliacao
 * @package app\Models
 */
class ProdutoSabor extends DataLayer
{
    public function __construct()
    {
        parent::__construct("produto_sabor", ["nome","id_empresa"]);
    }

    public function add(Empresa $empresa, $nome)
    {
        $this->id_empresa = $empresa->id;
        $this->nome = $nome;

        $this->save();
        return $this;
    }
}
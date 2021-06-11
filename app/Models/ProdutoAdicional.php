<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
/**
 * Class ProdutoAdicional
 * @package app\Models
 */
class ProdutoAdicional extends DataLayer
{
    public function __construct()
    {
        parent::__construct("produto_adicional", ["nome","id_empresa"]);
    }

    public function add(Empresa $empresa, $nome, $valor, $tipo_adicional)
    {
        $this->id_empresa = $empresa->id;
        $this->nome = $nome;
        $this->valor = $valor;
        $this->tipo_adicional = $tipo_adicional;

        $this->save();
        return $this;
    }
}
<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\PizzaTamanhos;
use app\Models\Categorias;

/**
 * Class Tamanhos
 * @package app\Models
 */
class PizzaTamanhosCategoria extends DataLayer
{
    public function __construct()
    {
        parent::__construct("pizza_tamanhos_categoria", []);
    }

    public function add(Empresa $empresa, PizzaTamanhos $tamanho, Categorias $categoria)
    {
        $this->id_empresa = $empresa->id;
        $this->id_categoria = $categoria->id;
        $this->id_tamanhos = $tamanho->id;

        $this->save();
        return $this;
    }
}
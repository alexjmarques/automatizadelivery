<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\PizzaMassas;
use app\Models\PizzaTamanhos;

/**
 * Class Tamanhos
 * @package app\Models
 */
class pizzaMassasTamanhos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("pizza_massas_tamanhos", []);
    }

    public function add(Empresa $empresa, PizzaMassas $massas, PizzaTamanhos $tamanhos)
    {
        $this->id_empresa = $empresa->id;
        $this->id_tamanhos = $tamanhos->id;
        $this->id_massas = $massas->id;

        $this->save();
        return $this;
    }
}
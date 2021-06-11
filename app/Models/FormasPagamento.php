<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
/**
 * Class FormasPagamento
 * @package app\Models
 */
class FormasPagamento extends DataLayer
{
    public function __construct()
    {
        parent::__construct("aux_pagamento", []);
    }

    public function add(Empresa $empresa, $tipo, $status)
    {
        $this->id_empresa = $empresa->id;
        $this->tipo = $tipo;
        $this->status = $status;

        $this->save();
        return $this;
    }
}
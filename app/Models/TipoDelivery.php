<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class Assinatura
 * @package app\Models
 */
class TipoDelivery extends DataLayer
{
    public function __construct()
    {
        parent::__construct("auxTipo", []);
    }

    public function add(Empresa $empresa, string $tipo, string $cod, string $status)
    {
        $this->id_empresa = $empresa->id;
        $this->tipo = $tipo;
        $this->cod = $cod;
        $this->status = $status;

        $this->save();
        return $this;
    }

}
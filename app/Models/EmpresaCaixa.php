<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
/**
 * Class User
 * @package app\Models
 */
class EmpresaCaixa extends DataLayer
{
    public function __construct()
    {
        parent::__construct("empCaixa", ["data_inicio", "hora_inicio"]);
    }

    public function add(Empresa $empresa, string $data_inicio, string $hora_inicio, string $hora_final, string $data_final)
    {
        $this->id_empresa = $empresa->id;
        $this->data_inicio = $data_inicio;
        $this->hora_inicio = $hora_inicio;
        $this->hora_final = $hora_final;
        $this->data_final = $data_final;

        $this->save();
        return $this;
    }
}
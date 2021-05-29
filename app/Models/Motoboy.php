<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Usuario;
/**
 * Class Motoboy
 * @package app\Models
 */
class Motoboy extends DataLayer
{
    public function __construct()
    {
        parent::__construct("motoboy", ["id_empresa","id_usuario"]);
    }

    public function add(Empresa $empresa, Usuarios $usuario, $diaria, $taxa, $placa)
    {
        $this->id_empresa = $empresa->id;
        $this->id_usuario = $usuario->id;
        $this->diaria = $diaria;
        $this->taxa = $taxa;
        $this->placa = $placa;

        $this->save();
        return $this;
    }
}
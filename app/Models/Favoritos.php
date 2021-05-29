<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Produtos;
use app\Models\Usuario;
/**
 * Class IfoodPedidos
 * @package app\Models
 */
class Favoritos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("favoritos", ["id_usuario","id_produto","id_empresa"]);
    }

    public function add(Empresa $empresa, Usuarios $usuario, Produtos $produto)
    {
        $this->id_empresa = $empresa->id;
        $this->id_usuario = $usuario->id;
        $this->id_produto = $produto->id;

        $this->save();
        return $this;
    }
}
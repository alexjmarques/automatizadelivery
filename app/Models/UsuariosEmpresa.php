<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Usuarios;
use app\Models\Empresa;
/**
 * Class User
 * @package app\Models
 */
class UsuariosEmpresa extends DataLayer
{
    public function __construct()
    {
        parent::__construct("usuarios_empresa", ["id_usuario", "id_empresa"]);
    }

    public function add(Usuarios $usuario, Empresa $empresa)
    {
        $this->id_usuario = $usuario->id;
        $this->id_empresa = $empresa->id;
        $this->id_nivel = $usuario->nivel;

        $this->save();
        return $this;
    }
}
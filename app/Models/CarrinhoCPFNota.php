<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Usuarios;

/**
 * Class Categorias
 * @package app\Models
 */
class CarrinhoCPFNota extends DataLayer
{
    public function __construct()
    {
        parent::__construct("carrinho_cpf_nota", ["numero_pedido", "id_cliente","id_empresa", "cpf"]);
    }

    public function add(Empresa $empresa, Usuarios $usuario, string $data, string $cpf, string $numero_pedido)
    {
        $this->id_cliente = $usuario->id;
        $this->id_empresa = $empresa->id;
        $this->numero_pedido = $numero_pedido;
        $this->cpf = $cpf;

        $this->save();
        return $this;
    }
}
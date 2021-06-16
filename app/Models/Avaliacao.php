<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Usuarios;
use app\Models\Empresa;
/**
 * Class Avaliacao
 * @package app\Models
 */
class Avaliacao extends DataLayer
{
    public function __construct()
    {
        parent::__construct("avaliacao", []);
    }

    public function add(Usuarios $usuario, Usuarios $motoboy, Empresa $empresa, $avaliacao_pedido, $avaliacao_motoboy, $data_compra)
    {
        $this->id_cliente = $usuario->id;
        $this->id_motoboy = $motoboy->id;
        $this->id_estabelecimento = $empresa->id;
        $this->avaliacao_pedido = $avaliacao_pedido;
        $this->avaliacao_motoboy = $avaliacao_motoboy;
        $this->data_compra = $data_compra;

        $this->save();
        return $this;
    }
}
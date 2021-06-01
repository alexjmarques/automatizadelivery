<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Usuario;
use app\Models\CupomDesconto;
/**
 * Class User
 * @package app\Models
 */
class CupomDescontoUtilizadores extends DataLayer
{
    public function __construct()
    {
        parent::__construct("cupomDescontoUtilizacoes", []);
    }

    public function add(Empresa $empresa, Usuarios $usuario, CupomDesconto $cupom, int $numero_pedido)
    {
        $this->id_empresa = $empresa->id;
        $this->id_cliente = $usuario->id;
        $this->id_cupom = $cupom->id;
        $this->numero_pedido = $numero_pedido;

        $this->save();
        return $this;
    }
}
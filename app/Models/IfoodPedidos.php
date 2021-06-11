<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
/**
 * Class IfoodPedidos
 * @package app\Models
 */
class IfoodPedidos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("ifood_pedidos", ["id_empresa","id_ifood"]);
    }

    public function add(Empresa $empresa, $id_ifood, $status, $numero_pedido)
    {
        $this->id_empresa = $empresa->id;
        $this->id_ifood = $id_ifood;
        $this->status = $status;
        $this->numero_pedido = $numero_pedido;

        $this->save();
        return $this;
    }
}
<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\FormasPagamento;

/**
 * Class Categorias
 * @package app\Models
 */
class CarrinhoPedidoPagamento extends DataLayer
{
    public function __construct()
    {
        parent::__construct("carrinhoPedidoPagamento", []);
    }

    public function add(Empresa $empresa,FormasPagamento $formasPagamento,string $pag_cartao, string $pag_dinheiro, string $numero_pedido)
    {
        $this->id_empresa = $empresa->id;
        $this->id_tipo_pagamento = $formasPagamento->id;
        $this->pag_cartao = $pag_cartao;
        $this->pag_dinheiro = $pag_dinheiro;
        $this->numero_pedido = $numero_pedido;

        $this->save();
        return $this;
    }
}
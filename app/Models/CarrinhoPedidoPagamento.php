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
        parent::__construct("carrinho_pedido_pagamento", []);
    }

    public function add(Empresa $empresa,FormasPagamento $formasPagamento,string $pag_cartao, string $pag_dinheiro, int $numero_pedido, int $id_cliente)
    {
        $this->id_empresa = $empresa->id;
        $this->id_tipo_pagamento = $formasPagamento->id;
        $this->pag_cartao = $pag_cartao;
        $this->id_cliente = $id_cliente;
        $this->pag_dinheiro = $pag_dinheiro;
        $this->numero_pedido = $numero_pedido;

        $this->save();
        return $this;
    }
}
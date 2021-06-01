<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Motoboy;
use app\Models\Usuarios;
use app\Models\EmpresaCaixa;
use app\Models\FormasPagamento;
use app\Models\TipoDelivery;

/**
 * Class Categorias
 * @package app\Models
 */
class CarrinhoPedidos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("carrinhoPedidos", ["id_caixa", "id_cliente","id_empresa", "status"]);
    }

    public function add(Empresa $empresa,Motoboy $motoboy,Usuarios $usuario,EmpresaCaixa $caixa,FormasPagamento $formasPagamento,TipoDelivery $tipoEntrega, string $total, string $total_pago, string $troco, string $data, string $hora, string $pago, string $observacao, string $numero_pedido, string $valor_frete, string $km, string $chave, string $status)
    {
        $this->id_empresa = $empresa->id;
        $this->id_motoboy = $motoboy->id;
        $this->id_cliente = $usuario->id;
        $this->id_caixa = $caixa->id;
        $this->tipo_pagamento = $formasPagamento->id;
        $this->tipo_frete = $tipoEntrega->id;
        $this->data_pedido = $data;
        $this->hora = $hora;
        $this->status = $status;
        $this->pago = $pago;
        $this->observacao = $observacao;
        $this->numero_pedido = $numero_pedido;
        $this->valor_frete = $valor_frete;
        $this->chave = $chave;
        $this->km = $km;
        $this->total = $total;
        $this->total_pago = $total_pago;
        $this->troco = $troco;

        $this->save();
        return $this;
    }
}
<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Motoboy;
use app\Models\Usuario;
use app\Models\EmpresaCaixa;

/**
 * Class Categorias
 * @package app\Models
 */
class CarrinhoEntregas extends DataLayer
{
    public function __construct()
    {
        parent::__construct("carrinho_entregas", ["id_caixa", "id_cliente","id_empresa", "id_motoboy"]);
    }

    public function add(Empresa $empresa,Motoboy $motoboy,Usuarios $usuario,EmpresaCaixa $caixa, string $pago, string $observacao, string $numero_pedido, string $status)
    {
        $this->id_motoboy = $motoboy->id;
        $this->id_caixa = $caixa->id;
        $this->id_cliente = $usuario->id;
        $this->id_empresa = $empresa->id;
        $this->status = $status;
        $this->observacao = $observacao;
        $this->numero_pedido = $numero_pedido;
        $this->pago = $pago;

        $this->save();
        return $this;
    }
}
<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Usuarios;
use app\Models\ProdutoAdicional;
use app\Models\Produtos;
use app\Models\Carrinho;

/**
 * Class Categorias
 * @package app\Models
 */
class CarrinhoAdicional extends DataLayer
{
    public function __construct()
    {
        parent::__construct("carrinho_adicional", []);
    }

    public function add(Carrinho $carrinho,Produtos $produto, Usuarios $usuario, ProdutoAdicional $adicional,Empresa $empresa,string $quantidade, string $valor, string $numero_pedido)
    {
        $this->id_carrinho = $carrinho->id;
        $this->id_produto = $produto->id;
        $this->id_cliente = $usuario->id;
        $this->id_adicional = $adicional->id;
        $this->id_empresa = $empresa->id;
        $this->quantidade = $quantidade;
        $this->valor = $valor;
        $this->numero_pedido = $numero_pedido;

        $this->save();
        return $this;
    }
}
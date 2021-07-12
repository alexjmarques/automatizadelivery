<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Usuarios;
use app\Models\ProdutoAdicional;
use app\Models\ProdutoSabor;
use app\Models\Produtos;


/**
 * Class Categorias
 * @package app\Models
 */
class Carrinho extends DataLayer
{
    public function __construct()
    {
        parent::__construct("carrinho", ["id_produto", "id_cliente","id_empresa", "quantidade"]);
    }

    public function add(Produtos $produto, Usuarios $usuario,Empresa $empresa,ProdutoSabor $sabores,ProdutoAdicional $adicional,string $observacao,string $quantidade, string $valor, string $numero_pedido, string $variacao)
    {
        $this->id_produto = $produto->id;
        $this->id_cliente = $usuario->id;
        $this->id_empresa = $empresa->id;
        $this->id_sabores = $sabores->id;
        $this->id_adicional = $adicional->id;
        $this->quantidade = $quantidade;
        $this->observacao = $observacao;
        $this->valor = $valor;
        $this->numero_pedido = $numero_pedido;
        $this->variacao = $variacao;

        $this->save();
        return $this;
    }
}
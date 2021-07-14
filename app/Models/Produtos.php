<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Categorias;
use app\Models\Empresa;
/**
 * Class Produtos
 * @package app\Models
 */
class Produtos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("produtos", []);
    }

    public function add(Categorias $categoria, Empresa $empresa, $nome, $cod, $descricao, $observacao, $valor, $valor_promocional, $imagem, $sabores, $dias_disponiveis, $status, $vendas )
    {
        $this->id_categoria = $categoria->id;
        $this->id_empresa = $empresa->id;
        $this->nome = $nome;
        $this->cod = $cod;
        $this->descricao = $descricao;
        $this->observacao = $observacao;
        $this->valor = $valor;
        $this->valor_promocional = $valor_promocional;
        $this->imagem = $imagem;
        $this->sabores = $sabores;
        $this->dias_disponiveis = $dias_disponiveis;
        $this->status = $status;
        $this->vendas = $vendas;

        $this->save();
        return $this;
    }
}
<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
/**
 * Class User
 * @package app\Models
 */
class Contato extends DataLayer
{
    public function __construct()
    {
        parent::__construct("cupom_desconto", []);
    }

    public function add(Empresa $empresa, $tipo_cupom, $nome_cupom, $valor_cupom, $expira, $qtd_utilizacoes, $status)
    {
        $this->id_empresa = $empresa->id;
        $this->tipo_cupom = $tipo_cupom;
        $this->nome_cupom = $nome_cupom;
        $this->valor_cupom = $valor_cupom;
        $this->expira = $expira;
        $this->qtd_utilizacoes = $qtd_utilizacoes;
        $this->status = $status;

        $this->save();
        return $this;
    }
}
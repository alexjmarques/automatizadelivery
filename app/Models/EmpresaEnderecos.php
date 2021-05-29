<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class EnderecosEmpresa
 * @package app\Models
 */
class EmpresaEnderecos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("empEnderecos", ["id_empresa","rua", "numero"]);
    }

    public function add(Empresa $empresa, string $nome_endereco, string $rua, string $numero, string $complemento, string $bairro, string $cidade, string $estado, string $cep, string $principal)
    {
        $this->id_empresa = $empresa->id;
        $this->nome_endereco = $nome_endereco;
        $this->rua = $rua;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
        $this->principal = $principal;

        $this->save();
        return $this;
    }
}
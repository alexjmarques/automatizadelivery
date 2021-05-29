<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Usuario;

/**
 * Class Enderecos
 * @package app\Models
 */
class UsuariosEnderecos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("enderecos", ["nome_endereco", "id_usuario", "rua", "numero"]);
    }

    public function add(Usuarios $user, string $nome_endereco, string $rua, string $numero, string $complemento, string $bairro, string $cidade, string $estado, string $cep, string $principal)
    {
        $this->id_usuario = $user->id;
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

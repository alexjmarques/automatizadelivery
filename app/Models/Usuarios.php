<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package app\Models
 */
class Usuarios extends DataLayer
{
    public function __construct()
    {
        parent::__construct("usuarios", ["nome", "email", "nivel"]);
    }

    public function add(string $nome, string $email, string $telefone, string $senha, string $nivel)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->senha = $senha;
        $this->nivel = $nivel;

        $this->save();
        return $this;
    }
}
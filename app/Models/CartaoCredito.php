<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
/**
 * Class ProdutoAdicional
 * @package app\Models
 */
class CartaoCredito extends DataLayer
{
    public function __construct()
    {
        parent::__construct("apdCreditCard", ["userHolder","id_empresa"]);
    }

    public function add(Empresa $empresa, string $user_holder, string $hash, string $brand, string $last_digits)
    {
        $this->id_empresa = $empresa->id;
        $this->user_holder = $user_holder;
        $this->hash = $hash;
        $this->brand = $brand;
        $this->last_digits = $last_digits;
        

        $this->save();
        return $this;
    }
}
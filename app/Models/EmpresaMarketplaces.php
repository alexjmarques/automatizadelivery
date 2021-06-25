<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class EnderecosEmpresa
 * @package app\Models
 */
class EmpresaMarketplaces extends DataLayer
{
    public function __construct()
    {
        parent::__construct("empresa_marketplaces", ["id_marketplaces","id_loja"]);
    }

    public function add(Empresa $empresa, string $id_marketplaces, string $id_loja, string $authorization_code, string $user_code)
    {
        $this->id_empresa = $empresa->id;
        $this->id_marketplaces = $id_marketplaces;
        $this->id_loja = $id_loja;
        $this->authorization_code = $authorization_code;
        $this->user_code = $user_code;

        $this->save();
        return $this;
    }
}
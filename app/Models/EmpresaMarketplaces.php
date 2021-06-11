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
        parent::__construct("empresa_marketplaces", ["id_marketplaces","idLoja"]);
    }

    public function add(Empresa $empresa, string $id_marketplaces, string $idLoja, string $authorization_code, string $user_code, string $data_atualizacao)
    {
        $this->id_empresa = $empresa->id;
        $this->id_marketplaces = $id_marketplaces;
        $this->idLoja = $idLoja;
        $this->authorization_code = $authorization_code;
        $this->user_code = $user_code;
        $this->data_atualizacao = $data_atualizacao;

        $this->save();
        return $this;
    }
}
<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Dias;

/**
 * Class EnderecosEmpresa
 * @package app\Models
 */
class EmpresaMarketplaces extends DataLayer
{
    public function __construct()
    {
        parent::__construct("empFuncionamento", ["abertura","fechamento", "id_dia","id_empresa"]);
    }

    public function add(Empresa $empresa, Dias $dia, string $abertura, string $fechamento)
    {
        $this->id_empresa = $empresa->id;
        $this->id_dia = $dia->id;
        $this->abertura = $abertura;
        $this->fechamento = $fechamento;

        $this->save();
        return $this;
    }
}
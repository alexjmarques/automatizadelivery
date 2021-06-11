<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;
use app\Models\Dias;

/**
 * Class EnderecosEmpresa
 * @package app\Models
 */
class EmpresaFuncionamento extends DataLayer
{
    public function __construct()
    {
        parent::__construct("empresa_funcionamento", ["abertura","fechamento", "id_dia","id_empresa"]);
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
<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class EnderecosEmpresa
 * @package app\Models
 */
class EmpresaFrete extends DataLayer
{
    public function __construct()
    {
        parent::__construct("empresa_frete", []);
    }

    public function add(Empresa $empresa, $status, $previsao_minutos, $taxa_entrega, $km_entrega, $km_entrega_excedente, $valor_excedente, $taxa_entrega_motoboy, $valor, $frete_status, $primeira_compra)
    {
        $this->id_empresa = $empresa->id;
        $this->status = $status;
        $this->previsao_minutos = $previsao_minutos;
        $this->taxa_entrega = $taxa_entrega;
        $this->km_entrega = $km_entrega;
        $this->km_entrega_excedente = $km_entrega_excedente;
        $this->valor_excedente = $valor_excedente;
        $this->taxa_entrega_motoboy = $taxa_entrega_motoboy;
        $this->valor = $valor;
        $this->frete_status = $frete_status;
        $this->primeira_compra = $primeira_compra;

        $this->save();
        return $this;
    }
}
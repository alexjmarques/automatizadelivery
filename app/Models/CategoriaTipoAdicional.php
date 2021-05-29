<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class Categorias
 * @package app\Models
 */
class CategoriaTipoAdicional extends DataLayer
{
    public function __construct()
    {
        parent::__construct("categoriaTipoAdicional", []);
    }

    public function add(Empresa $empresa, string $tipo, string $slug, string $tipo_escolha, string $qtd, string $status)
    {
        $this->id_empresa = $empresa->id;
        $this->tipo = $tipo;
        $this->slug = $slug;
        $this->tipo_escolha = $tipo_escolha;
        $this->qtd = $qtd;
        $this->status = $status;

        $this->save();
        return $this;
    }
}
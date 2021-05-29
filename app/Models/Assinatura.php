<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\Empresa;

/**
 * Class Assinatura
 * @package app\Models
 */
class Assinatura extends DataLayer
{
    public function __construct()
    {
        parent::__construct("apdAssinatura", ["subscription_id", "plano_id", "status", "id_empresa"]);
    }

    public function add(Empresa $empresa, string $subscription_id, string $plano_id, string $status)
    {
        $this->id_empresa = $empresa->id;
        $this->subscription_id = $subscription_id;
        $this->plano_id = $plano_id;
        $this->status = $status;

        $this->save();
        return $this;
    }

}
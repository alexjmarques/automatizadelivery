<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Assinatura
 * @package app\Models
 */
class Status extends DataLayer
{
    public function __construct()
    {
        parent::__construct("auxStatus", []);
    }

    public function add(string $delivery, string $retirada)
    {
        $this->delivery = $delivery;
        $this->retirada = $retirada;

        $this->save();
        return $this;
    }

}
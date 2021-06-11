<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Assinatura
 * @package app\Models
 */
class Paginas extends DataLayer
{
    public function __construct()
    {
        parent::__construct("paginas", ["titulo", "slug"]);
    }

    public function add(string $titulo, string $slug, string $conteudo)
    {
        $this->titulo = $titulo;
        $this->slug = $slug;
        $this->conteudo = $conteudo;

        $this->save();
        return $this;
    }

}
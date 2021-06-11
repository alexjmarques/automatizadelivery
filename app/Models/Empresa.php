<?php

namespace app\Models;

use CoffeeCode\DataLayer\DataLayer;
use app\Models\CategoriaSeguimentoSub;
use app\Models\Moeda;

/**
 * Class User
 * @package app\Models
 */
class Empresa extends DataLayer
{
    public function __construct()
    {
        parent::__construct("empresa_dados", ["nome_fantasia", "telefone", "id_moeda", "nf_paulista", "id_categoria"]);
    }

    public function add(CategoriaSeguimentoSub $categoria, Moeda $moeda, string $razao_social, string $cnpj, string $nome_fantasia, string $telefone, string $sobre, string $nf_paulista, string $logo, string $capa, string $dias_atendimento, string $email_contato, string $link_site)
    {
        $this->id_categoria = $categoria->id;
        $this->id_moeda = $moeda->id;
        $this->razao_social = $razao_social;
        $this->cnpj = $cnpj;
        $this->nome_fantasia = $nome_fantasia;
        $this->telefone = $telefone;
        $this->sobre = $sobre;
        $this->nf_paulista = $nf_paulista;
        $this->logo = $logo;
        $this->capa = $capa;
        $this->dias_atendimento = $dias_atendimento;
        $this->email_contato = $email_contato;
        $this->link_site = $link_site;


        $this->save();
        return $this;
    }
}

<?php

namespace app\classes;

use Aura\Session\SessionFactory;
use app\Models\Assinatura;
use app\Models\Empresa;
use app\Models\Usuarios;
use app\Models\Dias;
use app\Models\Estados;
use app\Models\EmpresaCaixa;
use app\Models\EmpresaFrete;
use app\Models\EmpresaMarketplaces;
use app\Models\EmpresaEnderecos;
use app\Models\Avaliacao;
use app\Models\UsuariosEmpresa;
use app\Models\TipoDelivery;
use app\Models\Produtos;
use app\Models\ProdutoSabor;
use app\Models\ProdutoAdicional;
use app\Models\Planos;
use app\Models\Motoboy;
use app\Models\Moeda;
use app\Models\IfoodPedidos;
use app\Models\FormasPagamento;
use app\Models\Favoritos;
use app\Models\UsuariosEnderecos;
use app\Models\CupomDescontoUtilizadores;
use app\Models\Categorias;
use app\Models\CupomDesconto;
use app\Models\Contato;
use app\Models\CartaoCredito;
use app\Models\Carrinho;
use app\Models\CarrinhoAdicional;
use app\Models\CarrinhoCPFNota;
use app\Models\CarrinhoEntregas;
use app\Models\CarrinhoPedidos;
use app\Models\CategoriaSeguimento;
use app\Models\CategoriaSeguimentoSub;
use app\Models\CategoriaTipoAdicional;


class Geral
{
    private $empresa;
    private $assinatura;
    private $dias;
    private $estados;
    private $empresaCaixa;
    private $empresaFrete;
    private $empresaMarketplaces;
    private $empresaEnderecos;
    private $avaliacao;
    private $usuarios;
    private $usuariosEmpresa;
    private $tipoDelivery;
    private $produtos;
    private $produtoSabor;
    private $produtoAdicional;
    private $planos;
    private $motoboy;
    private $moeda;
    private $ifoodPedidos;
    private $formasPagamento;
    private $favoritos;
    private $usuariosEnderecos;
    private $cupomDescontoUtilizadores;
    private $categorias;
    private $cupomDesconto;
    private $contato;
    private $cartaoCredito;
    private $carrinho;
    private $carrinhoAdicional;
    private $carrinhoCPFNota;
    private $carrinhoEntregas;
    private $carrinhoPedidos;
    private $categoriaSeguimentoSub;
    private $categoriaSeguimento;
    private $categoriaTipoAdicional;
    private $sessao;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->sessao = new SessionFactory();
        $this->empresa = new Empresa();
        $this->assinatura = new Assinatura();
        $this->dias = new Dias();
        $this->estados = new Estados();
        $this->empresaCaixa = new EmpresaCaixa();
        $this->empresaFrete = new EmpresaFrete();
        $this->empresaMarketplaces = new EmpresaMarketplaces();
        $this->empresaEnderecos = new EmpresaEnderecos();
        $this->usuariosEnderecos = new UsuariosEnderecos();
        $this->avaliacao = new Avaliacao();
        $this->usuarios = new Usuarios();
        $this->usuariosEmpresa = new UsuariosEmpresa();
        $this->tipoDelivery = new TipoDelivery();
        $this->produtos = new Produtos();
        $this->produtoSabor = new ProdutoSabor();
        $this->produtoAdicional = new ProdutoAdicional();
        $this->planos = new Planos();
        $this->motoboy = new Motoboy();
        $this->moeda = new Moeda();
        $this->ifoodPedidos = new IfoodPedidos();
        $this->formasPagamento = new FormasPagamento();
        $this->favoritos = new Favoritos();
        $this->cupomDescontoUtilizadores = new CupomDescontoUtilizadores();
        $this->categorias = new Categorias();
        $this->cupomDesconto = new CupomDesconto();
        $this->contato = new Contato();
        $this->cartaoCredito = new CartaoCredito();
        $this->carrinho = new Carrinho();
        $this->carrinhoAdicional = new CarrinhoAdicional();
        $this->carrinhoCPFNota = new CarrinhoCPFNota();
        $this->carrinhoEntregas = new CarrinhoEntregas();
        $this->carrinhoPedidos = new CarrinhoPedidos();
        $this->categoriaSeguimentoSub = new CategoriaSeguimentoSub();
        $this->categoriaSeguimento = new CategoriaSeguimento();
        $this->categoriaTipoAdicional = new CategoriaTipoAdicional();
    }

    public function getByField(string $table, string $field, string $valor)
    {
        return $this->{$table}->find("{$field} = :{$field}", "{$field}={$valor}")->fetch();
    }

    public function getById(string $table, int $id)
    {
        return $this->{$table}->find("id = :id", "id={$id}")->fetch();
        
    }

    public function limitOrder(string $table, string $valor,int $limit, string $field, string $order)
    {
        return $this->{$table}->find("id_empresa ={$valor}")->limit($limit)->order("{$field} {$order}")->fetch(true);
       
    }
    
    /**
     * Funções de Contagem
     *
     * @param string $table
     * @param string $field
     * @param string $valor
     * @return void
     */
    public function count(string $table, string $field, string $valor)
    {
        return $this->{$table}->find("{$field} = {$valor}")->count();
        
    }

    public function countStatusDay(string $table, string $field, string $valor, string $field2, string $valor2)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND data = CURDATE()")->count();
        
    }

    public function countCompany(string $table, string $valor)
    {
        return $this->{$table}->find("id_empresa ={$valor}")->count();
        
    }

    public function countCompanyDay(string $table, string $valor)
    {
        return $this->{$table}->find("id_empresa ={$valor} AND data = CURDATE()")->count();
        
    }

    public function countStatusCompany(string $table, string $idEmpresa, int $status)
    {
        return $this->{$table}->find("id_empresa = {$idEmpresa} AND status = {$status}")->count();
        
    }

    public function countStatusCompanyDay(string $table, string $idEmpresa, int $status)
    {
        return $this->{$table}->find("id_empresa = {$idEmpresa} AND status = {$status} AND data = CURDATE()")->count();
        
    }

    
}
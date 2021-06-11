<?php

namespace app\classes;

use Aura\Session\SessionFactory;
use app\Models\Assinatura;
use app\Models\Empresa;
use app\Models\Paginas;
use app\Models\EmpresaFuncionamento;
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
use app\Models\Status;
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
use app\Models\CarrinhoPedidoPagamento;
use app\Models\CategoriaSeguimento;
use app\Models\CategoriaSeguimentoSub;
use app\Models\CategoriaTipoAdicional;


class Acoes
{
    private $empresa;
    private $empresaFuncionamento;
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
    private $status;
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
    private $carrinhoPedidosPagamento;
    private $categoriaSeguimentoSub;
    private $categoriaSeguimento;
    private $categoriaTipoAdicional;
    private $sessao;
    private $paginas;

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
        $this->empresaFuncionamento = new EmpresaFuncionamento();
        $this->assinatura = new Assinatura();
        $this->dias = new Dias();
        $this->paginas = new Paginas();
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
        $this->status = new Status();
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
        $this->carrinhoPedidoPagamento = new CarrinhoPedidoPagamento();
        $this->categoriaSeguimento = new CategoriaSeguimento();
        $this->categoriaTipoAdicional = new CategoriaTipoAdicional();
    }

    public function getFind(string $table)
    {
        return $this->{$table}->find()->fetch(true);
    }

    public function getByField(string $table, string $field, string $valor)
    {
        return $this->{$table}->find("{$field} = :{$field}", "{$field}={$valor}")->fetch(false);
    }

    public function getByFieldTwo(string $table, string $field, string $valor, string $field2, string $valor2)
    {
        return $this->{$table}->find("{$field} = :{$field} AND {$field2} = {$valor2}", "{$field}={$valor}")->fetch(false);
    }

    public function getByFieldTwoAll(string $table, string $field, string $valor, string $field2, string $valor2)
    {
        return $this->{$table}->find("{$field} = :{$field} AND {$field2} = {$valor2}", "{$field}={$valor}")->fetch(true);
    }

    public function getByFieldTree(string $table, string $field, string $valor, string $field2, string $valor2, string $field3, string $valor3)
    {
        return $this->{$table}->find("{$field} = :{$field} AND {$field2} = {$valor2} AND {$field3} = {$valor3}", "{$field}={$valor}")->fetch(false);
    }

    public function getByFieldTreeMenor(string $table, string $field, string $valor, string $field2, string $valor2, string $field3, string $valor3)
    {
        return $this->{$table}->find("{$field} = :{$field} AND {$field2} = {$valor2} AND {$field3} < {$valor3}", "{$field}={$valor}")->order("id DESC")->fetch(false);
    }

    public function getByFieldTreeNull(string $table, string $field, string $valor, string $field2, string $valor2, string $field3, string $valor3)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND {$field3} is {$valor3}")->fetch(true);
    }

    public function getById(string $table, int $id)
    {
        return $this->{$table}->find($id)->fetch(true);
    }

    public function getByFieldAll(string $table, string $field, string $valor)
    {
        return $this->{$table}->find("{$field} = {$valor}")->fetch(true);
    }

    public function getByFieldAllLoop(string $table, string $field, string $valor, string $field2, string $valor2)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND numero_pedido is null")->fetch(true);
    }

    public function getByFieldAllTwo(string $table, string $field, string $valor, string $field2, string $valor2)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2}")->fetch(true);
    }

    public function getByFieldAllTwoNull(string $table, string $field, string $valor, string $field2, string $valor2)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND numero_pedido is null")->fetch(true);
    }

    public function limitOrder(string $table, string $field, string $valor,int $limit, string $field2, string $order)
    {
        return $this->{$table}->find("{$field} ={$valor}")->limit($limit)->order("{$field2} {$order}")->fetch(true);
    }

    public function limitOrderFill(string $table, string $field, string $valor,string $field1, string $valor1,string $field3, string $valor3,int $limit, string $field2, string $order)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field1} = {$valor1} AND {$field3} < {$valor3} ")->limit($limit)->order("{$field2} {$order}")->fetch(true);
    }

    public function pagination(string $table, string $field, string $valor,int $limit, string $offset, string $order)
    {
        return $this->{$table}->find("{$field} ={$valor}")->limit($limit)->offset($offset)->order($order)->fetch(true);
    }

    public function paginationAdd(string $table,int $limit, string $offset, string $order)
    {
        return $this->{$table}->find()->limit($limit)->offset($offset)->order($order)->fetch(true);
    }

    /**
     * Funções de Soma
     *
     * @param string $table
     * @param string $field
     * @param string $valor
     * @return void
     */
    public function sumFiels(string $table, string $field, string $valor, string $field2, string $valor2, string $linha)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2}", null, "SUM($linha) AS total")->fetch();
    }

    public function sumFielsM(string $table, string $field, string $valor, string $field2, string $valor2, string $linha)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} < {$valor2}", null, "SUM($linha) AS total")->fetch();
    }
    

    public function sumFielsTree(string $table, string $field,string $valor, string $field2,string $valor2,string $field3,string $valor3, string $linha)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND {$field3} = {$valor3}", null, "SUM($linha) AS total")->fetch();
    }

    public function sumFielsTreeNull(string $table, string $field,string $valor, string $field2,string $valor2,string $field3,string $valor3, string $linha)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND {$field3} is {$valor3}", null, "SUM($linha) AS total")->fetch();
    }

    public function sumFielsTreeM(string $table, string $field,string $valor, string $field2,string $valor2,string $field3,string $valor3, string $linha)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND {$field3} < {$valor3}", null, "SUM($linha) AS total")->fetch();
    }

    public function sum(string $table, string $valor, string $linha)
    {
        return $this->{$table}->find("id_empresa = {$valor}", null, "SUM($linha) AS total")->fetch();
    }
    
    /**
     * Funções de Contagem
     *
     * @param string $table
     * @param string $field
     * @param string $valor
     * @return void
     */
    public function countAdd(string $table)
    {
        return $this->{$table}->find()->count();
    }

    public function counts(string $table, string $field, string $valor)
    {
        return $this->{$table}->find("{$field} = {$valor}")->count();
    }

    public function countsTwo(string $table, string $field, string $valor, string $field2, string $valor2)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2}")->count();
    }

    public function countsTwoNull(string $table, string $field, string $valor, string $field2, string $valor2)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND numero_pedido is null")->count();
    }

    public function countsTree(string $table, string $field, string $valor, string $field2, string $valor2, string $field3, string $valor3)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND {$field3} = {$valor3}")->count();
    }

    public function countStatusDay(string $table, string $field, string $valor, string $field2, string $valor2, string $data)
    {
        return $this->{$table}->find("{$field} = {$valor} AND {$field2} = {$valor2} AND {$data} = CURRENT_DATE")->count();
    }

    public function countStatusMes(string $table, string $field, string $valor, string $data)
    {
        return $this->{$table}->find("{$field} = {$valor} AND MONTH({$data})=MONTH(now()) AND YEAR({$data})=YEAR(now())")->count();
    }

    public function countCompany(string $table,string $field, string $valor)
    {
        return $this->{$table}->find("{$field} ={$valor}")->count();
    }

    public function countCompanyVar(string $table,string $field2, string $valor, string $field, string $valor2)
    {
        return $this->{$table}->find("{$field2} ={$valor} AND {$field} = {$valor2}")->count();
    }

    public function countCompanyDay(string $table,string $field, string $valor , string $data)
    {
        return $this->{$table}->find("{$field} ={$valor} AND {$data} = CURRENT_DATE")->count();
    }

    public function countStatusCompany(string $table,string $field, string $valor, int $statuss)
    {
        return $this->{$table}->find("{$field} = {$valor} AND status = {$statuss}")->count();
    }

    public function countStatusCompanyDay(string $table,string $field, string $valor, int $statuss, string $data)
    {
        return $this->{$table}->find("{$field} = {$valor} AND status = {$statuss} AND {$data} = CURRENT_DATE")->count();
    }
}
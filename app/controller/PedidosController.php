<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Preferencias;
use app\core\Controller;
use Aura\Session\SessionFactory;
use app\Models\AdminCategoriaModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;
use app\Models\AdminConfigFreteModel;
use app\Models\AdminProdutoModel;
use app\Models\AdminProdutoAdicionalModel;
use app\Models\DiasModel;
use app\Models\EnderecosModel;
use app\Models\EstadosModel;
use app\Models\MoedaModel;
use app\Models\VendasModel;
use app\Models\CarrinhoModel;
use app\Models\AdminPagamentoModel;
use app\Models\AdminProdutoSaborModel;
use app\Models\AdminTipoModel;
use app\Models\CarrinhoAdicionalModel;
use app\Models\UsuarioModel;
use app\Models\RatingModel;


class PedidosController extends Controller
{
    //Instancia da Classe AdminConfigEmpresaModel
    private $configEmpresaModel;
    private $deliveryModel;
    private $moedaModel;
    private $categoriaModel;
    private $produtoModel;
    private $diasModel;
    private $usuarioModel;
    private $enderecosModel;
    private $sessionFactory;
    private $estadosModel;
    private $produtoAdicionalModel;
    private $produtoSaboresModel;
    private $carrinhoModel;
    private $pagamentoModel;
    private $tipoModel;
    private $carrinhoAdicionalModel;
    private $vendasModel;
    private $ratingModel;
    private $preferencias;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->preferencias = new Preferencias();
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
        $this->ratingModel = new RatingModel();
        $this->moedaModel = new MoedaModel();
        $this->deliveryModel = new AdminConfigFreteModel();
        $this->categoriaModel = new AdminCategoriaModel();
        $this->produtoModel = new AdminProdutoModel();
        $this->produtoAdicionalModel = new AdminProdutoAdicionalModel();
        $this->produtoSaboresModel = new AdminProdutoSaborModel();
        $this->diasModel = new DiasModel();
        $this->usuarioModel = new UsuarioModel();
        $this->enderecosModel = new EnderecosModel();
        $this->estadosModel = new EstadosModel();
        $this->carrinhoModel = new CarrinhoModel();
        $this->pagamentoModel = new AdminPagamentoModel();
        $this->tipoModel = new AdminTipoModel();
        $this->carrinhoAdicionalModel = new CarrinhoAdicionalModel();
        $this->vendasModel = new VendasModel();
        $this->sessionFactory = new SessionFactory();
    }
    /**
     * Pagina do pedidos já feitos
     *
     */
    public function index($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');


        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinho = $this->carrinhoModel->getAll($SessionIdUsuario);
            $resultVendas = $this->vendasModel->getAllUser($SessionIdUsuario);
            $resultUltimaVenda = $this->vendasModel->getLast($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/pedidos/main', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'produto' => $resultProdutos,
            'produtoAdicional' => $resultProdutoAdicional,
            'usuario' => $resulUsuario,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'carrinho' => $resultCarrinho,
            'tipo_frete' => $resultTipo,
            'tipo_pagamento' => $resultPagamento,
            'vendas' => $resultVendas,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }
    /**
     * Pagina do pedido
     *
     */
    public function view($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');





        $SessionIdUsuario = $segment->get('id_usuario');

        if (!isset($SessionIdUsuario)) {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

        $resultVendas = $this->vendasModel->getPedidoFeitoChave($data['chave']);

        $resultCarrinhoProdutoAdicional = $this->carrinhoAdicionalModel->getPedidoFeito($resultVendas[':numero_pedido'],$empresaAct[':id']);
        $resultCarrinho = $this->carrinhoModel->getPedidoFeito($resultVendas[':numero_pedido'],$empresaAct[':id']);


        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEstados = $this->estadosModel->getAll();
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);

        unset($_SESSION['numero_pedido']);
        $segment->set('numero_pedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/pedidos/view', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'produto' => $resultProdutos,
            'usuario' => $resulUsuario,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'carrinhoAdicional' => $resultCarrinhoProdutoAdicional,
            'adicionais' => $resultProdutoAdicional,
            'carrinho' => $resultCarrinho,
            'tipo_frete' => $resultTipo,
            'tipo_pagamento' => $resultPagamento,
            'sabores' => $resultSabores,
            'venda' => $resultVendas,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    /**
     * Pagina do pedido Carregamento Ajax
     *
     */
    public function statusPedidoFull($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultCarrinhoProdutoAdicional = $this->carrinhoAdicionalModel->getPedidoFeito($data['numero_pedido'],$empresaAct[':id']);
        $resultCarrinho = $this->carrinhoModel->getPedidoFeito($data['numero_pedido'],$empresaAct[':id']);
        $resultVendas = $this->vendasModel->getPedidoFeito($data['numero_pedido'],$empresaAct[':id']);

        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEstados = $this->estadosModel->getAll();
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        $resultAvaliacao = $this->ratingModel->getExist($data['numero_pedido'],$empresaAct[':id']);
        $avaliacao = $resultAvaliacao[':numero_pedido'] == null ? 0 : 1;


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/pedidos/pedidoAcompanharTotal', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'produto' => $resultProdutos,
            'usuario' => $resulUsuario,
            'avaliacao' => $avaliacao,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'carrinhoAdicional' => $resultCarrinhoProdutoAdicional,
            'adicionais' => $resultProdutoAdicional,
            'carrinho' => $resultCarrinho,
            'tipo_frete' => $resultTipo,
            'tipo_pagamento' => $resultPagamento,
            'sabores' => $resultSabores,
            'venda' => $resultVendas,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    /**
     * Cancelar os pedidos feitos pelo cliente
     *
     */
    public function cancelarPedido($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $valores = $this->getInput();
        $result = $this->vendasModel->cancelarPedidoFeito($valores);

        if ($result > 0) {
            echo 'Pedido cancelado com sucesso!';
        } else {
            echo 'Erro ao cancelar seu pedido';
        }
    }


    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {
        return (object) [
            'id' => Input::post('id'),
            'numero_pedido' => Input::post('numero_pedido'),
            'status' => 6,
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}

<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Preferencias;
use app\core\Controller;
use app\controller\AllController;
use app\Models\AdminCategoriaModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;
use app\Models\AdminConfigFreteModel;
use app\Models\AdminProdutoModel;
use app\Models\AdminProdutoAdicionalModel;
use app\Models\AdminUsuarioModel;
use app\Models\AdminCaixaModel;
use app\Models\DiasModel;
use app\Models\EnderecosModel;
use app\Models\EstadosModel;
use app\Models\MoedaModel;
use app\Models\VendasModel;
use app\Models\CarrinhoModel;
use app\Models\AdminPagamentoModel;
use app\Models\AdminProdutoSaborModel;
use Aura\Session\SessionFactory;
use app\Models\AdminTipoModel;
use app\Models\CarrinhoAdicionalModel;
use app\Models\UsuarioModel;
use app\Models\MotoboyEntregasModel;


class PedidosMotoboyController extends Controller
{
    //Instancia da Classe AdminConfigEmpresaModel
    private $configEmpresaModel;
    private $deliveryModel;
    private $moedaModel;
    private $caixaModel;
    private $categoriaModel;
    private $produtoModel;
    private $diasModel;
    private $usuarioModel;
    private $enderecosModel;
    private $estadosModel;
    private $sessionFactory;
    private $allController;
    private $produtoAdicionalModel;
    private $produtoSaboresModel;
    private $carrinhoModel;
    private $pagamentoModel;
    private $tipoModel;
    private $carrinhoAdicionalModel;
    private $vendasModel;
    private $entregasModel;
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
        $this->moedaModel = new MoedaModel();
        $this->caixaModel = new AdminCaixaModel();
        $this->deliveryModel = new AdminConfigFreteModel();
        $this->categoriaModel = new AdminCategoriaModel();
        $this->produtoModel = new AdminProdutoModel();
        $this->produtoAdicionalModel = new AdminProdutoAdicionalModel();
        $this->produtoSaboresModel = new AdminProdutoSaborModel();
        $this->diasModel = new DiasModel();
        $this->sessionFactory = new SessionFactory();
        $this->usuarioModel = new UsuarioModel();
        $this->enderecosModel = new EnderecosModel();
        $this->estadosModel = new EstadosModel();
        $this->carrinhoModel = new CarrinhoModel();
        $this->allController = new AllController();
        $this->pagamentoModel = new AdminPagamentoModel();
        $this->tipoModel = new AdminTipoModel();
        $this->carrinhoAdicionalModel = new CarrinhoAdicionalModel();
        $this->vendasModel = new VendasModel();
        $this->entregasModel = new MotoboyEntregasModel();
    }

    /**s
     * Pagian dos relatorio de entregas feitas
     * 
     * Entregas Pagas
     * Entregas Feitas Total
     * Entregas p/ Mês
     * Entregas p/ Data
     */
    public function relatorio($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $verificaLogin = $this->allController->verificaLogin($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $dataEscolhida = Input::get('mes');
        if ($dataEscolhida == null) {
            $dataEscolhida = date('m');
        } else {
            $dataEscolhida = Input::get('mes');
        }

        $resulCaixa = $this->caixaModel->getUll($empresaAct[':id']);
        $resultPedidos = $this->vendasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultBuscaAll = $this->entregasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEntregas = $this->vendasModel->somaEntregasMes($SessionIdUsuario,$empresaAct[':id']);
        $resultEntregasQtd = $this->vendasModel->qtdEntregasMes($SessionIdUsuario,$empresaAct[':id']);
        $resultEntregasDia = $this->vendasModel->somaEntregasDia($SessionIdUsuario, $resulCaixa[':id'],$empresaAct[':id']);
        $resultEntregasDiaCont = $this->vendasModel->qtdEntregasDia($SessionIdUsuario, $resulCaixa[':id'],$empresaAct[':id']);

        $totalMotoboyMes = $resultEntregas['total'] - ($resultEntregasQtd * $resultDelivery[':taxa_entrega_motoboy']);
        $totalMotoboyDia = $resultEntregasDia['total'] - ($resultEntregasDiaCont * $resultDelivery[':taxa_entrega_motoboy']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/relatorio/main', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'entregasFeitas' => $totalMotoboyMes,
            'entregasFeitasDia' => $totalMotoboyDia,
            'entregasDia' => $resultEntregasDiaCont,
            'busca' => $resultBuscaAll,
            'pedidos' => $resultPedidos,
            'frete' => $resultDelivery,
            'moeda' => $resultMoeda,
            'dataEscolhida' => $dataEscolhida,
            'mesAtual' => date('m'),
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }


    public function relatorioMes($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $verificaLogin = $this->allController->verificaLogin($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $dataEscolhida = Input::get('mes');
        if ($dataEscolhida == null) {
            $dataEscolhida = date('m');
        } else {
            $dataEscolhida = Input::get('mes');
        }
        $resultPedidos = $this->vendasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultBuscaAll = $this->entregasModel->getAllPorEmpresa($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/relatorio/relatorioMes', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'busca' => $resultBuscaAll,
            'pedidos' => $resultPedidos,
            'frete' => $resultDelivery,
            'moeda' => $resultMoeda,
            'dataEscolhida' => $dataEscolhida,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
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
        $resultCarrinho = $this->carrinhoModel->getCart($empresaAct[':id']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');


        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultVendas = $this->vendasModel->getAllUserMotoboy($SessionIdUsuario);
            $resultPedidoQtd = $this->vendasModel->vendasQtdMotoboy($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();

        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultUsuarios = $this->usuarioModel->getAll();

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/main', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'produto' => $resultProdutos,
            'produtoAdicional' => $resultProdutoAdicional,
            'usuario' => $resulUsuario,
            'carrinho' => $resultCarrinho,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'tipo_frete' => $resultTipo,
            'tipo_pagamento' => $resultPagamento,
            'vendas' => $resultVendas,
            'usuarios' => $resultUsuarios,
            'pedidosQtd' => $resultPedidoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias

        ]);
    }

    /**
     * Pagina do pedidos já feitos
     *
     */
    public function pesquisarEntrega($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $resultCarrinho = $this->carrinhoModel->getCart($empresaAct[':id']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');


        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultVendas = $this->vendasModel->getAllUserMotoboy($SessionIdUsuario);
            $resultPedidoQtd = $this->vendasModel->vendasQtdMotoboy($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();

        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);

        $resultUsuarios = $this->usuarioModel->getAll();



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/pesquisarEntrega', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'produto' => $resultProdutos,
            'produtoAdicional' => $resultProdutoAdicional,
            'usuario' => $resulUsuario,
            'carrinho' => $resultCarrinho,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'tipo_frete' => $resultTipo,
            'tipo_pagamento' => $resultPagamento,
            'vendas' => $resultVendas,
            'usuarios' => $resultUsuarios,
            'pedidosQtd' => $resultPedidoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias

        ]);
    }


    public function getEntrega($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $resultCarrinho = $this->carrinhoModel->getCart($empresaAct[':id']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');


        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        $resultPedidoQtd = $this->vendasModel->vendasQtdMotoboy($SessionIdUsuario);
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultUsuarios = $this->usuarioModel->getAll();

        $numero_pedido = Input::get('numero_pedido');

        if (!isset($SessionIdUsuario)) {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        if ($numero_pedido != null)
            $resultVendas = $this->vendasModel->getByNumPedido($numero_pedido);


        $resulCaixa = $this->caixaModel->getUll($empresaAct[':id']);



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/pesquisarEntregaView', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'motoboy' => $SessionIdUsuario,
            'usuario' => $resulUsuario,
            'usuarios' => $resultUsuarios,
            'carrinho' => $resultCarrinho,
            'tipo_frete' => $resultTipo,
            'tipo_pagamento' => $resultPagamento,
            'venda' => $resultVendas,
            'caixa' => $resulCaixa,
            'pedidosQtd' => $resultPedidoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias

        ]);
    }


    /**
     * Pagina do pedidos já feitos
     *
     */
    public function entregaListar($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $resultCarrinho = $this->carrinhoModel->getCart($empresaAct[':id']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultVendas = $this->vendasModel->getAllUserMotoboy($SessionIdUsuario);
            $resultPedidoQtd = $this->vendasModel->vendasQtdMotoboy($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();

        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);

        $resultUsuarios = $this->usuarioModel->getAll();


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/vendasEntregas', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'produto' => $resultProdutos,
            'produtoAdicional' => $resultProdutoAdicional,
            'usuario' => $resulUsuario,
            'carrinho' => $resultCarrinho,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'tipo_frete' => $resultTipo,
            'tipo_pagamento' => $resultPagamento,
            'vendas' => $resultVendas,
            'usuarios' => $resultUsuarios,
            'pedidosQtd' => $resultPedidoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }


    /**
     * Pagina do pedidos já feitos
     *
     */
    public function numeroEntregaListar($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resultPedidoQtd = $this->vendasModel->vendasQtdMotoboy($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/pedidoQtd', [
            'empresa' => $empresaAct,
            'pedidosQtd' => $resultPedidoQtd,
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
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        $resultCarrinhoProdutoAdicional = $this->carrinhoAdicionalModel->getPedidoFeito($data['numero_pedido'],$empresaAct[':id']);
        $resultCarrinho = $this->carrinhoModel->getPedidoFeito($data['numero_pedido'],$empresaAct[':id']);
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);
        $resultUsuarios = $this->usuarioModel->getAll();
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEstados = $this->estadosModel->getAll();

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultVendas = $this->vendasModel->getAllUserMotoboy($SessionIdUsuario);
            $resultVenda = $this->vendasModel->getPedidoFeito($data['numero_pedido'],$empresaAct[':id']);
            $resultPedidoQtd = $this->vendasModel->vendasQtdMotoboy($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/view', [
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
            'venda' => $resultVenda,
            'vendas' => $resultVendas,
            'usuarios' => $resultUsuarios,
            'pedidosQtd' => $resultPedidoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }


    /**
     * Cancelar os pedidos feitos pelo cliente
     *
     */
    public function mudarStatus($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $statusInsert = $this->getInput();
        //dd($statusInsert);
        $statusVenda = $this->getInputVendaStatus();
        $result = $this->entregasModel->updateVendaFim($statusInsert);
        $result2 = $this->vendasModel->updateStats($statusVenda);

        if ($result > 0 && $result2 > 0) {
            echo 'Status Informado ao Restaurante';
        } else {
            echo 'Oops! O novo Status não pode ser informado';
        }
    }


    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {
        $statusSt = $_POST['status'];
        //dd($statusSt);
        if ($statusSt != null) {
            $statusSelecionados = $_POST['status'];
        }

        $observacao = Input::post('observacao');
        if ($observacao == null) {
            $observacao = 'Pedido entrege ao cliente';
        }

        return (object) [
            'status' => $statusSelecionados,
            'observacao' => $observacao,
            'data' => date('Y-m-d'),
            'hora' => date('H:i:s'),
            'chave' => Input::post('chave'),
            'numero_pedido' => Input::post('numero_pedido'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputVendaStatus()
    {
        $statusSt = $_POST['status'];
        if ($statusSt != null) {
            $statusSelecionado = $_POST['status'];
        }
        return (object) [
            'id' => Input::post('id'),
            'status' => $statusSelecionado,
            'pago' => 1,
            'chave' => Input::post('chave'),
            'numero_pedido' => Input::post('numero_pedido'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}

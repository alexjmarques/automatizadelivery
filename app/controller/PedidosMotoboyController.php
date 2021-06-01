<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use Mobile_Detect;
use app\classes\Sessao;
use Browser;


class PedidosMotoboyController extends Controller
{
    private $acoes;
    private $sessao;
    private $geral;
    private $trans;
    

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->trans = new Translate(new PhpFilesLoader("../app/language"), ["default" => "pt_BR"]);
        $this->sessao = new Sessao();
        $this->geral = new AllController();
        $this->cache = new Cache();
        $this->acoes = new Acoes();
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
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultDelivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);

        $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $categoria = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $produtoTop5 = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');

        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_motoboy/relatorio/main', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'entregasFeitas' => $totalMotoboyMes,
            'entregasFeitasDia' => $totalMotoboyDia,
            'entregasDia' => $resultEntregasDiaCont,
            'busca' => $resultBuscaAll,
            'pedidos' => $resultPedidos,
            'frete' => $resultDelivery,
            'moeda' => $moeda,
            'dataEscolhida' => $dataEscolhida,
            'mesAtual' => date('m'),
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
            
        ]);
    }


    public function relatorioMes($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $resultDelivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $categoria = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $produtoTop5 = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        
        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $dataEscolhida = $data['mes'];
        if ($dataEscolhida == null) {
            $dataEscolhida = date('m');
        } else {
            $dataEscolhida = $data['mes'];
        }
        $resultPedidos = $this->vendasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultBuscaAll = $this->entregasModel->getAllPorEmpresa($empresaAct[':id']);


        $this->load('_motoboy/relatorio/relatorioMes', [
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'busca' => $resultBuscaAll,
            'pedidos' => $resultPedidos,
            'frete' => $resultDelivery,
            'moeda' => $moeda,
            'dataEscolhida' => $dataEscolhida,
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }



    /**
     * Pagina do pedidos já feitos
     *
     */
    public function index($data)
    {

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultDelivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $resultDelivery = $this->acoes->getByFieldAll('carrinho', 'id_empresa', $empresa->id);

        $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $categoria = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $produtoTop5 = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');

        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        


        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        // $resultEnderecos = $this->enderecosModel->getAll();
        // $resultEstados = $this->estadosModel->getAll();

        // $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        // $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        // $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        // $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);
        // $resultUsuarios = $this->usuarioModel->getAll();


        $this->load('_motoboy/pedidos/main', [
            'moeda' => $moeda,
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
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }

    /**
     * Pagina do pedidos já feitos
     *
     */
    public function pesquisarEntrega($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        }

        $this->load('_motoboy/pedidos/pesquisarEntrega', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }


    public function getEntrega($data)
    {
     
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $resultCarrinho = $this->acoes->getByFieldAll('carrinho', 'id_empresa', $empresa->id);

        $resultTipo = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
        $resultPagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);

        $resultSoma = $this->acoes->sumFielsTreeNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
        $resultSomaAdicional = $this->acoes->sumFielsTreeNull('carrinhoAdicional', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
        $resultVendasFeitas = $this->acoes->countsTwo('carrinhoPedidos', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);

        $numero_pedido = Input::get('numero_pedido');

        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $pedidosQtd = $this->acoes->countsTwoNull('carrinhoPedidos', 'id_motoboy', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            if ($numero_pedido != null){
                $resultVendas = $this->acoes->getByFieldTwo('carrinhoPedidos', 'id_empresa', $empresa->id, 'numero_pedido', $numero_pedido);
                $cliente = $this->acoes->getByField('usuarios', 'id', $resultVendas->id_cliente);
            }
        }else{
            redirect(BASE."{$empresa->link_site}/login");
        }

        $resulCaixa = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/pesquisarEntregaView', [
            'moeda' => $moeda,
            'usuario' => $resulUsuario,
            'cliente' => $cliente,
            'carrinho' => $resultCarrinho,
            'tipo_frete' => $resultTipo,
            'tipo_pagamento' => $resultPagamento,
            'venda' => $resultVendas,
            'id_motoboy' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->id,
            'pedidosQtd' => $pedidosQtd,
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'numero' => $this->geral->formataTelefone($cliente->telefone)
        ]);
    }


    /**
     * Pagina do pedidos já feitos
     *
     */
    public function entregaListar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $resultCarrinho = $this->carrinhoModel->getCart($empresaAct[':id']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
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
            'moeda' => $moeda,
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
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }


    /**
     * Pagina do pedidos já feitos
     *
     */
    public function numeroEntregaListar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/pedidoQtd', [
            'pedidosQtd' => $resultPedidoQtd,
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }
    /**
     * Pagina do pedido
     *
     */
    public function view($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

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

        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/pedidos/view', [
            'moeda' => $moeda,
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
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }


    /**
     * Cancelar os pedidos feitos pelo cliente
     *
     */
    public function mudarStatus($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
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

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
use app\classes\Sessao;
use Browser;

class AdminPedidosBalcaoController extends Controller
{
    //Instancia da Classe AdminPagamentoModel
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

    public function index($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $estabelecimento = $this->allController->verificaEstabelecimento($empresaAct[':id']);;;
        $resultPedidos = $this->adminVendasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultClientes = $this->adminUsuarioModel->getClientes();

        $resultProdutos = $this->adminProdutosModel->getAllPorEmpresa($empresaAct[':id']);
        $resultCategorias = $this->adminCategoriasModel->getAllPorEmpresa($empresaAct[':id']);

        $resultMotoboy = $this->adminUsuarioModel->getMotoboy();

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $resulUsuario = $this->adminUsuarioModel->getById($SessionIdUsuario);
            if ($resulUsuario[':nivel'] == 3) {
                redirect(BASE . $empresaAct[':link_site']);
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/login');
        }
        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $resulifood = $this->marketplace->getById(1);


        $this->load('_admin/pedidos/novo', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
            'usuarioLogado' => $resulUsuario,
            'moeda' => $moeda,
            'estabelecimento' => $estabelecimento,
            'nivelUsuario' => $SessionNivel,
            'statusiFood' => $resulifood,
            'pedidos' => $resultPedidos,
            'planoAtivo' => $planoAtivo,
            'produto' => $resultProdutos,
            'categoria' => $resultCategorias,
            'clientes' => $resultClientes,
            'motoboy' => $resultMotoboy,
            'caixa' => $resulCaixa
        ]);
    }


    public function start($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $sessionFactory = new \Aura\Session\SessionFactory;

        $session = $sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $segment->set('Pedidoid_cliente', Input::post('cliente'));
        $segment->set('PedidoTipoEntrega', Input::post('switch'));

        echo "Carrinho Interno iniciado";
    }


    public function produtos($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $estabelecimento = $this->allController->verificaEstabelecimento($empresaAct[':id']);;;
        $resultPedidos = $this->adminVendasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultClientes = $this->adminUsuarioModel->getClientes();

        $resultProdutos = $this->adminProdutosModel->getAllPorEmpresa($empresaAct[':id']);
        $resultCategorias = $this->adminCategoriasModel->getAllPorEmpresa($empresaAct[':id']);

        $resultMotoboy = $this->adminUsuarioModel->getMotoboy();

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionPedidoid_cliente = $segment->get('Pedidoid_cliente');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $resulUsuario = $this->adminUsuarioModel->getById($SessionIdUsuario);
            if ($resulUsuario[':nivel'] == 3) {
                redirect(BASE . $empresaAct[':link_site']);
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/login');
        }
        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $resulifood = $this->marketplace->getById(1);

        $resultCarrinhoQtd = $this->adminCarrinhoModel->carrinhoQtdList($SessionPedidoid_cliente,$empresaAct[':id']);
        $resultCarrinhoProdutos = $this->adminCarrinhoModel->getAllByCliente($SessionPedidoid_cliente,$empresaAct[':id']);
        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);
        $this->allController->verificaAdmin($empresaAct[':id']);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/pedidos/novoProduto', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
            'usuarioLogado' => $resulUsuario,
            'moeda' => $moeda,
            'estabelecimento' => $estabelecimento,
            'pedidos' => $resultPedidos,
            'planoAtivo' => $planoAtivo,
            'carrinhoqtd' => $resultCarrinhoQtd,
            'carrinhoItens' => $resultCarrinhoProdutos,
            'nivelUsuario' => $SessionNivel,
            'statusiFood' => $resulifood,
            'produto' => $resultProdutos,
            'categoria' => $resultCategorias,
            'clientes' => $resultClientes,
            'motoboy' => $resultMotoboy,
            'caixa' => $resulCaixa
        ]);
    }

    public function produtoMostrar($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultProduto = $this->adminProdutosModel->getById($data['id']);
        $resultProdutosAdicionais = $this->adminProdutosAdicionaisModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->adminProdutosSaboresModel->getAllPorEmpresa($empresaAct[':id']);

        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $resulifood = $this->marketplace->getById(1);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionPedidoid_cliente = $segment->get('Pedidoid_cliente');
        $resultCarrinho = $this->adminCarrinhoModel->getAll($SessionPedidoid_cliente);


        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);
        $this->allController->verificaAdmin($empresaAct[':id']);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/pedidos/produtoMostrar', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            'moeda' => $moeda,
            'caixa' => $resulCaixa,
            'produto' => $resultProduto,
            'planoAtivo' => $planoAtivo,
            'carrinho' => $resultCarrinho,
            'statusiFood' => $resulifood,
            'produtoAdicional' => $resultProdutosAdicionais,
            'produtoSabores' => $resultSabores,
            'chave' => md5(uniqid(rand(), true)),
            
            'id_cliente' => $SessionPedidoid_cliente
        ]);
    }

    public function carrinho($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        $Sessionnumero_pedido = $segment->get('numero_pedido');
        $SessionPedidoid_cliente = $segment->get('Pedidoid_cliente');
        $SessionPedidoTipoEntrega = $segment->get('PedidoTipoEntrega');


        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        //$resultDias = $this->diasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultCategoria = $this->adminCategoriasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutos = $this->adminProdutosModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutoAdicional = $this->adminProdutosAdicionaisModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->adminProdutosSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->adminTipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->adminPagamentoModel->getAllPorEmpresa($empresaAct[':id']);

        $resultCarrinho = $this->adminCarrinhoModel->getAllCarrinho($SessionPedidoid_cliente,$empresaAct[':id']);
        $resultVenda = $this->adminVendasModel->getVenda($SessionPedidoid_cliente);
        $resultCarrinhoAdicional = $this->carrinhoAdicionalModel->getItensPedido($SessionPedidoid_cliente,$empresaAct[':id']);
        $resultSoma = $this->adminCarrinhoModel->somaCarrinho($SessionPedidoid_cliente,$empresaAct[':id']);
        $resultSomaAdicional = $this->carrinhoAdicionalModel->somaCarrinhoAdicional($SessionPedidoid_cliente,$empresaAct[':id']);

        $valorCarrinho = ((float) $resultSoma['total'] + (float) $resultSomaAdicional['total']);

        $resultCarrinhoQtd = $this->adminCarrinhoModel->carrinhoQtdList($SessionPedidoid_cliente,$empresaAct[':id']);
        if ($resultCarrinhoQtd == 0) {
            redirect(BASE . $empresaAct[':link_site']);
        }

        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);
        $this->allController->verificaAdmin($empresaAct[':id']);
        $resulifood = $this->marketplace->getById(1);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/pedidos/carrinhoMostrarProdutos', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
            'moeda' => $moeda,
            'estados' => $resultEstados,
            'delivery' => $resultDelivery,
            'carrinho' => $resultCarrinho,
            'preVenda' => $resultVenda,
            'nivelUsuario' => $SessionNivel,
            'statusiFood' => $resulifood,
            'carrinhoAdicional' => $resultCarrinhoAdicional,
            'produtos' => $resultProdutos,
            'adicionais' => $resultProdutoAdicional,
            'sabores' => $resultSabores,
            'tipo' => $resultTipo,
            'planoAtivo' => $planoAtivo,
            'pagamento' => $resultPagamento,
            'tipo_frete' => $SessionPedidoTipoEntrega,
            'numero_pedido' => $Sessionnumero_pedido,
            'valorPedido' => $valorCarrinho,
            'carrinhoQtd' => $resultCarrinhoQtd,
        ]);
    }


    public function carrinhoFinalizar($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        $Sessionnumero_pedido = $segment->get('numero_pedido');
        $SessionPedidoid_cliente = $segment->get('Pedidoid_cliente');
        $SessionPedidoTipoEntrega = $segment->get('PedidoTipoEntrega');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultCategoria = $this->adminCategoriasModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutos = $this->adminProdutosModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutoAdicional = $this->adminProdutosAdicionaisModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->adminProdutosSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->adminTipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->adminPagamentoModel->getAllPorEmpresa($empresaAct[':id']);

        $resultCarrinho = $this->adminCarrinhoModel->getAllCarrinho($SessionPedidoid_cliente,$empresaAct[':id']);
        $resultVenda = $this->adminVendasModel->getVenda($SessionPedidoid_cliente);
        $resultCarrinhoAdicional = $this->carrinhoAdicionalModel->getItensPedido($SessionPedidoid_cliente,$empresaAct[':id']);
        $resultSoma = $this->adminCarrinhoModel->somaCarrinho($SessionPedidoid_cliente,$empresaAct[':id']);
        $resultSomaAdicional = $this->carrinhoAdicionalModel->somaCarrinhoAdicional($SessionPedidoid_cliente,$empresaAct[':id']);

        $resultEnderecos = $this->adminEnderecoModel->getByIdPedido($SessionPedidoid_cliente);


        $calcFret = $this->calculoFrete->calculo($resultEnderecos[':rua'], $resultEnderecos[':numero'], $resultEnderecos[':bairro'], $resultEnderecos[':cep'], $empresaAct[':id']);
        $taxa_entrega = $resultDelivery[':taxa_entrega'];
        $km_entrega = $resultDelivery[':km_entrega'] * 1000;
        $km_entrega_excedente = $resultDelivery[':km_entrega_excedente'] * 1000;
        $valor_excedente = $resultDelivery[':valor_excedente'];

        if ($calcFret <= $km_entrega) {
            $total = $taxa_entrega;
        } else if ($calcFret > $km_entrega && $calcFret <= $km_entrega_excedente) {
            $kmACalcular = ($calcFret - $km_entrega);
            $freteVezes = ($kmACalcular * $valor_excedente);
            $taxa_entregaNova = $taxa_entrega + $freteVezes;
            $total = $taxa_entregaNova;
        }

        $valorCarrinho = ((float) $resultSoma['total'] + (float) $resultSomaAdicional['total']);

        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);
        $this->allController->verificaAdmin($empresaAct[':id']);
        $resulifood = $this->marketplace->getById(1);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/pedidos/novoDetalhes', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
            'moeda' => $moeda,
            'estados' => $resultEstados,
            'planoAtivo' => $planoAtivo,
            'delivery' => $resultDelivery,
            'carrinho' => $resultCarrinho,
            'nivelUsuario' => $SessionNivel,
            'statusiFood' => $resulifood,
            'preVenda' => $resultVenda,
            'carrinhoAdicional' => $resultCarrinhoAdicional,
            'produtos' => $resultProdutos,
            'adicionais' => $resultProdutoAdicional,
            'sabores' => $resultSabores,
            'tipo' => $resultTipo,
            'pagamento' => $resultPagamento,
            'tipo_frete' => $SessionPedidoTipoEntrega,
            'calculoFrete' => $total,
            'numero_pedido' => $Sessionnumero_pedido,
            'valorPedido' => $valorCarrinho,
            'endereco' => $resultEnderecos,
            'km' => $calcFret
        ]);
    }

    //Adiciona o item ao carrinho e verifica se existe mais um passo para esse pedido
    public function carrinhoCheckout()
    {
        $carrinho = $this->getInput();

        $id_carrinhoUp = $this->adminCarrinhoModel->getByChave(Input::get('chave'));

        if ($id_carrinhoUp[':id']) {
            $result = $this->adminCarrinhoModel->updateProduto($carrinho);
        } else {
            $result = $this->adminCarrinhoModel->insert($carrinho);

            $id_carrinhoUp = $this->adminCarrinhoModel->getByChave(Input::get('chave'));
            echo $id_carrinhoUp[':id'];
        }

        $vendaProduto = $this->getInputVendasMais();
        $result2 = $this->adminProdutosModel->updateVendas($vendaProduto);
    }

    // Atualiza o item do carrinho e verifica se existe item adicional
    public function carrinhoCheckoutUpdate()
    {
        $tipoAdicional = Input::post('tipoAdicional');
        $carrinho = $this->getInputUp();
        $vendaProduto = $this->getInputVendasMais();
        $vendaProdutoMenos = $this->getInputVendasMenos();

        $result = $this->adminCarrinhoModel->update($carrinho);
        $result2 = $this->adminProdutosModel->updateVendas($vendaProdutoMenos);
        $result3 = $this->adminProdutosModel->updateVendas($vendaProduto);

        if ($tipoAdicional != null) {
            if ($result > 0) {
                echo 'Seu produto foi atualizado na sacola aguarde que tem mais!';
            } else {
                echo 'Erro ao atualizar seu carrinho';
            }
        } else {
            if ($result > 0) {
                echo 'Seu produto foi atualizado na Sacola!';
            } else {
                echo 'Erro ao atualiz seu carrinho';
            }
        }
    }


    //Cadastra, Deleta ou Atualiza item adicional
    public function addCarrinhoCheckoutAdicional($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $quantidade = Input::get('quantidade');
        $chave = Input::get('chave');
        if ($quantidade > 0) {

            $id_adicional = Input::get('id_adicional');
            $id_produto = Input::get('id_produto');

            $verificaCadastro = $this->carrinhoAdicionalModel->checkById($id_adicional, $chave, $id_produto);
            if ($verificaCadastro == 0) {
                $adicional = $this->getInputAdcional();
                //dd($adicional);
                $result = $this->carrinhoAdicionalModel->insert($adicional);
            } else {
                $adicional = $this->getInputUpdateAdcional();
                //dd($adicional);
                $result = $this->carrinhoAdicionalModel->update($adicional);
            }
            if ($result > 0) {
                echo 'Adicional Cadastrado!';
            } else {
                echo 'Erro ao adicionar Adicional';
            }
        } else {
            $id_adicional = Input::get('id_adicional');
            $id_produto = Input::get('id_produto');
            $resultCarrinhoAdicional = $this->carrinhoAdicionalModel->getById($id_adicional, $chave, $id_produto);
            $result = $this->carrinhoAdicionalModel->delete($resultCarrinhoAdicional[':id']);

            if ($result > 0) {
                echo 'Adicional Deletado!';
            } else {
                echo 'Erro ao Deletar Adicional';
            }
        }
    }

    //Cadastra, Deleta ou Atualiza item adicional
    public function removeCarrinhoCheckoutAdicional($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $chave = Input::get('chave');
        $id_carrinho = Input::get('id_carrinho');
        $id_adicional = Input::get('id_adicional');
        $id_cliente = Input::get('id_cliente');

        $resultSoma = $this->carrinhoAdicionalModel->somaCarrinhoAdicionalIsolado($chave, $id_carrinho, $id_adicional, $id_cliente, $empresaAct[':id']);
        $result = $this->carrinhoAdicionalModel->deleteChave($chave, $id_carrinho, $id_adicional, $id_cliente, $empresaAct[':id']);

        if ($resultSoma > 0) {
            echo $resultSoma['total'];
        } else {
            echo 'Erro ao Deletar Adicional';
        }
    }

    //Inicia a PreVenda
    public function carrinhoCheckoutFinal()
    {
        $carrinhoUp = $this->getInputUpdateCart();

        $result = $this->adminCarrinhoModel->updateFinalInterno($carrinhoUp);

        if ($result > 0) {
            echo 'Produto Adicionado ao carrinho';
        } else {
            echo 'Vixi Vai ficar ai mesmo';
        }
    }

    //Finaliza e fecha o pedido do cliente
    public function carrinhoFinalizarPedido($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $pedido = $this->getFinalizaPedido();
        $pedidoCarrinho = $this->getFinalizaPedidoCarrinho();
        $result = $this->adminVendasModel->insert($pedido);
        $result2 = $this->adminCarrinhoModel->updateFinalPedido($pedidoCarrinho);
        $result3 = $this->carrinhoAdicionalModel->updateFinalPedido($pedidoCarrinho);
        if (Input::post('cpf') != null) {
            $nfPaulista = $this->getCPFNota();
            $result4 = $this->carrinhoNFPaulistaModel->insert($nfPaulista);
        }

        if ($result > 0) {
            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');

            $segment->set('Pedidoid_cliente', null);
            $segment->set('PedidoTipoEntrega', null);
            echo 'Pedido Finalizado com sucesso!';
        } else {
            echo 'Erro ao finalizar o pedido';
        }
    }


    /**
     * //////////////////////////////////////////////////////////////////////////////////////////
     * ///////////////////////////////////  SESSÃO DELETE  //////////////////////////////////////
     * //////////////////////////////////////////////////////////////////////////////////////////
     */

    //Deletar Item do carrinho
    public function deletarItemCarrinho($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionPedidoid_cliente = $segment->get('Pedidoid_cliente');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $resultUsuario = $this->adminUsuarioModel->getById($SessionIdUsuario);
        /**
         * Diminuir a quantidade de venda do produto
         */
        $resultProduto = $this->adminProdutosModel->getById($data['id_produto']);
        $resultCarrinho = $this->adminCarrinhoModel->getById($data['id_carrinho']);

        $novoTotalVendasProduto = $resultProduto[':vendas'] - $resultCarrinho[':quantidade'];

        $result3 = $this->carrinhoAdicionalModel->deleteCart($data['id_produto'], $data['id_carrinho']);

        $result2 = $this->adminProdutosModel->updateVendasMenos($data['id_produto'], $novoTotalVendasProduto);
        $result = $this->adminCarrinhoModel->delete($data['id_carrinho']);

        if ($result > 0) {
            echo 'Seu item foi removido de sua Sacola!';
            redirect(BASE . $empresaAct[':link_site'] . '/admin/pedido/novo/produtos');
        } else {
            echo 'Não foi posível remover seu item!';
            redirect(BASE . $empresaAct[':link_site'] . '/admin/pedido/novo/produtos');
        }
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////////////////
     * ///////////////////////////////////  SESSÃO [GET] [POST] DADOS  //////////////////////////////////////
     * //////////////////////////////////////////////////////////////////////////////////////////////////////
     */

    //Retorna os dados do formulário em uma classe padrão stdObject
    private function getInputUpdateAdcional()
    {

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $Sessionnumero_pedido = $segment->get('numero_pedido');

        $id_adicional = Input::get('id_adicional');
        $chave = Input::get('chave');
        $id_produto = Input::get('id_produto');

        $resultCarrinhoAdicional = $this->carrinhoAdicionalModel->getByIdChave($id_adicional, $chave, $id_produto);

        return (object) [
            'id' => $resultCarrinhoAdicional[':id'],
            'chave' => Input::get('chave'),
            'id_produto' => Input::get('id_produto'),
            'id_cliente' => Input::get('id_cliente'),
            'id_carrinho' => Input::get('id_carrinho'),
            'id_adicional' => Input::get('id_adicional'),
            'valor' => Input::get('valor'),
            'quantidade' => Input::get('quantidade'),
            'numero_pedido' => $Sessionnumero_pedido,
            'chave' => Input::get('chave'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Retorna os dados do formulário em uma classe padrão stdObject
    private function getInputAdcional()
    {
        return (object) [
            'id_produto' => Input::get('id_produto'),
            'id_cliente' => Input::get('id_cliente'),
            'id_carrinho' => Input::get('id_carrinho'),
            'id_adicional' => Input::get('id_adicional'),
            'valor' => Input::get('valor'),
            'quantidade' => Input::get('quantidade'),
            'chave' => Input::get('chave'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Retorna os dados do formulário em uma classe padrão stdObject
    private function getInputPreVenda()
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        return (object) [
            'id_cliente' => $SessionIdUsuario,
            'total' => Input::post('valorFinal'),
            'status' => 0,
            'pago' => 0,
            'motoboy' => 0,
            'chave' => Input::post('chave'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }


    //Retorna os dados do formulário em uma classe padrão stdObject
    private function getInputUp()
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        $adicionalSt = $_POST['adicional'];
        if ($adicionalSt != null) {
            $adicionalSelecionados = implode(',', $adicionalSt);
        }

        $saborSt = $_POST['sabores'];
        if ($saborSt != null) {
            $saborSelecionados = implode(',', $saborSt);
        }

        return (object) [
            'id' => Input::post('id_carrinho', FILTER_SANITIZE_NUMBER_INT),
            'id_produto' => Input::post('id_produto'),
            'id_cliente' => $SessionIdUsuario,
            'quantidade' => Input::post('quantity'),
            'id_adicional' => $adicionalSelecionados,
            'id_sabores' => $saborSelecionados,
            'observacao' => Input::post('observacao'),
            'valor' => Input::post('valor'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega os dados
    private function getInput()
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('Pedidoid_cliente');
        $Sessionnumero_pedido = $segment->get('numero_pedido');

        $adicionalSt = $_GET['adicional'];
        if ($adicionalSt != null) {
            $adicionalSelecionados = implode(',', $adicionalSt);
        }

        $saborSt = $_GET['sabores'];
        if ($saborSt != null) {
            $saborSelecionados = implode(',', $saborSt);
        }

        $id_carrinhoUp = $this->adminCarrinhoModel->getByChave(Input::get('chave'));

        if ($id_carrinhoUp[':id']) {
            $id_carrinho = $id_carrinhoUp[':id'];
        } else {
            $id_carrinho = Input::get('id');
        }

        return (object) [
            'id' => $id_carrinho,
            'id_produto' => Input::get('id_produto'),
            'id_cliente' => $SessionIdUsuario,
            'quantidade' => Input::get('quantidade'),
            'id_adicional' => $adicionalSelecionados,
            'id_sabores' => $saborSelecionados,
            'observacao' => Input::get('observacao'),
            'valor' => Input::get('valor'),
            'chave' => Input::get('chave'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega os dados para fazer update na tabela [produtos] acrescentando mais itens ao numero de vendas feitas para determinado produto
    private function getInputVendasMais()
    {
        $qtd = Input::get('quantity');
        $id = Input::get('id_produto');

        $produto = $this->adminProdutosModel->getById($id);
        $novoTotal = $produto[':vendas'] + $qtd;

        return (object) [
            'id' => $id,
            'vendas' => $novoTotal,
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega os dados para fazer update na tabela [produtos] acrescentando mais itens ao numero de vendas feitas para determinado produto
    private function getInputVendasMenos()
    {
        $qtd = Input::get('quantidadeAnterior');
        $id = Input::get('id_produto');

        $produto = $this->adminProdutosModel->getById($id);
        $novoTotal = $produto[':vendas'] - $qtd;

        return (object) [
            'id' => $id,
            'vendas' => $novoTotal,
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega os dados do formulário em uma classe padrão stdObject
    private function getInputUpdateCart()
    {
        $adicionalSt = $_POST['adicional'];
        $adicionalSelecionados = implode(',', $adicionalSt);

        $saboresSt = $_POST['sabores'];
        $saboresSelecionados = implode(',', $saboresSt);


        return (object) [
            'id' => Input::post('id_carrinho', FILTER_SANITIZE_NUMBER_INT),
            'id_adicional' => $adicionalSelecionados,
            'id_sabores' => $saboresSelecionados,
            'observacao' => Input::post('observacao'),
            'chave' => Input::post('chave'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega todos os dados do carrinho para fechar o PEDIDO do cliente [Ultimo processo que o usuario irá fazer para concluir o pedido]
    private function getFinalizaPedido()
    {
        $empresaAct = $this->configEmpresaModel->getById(Input::post('id_empresa'));
        $resultiPedido = $this->adminVendasModel->getUll($empresaAct[':id']);
        $numero_pedido = date('y' . 'm' . 'd');

        if (substr($resultiPedido[':numero_pedido'], 0, 6) == $numero_pedido) {
            $numero_pedido = $resultiPedido[':numero_pedido'] + 1;
        } else {
            $numero_pedido = date('y' . 'm' . 'd') . 1;
        }


        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_cliente');
        $Sessionnumero_pedido = $segment->get('numero_pedido');
        $SessionPedidoid_cliente = $segment->get('Pedidoid_cliente');

        $resultSoma = $this->adminCarrinhoModel->somaCarrinho($SessionPedidoid_cliente, $empresaAct[':id']);
        $resultSomaAdicional = $this->carrinhoAdicionalModel->somaCarrinhoAdicional($SessionPedidoid_cliente, $empresaAct[':id']);

        $resultid_caixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $valorCarrinho = ((float) $resultSoma['total'] + (float) $resultSomaAdicional['total']);



        return (object) [
            'id_caixa' => $resultid_caixa[':id'],
            'id_cliente' => $SessionPedidoid_cliente,
            'total' => $valorCarrinho,
            'total_pago' => Input::post('total_pago'),
            'troco' => Input::post('troco'),
            'tipo_pagamento' => Input::post('tipo_pagamento'),
            'tipo_frete' => Input::post('tipo_frete'),
            'data' => date('Y-m-d'),
            'hora' => date('H:i:s'),
            'status' => 1,
            'pago' => 0,
            'observacao' => Input::post('observacao'),
            'numero_pedido' => $numero_pedido,
            'valor_frete' => Input::post('valor_frete'),
            'km' => Input::post('km'),
            'motoboy' => 0,
            'chave' => md5(uniqid(rand(), true)),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega o Número do pedido gerado na pagina de finalizar pedido e altera os itens nas tabelas [cartCarrinho] e [cartCarrinhoAdicional]
    private function getFinalizaPedidoCarrinho()
    {
        $empresaAct = $this->configEmpresaModel->getById(Input::post('id_empresa'));
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionPedidoid_cliente = $segment->get('Pedidoid_cliente');

        $resultiPedido = $this->adminVendasModel->getUll($empresaAct[':id']);
        $numero_pedido = date('y' . 'm' . 'd');

        if (substr($resultiPedido[':numero_pedido'], 0, 6) == $numero_pedido) {
            $numero_pedido = $resultiPedido[':numero_pedido'] + 1;
        } else {
            $numero_pedido = date('y' . 'm' . 'd') . 1;
        }

        return (object) [
            'id_cliente' => $SessionPedidoid_cliente,
            'numero_pedido' => $numero_pedido,
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    private function getCPFNota()
    {
        $empresaAct = $this->configEmpresaModel->getById(Input::post('id_empresa'));
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionPedidoid_cliente = $segment->get('Pedidoid_cliente');

        $resultiPedido = $this->adminVendasModel->getUll($empresaAct[':id']);
        $numero_pedido = date('y' . 'm' . 'd');

        if (substr($resultiPedido[':numero_pedido'], 0, 6) == $numero_pedido) {
            $numero_pedido = $resultiPedido[':numero_pedido'] + 1;
        } else {
            $numero_pedido = date('y' . 'm' . 'd') . 1;
        }

        return (object) [
            'numero_pedido' => $numero_pedido,
            'id_cliente' => $SessionPedidoid_cliente,
            'cpf' => Input::post('cpf'),
            'data' => date('Y-m-d H:i:s'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}
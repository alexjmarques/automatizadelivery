<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Preferencias;
use app\classes\CalculoFrete;
use app\core\Controller;
use app\Models\AdminCaixaModel;
use app\controller\AllController;
use app\Models\AdminCategoriaModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;
use app\Models\AdminConfigFreteModel;
use app\Models\AdminPagamentoModel;
use app\Models\AdminProdutoAdicionalModel;
use app\Models\AdminProdutoModel;
use app\Models\AdminCupomModel;
use app\Models\AdminCupomUtilizacoesModel;
use app\Models\AdminProdutoSaborModel;
use app\Models\AdminTipoModel;
use app\Models\CarrinhoAdicionalModel;
use app\Models\CarrinhoNFPaulistaModel;
use app\Models\PedidosPagamentoModel;
use app\Models\AdminTipoAdicionalModel;
use app\Models\CarrinhoModel;
use app\Models\DiasModel;
use app\Models\EnderecosModel;
use app\Models\EstadosModel;
use app\Models\MoedaModel;
use app\Models\UsuarioModel;
use app\Models\VendasModel;
use Aura\Session\SessionFactory;
use function JBZoo\Data\json;
use app\classes\Cache;
use Twilio\Rest\Client;
use Bcrypt\Bcrypt;

class CarrinhoController extends Controller
{
    private $configEmpresaModel;
    private $deliveryModel;
    private $moedaModel;
    private $categoriaModel;
    private $produtoModel;
    private $diasModel;
    private $usuarioModel;
    private $enderecosModel;
    private $estadosModel;
    private $produtoAdicionalModel;
    private $produtoSaboresModel;
    private $carrinhoModel;
    private $pagamentoModel;
    private $allController;
    private $tipoModel;
    private $carrinhoAdicionalModel;
    private $vendasModel;
    private $adminCaixaModel;
    private $pedidosPagamentoModel;
    private $sessionFactory;
    private $carrinhoNFPaulistaModel;
    private $adminTipoAdicionalModel;
    private $calculoFrete;
    private $preferencias;
    private $cupom;
    private $cache;
    private $smsClass;
    private $cupomUtilizacoes;

    public function __construct()
    {
        $this->cache = new Cache();
        //$this->smsClass = new Client();
        $this->diasModel = new DiasModel();
        $this->moedaModel = new MoedaModel();
        $this->cupom = new AdminCupomModel();
        $this->vendasModel = new VendasModel();
        $this->tipoModel = new AdminTipoModel();
        $this->estadosModel = new EstadosModel();
        $this->usuarioModel = new UsuarioModel();
        $this->calculoFrete = new CalculoFrete();
        $this->preferencias = new Preferencias();
        $this->carrinhoModel = new CarrinhoModel();
        $this->allController = new AllController();
        $this->sessionFactory = new SessionFactory();
        $this->enderecosModel = new EnderecosModel();
        $this->produtoModel = new AdminProdutoModel();
        $this->adminCaixaModel = new AdminCaixaModel();
        $this->pagamentoModel = new AdminPagamentoModel();
        $this->categoriaModel = new AdminCategoriaModel();
        $this->deliveryModel = new AdminConfigFreteModel();
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
        $this->produtoSaboresModel = new AdminProdutoSaborModel();
        $this->pedidosPagamentoModel = new PedidosPagamentoModel();
        $this->cupomUtilizacoes = new AdminCupomUtilizacoesModel();
        $this->carrinhoAdicionalModel = new CarrinhoAdicionalModel();
        $this->carrinhoNFPaulistaModel = new CarrinhoNFPaulistaModel();
        $this->adminTipoAdicionalModel = new AdminTipoAdicionalModel();
        $this->produtoAdicionalModel = new AdminProdutoAdicionalModel();
    }

    /**
     * //////////////////////////////////////////////////////////////////////////////////////////
     * ///////////////////////////////////  PAGINAS  ////////////////////////////////////////////
     * //////////////////////////////////////////////////////////////////////////////////////////
     */

    //  PAGINA - Produto { NOVO }
    public function index($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultDias = $this->diasModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutos = $this->produtoModel->getById($data['id']);
        $resultUsuario = $this->usuarioModel->getAll();
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resulTipoAdicional = $this->adminTipoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);

        if ($SessionIdUsuario != null) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario, $empresaAct[':id']);
        }

        $resultchave = md5(uniqid(rand(), true));

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('produto/main', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'categoria' => $resultCategoria,
            'produto' => $resultProdutos,
            'produtoAdicional' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'dias' => $resultDias,
            'usuario' => $resultUsuario,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'chave' => $resultchave,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'sessaoLogin' =>  $SessionIdUsuario,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    //  PAGINA - Produto { EDITAR }
    public function carrinhoProdutoEditar($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        $Sessionnumero_pedido = $segment->get('numero_pedido');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultDias = $this->diasModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);

        $resultProduto = $this->produtoModel->getById($data['id_produto']);
        $resultCarrinho = $this->carrinhoModel->getById($data['id_carrinho']);

        $resultUsuario = $this->usuarioModel->getAll();
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resulTipoAdicional = $this->adminTipoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);

        if (isset($SessionIdUsuario)) {
            $resultVendas = $this->vendasModel->getAllUser($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario, $empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultchave = md5(uniqid(rand(), true));


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('produto/editar', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'categoria' => $resultCategoria,
            'produto' => $resultProduto,
            'carrinho' => $resultCarrinho,
            'produtoAdicional' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'dias' => $resultDias,
            'usuario' => $resultUsuario,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'vendas' => $resultVendas,
            'chave' => $resultchave,
            'numero_pedido' => $Sessionnumero_pedido,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }





    //  PAGINA - Carrinho Finalizar Pedido
    public function carrinho($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        $segment->set('numero_pedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));
        $Sessionnumero_pedido = $segment->get('numero_pedido');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);

        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultDias = $this->diasModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);

        if (isset($SessionIdUsuario)) {

            if ($SessionIdUsuario == 0) {
                redirect(BASE . $empresaAct[':link_site'] . '/carrinho/dados');
            }
            $resultUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinho = $this->carrinhoModel->getAllCarrinho($SessionIdUsuario, $empresaAct[':id']);
            $resultVenda = $this->vendasModel->getVenda($SessionIdUsuario);
            $resultVendasFeitas = $this->vendasModel->getVendasFeitas($SessionIdUsuario);
            $resultEnderecos = $this->enderecosModel->getByIdPedido($resultUsuario[':id']);
            $resultCarrinhoAdicional = $this->carrinhoAdicionalModel->getItensPedido($SessionIdUsuario, $empresaAct[':id']);
            $resultSoma = $this->carrinhoModel->somaCarrinho($SessionIdUsuario, $empresaAct[':id']);
            $resultSomaAdicional = $this->carrinhoAdicionalModel->somaCarrinhoAdicional($SessionIdUsuario, $empresaAct[':id']);
            $valorCarrinho = ((float) $resultSoma['total'] + (float) $resultSomaAdicional['total']);
            $cFrete = $this->calculoFrete->calculo($resultEnderecos[':rua'], $resultEnderecos[':numero'], $resultEnderecos[':bairro'], $resultEnderecos[':cep'], $empresaAct[':id']);
            $infoKm = $this->calculoFrete->infoKm($resultEnderecos[':rua'], $resultEnderecos[':numero'], $resultEnderecos[':bairro'], $resultEnderecos[':cep'], $empresaAct[':id']);
            $taxa_entrega = $resultDelivery[':taxa_entrega'];
            $km_entrega = $resultDelivery[':km_entrega'] * 1000;
            $km_entrega_excedente = $resultDelivery[':km_entrega_excedente'] * 1000;
            $valor_excedente = $resultDelivery[':valor_excedente'];

            if ($cFrete <= $km_entrega) {
                $total = $taxa_entrega;
            } else if ($cFrete > $km_entrega && $cFrete <= $km_entrega_excedente) {
                $kmACalcular = (round($infoKm) - $resultDelivery[':km_entrega']);
                $freteVezes = ($kmACalcular * $valor_excedente);
                $taxa_entregaNova = $taxa_entrega + $freteVezes;
                $total = $taxa_entregaNova;
            }

            if ($resultDelivery[':frete_status'] == 1) {
                if ($resultDelivery[':valor'] <= $valorCarrinho) {
                    $total = 0;
                }
            }

            if ($resultDelivery[':primeira_compra'] == 1) {
                if ($resultVendasFeitas == 0) {
                    $total = 0;
                }
            }


            $cupomVerifica = $this->cupomUtilizacoes->getCountVerifica($SessionIdUsuario, $empresaAct[':id']);
            if ($cupomVerifica > 0) {
                $cupomUtilizacoesId = $this->cupomUtilizacoes->getByUser($SessionIdUsuario, $empresaAct[':id']);
                $cupomValida = $this->cupom->getById($cupomUtilizacoesId[':id_cupom']);
                if ((int)$cupomValida[':tipo_cupom'] == 1) {
                    $valor = $valorCarrinho;
                    $porcentagem = floatval($cupomValida[':valor_cupom']);
                    $resul = $valor * ($porcentagem / 100);
                    $resultado = $resul;
                } else {
                    $resultado = $cupomValida[':valor_cupom'];
                }
                $valorCarrinho = $valorCarrinho - $resultado;
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario, $empresaAct[':id']);
        if ($resultCarrinhoQtd == 0) {
            redirect(BASE . $empresaAct[':link_site']);
        }
        $resultchave = md5(uniqid(rand(), true));

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/carrinho/main', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'usuario' => $resultUsuario,
            'endereco' => $resultEnderecos,
            'estados' => $resultEstados,
            'delivery' => $resultDelivery,
            'deliveryEntregaExcedente' => $resultDelivery[':km_entrega_excedente'] * 1000,
            'carrinho' => $resultCarrinho,
            'preVenda' => $resultVenda,
            'carrinhoAdicional' => $resultCarrinhoAdicional,
            'produtos' => $resultProdutos,
            'adicionais' => $resultProdutoAdicional,
            'sabores' => $resultSabores,
            'tipo' => $resultTipo,
            'pagamento' => $resultPagamento,
            'chave' => $resultchave,
            'km' => $cFrete,
            'numero_pedido' => $Sessionnumero_pedido,
            'valorPedido' => $valorCarrinho,
            'calculoFrete' => $total,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'cupomVerifica' => $cupomVerifica,
            'cupomValor' => $resultado,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }


    public function carrinhoValidaCupom($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $cupomValida = $this->cupom->getByCode(Input::get('cupomDesconto'), $empresaAct[':id']);
        $cupomValidaCount = $this->cupom->getCount(Input::get('cupomDesconto'), $empresaAct[':id']);

        if ($cupomValidaCount <= 0) {
            echo 'Cupom de desconto inválido';
        } else {
            //Verifica se pode utilizar esse cupom novamente
            $cupomValidaUtil = $this->cupomUtilizacoes->getCount($SessionIdUsuario, Input::get('cupomDesconto'), $empresaAct[':id']);
            if ($cupomValidaUtil != 0) {
                if ($cupomValida[':qtd_utilizacoes'] >= $$cupomValidaUtil) {
                    echo 'Você excedeu o número de vezes para utilização deste Cupom';
                    exit;
                }
            }

            $resultSoma = $this->carrinhoModel->somaCarrinho($SessionIdUsuario, $empresaAct[':id']);
            $resultSomaAdicional = $this->carrinhoAdicionalModel->somaCarrinhoAdicional($SessionIdUsuario, $empresaAct[':id']);

            $valorCarrinho = ((float) $resultSoma['total'] + (float) $resultSomaAdicional['total']);

            if ((int)$cupomValida[':tipo_cupom'] == 1) {
                $valor = $valorCarrinho;
                $porcentagem = floatval($cupomValida[':valor_cupom']);
                $resul = $valor * ($porcentagem / 100);
                $resultado = $resul;
            } else {
                $resultado = $cupomValida[':valor_cupom'];
            }
            $this->cupomUtilizacoes->insert($SessionIdUsuario, $cupomValida[':id'], date('Y-m-d H:i:s'), $empresaAct[':id']);
            echo $resultado;
        }
    }


    public function carrinhoVisitante($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        $Sessionnumero_pedido = $segment->get('numero_pedido');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultDias = $this->diasModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resultTipo = $this->tipoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultPagamento = $this->pagamentoModel->getAllPorEmpresa($empresaAct[':id']);
        $resulTipoAdicional = $this->adminTipoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);

        if (isset($SessionIdUsuario)) {
            $resultUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinho = $this->carrinhoModel->getAllCarrinho($SessionIdUsuario, $empresaAct[':id']);
            $resultVenda = $this->vendasModel->getVenda($SessionIdUsuario);
            $resultEnderecos = $this->enderecosModel->getByIdPedido($resultUsuario[':id']);

            $resultCarrinhoAdicional = $this->carrinhoAdicionalModel->getItensPedido($SessionIdUsuario, $empresaAct[':id']);

            $resultSoma = $SessionIdUsuario == 0 ? $this->carrinhoModel->somaCarrinhoVisitante($SessionIdUsuario, session_id(), $empresaAct[':id']) : $this->carrinhoModel->somaCarrinho($SessionIdUsuario, $empresaAct[':id']);

            $resultSomaAdicional = $SessionIdUsuario == 0 ? $this->carrinhoAdicionalModel->somaCarrinhoAdicionalVisitante($SessionIdUsuario, session_id(), $empresaAct[':id']) : $this->carrinhoModel->somaCarrinho($SessionIdUsuario, $empresaAct[':id']);

            $valorCarrinho = ((float) $resultSoma['total'] + (float) $resultSomaAdicional['total']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario, $empresaAct[':id']);
        if ($resultCarrinhoQtd == 0) {
            redirect(BASE . $empresaAct[':link_site']);
        }
        $resultchave = md5(uniqid(rand(), true));

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/carrinho/carrinho', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'usuario' => $resultUsuario,
            'endereco' => $resultEnderecos,
            'estados' => $resultEstados,
            'delivery' => $resultDelivery,
            'carrinho' => $resultCarrinho,
            'preVenda' => $resultVenda,
            'carrinhoAdicional' => $resultCarrinhoAdicional,
            'produtos' => $resultProdutos,
            'adicionais' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'sabores' => $resultSabores,
            'tipo' => $resultTipo,
            'pagamento' => $resultPagamento,
            'chave' => $resultchave,
            'numero_pedido' => $Sessionnumero_pedido,
            'valorPedido' => $valorCarrinho,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'sessao_id'  => session_id(),
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }


    public function carrinhoVisitanteCadastro($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $segment->set('numero_pedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/carrinho/cadastro', [
            'empresa' => $resultEmpresa,
            'trans' => $trans,
            'preferencias' => $this->preferencias

        ]);

    }

    public function carrinhoVisitanteCadastroValida($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $codeValida = $segment->get('codeValida');
        $segment->set('numero_pedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/carrinho/validaAcesso', [
            'empresa' => $resultEmpresa,
            'codeValida' => $segment->getFlash('codeValida'),
            'trans' => $trans,
            'preferencias' => $this->preferencias

        ]);
    }

    public function carrinhoValidaAcessoCode($data)
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $codeValida = $segment->get('codeValida');

        if($codeValida == $data['codeValida']){
            $resultUp = $this->usuarioModel->getByTelefone($data['telefone']);
            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');

            $_SESSION = array(
                'Vendor\Aura\Segment' => array(
                    'id_usuario' => $resultUp[':id'],
                    'usuario' => $resultUp[':email'],
                    'nivel' => $resultUp[':nivel'],
                    'numero_pedido' => substr(number_format(time() * Rand(), 0, '', ''), 0, 6),
                ),
            );
            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');
            $SessionIdUsuario = $segment->get('id_usuario');

            if (isset($SessionIdUsuario)) {
                $end = $this->getInputVisitante();
                $result = $this->carrinhoModel->updateVisitante($end);
                $result .= $this->carrinhoAdicionalModel->updateVisitante($end);
                if( $result > 0){
                    echo 'OK Vai para o carrinho';
                }else{
                    echo 'Oooops Algo de errado aconteceu!';
                }
            }
        }
    }

    public function carrinhoCadastro($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $usuario = $this->getInputCadastro();
        $getTelefone = $this->usuarioModel->verifyTelefoneCadastrado(Input::post('telefone'));
        if ($getTelefone > 0) {
            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');
            $segment->set('codeValida', substr(number_format(time() * Rand(), 0, '', ''), 0, 4));
            $codeValida = $segment->get('codeValida');

            $mensagem = $empresaAct[':nomeFantasia']. ": seu codigo de autorizacao e " . $codeValida . ". Por seguranca, nao o compartilhe com mais ninguem";
            $numeroTelefone = preg_replace('/[^0-9]/', '', Input::post('telefone'));
            $ddi = '+55';
            $numerofinal = $ddi . $numeroTelefone;

            //$resultado = $this->smsClass->envioSMS($numerofinal, $mensagem);

            $account_sid = 'AC3891f3248b6bd5bd3f299c1a89886814';
            $auth_token = '3ce669b5e06e3a12578e1824dc75f132';

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                $numerofinal,
                array(
                    'from' => '+19096555675',
                    'body' => $mensagem
                )
            );
            echo 'Enviamos em seu celular um código para validar seu acesso!';
            //dd($client);

            // if ($retorno->status == "success") {
            // } else {
            //     echo 'Não foi possivel enviar validação de senha, tente novamente mais tarde!';
            // }
            exit;
        } else {
            echo '';
        }

        $result = $this->usuarioModel->insert($usuario);
        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo usuario';
        } else {
            $getTelefone = Input::post('telefone');
            $resultUp = $this->usuarioModel->getByTelefone($getTelefone);
            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');

            $session->setCookieParams(array('lifetime' => '2592000'));
            $session->setCookieParams(array('path' => BASE . $empresaAct[':link_site'] . 'cache/session'));
            $session->setCookieParams(array('domain' => 'automatiza.app'));

            $_SESSION = array(
                'Vendor\Aura\Segment' => array(
                    'id_usuario' => $resultUp[':id'],
                    'usuario' => $resultUp[':email'],
                    'nivel' => $resultUp[':nivel'],
                    'numero_pedido' => substr(number_format(time() * Rand(), 0, '', ''), 0, 6),
                ),
            );
            echo 'Agora Cadastrar Endereço';
        }
    }

    public function carrinhoVisitanteEndereco($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $resultEstados = $this->estadosModel->getAll();
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

        $end = $this->getInputVisitante();
        $result = $this->carrinhoModel->updateVisitante($end);
        $result .= $this->carrinhoAdicionalModel->updateVisitante($end);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/carrinho/endereco', [
            'empresa' => $resultEmpresa,
            'nome' => $resulUsuario[':nome'],
            'enderecos' => $resultEstados,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function carrinhoEndereco($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $end = $this->getInputEndereco();
        $result = $this->enderecosModel->insert($end);

        if ($result <= 0) {
            echo 'Erro ao cadastrar seu primeiro endereço';
        } else {
            echo 'Pronto vamos finalizar';
        }
    }

    //  PAGINA - Produto Adicional { NOVO }
    public function carrinhoCheckoutAdicional($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultDias = $this->diasModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);
        $resultCarrinho = $this->carrinhoModel->getByChave($data['chave']);
        $resultProdutos = $this->produtoModel->getById($resultCarrinho[':id_produto']);
        $resultUsuario = $this->usuarioModel->getAll();
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);
        $resulTipoAdicional = $this->adminTipoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);

        if (isset($SessionIdUsuario)) {
            $resultVendas = $this->vendasModel->getAllUser($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario, $empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('produto/adicional', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'categoria' => $resultCategoria,
            'produto' => $resultProdutos,
            'produtoAdicional' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'dias' => $resultDias,
            'usuario' => $resultUsuario,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'vendas' => $resultVendas,
            'carrinho' => $resultCarrinho,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'usuario' => $SessionIdUsuario,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    //  PAGINA - Produto Adicional { EDIÇÃO }
    public function carrinhoCheckoutAdicionalUpdate($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);
        $resultDias = $this->diasModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);

        $resultCarrinho = $this->carrinhoModel->getById($data['id']);
        $resultProdutoAdicionalCart = $this->carrinhoAdicionalModel->getByProd($resultCarrinho[':id_produto'], $SessionIdUsuario, $resultCarrinho[':chave']);
        $resultSomaAdicional = $this->carrinhoAdicionalModel->somaCarrinhoAdicionalChave($SessionIdUsuario, $resultCarrinho[':chave'], $empresaAct[':id']);

        $resultProdutos = $this->produtoModel->getById($resultCarrinho[':id_produto']);
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();
        $resultProdutoAdicional = $this->produtoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);
        $resultSabores = $this->produtoSaboresModel->getAllPorEmpresa($empresaAct[':id']);

        if (isset($SessionIdUsuario)) {
            $resultVendas = $this->vendasModel->getAllUser($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario, $empresaAct[':id']);
        $resultUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        $resulTipoAdicional = $this->adminTipoAdicionalModel->getAllPorEmpresa($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('produto/adicionalEditar', [
            'empresa' => $resultEmpresa,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'categoria' => $resultCategoria,
            'produto' => $resultProdutos,
            'produtoAdicional' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'produtoAdicionalCart' => $resultProdutoAdicionalCart,
            'produtoSabores' => $resultSabores,
            'somaAdicional' => $resultSomaAdicional,
            'dias' => $resultDias,
            'usuario' => $resultUsuario,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'vendas' => $resultVendas,
            'carrinho' => $resultCarrinho,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }


    /**
     * //////////////////////////////////////////////////////////////////////////////////////////
     * ///////////////////////////////////  SESSÃO ACOES  //////////////////////////////////////
     * //////////////////////////////////////////////////////////////////////////////////////////
     */

    // [ MODAL ] Carrega os dados do produto selecionado no modal Info para saber se o user vai deletar ou editar o produto
    public function carrinhoProdutoAcao($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        if (isset($SessionIdUsuario)) {
            $resultUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultProduto = $this->produtoModel->getById($data['id_produto']);
            $resultCarrinho = $this->carrinhoModel->getById($data['id_carrinho']);
            if ($resultCarrinho[':id_sabores'] != null) {
                $resultSabores = $this->produtoSaboresModel->getById($resultCarrinho[':id_sabores']);
                echo $resultProduto[':nome'] . ' - ' . $resultSabores[':nome'];
            } else {
                echo $resultProduto[':nome'];
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
    }

    //Adiciona o item ao carrinho e verifica se existe mais um passo para esse pedido
    public function carrinhoCheckout()
    {
        $adicional = $_POST['adicional'];
        $carrinho = $this->getInput();
        $vendaProduto = $this->getInputVendasMais();

        $result = $this->carrinhoModel->insert($carrinho);
        $result2 = $this->produtoModel->updateVendas($vendaProduto);

        if ($adicional != null) {
            if ($result > 0) {
                echo 'Seu produto foi adicionado a sacola aguarde que tem mais!';
            } else {
                echo 'Erro ao criar seu carrinho';
            }
        } else {

            if ($result > 0) {
                echo 'Seu produto foi adicionado a Sacola!';
            } else {
                echo 'Erro ao criar seu carrinho';
            }
        }
    }

    // Atualiza o item do carrinho e verifica se existe item adicional
    public function carrinhoCheckoutUpdate()
    {
        $adicional = $_POST['adicional'];
        $carrinho = $this->getInputUp();
        $vendaProduto = $this->getInputVendasMais();
        $vendaProdutoMenos = $this->getInputVendasMenos();

        $result = $this->carrinhoModel->update($carrinho);
        $result2 = $this->produtoModel->updateVendas($vendaProdutoMenos);
        $result3 = $this->produtoModel->updateVendas($vendaProduto);

        if ($adicional != null) {
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
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $quantidade = Input::get('quantidade');
        if ($quantidade > 0) {

            $id_adicional = Input::get('id_adicional');
            $id_produto = Input::get('id_produto');

            $verificaCadastro = $this->carrinhoAdicionalModel->checkById($id_adicional, $data['chave'], $id_produto);
            if ($verificaCadastro == 0) {
                $adicional = $this->getInputAdcional();
                //dd($adicional);
                $result = $this->carrinhoAdicionalModel->insert($adicional);
            } else {
                $adicional = $this->getInputUpdateAdcional();
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
            $resultCarrinhoAdicional = $this->carrinhoAdicionalModel->getById($id_adicional, $data['chave'], $id_produto);
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
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
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
        $result = $this->carrinhoModel->updateFinal($carrinhoUp);

        if ($result > 0) {
            echo 'OK Direcionando para finalizar pedido';
        } else {
            echo 'Vixi Vai ficar ai mesmo';
        }
    }

    //Finaliza e fecha o pedido do cliente
    public function carrinhoFinalizarPedido($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        $pedido = $this->getFinalizaPedido();
        $pagamento = $this->getInputPagamento();
        $pedidoCarrinho = $this->getFinalizaPedidoCarrinho();

        $result = $this->vendasModel->insert($pedido);
        $result2 = $this->carrinhoModel->updateFinalPedido($pedidoCarrinho);
        $result3 = $this->carrinhoAdicionalModel->updateFinalPedido($pedidoCarrinho);
        $result4 = $this->pedidosPagamentoModel->insert($pagamento);

        if (Input::post('cpf') != null) {
            $nfPaulista = $this->getCPFNota();
            $result4 = $this->carrinhoNFPaulistaModel->insert($nfPaulista);
        }

        $cupomVerifica = $this->cupomUtilizacoes->getCountVerifica($SessionIdUsuario, $empresaAct[':id']);
        $cupomUtilizacoesId = $this->cupomUtilizacoes->getByUser($SessionIdUsuario, $empresaAct[':id']);
        if ($cupomVerifica > 0) {
            $updateCupom = $this->cupomUtilizacoes->update($cupomUtilizacoesId[':id'], Input::post('numero_pedido'), $empresaAct[':id']);
        }

        if ($result > 0) {
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
    public function carrinhoDeletarItem($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        if (isset($SessionIdUsuario)) {
            $resultUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            /**
             * Diminuir a quantidade de venda do produto
             */
            $resultProduto = $this->produtoModel->getById($data['id_produto']);
            $resultCarrinho = $this->carrinhoModel->getById($data['id_carrinho']);

            $novoTotalVendasProduto = $resultProduto[':vendas'] - $resultCarrinho[':quantidade'];

            $result3 = $this->carrinhoAdicionalModel->deleteCart($data['id_produto'], $data['id_carrinho']);

            $result2 = $this->produtoModel->updateVendasMenos($data['id_produto'], $novoTotalVendasProduto);
            $result = $this->carrinhoModel->delete($data['id_carrinho']);

            if ($result > 0) {
                echo 'Seu item foi removido de sua Sacola!';
                redirect(BASE . $empresaAct[':link_site'] . 'carrinho');
            } else {
                echo 'Não foi possivel remover seu item!';
                redirect(BASE . $empresaAct[':link_site'] . 'carrinho');
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
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
            'id_empresa' => Input::get('id_empresa')
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
            'sessao_id' => session_id(),
            'id_empresa' => Input::get('id_empresa')
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

    // //Retorna os dados do formulário em uma classe padrão stdObject
    // private function getInputPreVendaValor()
    // {
    //     $session = $this->sessionFactory->newInstance($_COOKIE);
    //     $segment = $session->getSegment('Vendor\Aura\Segment');
    //     $SessionIdUsuario = $segment->get('id_usuario');
    //     $SessionUsuarioEmail = $segment->get('usuario');
    //     $SessionNivel = $segment->get('nivel');

    //     $resultVenda = $this->vendasModel->getVenda($SessionIdUsuario, '');
    //     $valorAtual = Input::post('valorFinal');
    //     $novoValor = $resultVenda[':total'] + $valorAtual;

    //     return (object) [
    //         'id' => $resultVenda[':id'],
    //         'total' => $novoValor,
    //         'chave' => $resultVenda[':chave'],
    //     ];

    // }

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
            'sessao_id' => session_id(),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega os dados
    private function getInput()
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        if (!isset($SessionIdUsuario)) {
            $bcrypt = new Bcrypt();
            $bcrypt_version = '2a';

            $geradorSenha =  $this->allController->geraSenha();
            $novoEmail = $bcrypt->encrypt($geradorSenha, $bcrypt_version);
            $email = $novoEmail . '@automatia.app';

            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');

            $_SESSION = array(
                'Vendor\Aura\Segment' => array(
                    'id_usuario' => 0,
                    'usuario' => $email,
                    'nivel' => 3,
                ),
            );
        }

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $Sessionnumero_pedido = $segment->get('numero_pedido');

        // $adicionalSt = $_POST['adicional'];
        // if ($adicionalSt != null) {
        //     $adicionalSelecionados = implode(',', $adicionalSt);
        // }

        $saborSt = $_POST['sabores'];
        if ($saborSt != null) {
            $saborSelecionados = implode(',', $saborSt);
        }

        return (object) [
            'id' => Input::post('id', FILTER_SANITIZE_NUMBER_INT),
            'id_produto' => Input::post('id_produto'),
            'id_cliente' => $SessionIdUsuario,
            'quantidade' => Input::post('quantity'),
            'id_adicional' => Input::post('adicional'),
            'id_sabores' => $saborSelecionados,
            'observacao' => Input::post('observacao'),
            'valor' => Input::post('valor'),
            'chave' => Input::post('chave'),
            'sessao_id' => session_id(),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega os dados para fazer update na tabela [produtos] acrescentando mais itens ao numero de vendas feitas para determinado produto
    private function getInputVendasMais()
    {
        $qtd = Input::post('quantity');
        $id = Input::post('id_produto');

        $produto = $this->produtoModel->getById($id);
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
        $qtd = Input::post('quantidadeAnterior');
        $id = Input::post('id_produto');

        $produto = $this->produtoModel->getById($id);
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

        return (object) [
            'id' => Input::post('id', FILTER_SANITIZE_NUMBER_INT),
            'id_adicional' => $adicionalSelecionados,
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega todos os dados do carrinho para fechar o PEDIDO do cliente [Ultimo processo que o usuario irá fazer para concluir o pedido]
    private function getFinalizaPedido()
    {
        $empresaAct = $this->configEmpresaModel->getById(Input::post('id_empresa'));
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $resultiPedido = $this->vendasModel->getUll($empresaAct[':id']);

        $resultSoma = $this->carrinhoModel->somaCarrinho($SessionIdUsuario, $empresaAct[':id']);
        $resultSomaAdicional = $this->carrinhoAdicionalModel->somaCarrinhoAdicional($SessionIdUsuario, $empresaAct[':id']);

        $resultid_caixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $valorCarrinho = ((float) $resultSoma['total'] + (float) $resultSomaAdicional['total']);

        return (object) [
            'id_caixa' => $resultid_caixa[':id'],
            'id_cliente' => $SessionIdUsuario,
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
            'numero_pedido' => Input::post('numero_pedido'),
            'valor_frete' => Input::post('valor_frete'),
            'km' => Input::post('km'),
            'motoboy' => 0,
            'chave' => Input::post('chave'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }

    //Pega o Número do pedido gerado na pagina de finalizar pedido e altera os itens nas tabelas [cartCarrinho] e [cartCarrinhoAdicional]
    private function getFinalizaPedidoCarrinho()
    {
        $empresaAct = $this->configEmpresaModel->getById(Input::post('id_empresa'));
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        $resultiPedido = $this->vendasModel->getUll($empresaAct[':id']);

        return (object) [
            'id_cliente' => $SessionIdUsuario,
            'numero_pedido' => Input::post('numero_pedido'),
            'id_empresa' => Input::post('id_empresa'),

        ];
    }


    private function getCPFNota()
    {
        $empresaAct = $this->configEmpresaModel->getById(Input::post('id_empresa'));
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        $resultiPedido = $this->vendasModel->getUll($empresaAct[':id']);

        return (object) [
            'numero_pedido' => Input::post('numero_pedido'),
            'id_cliente' => $SessionIdUsuario,
            'cpf' => Input::post('cpf'),
            'data' => date('Y-m-d H:i:s'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }


    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputCadastro()
    {
        $bcrypt = new Bcrypt();

        $bcrypt_version = '2a';
        $getSenha = preg_replace('/[^0-9]/', '', Input::post('telefone'));
        $senha = $bcrypt->encrypt($getSenha, $bcrypt_version);

        $geradorSenha =  $this->allController->geraSenha();
        $email = $geradorSenha . 'ath@automatiza.app';

        return (object) [
            'nome' => Input::post('nome'),
            'email' => $email,
            'telefone' => Input::post('telefone'),
            'senha' => $senha,
            'nivel' => 3,
        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputEndereco()
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

        return (object) [
            'id_usuario' => $resulUsuario[':id'],
            'email' => $resulUsuario[':email'],
            'nome_endereco' => 'Endereço Principal',
            'rua' => Input::post('rua'),
            'numero' => Input::post('numero'),
            'complemento' => Input::post('complemento'),
            'bairro' => Input::post('bairro'),
            'cidade' => Input::post('cidade'),
            'estado' => Input::post('estado'),
            'cep' => Input::post('cep'),
            'principal' => 1
        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputVisitante()
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

        return (object) [
            'id_cliente' => $resulUsuario[':id'],
            'sessao_id' => session_id()
        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputPagamento()
    {
        $dinheiro = str_replace(",", ".", Input::post('dinheiro'));
        if ($dinheiro == null) {
            $dinheiro = 0.00;
        }
        $pagCartao = Input::post('pagCartao');

        $total = $pagCartao - $dinheiro;

        return (object) [
            'numero_pedido' => Input::post('numero_pedido'),
            'id_tipo_pagamento' => Input::post('tipo_pagamento'),
            'pagCartao' => $total,
            'pagDinheiro' => $dinheiro,
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}

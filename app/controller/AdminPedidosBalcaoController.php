<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\CalculoFrete;
use app\classes\Cache;
use app\classes\SMS;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use Twilio\Rest\Client;
use app\classes\Preferencias;
use app\classes\Sessao;
use app\Models\Carrinho;
use app\Models\CarrinhoAdicional;
use app\Models\CarrinhoCPFNota;
use app\Models\CarrinhoPedidoPagamento;
use app\Models\CarrinhoPedidos;
use app\Models\Usuarios;
use app\Models\UsuariosEmpresa;
use app\Models\UsuariosEnderecos;
use Bcrypt\Bcrypt;
use Browser;

class AdminPedidosBalcaoController extends Controller
{
    //Instancia da Classe AdminPagamentoModel
    private $calculoFrete;
    private $sessao;
    private $bcrypt;
    private $acoes;
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
        $this->bcrypt = new Bcrypt();
        $this->acoes = new Acoes();
        $this->calculoFrete = new CalculoFrete();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        if($estabelecimento){
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);
        }
        
        $resultClientes = $this->acoes->getByFieldAll('usuarios', 'nivel', 3);
        $clientesEmpresa = $this->acoes->getByFieldTwoAll('usuariosEmpresa', 'id_empresa', $empresa->id, 'nivel', 3);
        
        $resultMotoboy = $this->acoes->getByFieldAll('motoboy', 'id_empresa', $empresa->id);
        
        
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $usuario = $this->acoes->getFind('usuarios');
        $count = $this->acoes->counts('motoboy', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $retorno = $this->acoes->pagination('motoboy', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/pedidos/novo', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario'=> $this->sessao->getNivel(),
            'moeda' => $moeda,
            'planoAtivo' => $planoAtivo,
            'clientes' => $resultClientes,
            'clientesEmpresa' => $clientesEmpresa,
            'motoboy' => $resultMotoboy
        ]);
    }



    public function start($data)
    {
        $this->sessao->sessaoNew('id_cliente', $data['cliente']);

        header('Content-Type: application/json');
        $json = json_encode(['id' => 1, 'resp' => 'insert', 'mensagem' => 'Carrinho interno iniciado', 'error' => 'Não foi posível iniciar carrinho interno iniciado', 'url' => 'admin/pedido/novo/produtos']);
        exit($json);
    }


    public function produtos($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        
        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $categoria = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $produtoTop5 = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');
        
        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        
        
        $ultimaVenda = null;
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);
            $verificaVendaAtiva = $this->acoes->countsTwo('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getSessao('id_cliente'));
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);

            if ($verificaVendaAtiva > 0) {
                $ultimaVenda = $this->acoes->limitOrderFill('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getSessao('id_cliente'), 'status', 4, 1, 'id', 'DESC');
            }
        }
        $hoje = date('w', strtotime(date('Y-m-d')));
        if ($hoje == 0) {
            $hoje = 7;
        }

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        }

        $this->load('_admin/pedidos/novoProduto', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario'=> $this->sessao->getNivel(),
            'moeda' => $moeda,
            'estabelecimento' => $estabelecimento,
            'produtoSabores' => $resultSabores,
            'planoAtivo' => $planoAtivo,
            'carrinhoqtd' => $resultCarrinhoQtd,
            'produto' => $produto,
            'categoria' => $categoria
        ]);
    }
    public function carrinhoQtd($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if($this->sessao->getSessao('id_cliente')){    
            $contagem = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);
            echo $contagem;
        }
    }
    public function carrinhoAddProduto($data)
    {
        $sabores = null;
        if ($data['sabores']) {
            $sabores = $data['sabores'][0];
        }

        $valor = new Carrinho();
        $valor->id_produto = $data['id'];
        $valor->id_cliente = $this->sessao->getSessao('id_cliente');
        $valor->id_empresa = $data['id_empresa'];
        $valor->quantidade = $data['quantity'];
        $valor->observacao = $data['observacao'];
        $valor->id_sabores = $sabores;
        $valor->id_adicional = $data['id_adicional'];
        $valor->valor = $data['valor'];
        $valor->save();

        if ($data['adicional']) {
            foreach ($data['adicional'] as $res) {
                if ($data["valor{$res}"]) {
                    $valor_adicional = $data["valor{$res}"];
                    $qtd_adicional = $data["qtd_ad{$res}"];
                }
                $cartAdic = new CarrinhoAdicional();
                $cartAdic->id_carrinho = $valor->id;
                $cartAdic->id_cliente = $this->sessao->getSessao('id_cliente');
                $cartAdic->id_produto = $data['id'];
                $cartAdic->id_adicional = $res;
                $cartAdic->valor = $valor_adicional;
                $cartAdic->quantidade = $qtd_adicional;
                $cartAdic->id_empresa = $data['id_empresa'];
                $cartAdic->save();
            }
        }
        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Produto Adicionado ao carrinho', 'error' => 'Não foi posível adicionar o produto ao carrinho', 'code' => 520]);
        exit($json);
    }

    public function produtoMostrar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produto = $this->acoes->getByField('produtos', 'id', $data['id']);
        $resultProdutosAdicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $categoria = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $produtoTop5 = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');

        $resultProdutoAdicional = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $resulTipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id_empresa', $empresa->id);

        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $verificaVendaAtiva = $this->acoes->countsTwo('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getSessao('id_cliente'));
        }

        $this->load('_admin/pedidos/produtoMostrar', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'moeda' => $moeda,
            'produto' => $produto,
            'planoAtivo' => $planoAtivo,
            'produtoAdicional' => $resultProdutoAdicional,
            'nivelUsuario'=> $this->sessao->getNivel(),
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'produtoSabores' => $resultSabores,
            'carrinhoqtd' => $verificaVendaAtiva,
            'chave' => md5(uniqid(rand(), true))
        ]);
    }

    public function carrinho($data)
    {

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        
        
        if ($this->sessao->getSessao('id_cliente')) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getSessao('id_cliente'));
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getSessao('id_cliente'), 'principal', 1);

            $carrinho = $this->acoes->getByFieldTreeNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id, 'numero_pedido', 'null');
            $usuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getSessao('id_cliente'));
            $endereco = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getSessao('id_cliente'), 'principal', 1);

            $estados = $this->acoes->getFind('estados');
            $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
            $carrinhoAdicional = $this->acoes->getByFieldAll('carrinhoAdicional', 'id_cliente', $this->sessao->getSessao('id_cliente'));
            $produtos = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);

            $adicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
            $sabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
            $tipo = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
            $pagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);

            $resultSoma = $this->acoes->sumFielsTreeNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
            $resultSomaAdicional = $this->acoes->sumFielsTreeNull('carrinhoAdicional', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
            $resultVendasFeitas = $this->acoes->countsTwo('carrinhoPedidos', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);
            $valorCarrinho = ((float) $resultSoma->total + (float) $resultSomaAdicional->total);

            $cFrete = $this->calculoFrete->calculo($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);
            $infoKm = $this->calculoFrete->infoKm($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);
            
            $taxa_entrega = $delivery->taxa_entrega;
            $km_entrega = $delivery->km_entrega * 1000;

            $taxa_entrega2 = $delivery->taxa_entrega2;
            $km_entrega2 = $delivery->km_entrega2 * 1000;

            $taxa_entrega3 = $delivery->taxa_entrega3;
            $km_entrega3 = $delivery->km_entrega3 * 1000;


            $km_entrega_excedente = $delivery->km_entrega_excedente * 1000;
            $valor_excedente = $delivery->valor_excedente;


            if ($cFrete <= $km_entrega) {
                $total = $taxa_entrega;

                if ($cFrete > $km_entrega && $cFrete <= $km_entrega_excedente) {
                    $kmACalcular = (round($infoKm) - $delivery->km_entrega);
                    $freteVezes = ($kmACalcular * $valor_excedente);
                    $taxa_entregaNova = $taxa_entrega + $freteVezes;
                    $total = $taxa_entregaNova;
                }
            }

            if ($km_entrega2 != 0.00) {
                if ($cFrete > $km_entrega && $cFrete <= $km_entrega2) {
                    $total = $taxa_entrega2;
                }

                if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega_excedente) {
                    $kmACalcular = (round($infoKm) - $delivery->km_entrega2);
                    $freteVezes = ($kmACalcular * $valor_excedente);
                    $taxa_entregaNova = $taxa_entrega2 + $freteVezes;
                    $total = $taxa_entregaNova;
                }
            }
            
            if ($km_entrega3 != 0.00) {
                if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega3) {
                    $total = $taxa_entrega3;
                }

                if ($cFrete > $km_entrega3 && $cFrete <= $km_entrega_excedente) {
                    $kmACalcular = (round($infoKm) - $delivery->km_entrega3);
                    $freteVezes = ($kmACalcular * $valor_excedente);
                    $taxa_entregaNova = $taxa_entrega3 + $freteVezes;
                    $total = $taxa_entregaNova;
                }
            }

            if ($delivery->frete_status == 1) {
                if ($delivery->valor <= $valorCarrinho) {
                    $total = 0;
                }
            }

            if ($delivery->primeira_compra == 1) {
                if ($resultVendasFeitas == 0) {
                    $total = 0;
                }
            }
            $numeroPedido = $this->sessao->sessaoNew('numeroPedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));
            $cupomVerifica = $this->acoes->countsTwoNull('cupomDescontoUtilizadores', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);

            if ($cupomVerifica > 0) {
                $cupomUtilizacoesId = $this->acoes->getByField('cupomDescontoUtilizadores', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id,);
                $cupomValida = $this->acoes->getByField('cupomDesconto', 'id', $cupomUtilizacoesId->id_cupom);

                if ((int)$cupomValida->tipo_cupom == 1) {
                    $valor = $valorCarrinho;
                    $porcentagem = floatval($cupomValida->valor_cupom);
                    $resul = $valor * ($porcentagem / 100);
                    $resultado = $resul;
                } else {
                    $resultado = $cupomValida->valor_cupom;
                }
                $valorCarrinho = $valorCarrinho - $resultado;
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/carrinho/dados");
        }
        $resultchave = md5(uniqid(rand(), true));

        $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);

        if ($resultCarrinhoQtd == 0) {
            redirect(BASE . "{$empresa->link_site}");
        }

        $this->load('_admin/pedidos/carrinhoMostrarProdutos', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'moeda' => $moeda,
            'estados' => $estados,
            'carrinho' => $carrinho,
            'carrinhoAdicional' => $carrinhoAdicional,
            'produtos' => $produtos,
            'adicionais' => $adicionais,
            'sabores' => $sabores,
            'tipo' => $tipo,
            'planoAtivo' => $planoAtivo,
            'pagamento' => $pagamento,
            'numero_pedido' => $this->sessao->getSessao('numeroPedido'),
            'nivelUsuario'=> $this->sessao->getNivel(),
            'valorPedido' => $valorCarrinho,
            'carrinhoQtd' => $resultCarrinhoQtd,
        ]);
    }


    public function carrinhoFinalizar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        
        
        if ($this->sessao->getSessao('id_cliente')) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getSessao('id_cliente'));
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getSessao('id_cliente'), 'principal', 1);

            $carrinho = $this->acoes->getByFieldTreeNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id, 'numero_pedido', 'null');
            $usuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getSessao('id_cliente'));
            $endereco = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getSessao('id_cliente'), 'principal', 1);

            $estados = $this->acoes->getFind('estados');
            $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
            $carrinhoAdicional = $this->acoes->getByFieldAll('carrinhoAdicional', 'id_cliente', $this->sessao->getSessao('id_cliente'));
            $produtos = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);

            $adicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
            $sabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
            $tipo = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
            $pagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);

            $resultSoma = $this->acoes->sumFielsTreeNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
            $resultSomaAdicional = $this->acoes->sumFielsTreeNull('carrinhoAdicional', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
            $resultVendasFeitas = $this->acoes->countsTwo('carrinhoPedidos', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);
            $valorCarrinho = ((float) $resultSoma->total + (float) $resultSomaAdicional->total);

            $cFrete = $this->calculoFrete->calculo($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);
            $infoKm = $this->calculoFrete->infoKm($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);
            $taxa_entrega = $delivery->taxa_entrega;
            $km_entrega = $delivery->km_entrega * 1000;
            $km_entrega_excedente = $delivery->km_entrega_excedente * 1000;
            $valor_excedente = $delivery->valor_excedente;

            if ($cFrete <= $km_entrega) {
                $total = $taxa_entrega;
            } else if ($cFrete > $km_entrega && $cFrete <= $km_entrega_excedente) {
                $kmACalcular = (round($infoKm) - $delivery->km_entrega);
                $freteVezes = ($kmACalcular * $valor_excedente);
                $taxa_entregaNova = $taxa_entrega + $freteVezes;
                $total = $taxa_entregaNova;
            }

            if ($delivery->frete_status == 1) {
                if ($delivery->valor <= $valorCarrinho) {
                    $total = 0;
                }
            }

            if ($delivery->primeira_compra == 1) {
                if ($resultVendasFeitas == 0) {
                    $total = 0;
                }
            }

            
            $this->sessao->sessaoNew('numeroPedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));
            
            $cupomVerifica = $this->acoes->countsTwoNull('cupomDescontoUtilizadores', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);

            if ($cupomVerifica > 0) {
                $cupomUtilizacoesId = $this->acoes->getByField('cupomDescontoUtilizadores', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id,);
                $cupomValida = $this->acoes->getByField('cupomDesconto', 'id', $cupomUtilizacoesId->id_cupom);

                if ((int)$cupomValida->tipo_cupom == 1) {
                    $valor = $valorCarrinho;
                    $porcentagem = floatval($cupomValida->valor_cupom);
                    $resul = $valor * ($porcentagem / 100);
                    $resultado = $resul;
                } else {
                    $resultado = $cupomValida->valor_cupom;
                }
                $valorCarrinho = $valorCarrinho - $resultado;
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/carrinho/dados");
        }
        $resultchave = md5(uniqid(rand(), true));

        $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);

        if ($resultCarrinhoQtd == 0) {
            redirect(BASE . "{$empresa->link_site}");
        }
        $this->load('_admin/pedidos/novoDetalhes', [
            'empresa' => $empresa,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'moeda' => $moeda,
            'estados' => $estados,
            'planoAtivo' => $planoAtivo,
            'delivery' => $delivery,
            'carrinho' => $carrinho,
            'carrinhoAdicional' => $carrinhoAdicional,
            'produtos' => $produtos,
            'adicionais' => $adicionais,
            'sabores' => $sabores,
            'tipo' => $tipo,
            'pagamento' => $pagamento,
            'calculoFrete' => $total,
            'numero_pedido' => $this->sessao->getSessao('numeroPedido'),
            'nivelUsuario'=> $this->sessao->getNivel(),
            'valorPedido' => $valorCarrinho,
            'endereco' => $endereco,
            'km' => $cFrete,
            'km_entrega_excedente' => $km_entrega_excedente,
            'km_entrega' => $km_entrega
        ]);
    }

    //Finaliza e fecha o pedido do cliente
    public function carrinhoFinalizarPedido($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $carrinho = $this->acoes->getByFieldAllTwoNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $chave = md5(uniqid(rand(), true));

        if ($carrinho) {
            foreach ($carrinho as $cart) {
                $cartAdicional = (new Carrinho())->findById($cart->id);
                $cartAdicional->numero_pedido = $data['numero_pedido'];
                $cartAdicional->save();
            }
        }

        $carrinhoAdicional = $this->acoes->getByFieldAllTwoNull('carrinhoAdicional', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);

        if ($carrinhoAdicional) {
            foreach ($carrinhoAdicional as $cartAdic) {
                $cartAdicional = (new CarrinhoAdicional())->findById($cartAdic->id);
                $cartAdicional->numero_pedido = $data['numero_pedido'];
                $cartAdicional->save();
            }
        }

        if ($data['cpf'] != null) {
            $cpf = new CarrinhoCPFNota();
            $cpf->id_cliente = $this->sessao->getSessao('id_cliente');
            $cpf->id_empresa = $empresa->id;
            $cpf->numero_pedido = $data['numero_pedido'];
            $cpf->cpf = $data['cpf'];
            $cpf->save();
        }


        $pagamento = $data['tipo_pagamento'] == 7 ? $data['dinheiro'] : 0;

        if ($data['tipo_pagamento'] == 7) {
            $pagamento = $data['dinheiro'];
            $pagamentoCartão = $data['dinheiro'] - $data['total_pago'];
        } else {
            $pagamentoCartão = $data['total_pago'];
        }


        $cpp = new CarrinhoPedidoPagamento();
        $cpp->pag_dinheiro = $pagamento;
        $cpp->pag_cartao = $pagamentoCartão;
        $cpp->id_cliente = $this->sessao->getSessao('id_cliente');
        $cpp->id_tipo_pagamento = $data['tipo_pagamento'];
        $cpp->numero_pedido = $data['numero_pedido'];
        $cpp->id_empresa = $empresa->id;
        $cpp->save();



        $pedido = new CarrinhoPedidos();
        $pedido->id_caixa = $estabelecimento[0]->id;
        $pedido->id_cliente = $this->sessao->getSessao('id_cliente');
        $pedido->id_empresa = $empresa->id;
        $pedido->total = $data['total'];
        $pedido->total_pago = $data['total_pago'];
        $pedido->troco = $data['troco'];
        $pedido->tipo_pagamento = $data['tipo_pagamento'];
        $pedido->tipo_frete = $data['tipo_frete'];
        $pedido->data_pedido = date('Y-m-d');
        $pedido->hora = date('H:i:s');
        $pedido->status = 1;
        $pedido->pago = 0;
        $pedido->observacao = $data['observacao'];
        $pedido->numero_pedido = $data['numero_pedido'];
        $pedido->valor_frete = $data['valor_frete'];
        $pedido->km = $data['km'];
        $pedido->chave = $chave;
        $pedido->save();

        $cliente = $this->acoes->getByField('usuarios', 'id', $this->sessao->getSessao('id_cliente'));
        $mensagem =  "Você acaba de efetuar um pedido no {$empresa->nome_fantasia} esse é seu número de pedido: {$data['numero_pedido']}. Para acompanhar acesse o link: https://www.automatizadelivery.com.br/{$empresa->link_site}/meu-pedido/{$chave}";
        $ddi = '+55';
        $numerofinal = $ddi . $cliente->telefone;

        $client = new Client(TWILIO['account_sid'], TWILIO['auth_token']);
        $client->messages->create($numerofinal,array('from' => TWILIO['number'],'body' => $mensagem));

        header('Content-Type: application/json');
        $json = json_encode(['id' => $pedido->id, 'resp' => 'insert', 'mensagem' => 'Pedido finalizado com sucesso', 'url' => 'admin/pedidos', 'pedido' => $data['numero_pedido']]);
        exit($json);
    }

    public function deletarItemCarrinho($data)
    {
        $resultProduto = $this->acoes->getByFieldAll('carrinhoAdicional', 'id_carrinho', $data['id_carrinho']);

        $valor = (new Carrinho())->findById($data['id_carrinho']);
        $valor->destroy();

        if ($resultProduto) {
            foreach ($resultProduto as $res) {
                $valorAd = (new CarrinhoAdicional())->findById($res->id);
                $valorAd->destroy();
            }
            redirect(BASE . "{$data['linkSite']}/admin/pedido/novo/produtos");
        }
        redirect(BASE . "{$data['linkSite']}/admin/pedido/novo/produtos");
    }

    public function carrinhoCadastroValida($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $getTelefone = $this->acoes->counts('usuarios', 'telefone', preg_replace('/[^0-9]/', '', $data['telefone']));

        if ($getTelefone > 0) {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Cliente já possuí conta cadastrada no sistema']);
            exit($json);
        } else {
            $getSenha = preg_replace('/[^0-9]/', '', $data['telefone']);
            $senha = $this->bcrypt->encrypt($getSenha, '2a');

            $hash =  md5(uniqid(rand(), true));
            $email = $hash . 'ath@automatizadelivery.com.br';

            $valor = new Usuarios();
            $valor->nome = $data['nome'];
            $valor->email = $email;
            $valor->telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
            $valor->senha = $senha;
            $valor->nivel = 3;
            $valor->save();

            $valorEmp = new UsuariosEmpresa();
            $valorEmp->id_usuario = $valor->id;
            $valorEmp->id_empresa = $empresa->id;
            $valorEmp->nivel = 3;
            $valorEmp->save();

            if ($data['entrega'] == 1) {
                $valorEnd = new UsuariosEnderecos();
                $valorEnd->id_usuario = $valor->id;
                $valorEnd->nome_endereco = "Padrão";
                $valorEnd->rua = $data['rua'];
                $valorEnd->numero = $data['numero'];
                $valorEnd->complemento = $data['complemento'];
                $valorEnd->bairro = $data['bairro'];
                $valorEnd->cidade = $data['cidade'];
                $valorEnd->estado = $data['estado'];
                $valorEnd->cep = $data['cep'];
                $valorEnd->principal = 1;
                $valorEnd->save();
            }
            $this->sessao->sessaoNew('id_cliente', $valor->id);

            header('Content-Type: application/json');
            $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Cliente Cadastrado com sucesso', 'url' => 'admin/pedido/novo/produtos']);
            exit($json);
        }
    }
}

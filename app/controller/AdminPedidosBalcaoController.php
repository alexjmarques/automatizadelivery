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
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);
        }

        $resultClientes = $this->acoes->getByFieldAll('usuarios', 'nivel', 3);
        $clientesEmpresa = $this->acoes->getByFieldTwoAll('usuariosEmpresa', 'id_empresa', $empresa->id, 'nivel', 3);

        $resultMotoboy = $this->acoes->getByFieldAll('motoboy', 'id_empresa', $empresa->id);


        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
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
            'nivelUsuario' => $this->sessao->getNivel(),
            'moeda' => $moeda,
            'planoAtivo' => $planoAtivo,
            'clientes' => $resultClientes,
            'caixa' => $caixa->status,
            'motoboy' => $resultMotoboy
        ]);
    }

    public function pesquisaCliente($data)
    {
        $telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
        $resultClientes = $this->acoes->getByFieldTwo('usuarios', 'telefone', $telefone, 'nivel', 3);
        if ($resultClientes) {
            //$resultEndereco = $this->acoes->getByField('enderecos', 'id_usuario', $resultClientes->id);
            header('Content-Type: application/json');
            $json = json_encode(['id' => $resultClientes->id, 'nome' => $resultClientes->nome, 'telefone' => $data['telefone']]);
            exit($json);
        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'mensagem' => 'Cliente não cadastrado, faça o cadastro antes de continuar']);
            exit($json);
        }
    }


    public function start($data)
    {
        $this->sessao->sessaoNew('id_cliente', $data['cliente']);

        header('Content-Type: application/json');
        $json = json_encode(['id' => 1, 'resp' => 'insert', 'mensagem' => 'Carrinho interno iniciado', 'error' => 'Não foi posível iniciar carrinho interno iniciado', 'code' => 1,  'url' => 'admin/pedido/novo/produtos']);
        exit($json);
    }


    public function produtos($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $produtoTop5 = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');

        $categoria = $this->acoes->getByFieldAllOrder('categorias', 'id_empresa', $empresa->id, 'posicao ASC');
        $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
        $tamanhosCategoria = $this->acoes->getByFieldAll('pizzaTamanhosCategoria', 'id_empresa', $empresa->id);

        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);


        $ultimaVenda = null;
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            //$resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);
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
            'nivelUsuario' => $this->sessao->getNivel(),
            'tamanhos' => $tamanhos,
            'tamanhosCategoria' => $tamanhosCategoria,
            'moeda' => $moeda,
            'estabelecimento' => $estabelecimento,
            'produtoSabores' => $resultSabores,
            'planoAtivo' => $planoAtivo,
            //'carrinhoqtd' => $resultCarrinhoQtd,
            'produto' => $produto,
            'caixa' => $caixa->status,
            'categoria' => $categoria
        ]);
    }

    public function pedidoEditar($data)
    {
        //dd('pagamento');
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $pedido = $this->acoes->getByField('carrinhoPedidos', 'id', $data['id']);
        $cliente = $this->acoes->getByField('usuarios', 'id', $pedido->id_cliente);
        $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);


        $carrinho = $this->acoes->getByFieldTreeNull('carrinho', 'id_cliente', $pedido->id_cliente, 'id_empresa', $empresa->id, 'numero_pedido', $pedido->numero_pedido);
        $usuario = $this->acoes->getByField('usuarios', 'id', $pedido->id_cliente);
        $endereco = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $pedido->id_cliente, 'principal', 1);

        $estados = $this->acoes->getFind('estados');
        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $carrinhoAdicional = $this->acoes->getByFieldAll('carrinhoAdicional', 'id_cliente', $pedido->id_cliente);
        $produtos = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);

        $adicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $sabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $tipo = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
        $pagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);

        $resultSoma = $this->acoes->sumFielsTreeNotNull('carrinho', 'id_cliente', $pedido->id_cliente, 'id_empresa', $empresa->id, 'numero_pedido', $pedido->numero_pedido, 'valor * quantidade');
        $resultSomaAdicional = $this->acoes->sumFielsTreeNotNull('carrinhoAdicional', 'id_cliente', $pedido->id_cliente, 'id_empresa', $empresa->id, 'numero_pedido', $pedido->numero_pedido, 'valor * quantidade');
        $resultVendasFeitas = $this->acoes->countsTwo('carrinhoPedidos', 'id_cliente', $pedido->id_cliente, 'id_empresa', $empresa->id);
        $valorCarrinho = ((float) $resultSoma->total + (float) $resultSomaAdicional->total);

        $categoria = $this->acoes->getByFieldAllOrder('categorias', 'id_empresa', $empresa->id, 'posicao ASC');
        $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
        $tamanhosCategoria = $this->acoes->getByFieldAll('pizzaTamanhosCategoria', 'id_empresa', $empresa->id);
        $carrinho = $this->acoes->getByFieldTwoAll('carrinho', 'id_empresa', $empresa->id, 'numero_pedido', $pedido->numero_pedido);
        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);

        $adicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $sabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $tipo = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
        $pagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);

        if ($endereco) {
            $cFrete = $this->calculoFrete->calculo($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);
            $infoKm = $this->calculoFrete->infoKm($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);

            $termo = 'km';
            $pattern = '/' . $termo . '/';
            if (preg_match($pattern, $infoKm)) {
                $cFrete = $cFrete;
            } else {
                $cFrete = 1;
            }

            //dd($infoKm);
            $taxa_entrega = $delivery->taxa_entrega;
            $km_entrega = $delivery->km_entrega;

            $taxa_entrega2 = $delivery->taxa_entrega2;
            $km_entrega2 = $delivery->km_entrega2;

            $taxa_entrega3 = $delivery->taxa_entrega3;
            $km_entrega3 = $delivery->km_entrega3;

            $km_entrega_excedente = $delivery->km_entrega_excedente;
            $valor_excedente = $delivery->valor_excedente;


            if ($cFrete <= $km_entrega) {
                $total = $taxa_entrega;
                if ($cFrete > $km_entrega && $cFrete <= $km_entrega_excedente) {
                    $kmACalcular = ((int)$cFrete - $delivery->km_entrega);
                    $freteVezes = ($kmACalcular * $valor_excedente);
                    $taxa_entregaNova = $taxa_entrega + $freteVezes;
                    $total = $taxa_entregaNova;
                }
            }

            if ($delivery->km_entrega_excedente != 0) {
                $deliveryEntregaExcedente = $delivery->km_entrega_excedente;
            }

            if ($km_entrega2 != 0.00) {
                if ($cFrete > $km_entrega && $cFrete <= $km_entrega2) {
                    $total = $taxa_entrega2;
                }

                if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega_excedente) {
                    $kmACalcular = ((int)$cFrete - $delivery->km_entrega2);
                    $freteVezes = ($kmACalcular * $valor_excedente);
                    $taxa_entregaNova = $taxa_entrega2 + $freteVezes;
                    $total = $taxa_entregaNova;

                    //dd($total);
                }

                if ($delivery->km_entrega_excedente == 0) {
                    $deliveryEntregaExcedente = $delivery->km_entrega2;
                }
            }

            if ($km_entrega3 != 0.00) {
                if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega3) {
                    $total = $taxa_entrega3;
                }

                if ($cFrete > $km_entrega3 && $cFrete <= $km_entrega_excedente) {
                    $kmACalcular = ((int)$cFrete - $delivery->km_entrega3);
                    $freteVezes = ($kmACalcular * $valor_excedente);
                    $taxa_entregaNova = $taxa_entrega3 + $freteVezes;
                    $total = $taxa_entregaNova;
                }

                if ($delivery->km_entrega_excedente == 0) {
                    $deliveryEntregaExcedente = $delivery->km_entrega3;
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
        }

        $ultimaVenda = null;
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $pedido->id_cliente, 'id_empresa', $empresa->id);
            $verificaVendaAtiva = $this->acoes->countsTwo('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $pedido->id_cliente);
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);

            if ($verificaVendaAtiva > 0) {
                $ultimaVenda = $this->acoes->limitOrderFill('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $pedido->id_cliente, 'status', 4, 1, 'id', 'DESC');
            }
        }
        $hoje = date('w', strtotime(date('Y-m-d')));
        if ($hoje == 0) {
            $hoje = 7;
        }

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        }

        $this->load('_admin/pedidos/pedidoEditar', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'pedido' => $pedido,

            'pagamento' => $pagamento,
            'tipo' => $tipo,
            'sabores' => $sabores,
            'adicionais' => $adicionais,
            'calculoFrete' => $total,
            'cliente' => $cliente,
            'carrinho' => $carrinho,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'tamanhos' => $tamanhos,
            'tamanhosCategoria' => $tamanhosCategoria,
            'moeda' => $moeda,
            'estabelecimento' => $estabelecimento,
            'produtoSabores' => $resultSabores,
            'planoAtivo' => $planoAtivo,
            'carrinhoqtd' => $resultCarrinhoQtd,
            'produto' => $produto,
            'caixa' => $caixa->status,
            'carrinhoAdicional' => $carrinhoAdicional,
            'valorPedido' => $valorCarrinho,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'categoria' => $categoria
        ]);
    }
    public function carrinhoQtd($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($this->sessao->getSessao('id_cliente')) {
            $contagem = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);
            echo $contagem;
        }
    }

    public function carrinhoAddProdutoPizza($data)
    {
        $tamanho = $this->acoes->getByField('pizzaTamanhos', 'id', $data['tamanho']);
        $massa = $this->acoes->getByField('pizzaMassas', 'id', $data['borda']);

        $quantidade = "";
        if ($data['tipo'] == 1) {
            $quantidade == "INTEIRA";
        } else if ($data['tipo'] == 2) {
            $quantidade == "MEIO A MEIO";
        } else {
            $quantidade == $data['tipo'] . " SABORES";
        }

        /**
         * Soma dos valores pegando pelo valor da pizza maior
         */
        $idProduto = 0;
        $valor = 0;
        if (is_array($data['pizza'])) {
            $i = 1;
            $sabor = "";
            $arrValor = array();
            foreach ($data['pizza'] as $key => $cart) {
                $idProduto = $cart;
                $pizzaValor = $this->acoes->getByFieldTwo('pizzaProdutoValor', 'id_produto', $cart, 'id_tamanho', $data['tamanho']);
                $pizzaNome = $this->acoes->getByField('produtos', 'id', $cart);
                $sabor .= $i++ . '/' . $data['tipo'] . ' [' . $pizzaNome->cod . '] ' . $pizzaNome->nome . ' - ';
                array_push($arrValor, $pizzaValor->valor);
            }
            $saborfinal = rtrim($sabor, ' - ');
            $nomePizza = "PIZZA {$tamanho->nome} {$data['tipo']} SABORES - {$massa->nome} - {$saborfinal}";
        }
        $valorFinal = $massa->valor + $this->geral->max_key($arrValor);


        /**
         * Soma dos valores dividindo pelo tipo de pizza
         * 
         * if(is_array($data['pizza'])){
         *  $i = 1;
         *   $sabor = "";
         *   foreach ($data['pizza'] as $key => $cart) {
         *       $idProduto = $cart;              
         *        $pizzaValor = $this->acoes->getByFieldTwo('pizzaProdutoValor', 'id_produto', $cart,'id_tamanho', $data['tamanho']);
         *        $pizzaNome = $this->acoes->getByField('produtos', 'id', $cart);
         *        $sabor .= $i++.'/'.$data['tipo'].' '.$pizzaNome->nome.' - ';
         *        $valor += ($pizzaValor->valor / $data['tipo']);
         *    }
         *    $saborfinal = rtrim($sabor, ' - ');
         *    $nomePizza = "PIZZA {$tamanho->nome} {$data['tipo']} SABORES - {$massa->nome} - {$saborfinal}";
         *    //dd($sabor);
         * }
         */



        $valor = new Carrinho();
        $valor->id_produto = $idProduto;
        $valor->id_cliente = $this->sessao->getSessao('id_cliente');
        $valor->id_empresa = $data['id_empresa'];
        $valor->quantidade = $data['quantity'];
        $valor->observacao = $data['observacao'];
        $valor->valor = $valorFinal;
        $valor->variacao = $nomePizza;
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Produto Adicionado ao carrinho', 'error' => 'Não foi posível adicionar o produto ao carrinho', 'code' => 520]);
        exit($json);
    }

    public function carrinhoEditarProdutoPizza($data)
    {
        $pedido = $this->acoes->getByField('carrinhoPedidos', 'numero_pedido', $data['numero_pedido'], 'id_empresa', $data['id_empresa']);

        $tamanho = $this->acoes->getByField('pizzaTamanhos', 'id', $data['tamanho']);
        $massa = $this->acoes->getByField('pizzaMassas', 'id', $data['borda']);

        $quantidade = "";
        if ($data['tipo'] == 1) {
            $quantidade == "INTEIRA";
        } else if ($data['tipo'] == 2) {
            $quantidade == "MEIO A MEIO";
        } else {
            $quantidade == $data['tipo'] . " SABORES";
        }

        /**
         * Soma dos valores pegando pelo valor da pizza maior
         */
        $idProduto = 0;
        $valor = 0;
        if (is_array($data['pizza'])) {
            $i = 1;
            $sabor = "";
            $arrValor = array();
            foreach ($data['pizza'] as $key => $cart) {
                $idProduto = $cart;
                $pizzaValor = $this->acoes->getByFieldTwo('pizzaProdutoValor', 'id_produto', $cart, 'id_tamanho', $data['tamanho']);
                $pizzaNome = $this->acoes->getByField('produtos', 'id', $cart);
                $sabor .= $i++ . '/' . $data['tipo'] . ' ' . $pizzaNome->cod . ' ' . $pizzaNome->nome . ' - ';
                array_push($arrValor, $pizzaValor->valor);
            }
            $saborfinal = rtrim($sabor, ' - ');
            $nomePizza = "PIZZA {$tamanho->nome} {$data['tipo']} SABORES - {$massa->nome} - {$saborfinal}";
        }
        $valorFinal = $massa->valor + $this->geral->max_key($arrValor);


        /**
         * Soma dos valores dividindo pelo tipo de pizza
         * 
         * if(is_array($data['pizza'])){
         *  $i = 1;
         *   $sabor = "";
         *   foreach ($data['pizza'] as $key => $cart) {
         *       $idProduto = $cart;              
         *        $pizzaValor = $this->acoes->getByFieldTwo('pizzaProdutoValor', 'id_produto', $cart,'id_tamanho', $data['tamanho']);
         *        $pizzaNome = $this->acoes->getByField('produtos', 'id', $cart);
         *        $sabor .= $i++.'/'.$data['tipo'].' '.$pizzaNome->nome.' - ';
         *        $valor += ($pizzaValor->valor / $data['tipo']);
         *    }
         *    $saborfinal = rtrim($sabor, ' - ');
         *    $nomePizza = "PIZZA {$tamanho->nome} {$data['tipo']} SABORES - {$massa->nome} - {$saborfinal}";
         *    //dd($sabor);
         * }
         */

        $valor = new Carrinho();
        $valor->id_produto = $idProduto;
        $valor->id_cliente = $pedido->id_cliente;
        $valor->id_empresa = $data['id_empresa'];
        $valor->quantidade = $data['quantity'];
        $valor->observacao = $data['observacao'];
        $valor->numero_pedido = $data['numero_pedido'];
        $valor->valor = $valorFinal;
        $valor->variacao = $nomePizza;
        $valor->save();


        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Produto Adicionado ao pedido', 'error' => 'Não foi posível adicionar o produto ao pedido', 'code' => 520, 'url' => "pedido/editar/produtos/{$pedido->id}"]);
        exit($json);
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

    public function carrinhoEditarProduto($data)
    {
        $pedido = $this->acoes->getByField('carrinhoPedidos', 'numero_pedido', $data['numero_pedido'], 'id_empresa', $data['id_empresa']);
        //dd($data);
        $sabores = null;
        if ($data['sabores']) {
            $sabores = $data['sabores'][0];
        }

        $valor = new Carrinho();
        $valor->id_produto = $data['id'];
        $valor->id_cliente = $pedido->id_cliente;
        $valor->id_empresa = $data['id_empresa'];
        $valor->quantidade = $data['quantity'];
        $valor->numero_pedido = $data['numero_pedido'];
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
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Produto Adicionado ao pedido', 'error' => 'Não foi posível adicionar o produto ao pedido', 'code' => 520, 'url' => "pedido/editar/produtos/{$pedido->id}"]);
        exit($json);
    }

    public function produtoMostrar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
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
            'nivelUsuario' => $this->sessao->getNivel(),
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'produtoSabores' => $resultSabores,
            'carrinhoqtd' => $verificaVendaAtiva,
            'chave' => md5(uniqid(rand(), true)),
            'caixa' => $caixa->status
        ]);
    }
    public function produtoMostrarEditar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
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

        $this->load('_admin/pedidos/produtoMostrarEditar', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'moeda' => $moeda,
            'produto' => $produto,
            'numero_pedido' => $data['numero_pedido'],
            'planoAtivo' => $planoAtivo,
            'produtoAdicional' => $resultProdutoAdicional,
            'nivelUsuario' => $this->sessao->getNivel(),
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'produtoSabores' => $resultSabores,
            'carrinhoqtd' => $verificaVendaAtiva,
            'chave' => md5(uniqid(rand(), true)),
            'caixa' => $caixa->status
        ]);
    }




    public function produtoPizzaMostrar($data)
    {
        //dd($data);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $tamanho = $this->acoes->getByField('pizzaTamanhos', 'id', $data['tamanho']);
        $tamanhosCategoria = $this->acoes->getByFieldAll('pizzaTamanhosCategoria', 'id_empresa', $empresa->id);

        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produtos = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $produtoValor = $this->acoes->getByFieldAll('pizzaProdutoValor', 'id_empresa', $empresa->id, 'id_tamanho', $data['tamanho']);
        $massaTamanho = $this->acoes->getByFieldAll('pizzaMassasTamanhos', 'id_empresa', $empresa->id);

        $pizzaMassasTamanhos = $this->acoes->getByFieldAll('pizzaMassasTamanhos', 'id_empresa', $empresa->id);
        $pizzaMassas = $this->acoes->getByFieldAllOrder('pizzaMassas', 'id_empresa', $empresa->id, 'nome DESC');

        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
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

        $this->load('_admin/pedidos/produtoPizzaMostrar', [
            'empresa' => $empresa,
            'pizzaMassas' => $pizzaMassas,
            'massasTamanho' => $massaTamanho,
            'pizzaMassasTamanhos' => $pizzaMassasTamanhos,
            'produtos' => $produtos,
            'produtoValor' => $produtoValor,
            'empresa' => $empresa,
            'delivery' => $delivery,
            'categoria' => $categoria,
            'tamanhosCategoria' => $tamanhosCategoria,
            'tamanho' => $tamanho,
            'categoria' => $categoria,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'moeda' => $moeda,
            'planoAtivo' => $planoAtivo,
            'produtoAdicional' => $resultProdutoAdicional,
            'nivelUsuario' => $this->sessao->getNivel(),
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'produtoSabores' => $resultSabores,
            'carrinhoqtd' => $verificaVendaAtiva,
            'chave' => md5(uniqid(rand(), true)),
            'caixa' => $caixa->status
        ]);
    }

    public function produtoPizzaMostrarEditar($data)
    {
        //dd($data);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $tamanho = $this->acoes->getByField('pizzaTamanhos', 'id', $data['tamanho']);
        $tamanhosCategoria = $this->acoes->getByFieldAll('pizzaTamanhosCategoria', 'id_empresa', $empresa->id);

        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produtos = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $produtoValor = $this->acoes->getByFieldAll('pizzaProdutoValor', 'id_empresa', $empresa->id, 'id_tamanho', $data['tamanho']);
        $massaTamanho = $this->acoes->getByFieldAll('pizzaMassasTamanhos', 'id_empresa', $empresa->id);

        $pizzaMassasTamanhos = $this->acoes->getByFieldAll('pizzaMassasTamanhos', 'id_empresa', $empresa->id);
        $pizzaMassas = $this->acoes->getByFieldAllOrder('pizzaMassas', 'id_empresa', $empresa->id, 'nome DESC');

        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
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

        $this->load('_admin/pedidos/produtoPizzaMostrarEditar', [
            'empresa' => $empresa,
            'pizzaMassas' => $pizzaMassas,
            'massasTamanho' => $massaTamanho,
            'pizzaMassasTamanhos' => $pizzaMassasTamanhos,
            'produtos' => $produtos,
            'produtoValor' => $produtoValor,
            'empresa' => $empresa,
            'delivery' => $delivery,
            'categoria' => $categoria,
            'tamanhosCategoria' => $tamanhosCategoria,
            'tamanho' => $tamanho,
            'numero_pedido' => $data['numero_pedido'],
            'categoria' => $categoria,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'moeda' => $moeda,
            'planoAtivo' => $planoAtivo,
            'produtoAdicional' => $resultProdutoAdicional,
            'nivelUsuario' => $this->sessao->getNivel(),
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'produtoSabores' => $resultSabores,
            'carrinhoqtd' => $verificaVendaAtiva,
            'chave' => md5(uniqid(rand(), true)),
            'caixa' => $caixa->status
        ]);
    }

    public function carrinho($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);

        $categoria = $this->acoes->getByFieldAllOrder('categorias', 'id_empresa', $empresa->id, 'posicao ASC');
        $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
        $tamanhosCategoria = $this->acoes->getByFieldAll('pizzaTamanhosCategoria', 'id_empresa', $empresa->id);


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

            if ($endereco) {
                $cFrete = $this->calculoFrete->calculo($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);
                $infoKm = $this->calculoFrete->infoKm($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);

                $termo = 'km';
                $pattern = '/' . $termo . '/';
                if (preg_match($pattern, $infoKm)) {
                    $cFrete = $cFrete;
                } else {
                    $cFrete = 1;
                }

                //dd($infoKm);
                $taxa_entrega = $delivery->taxa_entrega;
                $km_entrega = $delivery->km_entrega;

                $taxa_entrega2 = $delivery->taxa_entrega2;
                $km_entrega2 = $delivery->km_entrega2;

                $taxa_entrega3 = $delivery->taxa_entrega3;
                $km_entrega3 = $delivery->km_entrega3;

                $km_entrega_excedente = $delivery->km_entrega_excedente;
                $valor_excedente = $delivery->valor_excedente;




                if ($cFrete <= $km_entrega) {
                    $total = $taxa_entrega;
                    if ($cFrete > $km_entrega && $cFrete <= $km_entrega_excedente) {
                        $kmACalcular = ((int)$cFrete - $delivery->km_entrega);
                        $freteVezes = ($kmACalcular * $valor_excedente);
                        $taxa_entregaNova = $taxa_entrega + $freteVezes;
                        $total = $taxa_entregaNova;
                    }
                }

                if ($delivery->km_entrega_excedente != 0) {
                    $deliveryEntregaExcedente = $delivery->km_entrega_excedente;
                }

                if ($km_entrega2 != 0.00) {
                    if ($cFrete > $km_entrega && $cFrete <= $km_entrega2) {
                        $total = $taxa_entrega2;
                    }

                    if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega_excedente) {
                        $kmACalcular = ((int)$cFrete - $delivery->km_entrega2);
                        $freteVezes = ($kmACalcular * $valor_excedente);
                        $taxa_entregaNova = $taxa_entrega2 + $freteVezes;
                        $total = $taxa_entregaNova;

                        //dd($total);
                    }

                    if ($delivery->km_entrega_excedente == 0) {
                        $deliveryEntregaExcedente = $delivery->km_entrega2;
                    }
                }

                if ($km_entrega3 != 0.00) {
                    if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega3) {
                        $total = $taxa_entrega3;
                    }

                    if ($cFrete > $km_entrega3 && $cFrete <= $km_entrega_excedente) {
                        $kmACalcular = ((int)$cFrete - $delivery->km_entrega3);
                        $freteVezes = ($kmACalcular * $valor_excedente);
                        $taxa_entregaNova = $taxa_entrega3 + $freteVezes;
                        $total = $taxa_entregaNova;
                    }

                    if ($delivery->km_entrega_excedente == 0) {
                        $deliveryEntregaExcedente = $delivery->km_entrega3;
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
            'tamanhosCategoria' => $tamanhosCategoria,
            'tamanhos' => $tamanhos,
            'produtos' => $produtos,
            'adicionais' => $adicionais,
            'sabores' => $sabores,
            'tipo' => $tipo,
            'planoAtivo' => $planoAtivo,
            'pagamento' => $pagamento,
            'numero_pedido' => $this->sessao->getSessao('numeroPedido'),
            'nivelUsuario' => $this->sessao->getNivel(),
            'valorPedido' => $valorCarrinho,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'caixa' => $caixa->status
        ]);
    }


    public function carrinhoFinalizar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);

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

            if ($endereco) {
                $cFrete = $this->calculoFrete->calculo($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);
                $infoKm = $this->calculoFrete->infoKm($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);

                $termo = 'km';
                $pattern = '/' . $termo . '/';
                if (preg_match($pattern, $infoKm)) {
                    $cFrete = $cFrete;
                } else {
                    $cFrete = 1;
                }

                //dd($infoKm);
                //dd($cFrete);
                $taxa_entrega = $delivery->taxa_entrega;
                $km_entrega = $delivery->km_entrega;

                $taxa_entrega2 = $delivery->taxa_entrega2;
                $km_entrega2 = $delivery->km_entrega2;

                $taxa_entrega3 = $delivery->taxa_entrega3;
                $km_entrega3 = $delivery->km_entrega3;

                $km_entrega_excedente = $delivery->km_entrega_excedente;
                $valor_excedente = $delivery->valor_excedente;


                if ($cFrete <= $km_entrega) {
                    $total = $taxa_entrega;
                    if ($cFrete > $km_entrega && $cFrete <= $km_entrega_excedente) {
                        $kmACalcular = ((int)$cFrete - $delivery->km_entrega);
                        $freteVezes = ($kmACalcular * $valor_excedente);
                        $taxa_entregaNova = $taxa_entrega + $freteVezes;
                        $total = $taxa_entregaNova;
                    }
                }

                if ($delivery->km_entrega_excedente != 0) {
                    $deliveryEntregaExcedente = $delivery->km_entrega_excedente;
                }

                if ($km_entrega2 != 0.00) {
                    if ($cFrete > $km_entrega && $cFrete <= $km_entrega2) {
                        $total = $taxa_entrega2;
                    }

                    if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega_excedente) {
                        $kmACalcular = ((int)$cFrete - $delivery->km_entrega2);
                        $freteVezes = ($kmACalcular * $valor_excedente);
                        $taxa_entregaNova = $taxa_entrega2 + $freteVezes;
                        $total = $taxa_entregaNova;

                        //dd($total);
                    }

                    if ($delivery->km_entrega_excedente == 0) {
                        $deliveryEntregaExcedente = $delivery->km_entrega2;
                    }
                }

                if ($km_entrega3 != 0.00) {
                    if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega3) {
                        $total = $taxa_entrega3;
                    }

                    if ($cFrete > $km_entrega3 && $cFrete <= $km_entrega_excedente) {
                        $kmACalcular = ((int)$cFrete - $delivery->km_entrega3);
                        $freteVezes = ($kmACalcular * $valor_excedente);
                        $taxa_entregaNova = $taxa_entrega3 + $freteVezes;
                        $total = $taxa_entregaNova;
                    }

                    if ($delivery->km_entrega_excedente == 0) {
                        $deliveryEntregaExcedente = $delivery->km_entrega3;
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
            'nivelUsuario' => $this->sessao->getNivel(),
            'valorPedido' => $valorCarrinho,
            'endereco' => $endereco,
            'km' => $cFrete,
            'km_entrega_excedente' => $km_entrega_excedente,
            'km_entrega' => $km_entrega,
            'caixa' => $caixa->status
        ]);
    }

    //Finaliza e fecha o pedido do cliente
    public function carrinhoFinalizarPedido($data)
    {
        if($data['tipo_frete']){
            $tipo_frete = $data['tipo_frete'];
        }else{
            $tipo_frete = 1;
        }

        if($data['valor_frete']){
            $valor_frete = $data['valor_frete'];
        }else{
            $valor_frete = 0;
        }
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $carrinho = $this->acoes->getByFieldAllTwoNull('carrinho', 'id_cliente', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
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
        $pedido->tipo_frete = $tipo_frete;
        $pedido->data_pedido = date('Y-m-d');
        $pedido->hora = date('H:i:s');
        $pedido->status = 1;
        $pedido->pago = 0;
        $pedido->desconto = $this->geral->brl2decimal($data['desconto']);
        $pedido->observacao = $data['observacao'];
        $pedido->numero_pedido = $data['numero_pedido'];
        $pedido->valor_frete = $valor_frete;
        $pedido->km = $data['km'];
        $pedido->chave = $chave;
        $pedido->save();

        //dd($pedido);

        $user = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $this->sessao->getSessao('id_cliente'), 'id_empresa', $empresa->id);

        if ($user) {
            $userUp = (new UsuariosEmpresa())->findById($user->id);
            $userUp->pedidos = $user->pedidos + 1;
            $userUp->save();
        } else {
            $userUp = new UsuariosEmpresa();
            $userUp->id_empresa = $empresa->id;
            $userUp->id_usuario = $this->sessao->getSessao('id_cliente');
            $userUp->nivel = 3;
            $userUp->pedidos = 1;
            $userUp->save();
        }

        //$cliente = $this->acoes->getByField('usuarios', 'id', $this->sessao->getSessao('id_cliente'));
        //$mensagem =  "Você acaba de efetuar um pedido no {$empresa->nome_fantasia} esse é seu número de pedido: {$data['numero_pedido']}. Para acompanhar seu pedido acesse nosso site, faça o login usando o número de Telefone informado no momento do pedido. Para acompanhar acesse o link: https://www.automatizadelivery.com.br/{$empresa->link_site}/login";
        //$ddi = '+55';
        //$numerofinal = $ddi . $cliente->telefone;

        //$client = new Client(TWILIO['account_sid'], TWILIO['auth_token']);
        //$client->messages->create($numerofinal, array('from' => TWILIO['number'], 'body' => $mensagem));

        header('Content-Type: application/json');
        $json = json_encode(['id' => $pedido->id, 'resp' => 'insert', 'mensagem' => 'Pedido finalizado com sucesso', 'code' => 2,  'url' => 'admin/pedidos', 'pedido' => $data['numero_pedido']]);
        exit($json);
    }


    public function carrinhoFinalizarPedidoEditar($data)
    {
        $pedido = (new CarrinhoPedidos())->findById($data['id']);
        $pedido->total = $data['total'];
        $pedido->total_pago = $data['total_pago'];
        $pedido->troco = $data['troco'];
        $pedido->desconto = $this->geral->brl2decimal($data['desconto']);;
        $pedido->tipo_pagamento = $data['tipo_pagamento'];
        $pedido->observacao = $data['observacao_final'];
        $pedido->valor_frete = $data['valor_frete'];
        $pedido->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $pedido->id, 'resp' => 'insert', 'mensagem' => 'Pedido editado com sucesso', 'code' => 2,  'url' => 'admin/pedidos', 'pedido' => $data['numero_pedido']]);
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

    public function deletarItemCarrinhoEditar($data)
    {
        $resultProduto = $this->acoes->getByFieldAll('carrinhoAdicional', 'id_carrinho', $data['id_carrinho']);

        $valor = (new Carrinho())->findById($data['id_carrinho']);
        $valor->destroy();

        if ($resultProduto) {
            foreach ($resultProduto as $res) {
                $valorAd = (new CarrinhoAdicional())->findById($res->id);
                $valorAd->destroy();
            }
            redirect(BASE . "{$data['linkSite']}/admin/pedido/editar/produtos/{$data['pedido']}");
        }
        redirect(BASE . "{$data['linkSite']}/admin/pedido/editar/produtos/{$data['pedido']}");
    }

    public function carrinhoCadastroValida($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $getTelefone = $this->acoes->getByField('usuarios', 'telefone', preg_replace('/[^0-9]/', '', $data['telefone']));

        if ($getTelefone->id > 0) {
            $usuario = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $getTelefone->id, 'id_empresa', $empresa->id);

            if ($usuario) {
                header('Content-Type: application/json');
                $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Cliente já possuí conta cadastrada no sistema']);
                exit($json);
            } else {
                $valorEmp = new UsuariosEmpresa();
                $valorEmp->id_usuario = $getTelefone->id;
                $valorEmp->id_empresa = $empresa->id;
                $valorEmp->nivel = 3;
                $valorEmp->save();

                if ($valorEmp->id > 0) {
                    if ($data['entrega'] == 1) {
                        $valorEnd = new UsuariosEnderecos();
                        $valorEnd->id_usuario = $getTelefone->id;
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
                    $this->sessao->sessaoNew('id_cliente', $getTelefone->id);

                    header('Content-Type: application/json');
                    $json = json_encode(['id' => $valorEmp->id, 'resp' => 'insert', 'mensagem' => 'Cliente Cadastrado com sucesso', 'code' => 5,  'url' => 'admin/pedido/novo/produtos']);
                    exit($json);
                }
            }
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

            if ($valor->id > 0) {
                $valorEmp = new UsuariosEmpresa();
                $valorEmp->id_usuario = $valor->id;
                $valorEmp->id_empresa = $empresa->id;
                $valorEmp->nivel = 3;
                $valorEmp->save();
            }

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
            $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Cliente Cadastrado com sucesso', 'code' => 5,  'url' => 'admin/pedido/novo/produtos']);
            exit($json);
        }
    }
}

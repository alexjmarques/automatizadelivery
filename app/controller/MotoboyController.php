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
use Bcrypt\Bcrypt;
use Mobile_Detect;
use app\classes\Sessao;
use app\Models\CarrinhoEntregas;
use app\Models\CarrinhoPedidos;
use app\Models\Usuarios;
use app\Models\UsuariosEmpresa;
use Browser;


class MotoboyController extends Controller
{
    private $acoes;
    private $sessao;
    private $geral;
    private $bcrypt;
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
        $this->bcrypt = new Bcrypt();
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
    public function index($data)
    {
        //dd($data);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultDelivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        //dd($resultDelivery);

        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        if ($this->sessao->getUser()) {
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

            $resultCarrinhoQtd = $this->acoes->countsFour('carrinhoEntregas', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser(), 'id_caixa', $estabelecimento[0]->id, 'status', 3);


            $entregasFeitas = $this->acoes->sumFielsTree('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser(), 'status', 4, 'valor_frete');

            $resultEntregasDiaCont = $this->acoes->countsFour('carrinhoEntregas', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser(), 'id_caixa', $estabelecimento[0]->id, 'status', 4);
            $totalMotoboyDia = $this->acoes->sumFielsFour('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser(), 'id_caixa', $estabelecimento[0]->id, 'status', 4, 'valor_frete');

            //dd($resultEntregasDiaCont);

            $entregasFeitasDia = $totalMotoboyDia->total - ($resultEntregasDiaCont * $resultDelivery->taxa_entrega_motoboy);

            //dd($entregasFeitasDia);

            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            if ($this->sessao->getNivel() == 0) {
                redirect(BASE . "{$empresa->link_site}/admin");
            }
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/motoboy/login");
        }

        $this->load('_motoboy/relatorio/main', [
            'empresa' => $empresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'entregasFeitas' => $entregasFeitas,
            'entregasFeitasDia' => $entregasFeitasDia,
            'entregasDia' => $resultEntregasDiaCont,
            'frete' => $resultDelivery,
            'moeda' => $moeda,
            'mesAtual' => date('m'),
            'usuarioAtivo' => $resulUsuario,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status

        ]);
    }

    public function login($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            redirect(BASE . "{$empresa->link_site}/motoboy");
        }

        $this->load('_motoboy/login/main', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status

        ]);
    }

    public function loginValida($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $motoboy = $this->acoes->getByField('usuarios', 'telefone', preg_replace('/[^0-9]/', '', $data['telefone']));
        if ($motoboy) {
            if ($this->bcrypt->verify($data['senha'], $motoboy->senha)) {

                $this->sessao->sessaoNew('id_usuario', $motoboy->id);
                $this->sessao->sessaoNew('usuario', $motoboy->email);
                $this->sessao->sessaoNew('nivel', $motoboy->nivel);

                header('Content-Type: application/json');
                $json = json_encode(['id' => $motoboy->id, 'resp' => 'login', 'mensagem' => 'Aguarde estamos redirecionando para a pagina inicial','code' => 2 ,  'url' => 'motoboy']);
                exit($json);
            } else {
                header('Content-Type: application/json');
                $json = json_encode(['link' => "", 'resp' => 'login', 'error' => "Senha incorreta. Verifique se digitou sua senha corretamente!"]);
                exit($json);
            }

            $nivel = $this->acoes->getByField('usuariosEmpresa', 'id_usuario', $motoboy->id);
            if ($nivel->nivel == 1) {
            } else {
                $valorEmp = new UsuariosEmpresa();
                $valorEmp->id_usuario = $motoboy->id;
                $valorEmp->id_empresa = $empresa->id;
                $valorEmp->pedidos = 0;
                $valorEmp->nivel = $data['nivel'];
                $valorEmp->save();
            }
        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Este número de telefone não esta registrado em nosso sistema, Verifique e tente novamente', 'error' => 'Este número de telefone não esta registrado em nosso sistema, Verifique e tente novamente']);
            exit($json);
        }
    }

    public function cadastro($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/login/cadastro', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status

        ]);
    }

    public function insert($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $telefone = $this->acoes->getByField('usuarios', 'telefone', preg_replace('/[^0-9]/', '', $data['telefone']));

        if ($telefone) {
            $nivel = $this->acoes->getByField('usuariosEmpresa', 'id_usuario', $telefone->id);
            if ($nivel->nivel == 1) {
                header('Content-Type: application/json');
                $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Número de telefone já cadastrado em nossa plataforma', 'error' => 'Número de telefone já cadastrado em nossa plataforma','code' => 2 ,  'url' => 'motoboy/login']);
                exit($json);
            } else {
                $valorEmp = new UsuariosEmpresa();
                $valorEmp->id_usuario = $telefone->id;
                $valorEmp->id_empresa = $empresa->id;
                $valorEmp->pedidos = 0;
                $valorEmp->nivel = $data['nivel'];
                $valorEmp->save();
            }
        } else {
            $email = $data['email'];
            if ($data['email'] == null) {
                $hash =  md5(uniqid(rand(), true));
                $email = $hash . '@automatizadelivery.com.br';
            }

            if ($data['senha']) {
                $senha = $this->bcrypt->encrypt($data['senha'], '2a');
            }

            $valor = new Usuarios();
            $valor->nome = $data['nome'];
            $valor->email = $email;
            $valor->telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
            $valor->senha = $senha;
            $valor->nivel = $data['nivel'];
            $valor->save();

            $valorEmp = new UsuariosEmpresa();
            $valorEmp->id_usuario = $valor->id;
            $valorEmp->id_empresa = $empresa->id;
            $valorEmp->nivel = $data['nivel'];
            $valorEmp->pedidos = 0;
            $valorEmp->save();

            header('Content-Type: application/json');
            $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Conta criada com sucesso', 'error' => 'Erro ao criar sua conta','code' => 2 ,  'url' => 'motoboy/login']);
            exit($json);
        }
    }


    public function relatorioMes($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultDelivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $dataEscolhida = $data['mes'];
        if ($dataEscolhida == null) {
            $dataEscolhida = date('m');
        } else {
            $dataEscolhida = $data['mes'];
        }

        $resultPedidos = $this->acoes->getByFieldTwoAll('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser());
        $resultBuscaAll = $this->acoes->getByFieldTwoAll('carrinhoEntregas', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser());

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
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
        ]);
    }


    public function entregas($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($this->sessao->getUser()) {
            $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultPedidoQtd = $this->acoes->countsFour('carrinhoEntregas', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser(), 'id_caixa', $estabelecimento[0]->id, 'status', 4);
        }
        $this->load('_motoboy/pedidos/main', [
            'pedidosQtd' => $resultPedidoQtd,
            'empresa' => $empresa,
            'usuarioAtivo' => $usuarioLogado,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'usuarioLogado' => $usuarioLogado,
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
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        }

        $this->load('_motoboy/pedidos/pesquisarEntrega', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'usuarioLogado' => $usuarioLogado,
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

        $numero_pedido = $data['numero_pedido'];

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $pedidosQtd = $this->acoes->countsTwoNull('carrinhoPedidos', 'id_motoboy', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            if ($numero_pedido != null) {
                $resultVendas = $this->acoes->getByFieldTwo('carrinhoPedidos', 'id_empresa', $empresa->id, 'numero_pedido', $numero_pedido);
                $cliente = $this->acoes->getByField('usuarios', 'id', $resultVendas->id_cliente);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/login");
        }

        $resulCaixa = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
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
            'caixa' => $caixa->status,
            'pedidosQtd' => $pedidosQtd,
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'numero' => $this->geral->formataTelefone($cliente->telefone)
        ]);
    }

    public function pegarEntrega($data)
    {
        $pedido = $this->acoes->getByField('carrinhoPedidos', 'id', $data['pedido']);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $valor = (new CarrinhoPedidos())->findById($data['pedido']);
        $valor->status = 3;
        $valor->id_motoboy = $this->sessao->getUser();
        $valor->save();

        $entregas = new CarrinhoEntregas();
        $entregas->id_motoboy = $this->sessao->getUser();
        $entregas->id_caixa = $estabelecimento[0]->id;
        $entregas->id_cliente = $pedido->id_cliente;
        $entregas->id_empresa = $empresa->id;
        $entregas->numero_pedido = $pedido->numero_pedido;
        $entregas->status = 3;
        $entregas->save();
        redirect(BASE . "{$empresa->link_site}/motoboy/entregas");

        // header('Content-Type: application/json');
        // $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Pedido atribuído ao seu perfil', 'error' => 'Não foi possível atribuír ao seu perfil! Tente novamente','code' => 2 ,  'url' => 'motoboy/entregas']);
        // exit($json);
    }


    public function entregaListar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $status = $this->acoes->getFind('status');
        $resultTipo = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
        $resultPagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);

        $resultBuscaAll = $this->acoes->getByFieldAll('carrinhoEntregas', 'id_empresa', $empresa->id);
        $resultVendas = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser(), 'status', 3);
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resulUsuario = $this->acoes->getByFieldAll('usuarios', 'nivel', 3);
            $enderecos = $this->acoes->getFind('usuariosEnderecos');

            if ($usuarioLogado->nivel == 1) {
                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
                $resultEntregasDiaCont = $this->acoes->countsFour('carrinhoEntregas', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser(), 'id_caixa', $estabelecimento[0]->id, 'status', 4);

                $this->load('_motoboy/pedidos/vendasEntregas', [
                    'moeda' => $moeda,
                    'usuario' => $resulUsuario,
                    'status' => $status,
                    'tipo_frete' => $resultTipo,
                    'enderecos' => $enderecos,
                    'tipo_pagamento' => $resultPagamento,
                    'vendas' => $resultVendas,
                    'pedidosQtd' => $resultEntregasDiaCont,
                    'empresa' => $empresa,
                    'usuarioAtivo' => $usuarioLogado,
                    'trans' => $this->trans,
                    'detect' => new Mobile_Detect(),
                    'usuarioLogado' => $usuarioLogado,
                    'isLogin' => $this->sessao->getUser(),
                ]);
            }
        }
    }



    public function numeroEntregaListar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($usuarioLogado->nivel == 1) {
                $resultCarrinhoQtd = $this->acoes->countsFour('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_motoboy', $this->sessao->getUser(), 'id_caixa', $estabelecimento[0]->id, 'status', 3);

                $this->load('_motoboy/pedidos/pedidoQtd', [
                    'pedidosQtd' => $resultCarrinhoQtd,
                    'empresa' => $empresa,
                    'trans' => $this->trans,
                    'detect' => new Mobile_Detect(),
                    'isLogin' => $this->sessao->getUser(),
                ]);
            }
        }
    }

    public function view($data)
    {

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultDelivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);

        $pedido = $this->acoes->getByFieldTwo('carrinhoPedidos', 'id_empresa', $empresa->id, 'numero_pedido', $data['numero_pedido']);
        $entrega = $this->acoes->getByField('carrinhoEntregas', 'numero_pedido', $data['numero_pedido'], 'id_empresa', $empresa->id);
        $usuario = $this->acoes->getByField('usuarios', 'id', $pedido->id_cliente);
        $endereco = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $usuario->id, 'principal', 1);
        $status = $this->acoes->getFind('status');

        $this->load('_motoboy/pedidos/view', [
            'venda' => $pedido,
            'entrega' => $entrega,
            'status' => $status,
            'usuario' => $usuario,
            'endereco' => $endereco,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }

    public function mudarStatus($data)
    {
        $valor = (new CarrinhoPedidos())->findById($data['id_pedido']);
        $valor->status = $data['status'];
        $valor->save();

        $entrega = (new CarrinhoEntregas())->findById($data['id_entrega']);
        if ($data['observacao']) {
            $entrega->observacao = $data['observacao'];
        }
        $entrega->status = $data['status'];
        $entrega->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Informamos ao estabelecimento o novo Status', 'error' => 'Não foi possivel informamos ao estabelecimento o novo Status! Tente novamente','code' => 2 ,  'url' => 'motoboy']);
        exit($json);
    }
}

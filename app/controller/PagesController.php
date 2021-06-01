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

class PagesController extends Controller
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

    public function index($data)
    {

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $categoria = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $produtoTop5 = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');

        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $ultimaVenda = null;
        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            $verificaVendaAtiva = $this->acoes->countsTwo('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser());

            if ($verificaVendaAtiva > 0) {
                $ultimaVenda = $this->acoes->limitOrderFill('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser(), 'status', 4, 1, 'id', 'DESC');
            }
            // $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresa->id);
        }
        $hoje = date('w', strtotime(date('Y-m-d')));
        if ($hoje == 0) {
            $hoje = 7;
        }


        if ($this->sessao->getUser()) {
            if ($this->sessao->getNivel() != 3) {
                redirect(BASE . "{$empresa->link_site}/motoboy");
            }
        }

        $this->load('home/main', [
            'empresa' => $empresa,
            'moeda' => $moeda,
            'delivery' => $delivery,
            'categoria' => $categoria,
            'produto' => $produto,
            'produtoTop5' => $produtoTop5,
            'dias' => $dias,
            'ultimaVenda' => $ultimaVenda,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'veriFavoritos' => $veriFavoritos,
            'favoritos' => $favoritos,
            'produtoQtd' => $produtoQtd,
            'hoje' =>  $hoje,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }


    public function ultimaVenda($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($this->sessao->getUser()) {
            $ultimaVenda = $this->acoes->limitOrderFill('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser(), 'status', 4, 1, 'id', 'DESC');
            $resultUltimaVenda = $this->acoes->getByFieldTreeMenor('carrinhoPedidos', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'status', 4);
        }
        $status = $this->acoes->getFind('status');
        $this->load('_cliente/pedidos/pedidoStatusHome', [
            'empresa' => $empresa,
            'status' => $status,
            'ultimaVenda' => $resultUltimaVenda,
            'trans' => $this->trans,

        ]);
    }

    public function quemSomos($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $formasPagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);
        $empresaFuncionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        $estados = $this->acoes->getFind('estados');
        $dias = $this->acoes->getFind('dias');
        
        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }
        $this->load('_geral/quem-somos/main', [
            'empresa' => $empresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'usuarioAtivo' => $resulUsuario,
            'endereco' => $empresaEndereco,
            'estados' => $estados,
            'funcionamento' => $empresaFuncionamento,
            'dias' => $dias,
            'formasPagamento' => $formasPagamento,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }

    public function bemVindo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $this->load('_geral/bemVindo/main', [
            'empresa' => $empresa,

        ]);
    }

    public function novoDelivery($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $this->load('_geral/bemVindo/semProduto', [
            'empresa' => $empresa,
            'trans' => $this->trans,

        ]);
    }

    public function contato($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $this->load('_geral/contato/main', [
            'empresa' => $empresa,
            'trans' => $this->trans,

        ]);
    }

    public function delivery($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }
        $this->load('_cliente/contato/main', [
            'empresa' => $empresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }

    public function termosUso($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $this->load('_geral/termosUso/main', [
            'empresa' => $empresa,
            'trans' => $this->trans
        ]);
    }

    public function politicaPrivacidade($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $this->load('_geral/politicaPrivacidade/main', [
            'empresa' => $empresa,
            'trans' => $this->trans
        ]);
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
            'sessao_id' => session_id(),
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}

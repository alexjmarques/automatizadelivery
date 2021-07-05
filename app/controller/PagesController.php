<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\classes\Email;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\classes\Sessao;
use Browser;
use Mobile_Detect;

class PagesController extends Controller
{
    private $acoes;
    private $sessao;
    private $geral;
    private $email;
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
        $this->email = new Email();
    }

    

    public function index($data)
    {
        $empresas = $this->acoes->getFind('empresa');
        $empresaDelivery = $this->acoes->getFind('empresaFrete');
        $empresaEndereco = $this->acoes->getFind('empresaEnderecos');
        $categoria = $this->acoes->getFind('categoriaSeguimentoSub');
        $pedidos = $this->acoes->getFind('carrinhoPedidos');
        $links = $this->acoes->getFind('paginas');

        $this->load('home/home', [
            'links' => $links,
            'empresas' => $empresas,
            'empresaDelivery' => $empresaDelivery,
            'empresaEndereco' => $empresaEndereco,
            'categoria' => $categoria,
            'pedidos' => $pedidos,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function termosUso($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }
        $this->load('_geral/termosUso/main', [
            'empresa' => $empresa,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()
        ]);
    }

    public function politicaPrivacidade($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $links = $this->acoes->getFind('paginas');
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }
        $this->load('_geral/politicaPrivacidade/main', [
            'empresa' => $empresa,
            'links' => $links,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()
        ]);
    }

    public function sobre($data)
    {
        dd($data);
        $this->load('_geral/quem-somos/sobre', [
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function visaoValores($data)
    {
        $this->load('home/visaoValores', [
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function trabalheConosco($data)
    {
        $this->load('home/trabalheConosco', [
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function contatoConosco($data)
    {
        $this->load('home/contato', [
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function home($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($empresa) {
            $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
            $atendimento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
            $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
            $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
            $produtoQtd = $this->acoes->counts('produtos', 'id_empresa', $empresa->id);
            $categoria = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
            $dias = $this->acoes->getFind('dias');
            $produtoTop5 = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');

            $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
            $ultimaVenda = null;
            if ($this->sessao->getUser()) {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
                $verificaVendaAtiva = $this->acoes->countsTwo('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser());
                $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);

                if ($verificaVendaAtiva > 0) {
                    $ultimaVenda = $this->acoes->limitOrderFill('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser(), 'status', 4, 1, 'id', 'DESC');
                    $diahoje = date('d');
                }
                // $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresa->id);
            }
            $hoje = date('w', strtotime(date('Y-m-d')));
            if ($hoje == 0) {
                $hoje = 7;
            }

            if ($this->sessao->getUser()) {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                if ($this->sessao->getNivel() == 1) {
                    redirect(BASE . "{$empresa->link_site}/motoboy");
                }

                if ($this->sessao->getNivel() == 0) {
                    redirect(BASE . "{$empresa->link_site}/admin");
                }
            }
            if ($produtoQtd == 0) {
                redirect(BASE . "{$empresa->link_site}/novo-por-aqui");
            }
        }

        $this->load('home/main', [
            'empresa' => $empresa,
            'endereco' => $empresaEndereco,
            'atendimento' => $atendimento,
            'moeda' => $moeda,
            'delivery' => $delivery,
            'categoria' => $categoria,
            'produto' => $produto,
            'produtoTop5' => $produtoTop5,
            'dias' => $dias,
            'ultimaVenda' => $ultimaVenda,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'enderecoAtivo' => $enderecoAtivo,
            '$diahoje' => $diahoje,
            // 'favoritos' => $favoritos,
            // 'produtoQtd' => $produtoQtd,
            'hoje' =>  $hoje,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()

        ]);
    }


    public function ultimaVenda($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            $ultimaVenda = $this->acoes->limitOrderFill('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser(), 'status', 4, 1, 'id', 'DESC');
            $resultUltimaVenda = $this->acoes->getByFieldTreeMenor('carrinhoPedidos', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'status', 4);
        }
        $status = $this->acoes->getFind('status');
        $this->load('_cliente/pedidos/pedidoStatusHome', [
            'empresa' => $empresa,
            'status' => $status,
            'ultimaVenda' => $resultUltimaVenda,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()
        ]);
    }

    public function quemSomos($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $formasPagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);
        $empresaFuncionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $estados = $this->acoes->getFind('estados');
        $dias = $this->acoes->getFind('dias');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }
        $this->load('_geral/quem-somos/main', [
            'empresa' => $empresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'usuarioAtivo' => $resulUsuario,
            'endereco' => $empresaEndereco,
            'estados' => $estados,
            'funcionamento' => $empresaFuncionamento,
            'enderecoAtivo' => $enderecoAtivo,
            'dias' => $dias,
            'formasPagamento' => $formasPagamento,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }

    public function bemVindo($data)
    {
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $this->load('_geral/bemVindo/main', [
            'empresa' => $empresa,
            'enderecoAtivo' => $enderecoAtivo,
            'detect' => new Mobile_Detect()
        ]);
    }

    public function novoDelivery($data)
    {
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $this->load('_geral/bemVindo/semProduto', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'enderecoAtivo' => $enderecoAtivo,
            'detect' => new Mobile_Detect()
        ]);
    }

    public function contato($data)
    {
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $this->load('_geral/contato/main', [
            'empresa' => $empresa,
            'trans' => $this->trans,
            'enderecoAtivo' => $enderecoAtivo,
            'detect' => new Mobile_Detect()
        ]);
    }

    public function delivery($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }
        $links = $this->acoes->getFind('paginas');

        $this->load('_cliente/contato/main', [
            'empresa' => $empresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'usuarioAtivo' => $resulUsuario,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'links' => $links,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }

    public function paginas($data)
    {
        $links = $this->acoes->getFind('paginas');
        $paginas = $this->acoes->getByField('paginas', 'slug', $data['slug']);
        $this->load('_geral/paginas/main', [
            'page' => $paginas,
            'links' => $links,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function contatoPage($data)
    {
        $links = $this->acoes->getFind('paginas');
        $this->load('_geral/paginas/contato', [
            'links' => $links,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function contatoSend($data)
    {
        $this->email->contato($data['nome'], $data['email'], $data['telefone'], $data['msn']);

        header('Content-Type: application/json');
        $json = json_encode(['id' => 1, 'resp' => 'send', 'mensagem' => 'Email enviado com sucesso', 'error' => 'Não foi possível enviar tente novamente mais tarde','code' => 2 ,  'url' => 'institucional/contato', 'code' => 12]);
        exit($json);
        redirect("https://automatizadelivery.com.br/institucional/contato");
    }
    
}

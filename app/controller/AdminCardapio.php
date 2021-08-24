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

class AdminCardapio extends Controller
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
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');

        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $qtdTamanho = $this->acoes->counts('pizzaTamanhos', 'id_empresa', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $produtosValor = $this->acoes->getByFieldAll('pizzaProdutoValor', 'id_empresa', $empresa->id);

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }
        if ($empresa) {
            $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
            $atendimento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
            $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
            $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
            $produtoQtd = $this->acoes->counts('produtos', 'id_empresa', $empresa->id);

            $categoria = $this->acoes->getByFieldAllOrder('categorias', 'id_empresa', $empresa->id, 'posicao ASC');
            $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
            $tamanhosCategoria = $this->acoes->getByFieldAll('pizzaTamanhosCategoria', 'id_empresa', $empresa->id);


            $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
            $ultimaVenda = null;
            if ($this->sessao->getUser()) {
                if ($this->sessao->getUser() != 'undefined') {
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
            }
        }

        $this->load('_admin/cardapio/main', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'endereco' => $empresaEndereco,
            'atendimento' => $atendimento,
            'moeda' => $moeda,
            'delivery' => $delivery,
            'categoria' => $categoria,
            'tamanhosCategoria' => $tamanhosCategoria,
            'tamanhos' => $tamanhos,
            'produto' => $produto,
            'planoAtivo' => $planoAtivo,
            'qtdTamanho' => $qtdTamanho,
            'moeda' => $moeda,
            'ultimaVenda' => $ultimaVenda,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $caixa->status

        ]);
    }
}

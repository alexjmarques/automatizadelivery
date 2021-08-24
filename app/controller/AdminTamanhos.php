<?php

namespace app\controller;

use app\classes\Acoes;
use app\classes\Cache;
use app\core\Controller;
use app\api\iFood\Authetication;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\Models\PizzaTamanhos;
use app\classes\Sessao;
use app\Models\PizzaTamanhosCategoria;

class AdminTamanhos extends Controller
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
        //$this->ifood = new iFood();
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $count = $this->acoes->counts('pizzaTamanhos', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 30, $page);
        $resulttamanhos = $this->acoes->pagination('pizzaTamanhos', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/tamanhos/main', [
            'tamanhos' => $resulttamanhos,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'nivelUsuario' => $this->sessao->getNivel(),
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $caixa->status
        ]);
    }

    public function novo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $categorias = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $this->load('_admin/tamanhos/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'categorias' => $categorias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status
        ]);
    }

    public function editar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $retorno = $this->acoes->getByField('pizzaTamanhos', 'id', $data['id']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $categorias = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $tamanhoCategoria = $this->acoes->getByFieldTwoAll('pizzaTamanhosCategoria', 'id_empresa', $empresa->id, 'id_tamanhos', $data['id']);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $this->load('_admin/tamanhos/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'categorias' => $categorias,
            'tamanhoCategoria' => $tamanhoCategoria,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $caixa->status
        ]);
    }

    public function insert($data)
    {
        $tamanho = new PizzaTamanhos();
        $tamanho->nome = $data['nome'];
        $tamanho->qtd_sabores = $data['qtd_sabores'];
        $tamanho->qtd_pedacos = $data['qtd_pedacos'];
        $tamanho->id_empresa = $data['id_empresa'];
        $tamanho->save();

        if ($tamanho->id > 0) {
            foreach ($data['categorias'] as $res) {
                $tamanhoCat = new PizzaTamanhosCategoria();
                $tamanhoCat->id_categoria = $res;
                $tamanhoCat->id_tamanhos = $tamanho->id;
                $tamanhoCat->id_empresa = $data['id_empresa'];
                $tamanhoCat->save();
            }

            header('Content-Type: application/json');
            $json = json_encode(['id' => $tamanho->id, 'resp' => 'insert', 'mensagem' => 'Tamanho cadastrada com sucesso', 'error' => 'Não foi posível cadastrar a tamanho', 'code' => 2,  'url' => 'admin/tamanhos',]);
            exit($json);
        } else {
            dd("Erro no Tamanho: " . $tamanho);
        }
    }

    public function update($data)
    {
        $tamanho = (new PizzaTamanhos())->findById($data['id']);
        $tamanho->nome = $data['nome'];
        $tamanho->qtd_sabores = $data['qtd_sabores'];
        $tamanho->qtd_pedacos = $data['qtd_pedacos'];
        $tamanho->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $tamanho->id, 'resp' => 'update', 'mensagem' => 'Tamanho atualizada com sucesso', 'error' => 'Não foi posível atualizada a tamanho', 'code' => 2,  'url' => 'admin/tamanhos',]);
        exit($json);
    }

    public function updateItem($data)
    {
        if ($data['tamanhos_categoria']) {
            $valor = (new PizzaTamanhosCategoria())->findById($data['tamanhos_categoria']);
            $valor->destroy();
        } else {
            $tamanhoCat = new PizzaTamanhosCategoria();
            $tamanhoCat->id_categoria = $data['id_categoria'];
            $tamanhoCat->id_tamanhos = $data['id_tamanhos'];
            $tamanhoCat->id_empresa = $data['id_empresa'];
            $tamanhoCat->save();
        }
    }

    public function deletar($data)
    {
        $valor = (new PizzaTamanhos())->findById($data['id']);
        $valor->destroy();

        redirect(BASE . "{$data['estado']}/{$data['linkSite']}/admin/tamanhos");
    }
}

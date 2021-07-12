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
use app\Models\PizzaMassas;
use app\classes\Sessao;
use app\Models\PizzaMassasTamanhos;

class AdminMassas extends Controller
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
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $count = $this->acoes->counts('pizzaMassas', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $resultMassas = $this->acoes->pagination('pizzaMassas', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/massas/main', [
            'massas' => $resultMassas,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
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
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $categorias = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/massas/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'categorias' => $categorias,
            'tamanhos' => $tamanhos,
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
        $retorno = $this->acoes->getByField('pizzaMassas', 'id', $data['id']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $categorias = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $massasTamanhos = $this->acoes->getByFieldAll('pizzaMassasTamanhos', 'id_empresa', $empresa->id);

        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/massas/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'categorias' => $categorias,
            'tamanhos' => $tamanhos,
            'massasTamanhos' => $massasTamanhos,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $caixa->status
        ]);
    }

    public function insert($data)
    {
        
        $massas = new PizzaMassas();
        $massas->nome = $data['nome'];
        $massas->valor = $this->geral->brl2decimal($data['valor']);
        $massas->id_empresa = $data['id_empresa'];
        $massas->save();


        if ($massas->id > 0) {
            foreach ($data['categorias'] as $res) {
                $tamanhoCat = new PizzaMassasTamanhos();
                $tamanhoCat->id_tamanhos = $res;
                $tamanhoCat->id_massas = $massas->id;
                $tamanhoCat->id_empresa = $data['id_empresa'];
                $tamanhoCat->save();
            }

            header('Content-Type: application/json');
            $json = json_encode(['id' => $massas->id, 'resp' => 'insert', 'mensagem' => 'Massa cadastrada com sucesso', 'error' => 'Não foi posível cadastrar a massa', 'code' => 2,  'url' => 'admin/massas',]);
            exit($json);
        } else {
            dd("Erro no Tamanho: " . $massas);
        }

        
    }


    public function update($data)
    {
        $massas = (new PizzaMassas())->findById($data['id']);
        $massas->nome = $data['nome'];
        $massas->valor = $this->geral->brl2decimal($data['valor']);
        $massas->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $massas->id, 'resp' => 'update', 'mensagem' => 'Massa atualizada com sucesso', 'error' => 'Não foi posível atualizada a massa', 'code' => 2,  'url' => 'admin/massas',]);
        exit($json);
    }

    public function updateItem($data)
    {
        //dd($data);
        if ($data['tamanhos_categoria']) {
            $valor = (new PizzaMassasTamanhos())->findById($data['tamanhos_categoria']);
            $valor->destroy();
        } else {
            $tamanhoCat = new PizzaMassasTamanhos();
            $tamanhoCat->id_tamanhos = $data['id_tamanhos'];
            $tamanhoCat->id_massas = $data['id_massas'];
            $tamanhoCat->id_empresa = $data['id_empresa'];
            $tamanhoCat->save();
        }
    }
}

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
use app\classes\Sessao;
use app\Models\CategoriaTipoAdicional;

class AdminTipoAdicional extends Controller
{
    //Instancia da Classe AdminTipoModel

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
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $count = $this->acoes->counts('categoriaTipoAdicional', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $tipoAdicional = $this->acoes->pagination('categoriaTipoAdicional', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/tipoAdicional/main', [
            'tipoAdicional' => $tipoAdicional,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $caixa->status,
        ]);
    }

    public function novo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/tipoAdicional/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $caixa->status,
        ]);
    }

    /**
     *
     * Recupera a pagina de produto selecionada
     *
     */
    public function editar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $retorno = $this->acoes->getByField('categoriaTipoAdicional', 'id', $data['id']);
        //dd($retorno);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/tipoAdicional/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
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
        $valor = new CategoriaTipoAdicional();
        $valor->tipo = $data['tipo'];
        $valor->slug = $data['slug'];
        $valor->tipo_escolha = $data['tipo_escolha'];
        $valor->qtd = $data['qtd'];
        $valor->status = $data['switch'];
        $valor->id_empresa = $data['id_empresa'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Categoria Adicional cadastrada com sucesso', 'error' => 'Não foi posível cadastrar a categoria adicional','code' => 2 ,  'url' => 'admin/tipo-adicionais',]);
        exit($json);
    }

    public function update($data)
    {
        $valor = (new CategoriaTipoAdicional())->findById($data['id']);
        $valor->tipo = $data['tipo'];
        $valor->slug = $data['slug'];
        $valor->tipo_escolha = $data['tipo_escolha'];
        $valor->qtd = $data['qtd'];
        $valor->status = $data['switch'];
        $valor->id_empresa = $data['id_empresa'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Categoria Adicional atualizada com sucesso', 'error' => 'Não foi posível atualizar a categoria adicional','code' => 2 ,  'url' => 'admin/tipo-adicionais',]);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new CategoriaTipoAdicional())->findById($data['id']);
        $valor->destroy();

        redirect(BASE . "{$data['linkSite']}/admin/tipo-adicionais");
    }
}

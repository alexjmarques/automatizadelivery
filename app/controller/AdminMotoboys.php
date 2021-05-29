<?php

namespace app\controller;

use app\classes\Input;
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
use app\Models\Motoboy;

class AdminMotoboys extends Controller
{
    //Instancia da Classe AdminMotoboyModel
    private $preferencias;
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
        $this->preferencias = new Preferencias();
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
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
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
        $retorno = $this->acoes->pagination('motoboy','id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');
        

        $this->load('_admin/motoboys/main', [
            'motoboy' => $retorno,
            'usuario' => $usuario,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            'preferencias' => $this->preferencias,
            'caixa' => $estabelecimento[0]->data_final,
        ]);
    }

    public function novo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }
        
        $this->load('_admin/motoboys/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            'preferencias' => $this->preferencias,
            'caixa' => $estabelecimento[0]->data_final,
        ]);
    }

    public function editar($data)
    {
        $usuario = $this->acoes->getFind('usuarios');
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $retorno = $this->acoes->getByField('motoboy', 'id', $data['id']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }
        
        $this->load('_admin/motoboys/editar', [
            'retorno' => $retorno,
            'usuario' => $usuario,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            'preferencias' => $this->preferencias,
            'caixa' => $estabelecimento[0]->data_final,
        ]);
    }

    public function insert($data)
    {
        $valor = new Motoboy();
        $valor->id_usuario = Input::post('id_usuario');
        $valor->diaria = Input::post('diaria');
        $valor->taxa = Input::post('taxa');
        $valor->placa = Input::post('placa');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'insert', 'titulo' => 'Motoboy','url' => 'motoboys']);
        exit($json);
    }

    public function update($data)
    {

        $valor = (new Motoboy())->findById($data['id']);
        $valor->id_usuario = Input::post('id_usuario');
        $valor->diaria = Input::post('diaria');
        $valor->taxa = Input::post('taxa');
        $valor->placa = Input::post('placa');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'update','titulo' => 'Motoboy','url' => 'motoboys']);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new Motoboy())->findById($data['id']);
        $valor->destroy();

        redirect(BASE . "{$data['linkSite']}/admin/motoboys");
    }
}

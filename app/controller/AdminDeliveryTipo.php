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
use app\Models\TipoDelivery;

class AdminDeliveryTipo extends Controller
{
    //Instancia da Classe AdminDeliveryTipoModel
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

        $count = $this->acoes->counts('tipoDelivery', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $resultProdutos = $this->acoes->pagination('tipoDelivery', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');


        $this->load('_admin/delivery/main', [
            'delivery' => $resultProdutos,
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


    public function editar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $retorno = $this->acoes->getByField('tipoDelivery', 'id', $data['id']);
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

        $this->load('_admin/delivery/editar', [
            'retorno' => $retorno,
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
        $valor = new TipoDelivery();
        $valor->tipo = Input::post('tipo');
        $valor->status = Input::post('switch');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'insert', 'titulo' => 'Tipo de Delivery','url' => 'delivery',]);
        exit($json);
    }

    public function update($data)
    {

        $valor = (new TipoDelivery())->findById($data['id']);
        $valor->tipo = Input::post('tipo');
        $valor->status = Input::post('switch');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'update','titulo' => 'Tipo de Delivery','url' => 'delivery',]);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new TipoDelivery())->findById($data['id']);
        $valor->destroy();

        redirect(BASE . "{$data['linkSite']}/admin/delivery");
    }
}

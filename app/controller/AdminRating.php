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


class AdminRating extends Controller
{
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
        //$this->ifood = new iFood();
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }

    public function index($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $rating = $this->ratingModel->qtdRating($empresaAct[':id']);
        $ratingAll = $this->ratingModel->getAllPorEmpresa($empresaAct[':id']);
        $ratingPedidos = $this->ratingModel->mediaPedidos($empresaAct[':id']);
        $ratingEntrega = $this->ratingModel->mediaEntrega($empresaAct[':id']);

        $day = date('w');
        $domingo = date('Y-m-d', strtotime('-' . $day . ' days'));
        $noventa = date('Y-m-d', strtotime('-' . (90 - $day) . ' days'));

        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);
        $estabelecimento = $this->allController->verificaEstabelecimento($empresaAct[':id']);
        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $this->allController->verificaAdmin($empresaAct[':id']);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/avaliacao/main', [
            'empresa' => $empresaAct,
            'noventa' => $noventa,
            'planoAtivo' => $planoAtivo,
            'estabelecimento' => $estabelecimento,
            'caixa' => $resulCaixa,
            'hoje' => $domingo,
            'domingo' => $domingo,
            'ratingAll' => $ratingAll,
            'rating' => $rating,
            'votacaoEntrega' => $ratingEntrega['avaliacao_motoboy'],
            'votacaoPedidos' => $ratingPedidos['avaliacao_pedido'],
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }
}

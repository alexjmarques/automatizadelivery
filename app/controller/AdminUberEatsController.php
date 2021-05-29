<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Preferencias;
use app\core\Controller;
use app\controller\AllController;
use Aura\Session\SessionFactory;
use app\Models\AdminConfigFreteModel;
use app\Models\AdminCaixaModel;
use app\Models\AdminMarketplacesModel;
use app\Models\AdminDashboardModel;
use app\Models\AdminIfoodCategoriaModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;
use app\Models\AdminProdutoAdicionalModel;
use app\Models\AdminProdutoSaborModel;
use app\Models\AdminProdutoModel;
use app\Models\AdminUsuarioModel;
use app\Models\VendasModel;
use app\Models\DiasModel;
use app\Models\MoedaModel;
use app\Models\ApdPlanosModel;
use app\Models\AdminAssinaturaModel;
use app\classes\Cache;


//use MatheusHack\IFood\Restaurant;

class AdminUberEatsController extends Controller
{
    //Instancia da Classe AdminProdutoModel
    private $deliveryModel;
    private $adminProdutosModel;
    private $adminProdutosAdicionaisModel;
    private $adminProdutosSaboresModel;
    private $adminConfigEmpresaModel;
    private $adminMoedaModel;
    private $adminUberEatsCategoriasModel;
    private $adminVendasModel;
    private $sessionFactory;
    private $adminDashboardModel;
    private $adminDiasModel;
    private $adminUsuarioModel;
    private $adminCaixaModel;
    private $allController;
    private $authetication;
    private $marketplace;
    private $apdPlanosModel;
    private $assinaturaModel;
    private $resulifood;
    private $preferencias;
    private $cache;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->adminProdutosAdicionaisModel = new AdminProdutoAdicionalModel();
        $this->adminProdutosSaboresModel = new AdminProdutoSaborModel();
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
        $this->adminUberEatsCategoriasModel = new AdminIfoodCategoriaModel();
        $this->adminDashboardModel = new AdminDashboardModel();
        $this->adminProdutosModel = new AdminProdutoModel();
        $this->assinaturaModel = new AdminAssinaturaModel();
        $this->deliveryModel = new AdminConfigFreteModel();
        $this->adminUsuarioModel = new AdminUsuarioModel();
        $this->marketplace = new AdminMarketplacesModel();
        $this->adminCaixaModel = new AdminCaixaModel();
        $this->apdPlanosModel = new ApdPlanosModel();
        $this->sessionFactory = new SessionFactory();
        $this->adminVendasModel = new VendasModel();
        $this->allController = new AllController();
        $this->adminMoedaModel = new MoedaModel();
        $this->preferencias = new Preferencias();
        $this->adminDiasModel = new DiasModel();
        $this->cache = new Cache();
        $this->resulifood = $this->marketplace->getById(1);
    }

    public function index($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $result = $this->configEmpresaModel->getById($empresaAct[':id']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->adminUsuarioModel->getById($SessionIdUsuario);
            if ($resulUsuario[':nivel'] == 3) {
                redirect(BASE . $empresaAct[':link_site']);
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/login');
        }

        $estabelecimento = $this->allController->verificaEstabelecimento($empresaAct[':id']);;;
        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $resulUber = $this->marketplace->getById(2);
        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);
        $this->allController->verificaAdmin($empresaAct[':id']);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/marketplaces/uberEats', [
            'empresa' => $empresaAct,
            'nivelUsuario' => $SessionNivel,
            'statusUberEats' => $resulUber,
            'planoAtivo' => $planoAtivo,
            'usuarioLogado' => $resulUsuario,
            'estabelecimento' => $estabelecimento,
            'trans' => $trans,
            'preferencias' => $this->preferencias,
            'caixa' => $resulCaixa,

        ]);
    }
}
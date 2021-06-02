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


//use MatheusHack\IFood\Restaurant;

class AdminClickEntregasController extends Controller
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
        $result = $this->configEmpresaModel->getById($empresaAct[':id']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
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

        $this->load('_admin/marketplaces/clickEntregas', [
            'empresa' => $empresaAct,
            'nivelUsuario' => $SessionNivel,
            'statusUberEats' => $resulUber,
            'planoAtivo' => $planoAtivo,
            'usuarioLogado' => $resulUsuario,
            'estabelecimento' => $estabelecimento,
            'trans' => $trans,
            
            'caixa' => $resulCaixa,

        ]);
    }
}
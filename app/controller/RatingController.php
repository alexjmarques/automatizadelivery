<?php

namespace app\controller;

use app\core\Controller;
use app\Models\RatingModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;
use app\Models\AdminUsuarioModel;
use app\classes\Input;
use app\classes\Preferencias;
use app\controller\AllController;
use app\Models\VendasModel;
use Aura\Session\SessionFactory;
use app\Models\AdminCaixaModel;

class RatingController extends Controller
{
    private $configEmpresaModel;
    private $ratingModel;
    private $adminUsuarioModel;
    private $adminCaixaModel;
    private $allController;
    private $vendasModel;
    private $sessionFactory;
    

    /**
     * 
     * Metodo Construtor
     * 
     * @return void
     */
    public function __construct()
    {
        
        $this->ratingModel = new RatingModel();
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
        $this->adminUsuarioModel = new AdminUsuarioModel();
        $this->vendasModel = new VendasModel();
        $this->allController = new AllController();
        $this->adminCaixaModel = new AdminCaixaModel();
        $this->sessionFactory = new SessionFactory();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        $resultVendas = $this->vendasModel->getPedidoFeito($data['numero_pedido'], $empresaAct[':id']);

        $estabelecimento = $this->allController->verificaEstabelecimento($empresaAct[':id']);;;
        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $resulifood = $this->marketplace->getById(1);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_geral/rating/main', [
            'empresa' => $resultEmpresa,
            'estabelecimento' => $estabelecimento,
            'pedido' => $resultVendas[':numero_pedido'],
            'id_motoboy' => $resultVendas[':motoboy'],
            'id_cliente' => $SessionIdUsuario,
            'data_compra' => $resultVendas[':data'] . ' ' . $resultVendas[':hora'],
            'empresa' => $empresa,
            'trans' => $this->trans,
            'planoAtivo' => $planoAtivo,
            'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_final,
        ]);
    }

    public function rating($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $avaliacao = $this->getInput();
        $result = $this->ratingModel->insert($avaliacao);

        if ($result <= 0) {
            echo 'Erro ao Votar';
        } else {
            echo 'Agradecemos pela sua avaliação!';
        }
    }

    /**
     * Retorna os dados do formulario em uma classe stdObject
     * 
     * @return object
     */
    private function getInput()
    {
        return (object)[
            'id' => Input::post('id', FILTER_SANITIZE_NUMBER_INT),
            'numero_pedido' => Input::post('numero_pedido'),
            'id_cliente' => Input::post('id_cliente'),
            'id_motoboy' => Input::post('id_motoboy'),
            'avaliacao_pedido' => Input::post('avaliacao_pedido'),
            'avaliacao_motoboy' => Input::post('avaliacao_motoboy'),
            'observacao' => Input::post('observacao'),
            'data_compra' => Input::post('data_compra'),
            'data_votacao' => date('Y-m-d H:i:s')
        ];
    }
}

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


class AdminTipo extends Controller
{
    //Instancia da Classe adminTipoAdicionalModel
    
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
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
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
        $resultProdutos = $this->acoes->pagination('tipoDelivery','id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');
        

        $this->load('_admin/tipoAdicional/main', [
            'tipoDelivery' => $resultProdutos,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_inicio,
        ]);
    }

    public function novo($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
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
        $resulifood = $this->marketplace->getById(1);


        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);
        $this->allController->verificaAdmin($empresaAct[':id']);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/tipoAdicional/novo', [
            'empresa' => $empresaAct,
            'usuarioLogado' => $resulUsuario,
            'estabelecimento' => $estabelecimento,
            'nivelUsuario' => $SessionNivel,
            'statusiFood' => $resulifood,
            'planoAtivo' => $planoAtivo,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'planoAtivo' => $planoAtivo,
            'usuarioLogado' => $usuarioLogado,
'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_inicio,
        ]);
    }

    public function insert($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $tipo = $this->getInput();
        $result = $this->adminTipoAdicionalModel->insert($tipo);

        if ($result <= 0) {
            echo 'Erro ao cadastrar a tipo';
        } else {
            echo 'Tipo cadastrado com sucesso';
        }
    }

    /**
     *
     * Recupera a pagina de produto selecionada
     *
     */
    public function editar($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');


        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        $resultTipo = $this->adminTipoAdicionalModel->getById($data['id']);

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
        $resulifood = $this->marketplace->getById(1);

        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);
        $this->allController->verificaAdmin($empresaAct[':id']);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/tipo/editar', [
            'empresa' => $empresaAct,
            'tipoAtivo' => $resultTipo,
            'usuarioLogado' => $resulUsuario,
            'nivelUsuario' => $SessionNivel,
            'statusiFood' => $resulifood,
            'estabelecimento' => $estabelecimento,
            'planoAtivo' => $planoAtivo,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'planoAtivo' => $planoAtivo,
            'usuarioLogado' => $usuarioLogado,
'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_inicio,
        ]);
    }

    /**
     *
     * Faz a atualização da pagina de proutos
     *
     */
    public function update($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $tipo = $this->getInput();
        $result = $this->adminTipoAdicionalModel->update($tipo);

        if ($result <= 0) {
            echo 'Erro ao atualizar a tipo';
        } else {
            echo 'Tipo atualizar com sucesso';
        }
    }

    /**
     *
     * Faz a atualização da pagina de proutos
     *
     */
    public function deletar($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $result = $this->adminTipoAdicionalModel->delete($data['id']);
        if ($result <= 0) {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/tipoAdicional');
            exit;
        }
        redirect(BASE . $empresaAct[':link_site'] . '/admin/tipoAdicional');
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
            'tipo' => Input::post('tipo'),
            'status' => Input::post('status'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}

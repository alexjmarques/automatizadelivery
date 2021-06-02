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
use app\Models\CarrinhoPedidos;
use app\Models\Motoboy;

class AdminMotoboys extends Controller
{
    //Instancia da Classe AdminMotoboyModel

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
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
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
        $retorno = $this->acoes->pagination('motoboy', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');


        $this->load('_admin/motoboys/main', [
            'motoboy' => $retorno,
            'usuario' => $usuario,
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
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $motoboys = $this->acoes->getByFieldAll('usuarios', 'nivel', 1);
        $motoboysEmpresa = $this->acoes->getByFieldAll('usuariosEmpresa', 'id_empresa', $empresa->id);


        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
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
            'motoboys' => $motoboys,
            'motoboysEmpresa' => $motoboysEmpresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->data_inicio,
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
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
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
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function insert($data)
    {
        $valor = new Motoboy();
        $valor->id_usuario = $data['id_usuario'];
        $valor->diaria = $data['diaria'];
        $valor->taxa = $data['taxa'];
        $valor->placa = $data['placa'];
        $valor->id_empresa = $data['id_empresa'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Motoboy cadastrado com sucesso', 'error' => 'Não foi possível cadastrar o Motoboy', 'url' => 'admin/motoboys']);
        exit($json);
    }

    public function update($data)
    {

        $valor = (new Motoboy())->findById($data['id']);
        $valor->diaria = $data['diaria'];
        $valor->taxa = $data['taxa'];
        $valor->placa = $data['placa'];
        $valor->id_empresa = $data['id_empresa'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Motoboy atualizado com sucesso', 'error' => 'Não foi possível atualizar o Motoboy', 'url' => 'admin/motoboys']);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new Motoboy())->findById($data['id']);
        $valor->destroy();

        redirect(BASE . "{$data['linkSite']}/admin/motoboys");
    }



    public function entregas($data)
    {

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $motoboys = $this->acoes->getByFieldAll('usuarios', 'nivel', 1);
        $motoboysEmpresa = $this->acoes->getByFieldAll('usuariosEmpresa', 'id_empresa', $empresa->id);


        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }
        $this->load('_admin/motoboys/entregas', [
            'empresa' => $empresa,
            'motoboys' => $motoboys,
            'motoboysEmpresa' => $motoboysEmpresa,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function entregasBuscar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        
        if ($data['id_motoboy'] != null){
            $resultMotoboy = $this->acoes->getByField('motoboy', 'id_usuario', $data['id_motoboy']);
            $usuario = $this->acoes->getByField('usuarios', 'id', $data['id_motoboy']);

            $data_inicio = $data['inicio'];
            $dataTermino = $data['termino'];
    
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_empresa', $empresa->id);
            $resultBuscaAll = $this->acoes->getByFieldAll('carrinhoEntregas', 'id_empresa', $empresa->id);
        }

        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/motoboys/entregaResultado', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->data_inicio,
            'estabelecimento' => $estabelecimento,
            'busca' => $resultBuscaAll,
            'pedidos' => $resultPedidos,
            'planoAtivo' => $planoAtivo,
            'motoboy' => $resultMotoboy,
            'usuario' => $usuario,
            'data_inicio' => $data_inicio,
            'dataTermino' => $dataTermino
        ]);
    }

    //Mudar Status Pagamento Motoboy
    public function entregasPagamento($data)
    {
        $plano = $_GET['pago'];
        dd($plano);
        $count = count($plano);
        for ($i = 0; $i < $count; $i++) {
            $valor = (new CarrinhoPedidos())->findById($plano[$i]);
            $valor->pago = 1;
            $valor->status = 4;
            $valor->save();
        }
    }
}

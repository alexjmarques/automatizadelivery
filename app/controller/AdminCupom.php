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
use app\Models\CupomDesconto;

class AdminCupom extends Controller
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
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $count = $this->acoes->counts('cupomDesconto', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $retorno = $this->acoes->pagination('cupomDesconto','id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/cupom/main', [
            'cupom' => $retorno,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
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
        
        $this->load('_admin/cupom/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_final,
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
        $retorno = $this->acoes->getByField('cupomDesconto', 'id', $data['id']);
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
        
        $this->load('_admin/cupom/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_final,
        ]);

    }


    public function insert($data)
    {
        $valorC = str_replace(",", ".", Input::post('valor_cupom'));
        $dataC = Input::post('expira');
        $dataC = implode("-",array_reverse(explode("/",$dataC)));
        $valor_cupom = number_format((float)$valorC, 2, '.', ',');
        $expira = date('Y-m-d H:i:s', strtotime($dataC));

        $valor = new CupomDesconto();
        $valor->tipo_cupom = Input::post('tipo_cupom');
        $valor->nome_cupom = Input::post('nome_cupom');
        $valor->valor_cupom = $valor_cupom;
        $valor->expira = $expira;
        $valor->qtd_utilizacoes = Input::post('qtd_utilizacoes');
        $valor->status = Input::post('switch');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'insert','mensagem' => 'Cupom Desconto cadastrado com sucesso','error' => 'Não foi posível cadastrar o Cupom de Desconto','url' => 'cupons',]);
        exit($json);
    }

    public function update($data)
    {

        $valorC = str_replace(",", ".", Input::post('valor_cupom'));
        $dataC = Input::post('expira');
        $dataC = implode("-",array_reverse(explode("/",$dataC)));
        $valor_cupom = number_format((float)$valorC, 2, '.', ',');
        $expira = date('Y-m-d H:i:s', strtotime($dataC));

        $valor = (new CupomDesconto())->findById($data['id']);
        $valor->tipo_cupom = Input::post('tipo_cupom');
        $valor->nome_cupom = Input::post('nome_cupom');
        $valor->valor_cupom = $valor_cupom;
        $valor->expira = $expira;
        $valor->qtd_utilizacoes = Input::post('qtd_utilizacoes');
        $valor->status = Input::post('switch');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'update','mensagem' => 'Cupom Desconto atualizado com sucesso','error' => 'Não foi posível atualizar o Cupom de desconto','url' => 'cupons',]);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new CupomDesconto())->findById($data['id']);
        $valor->destroy();

        redirect(BASE. "{$data['linkSite']}/admin/cupons");
    }
}

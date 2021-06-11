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
use app\Models\Categorias;
use app\classes\Sessao;
use app\Models\EmpresaFuncionamento;

class AdminAtendimento extends Controller
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
        
        $verificaUser = $this->geral->verificaEmpresaUser($empresa->id);
        
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $dias = $this->acoes->getFind('dias');
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $count = $this->acoes->counts('empresaFuncionamento', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $funcionamento = $this->acoes->pagination('empresaFuncionamento', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id_dia DESC');

        $this->load('_admin/atendimento/main', [
            'funcionamento' => $funcionamento,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'dias' => $dias,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function novo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $verificaUser = $this->geral->verificaEmpresaUser($empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $dias = $this->acoes->getFind('dias');
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/atendimento/novo', [
            'planoAtivo' => $planoAtivo,
            'dias' => $dias,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario'=> $this->sessao->getNivel(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function editar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $verificaUser = $this->geral->verificaEmpresaUser($empresa->id);
        $retorno = $this->acoes->getByField('empresaFuncionamento','id', $data['id']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $dias = $this->acoes->getFind('dias');
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/atendimento/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'dias' => $dias,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'nivelUsuario'=> $this->sessao->getNivel(),
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function insert($data)
    {
        $valor = new EmpresaFuncionamento();
        $valor->id_dia = $data['dia'];
        $valor->abertura = date('H:i:s', strtotime($data['abertura']));
        $valor->fechamento = date('H:i:s', strtotime($data['fechamento']));
        $valor->id_empresa = $data['id_empresa'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Horário de Funcionamento cadastrado com sucesso', 'error' => 'Não foi posível cadastrar o Horário de Funcionamento', 'url' => 'admin/conf/atendimento',]);
        exit($json);
    }

    public function update($data)
    {
        $valor = (new EmpresaFuncionamento())->findById($data['id']);
        $valor->id_dia = $data['dia'];
        $valor->abertura = date('H:i:s', strtotime($data['abertura']));
        $valor->fechamento = date('H:i:s', strtotime($data['fechamento']));
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Horário de Funcionamento atualizado com sucesso', 'error' => 'Não foi posível atualizar o Horário de Funcionamento', 'url' => 'admin/conf/atendimento',]);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new EmpresaFuncionamento())->findById($data['id']);
        $valor->destroy();

        redirect(BASE . "{$data['linkSite']}/admin/atendimento");
    }
}

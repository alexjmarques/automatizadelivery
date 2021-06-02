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
use app\Models\ProdutoAdicional;

class AdminProdutosAdicionais extends Controller
{
    
    private $acoes;
    private $sessao;
    private $geral;
    private $trans;

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
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $count = $this->acoes->counts('produtoAdicional', 'id_empresa', $empresa->id);
        $categoriaQtd = $this->acoes->counts('categoriaTipoAdicional', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $resultCategorias = $this->acoes->pagination('produtoAdicional','id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');
        $categoriaTipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id_empresa', $empresa->id);
        
        $this->load('_admin/produtoAdicional/main', [
            'produtoAdicional' => $resultCategorias,
            'categoriaTipoAdicional' => $categoriaTipoAdicional,
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

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }
        
        $this->load('_admin/produtoAdicional/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
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
        $retorno = $this->acoes->getByField('produtoAdicional', 'id', $data['id']);
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
        
        $this->load('_admin/produtoAdicional/editar', [
            'retorno' => $retorno,
            'usuario' => $usuario,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_inicio,
        ]);
    }

    public function insert($data)
    {
        $valor = new ProdutoAdicional();
        $valor->id_usuario = Input::post('id_usuario');
        $valor->diaria = Input::post('diaria');
        $valor->taxa = Input::post('taxa');
        $valor->placa = Input::post('placa');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'insert', 'mensagem' => 'Produto Adicional cadastrado com sucesso','error' => 'Não foi possível cadastrar o produto adicional','url' => 'produtos-adicionais']);
        exit($json);
    }

    public function update($data)
    {
        $valor = str_replace(",", ".", Input::post('valor'));

        $valor = (new ProdutoAdicional())->findById($data['id']);
        $valor->tipo_adicional = Input::post('tipo_adicional');
        $valor->nome = Input::post('nome');
        $valor->valor = $valor;
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'update','mensagem' => 'Produto Adicional atualizado com sucesso' ,'error' => 'Não foi possível atualizar o produto adicional','url' => 'produtos-adicionais']);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new ProdutoAdicional())->findById($data['id']);
        $valor->destroy();

        redirect(BASE . "{$data['linkSite']}/admin/motoboys");
    }

}

<?php

namespace app\controller;

use app\classes\Acoes;
use app\classes\Cache;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Sessao;
use app\Models\Paginas;
use Browser;
use Mobile_Detect;

class Admin extends Controller
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
        if ($this->sessao->getNivel()) {
            $empresas = $this->acoes->getFind('empresa');
            $empresasCont = $this->acoes->countAdd('empresa');
            $empresaDelivery = $this->acoes->getFind('empresaFrete');
            $empresaEndereco = $this->acoes->getFind('empresaEnderecos');
            $categoria = $this->acoes->getFind('categoriaSeguimentoSub');
            $pedidos = $this->acoes->getFind('carrinhoPedidos');

            if ($this->sessao->getNivel() == 10) {redirect(BASE);}

            $this->load('_gestao_admin/dashboard/main', [
                'empresas' => $empresas,
                'empresasCont' => $empresasCont,
                'empresaDelivery' => $empresaDelivery,
                'empresaEndereco' => $empresaEndereco,
                'categoria' => $categoria,
                'pedidos' => $pedidos,
                'trans' => $this->trans,
                'detect' => new Mobile_Detect()

            ]);
        }
    }

    public function empresas($data)
    {
        if ($this->sessao->getNivel()) {
            if ($this->sessao->getNivel() == 10) {redirect(BASE);}
            $count = $this->acoes->countAdd('empresa');
            $planos = $this->acoes->getFind('planos');
            $assinatura = $this->acoes->getFind('assinatura');
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
            $pager = new \CoffeeCode\Paginator\Paginator();
            $pager->pager((int)$count, 30, $page);
            $empresas = $this->acoes->paginationAdd('empresa', $pager->limit(), $pager->offset(), 'id ASC');

            $this->load('_gestao_admin/empresas/main', [
                'planos' => $planos,
                'assinatura' => $assinatura,
                'usuarioLogado' => $usuarioLogado,
                'empresas' => $empresas,
                'trans' => $this->trans,
                'paginacao' => $pager->render('mt-4 pagin'),
                'detect' => new Mobile_Detect()
            ]);
        }
    }

    public function paginasInt($data)
    {
        if ($this->sessao->getNivel()) {
            if ($this->sessao->getNivel() == 10) {redirect(BASE);}
            $count = $this->acoes->countAdd('paginas');
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
            $pager = new \CoffeeCode\Paginator\Paginator();
            $pager->pager((int)$count, 30, $page);
            $paginas = $this->acoes->paginationAdd('paginas', $pager->limit(), $pager->offset(), 'id ASC');

            $this->load('_gestao_admin/paginas/main', [
                'paginas' => $paginas,
                'trans' => $this->trans,
                'usuarioLogado' => $usuarioLogado,
                'paginacao' => $pager->render('mt-4 pagin'),
                'detect' => new Mobile_Detect()
            ]);
        }
    }

    public function nova($data)
    {
        if ($this->sessao->getNivel()) {
            if ($this->sessao->getNivel() == 10) {redirect(BASE);}
            $this->load('_gestao_admin/paginas/novo', [
                'isLogin' => $this->sessao->getUser(),
                'trans' => $this->trans,
                'detect' => new Mobile_Detect()
            ]);
        }
    }

    public function editar($data)
    {
        if ($this->sessao->getNivel()) {
            if ($this->sessao->getNivel() == 10) {redirect(BASE);}
            $retorno = $this->acoes->getByField('paginas', 'id', $data['id']);

            $this->load('_gestao_admin/paginas/editar', [
                'retorno' => $retorno,
                'isLogin' => $this->sessao->getUser(),
                'trans' => $this->trans,
                'detect' => new Mobile_Detect()
            ]);
        }
    }

    public function insert($data)
    {
        $valor = new Paginas();
        $valor->titulo = $data['titulo'];
        $valor->slug = $data['slug'];
        $valor->conteudo = $data['conteudo'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'P??gina cadastrada com sucesso', 'error' => 'N??o foi pos??vel cadastrar a p??gina', 'code' => 2,  'url' => 'admin/paginas',]);
        exit($json);
    }

    public function update($data)
    {
        $valor = (new Paginas())->findById($data['id']);
        $valor->titulo = $data['titulo'];
        $valor->slug = $data['slug'];
        $valor->conteudo = $data['conteudo'];

        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'P??gina atualizada com sucesso', 'error' => 'N??o foi pos??vel atualizar a p??gina', 'code' => 2,  'url' => 'admin/paginas',]);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new Paginas())->findById($data['id']);
        $valor->destroy();

        redirect(BASE . "admin/paginas");
    }
}

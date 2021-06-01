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
use app\Models\Categorias;
use app\Models\Produtos;

class AdminProdutos extends Controller
{
    //Instancia da Classe AdminProdutoModel
    
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

        $count = $this->acoes->counts('produtos', 'id_empresa', $empresa->id);
        $categoriaQtd = $this->acoes->counts('categorias', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $resultProdutos = $this->acoes->pagination('produtos','id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');
        $resultCategorias = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);


        $this->load('_admin/produtos/main', [
            'produtos' => $resultProdutos,
            'categorias' => $resultCategorias,
            'categoriaQtd' => $categoriaQtd,
            'paginacao' => $pager->render('mt-4 pagin'),
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
     * Nova pagina de produtos
     *
     */
    public function novo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $qtdProdutosAdicionais = $this->acoes->counts('produtoAdicional', 'id_empresa', $empresa->id);
        $qtdSabores = $this->acoes->counts('produtoSabor', 'id_empresa', $empresa->id);

        $categoriaLista = $this->acoes->getFind('categorias');
        $tipoAdicional = $this->acoes->getFind('categoriaTipoAdicional');
        $produtosAdicionais = $this->acoes->getFind('produtoAdicional');
        $produtosSabores = $this->acoes->getFind('produtoSabor');
        $diaSelecao = $this->acoes->getFind('dias');

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
        
        $this->load('_admin/produtos/novo', [
            'planoAtivo' => $planoAtivo,
            'categoriaLista' => $categoriaLista,
            'qtdProdutosAdicionais' => $qtdProdutosAdicionais,
            'produtosSabores' => $produtosSabores,
            'produtosAdicionais' => $produtosAdicionais,
            'tipoAdicional' => $tipoAdicional,
            'diaSelecao' => $diaSelecao,
            'qtdSabores' => $qtdSabores,
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
        $qtdProdutosAdicionais = $this->acoes->counts('produtoAdicional', 'id_empresa', $empresa->id);
        $qtdSabores = $this->acoes->counts('produtoSabor', 'id_empresa', $empresa->id);
        $retorno = $this->acoes->getByField('produtos', 'id', $data['id']);

        $categoriaLista = $this->acoes->getFind('categorias');
        $tipoAdicional = $this->acoes->getFind('categoriaTipoAdicional');
        $produtosAdicionais = $this->acoes->getFind('produtoAdicional');
        $produtosSabores = $this->acoes->getFind('produtoSabor');
        $diaSelecao = $this->acoes->getFind('dias');

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
        
        $this->load('_admin/produtos/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'categoriaLista' => $categoriaLista,
            'qtdProdutosAdicionais' => $qtdProdutosAdicionais,
            'produtosSabores' => $produtosSabores,
            'produtosAdicionais' => $produtosAdicionais,
            'tipoAdicional' => $tipoAdicional,
            'diaSelecao' => $diaSelecao,
            'qtdSabores' => $qtdSabores,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_final,
        ]);
    }

    public function uploadImagem($data)
    {
        if (isset($_POST['image'])) {
            $data = $_POST['image'];
            $imageArray1 = explode(";", $data);
            $imageArray2 = explode(",", $imageArray1[1]);
            $data = base64_decode($imageArray2[1]);
            $imageNome = time() . '.jpg';
            $imageCaminho = UPLOADS_BASE . $imageNome;
            file_put_contents($imageCaminho, $data);
            echo $imageNome;
        }
    }

    public function insert($data)
    {
        $adicionalSt = $_POST['adicional'];
        if ($adicionalSt != null) {
            $adicionalSelecionados = implode(',', $adicionalSt);
        }

        $saborSt = $_POST['sabor'];
        if ($saborSt != null) {
            $saborSelecionados = implode(',', $saborSt);
        }

        $diasDD = $_POST['dias_disponiveis'];
        if ($diasDD != null) {
            $dias_disponiveis = implode(',', $diasDD);
        }

        $valor_promocional = $this->geral->brl2decimal(Input::post('valor_promocional'));

        if (empty($valor_promocional)) {
            $valor_promocional = 0.00;
        }

        $valor = new Produtos();
        $valor->nome = Input::post('nome');
        $valor->descricao = Input::post('descricao');
        $valor->observacao = Input::post('observacao');
        $valor->valor = $this->geral->brl2decimal(Input::post('valor'));
        $valor->valor_promocional = $valor_promocional;
        $valor->id_categoria = Input::post('categoria');
        $valor->imagem = Input::post('imagemNome');
        $valor->adicional = $adicionalSelecionados;
        $valor->sabores = $saborSelecionados;
        $valor->status = Input::post('switch');
        $valor->dias_disponiveis = $dias_disponiveis;
        $valor->vendas = Input::post('vendas');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        $catNe = $this->acoes->getByField('categorias', 'id', Input::post('categoria'));
        $novaQtdN = $catNe->produtos + 1;
            
        $valorNCat = (new Categorias())->findById(Input::post('categoria'));
        $valorNCat->produtos = $novaQtdN;
        $valorNCat->id_empresa = Input::post('id_empresa');
        $valorNCat->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'insert','mensagem' => 'Produto cadastrado com sucesso','error' => 'Não foi possível cadastrar o Produto','url' => 'produtos',]);
        exit($json);
    }

    public function update($data)
    {
        
        $adicionalSt = $_POST['adicional'];
        if ($adicionalSt != null) {
            $adicionalSelecionados = implode(',', $adicionalSt);
        }

        $saborSt = $_POST['sabores'];
        if ($saborSt != null) {
            $saborSelecionados = implode(',', $saborSt);
        }

        $diasDD = $_POST['dias_disponiveis'];
        if ($diasDD != null) {
            $dias_disponiveis = implode(',', $diasDD);
        }

        $valor_promocional = $this->geral->brl2decimal(Input::post('valor_promocional'));

        if (empty($valor_promocional)) {
            $valor_promocional = 0.00;
        }

        $valor = (new Produtos())->findById($data['id']);
        $valor->nome = Input::post('nome');
        $valor->descricao = Input::post('descricao');
        $valor->observacao = Input::post('observacao');
        $valor->valor = $this->geral->brl2decimal(Input::post('valor'));
        $valor->valor_promocional = $valor_promocional;
        $valor->categoria = Input::post('categoria');
        $valor->imagem = Input::post('imagemNome');
        $valor->adicional = $adicionalSelecionados;
        $valor->sabores = $saborSelecionados;
        $valor->status = Input::post('switch');
        $valor->dias_disponiveis = $dias_disponiveis;
        $valor->vendas = Input::post('vendas');
        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();

        

        if(Input::post('categoriaCad') != Input::post('categoria')){
            $cat = $this->acoes->getByField('categorias', 'id', Input::post('categoriaCad'));
            $novaQtd = $cat->produtos - 1;
            
            $valorCat = (new Categorias())->findById(Input::post('categoriaCad'));
            $valorCat->produtos = $novaQtd;
            $valorCat->id_empresa = Input::post('id_empresa');
            $valorCat->save();


            $catNe = $this->acoes->getByField('categorias', 'id', Input::post('categoria'));
            $novaQtdN = $catNe->produtos + 1;
            
            $valorNCat = (new Categorias())->findById(Input::post('categoria'));
            $valorNCat->produtos = $novaQtdN;
            $valorNCat->id_empresa = Input::post('id_empresa');
            $valorNCat->save();
        }

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'update','mensagem' => 'Produto atualizado com sucesso','error' => 'Não foi possível atualizar o produto','url' => 'produtos',]);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new Produtos())->findById($data['id']);
        $valor->destroy();

        $cat = $this->acoes->getByField('categorias', 'id', Input::post('categoria'));
        $novaQtd = $cat->produtos - 1;
            
        $valorCat = (new Categorias())->findById(Input::post('categoria'));
        $valorCat->produtos = $novaQtd;
        $valorCat->id_empresa = Input::post('id_empresa');
        $valorCat->save();

        redirect(BASE. "{$data['linkSite']}/admin/categorias");
    }

}

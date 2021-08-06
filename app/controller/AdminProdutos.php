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
use app\Models\PizzaProdutoValor;

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
        $qtdTamanho = $this->acoes->counts('pizzaTamanhos', 'id_empresa', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $produtosValor = $this->acoes->getByFieldAll('pizzaProdutoValor', 'id_empresa', $empresa->id);

        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $count = $this->acoes->counts('produtos', 'id_empresa', $empresa->id);
        $categoriaQtd = $this->acoes->counts('categorias', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 30, $page);
        $resultProdutos = $this->acoes->pagination('produtos', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');
        $resultCategorias = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);


        $this->load('_admin/produtos/main', [
            'produtos' => $resultProdutos,
            'categoriaQtd' => $categoriaQtd,
            'produtosValor' => $produtosValor,
            'categorias' => $resultCategorias,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'qtdTamanho' => $qtdTamanho,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
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

        $categoriaLista = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);

        $tipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id_empresa', $empresa->id);
        $produtosAdicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $produtosSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $diaSelecao = $this->acoes->getFind('dias');

        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
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
            'catId' => $data['catId'],
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
        ]);
    }


    public function novoVariavel($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $qtdProdutosAdicionais = $this->acoes->counts('produtoAdicional', 'id_empresa', $empresa->id);
        $qtdSabores = $this->acoes->counts('produtoSabor', 'id_empresa', $empresa->id);

        $qtdTamanho = $this->acoes->counts('pizzaTamanhos', 'id_empresa', $empresa->id);
        $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
        $categoriaLista = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $tipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id_empresa', $empresa->id);
        $produtosAdicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $produtosSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $tamanhoCategoria = $this->acoes->getByFieldTwoAll('pizzaTamanhosCategoria', 'id_empresa', $empresa->id, 'id_categoria', $data['catId']);
        $diaSelecao = $this->acoes->getFind('dias');

        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/produtos/novoVariavel', [
            'planoAtivo' => $planoAtivo,
            'categoriaLista' => $categoriaLista,
            'qtdProdutosAdicionais' => $qtdProdutosAdicionais,
            'tamanhos' => $tamanhos,
            'tamanhoCategoria' => $tamanhoCategoria,
            'produtosSabores' => $produtosSabores,
            'produtosAdicionais' => $produtosAdicionais,
            'tipoAdicional' => $tipoAdicional,
            'diaSelecao' => $diaSelecao,
            'qtdSabores' => $qtdSabores,
            'qtdTamanho' => $qtdTamanho,
            'catId' => $data['catId'],
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
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
        $categoriaLista = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $tipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id_empresa', $empresa->id);
        $produtosAdicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $produtosSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
        $diaSelecao = $this->acoes->getFind('dias');

        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/produtos/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'tamanhos' => $tamanhos,
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
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
        ]);
    }

    public function editarVariavel($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $qtdProdutosAdicionais = $this->acoes->counts('produtoAdicional', 'id_empresa', $empresa->id);
        $qtdSabores = $this->acoes->counts('produtoSabor', 'id_empresa', $empresa->id);
        $retorno = $this->acoes->getByField('produtos', 'id', $data['id']);
        $categoriaLista = $this->acoes->getByFieldAll('categorias', 'id_empresa', $empresa->id);
        $tipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id_empresa', $empresa->id);
        $produtosAdicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $produtosSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $tamanhos = $this->acoes->getByFieldAll('pizzaTamanhos', 'id_empresa', $empresa->id);
        $tamanhosCategorias = $this->acoes->getByFieldAll('pizzaTamanhosCategoria', 'id_categoria', $retorno->id_categoria);
        $valorProduto = $this->acoes->getByFieldAll('pizzaProdutoValor', 'id_produto', $retorno->id);

        $diaSelecao = $this->acoes->getFind('dias');

        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/produtos/editarVariavel', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'categoriaLista' => $categoriaLista,
            'tamanhos' => $tamanhos,
            'tamanhosCategorias' => $tamanhosCategorias,
            'valorProduto' => $valorProduto,
            'qtdProdutosAdicionais' => $qtdProdutosAdicionais,
            'produtosSabores' => $produtosSabores,
            'produtosAdicionais' => $produtosAdicionais,
            'tipoAdicional' => $tipoAdicional,
            'diaSelecao' => $diaSelecao,
            'qtdSabores' => $qtdSabores,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
        ]);
    }

    public function uploadImagem($data)
    {
        $upload = new \CoffeeCode\Uploader\Image(UPLOADS_BASE, "images");
        $files = $_FILES;
        if (!empty($files["image"])) {
            $file = $files["image"];
            try {
                $uploaded = $upload->upload($file, $file["name"]);
                $partes = explode("/uploads", $uploaded);
                echo $partes[1];
            } catch (\Exception $e) {
                echo "<p>(!) {$e->getMessage()}</p>";
            }
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

        if ($data['valor_promocional']) {
            $valor_promocional = $this->geral->brl2decimal($data['valor_promocional']);
        } else {
            $valor_promocional = 0;
        }

        if ($data['valor']) {
            $preco = $this->geral->brl2decimal($data['valor']);
        } else {
            $preco = 0;
        }

        if ($data['switch']) {
            $status = $data['switch'];
        } else {
            $status = 0;
        }

        $valor = new Produtos();
        $valor->nome = $data['nome'];
        $valor->cod = $data['cod'];
        $valor->descricao = $data['descricao'];
        $valor->observacao = $data['observacao'];
        $valor->valor = $preco;
        $valor->valor_promocional = $valor_promocional;
        $valor->id_categoria = $data['categoria'];
        $valor->imagem = $data['imagemNome'];
        $valor->adicional = $adicionalSelecionados;
        $valor->sabores = $saborSelecionados;
        $valor->status = $status;
        $valor->dias_disponiveis = $dias_disponiveis;
        $valor->vendas = $data['vendas'];
        $valor->id_empresa = $data['id_empresa'];
        $valor->save();

        if ($data['valor'] ==  0) {
            if ($valor->id >  0) {
                $array = $data['preco'];
                $newArray = array();
                foreach (array_keys($array) as $fieldKey) {
                    foreach ($array[$fieldKey] as $key => $value) {
                        $newArray[$key][$fieldKey] = $value;
                    }
                }
                foreach ($newArray as $res) {
                    $prodValor = new PizzaProdutoValor();
                    $prodValor->id_tamanho = $res['tamanho'];
                    $prodValor->valor = $this->geral->brl2decimal($res['valor']);
                    $prodValor->id_produto = $valor->id;
                    $prodValor->id_empresa = $data['id_empresa'];
                    $prodValor->save();
                }
            }
        }

        $catNe = $this->acoes->getByField('categorias', 'id', $data['categoria']);
        $novaQtdN = $catNe->produtos + 1;

        $valorNCat = (new Categorias())->findById($data['categoria']);
        $valorNCat->produtos = $novaQtdN;
        $valorNCat->id_empresa = $data['id_empresa'];
        $valorNCat->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Produto cadastrado com sucesso', 'error' => 'Não foi possível cadastrar o Produto', 'code' => 2,  'url' => 'admin/cardapio',]);
        exit($json);
    }

    public function update($data)
    {
        //dd($data);

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

        if ($data['valor_promocional']) {
            $valor_promocional = $this->geral->brl2decimal($data['valor_promocional']);
        } else {
            $valor_promocional = 0;
        }

        if ($data['switch']) {
            $status = $data['switch'];
        } else {
            $status = 0;
        }

        // if ($data['cod']) {
        //     $cod = $data['cod'];
        // } else {
        //     $cod = 0;
        // }

        $valor = (new Produtos())->findById($data['id']);
        $valor->nome = $data['nome'];
        $valor->cod = $data['cod'];
        $valor->descricao = $data['descricao'];
        $valor->observacao = $data['observacao'];
        $valor->valor = $this->geral->brl2decimal($data['valor']);
        $valor->valor_promocional = $valor_promocional;
        $valor->imagem = $data['imagemNome'];
        $valor->adicional = $adicionalSelecionados;
        $valor->sabores = $saborSelecionados;
        $valor->status = $status;
        $valor->dias_disponiveis = $dias_disponiveis;
        $valor->id_empresa = $data['id_empresa'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Produto atualizado com sucesso', 'error' => 'Não foi possível atualizar o produto', 'code' => 2,  'url' => 'admin/cardapio',]);
        exit($json);
    }

    public function updatePizza($data)
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

        if ($data['valor_promocional']) {
            $valor_promocional = $this->geral->brl2decimal($data['valor_promocional']);
        } else {
            $valor_promocional = 0;
        }

        if ($data['valor']) {
            $preco = $this->geral->brl2decimal($data['valor']);
        } else {
            $preco = 0;
        }

        if ($data['switch']) {
            $status = $data['switch'];
        } else {
            $status = 0;
        }

        $valor = (new Produtos())->findById($data['id']);
        $valor->nome = $data['nome'];
        $valor->cod = $data['cod'];
        $valor->descricao = $data['descricao'];
        $valor->observacao = $data['observacao'];
        $valor->valor = $preco;
        $valor->valor_promocional = $valor_promocional;
        $valor->imagem = $data['imagemNome'];
        $valor->adicional = $adicionalSelecionados;
        $valor->sabores = $saborSelecionados;
        $valor->status = $status;
        $valor->dias_disponiveis = $dias_disponiveis;
        $valor->vendas = $data['vendas'];
        $valor->id_empresa = $data['id_empresa'];
        $valor->save();

        if ($data['valor'] ==  0) {
            if ($valor->id > 0) {

                $array = $data['preco'];
                $newArray = array();
                foreach (array_keys($array) as $fieldKey) {
                    foreach ($array[$fieldKey] as $key => $value) {
                        $newArray[$key][$fieldKey] = $value;
                    }
                }
                foreach ($newArray as $res) {
                    //print_r((int)$res['id_valor']);
                    $prodValor = (new PizzaProdutoValor())->findById((int)$res['id_valor']);
                    $prodValor->valor = $this->geral->brl2decimal($res['valor']);
                    $prodValor->save();
                }
                //dd('');
            }
        }

        if ($data['categoriaCad'] != $data['categoria']) {
            $cat = $this->acoes->getByField('categorias', 'id', $data['categoriaCad']);
            $novaQtd = $cat->produtos - 1;

            $valorCat = (new Categorias())->findById($data['categoriaCad']);
            $valorCat->produtos = $novaQtd;
            $valorCat->id_empresa = $data['id_empresa'];
            $valorCat->save();


            $catNe = $this->acoes->getByField('categorias', 'id', $data['categoria']);
            $novaQtdN = $catNe->produtos + 1;

            $valorNCat = (new Categorias())->findById($data['categoria']);
            $valorNCat->produtos = $novaQtdN;
            $valorNCat->id_empresa = $data['id_empresa'];
            $valorNCat->save();
        }

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Produto atualizado com sucesso', 'error' => 'Não foi possível atualizar o produto', 'code' => 2,  'url' => 'admin/cardapio',]);
        exit($json);
    }

    public function deletar($data)
    {
        $valor = (new Produtos())->findById($data['id']);
        $valor->destroy();

        $cat = $this->acoes->getByField('categorias', 'id', $data['categoria']);
        $novaQtd = $cat->produtos - 1;

        $valorCat = (new Categorias())->findById($data['categoria']);
        $valorCat->produtos = $novaQtd;
        $valorCat->id_empresa = $data['id_empresa'];
        $valorCat->save();

        redirect(BASE . "{$data['linkSite']}/admin/cardapio");
    }
}

<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\classes\CalculoFrete;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use Twilio\Rest\Client;
use app\classes\Sessao;
use app\Models\Carrinho;
use app\Models\CarrinhoAdicional;
use app\Models\CarrinhoCPFNota;
use app\Models\CarrinhoPedidoPagamento;
use app\Models\CarrinhoPedidos;
use app\Models\CupomDescontoUtilizadores;
use app\Models\Produtos;
use app\Models\Usuarios;
use app\Models\UsuariosEmpresa;
use Bcrypt\Bcrypt;
use Browser;
use Mobile_Detect;

class CarrinhoPizzaController extends Controller
{

    private $acoes;
    private $sessao;
    private $geral;
    private $trans;
    private $bcrypt;
    private $calculoFrete;

    public function __construct()
    {
        $this->trans = new Translate(new PhpFilesLoader("../app/language"), ["default" => "pt_BR"]);
        $this->sessao = new Sessao();
        $this->geral = new AllController();
        $this->calculoFrete = new CalculoFrete();
        $this->bcrypt = new Bcrypt();
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $categoria = $this->acoes->getByField('categorias', 'slug', $data['categoriaSlug']);
        $tamanhos = $this->acoes->getByField('pizzaTamanhos', 'id', $data['tamanhoId']);
        $tamanhosCategoria = $this->acoes->getByField('pizzaTamanhosCategoria', 'id', $data['tamanhoCatId']);

        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produtos = $this->acoes->getByFieldTwoAll('produtos', 'id_empresa', $empresa->id, 'id_categoria', $categoria->id);
        $produtoValor = $this->acoes->getByFieldTwoAll('pizzaProdutoValor', 'id_empresa', $empresa->id, 'id_tamanho', $data['tamanhoId']);
        $massaTamanho = $this->acoes->getByFieldAll('pizzaMassasTamanhos', 'id_tamanhos', $data['tamanhoId']);
        //dd($massaTamanho);
        $pizzaMassasTamanhos = $this->acoes->getByFieldAll('pizzaMassasTamanhos', 'id_empresa', $empresa->id);
        $pizzaMassas = $this->acoes->getByFieldAll('pizzaMassas', 'id_empresa', $empresa->id);


        
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);

        $quantidade = $data['quantidade'];

        $resultchave = md5(uniqid(rand(), true));
        $resultCarrinhoQtd = 0;
        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            if ($this->sessao->getNivel() == 1) {
                redirect(BASE . "{$empresa->link_site}/motoboy");
            }

            if ($this->sessao->getNivel() == 0) {
                redirect(BASE . "{$empresa->link_site}/admin");
            }
        }

        $this->load('produto/pizza', [
            'moeda' => $moeda,
            'pizzaMassas' => $pizzaMassas,
            'massasTamanho' => $massaTamanho,
            'pizzaMassasTamanhos' => $pizzaMassasTamanhos,
            'produtos' => $produtos,
            'produtoValor' => $produtoValor,
            'empresa' => $empresa,
            'enderecoAtivo' => $enderecoAtivo,
            'delivery' => $delivery,
            'categoria' => $categoria,
            'ii' => $quantidade,
            'tamanhosCategoria' => $tamanhosCategoria,
            'tamanho' => $tamanhos,
            'categoria' => $categoria,
            'chave' => $resultchave,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'categoriaSlug' => $data['categoriaSlug'],
            'tamanhoId' => $data['tamanhoId'],
            'tamanhoCatId' => $data['tamanhoCatId']

        ]);
    }

    public function insert($data)
    {
        
        $quantidade = "";
        if($data['quantidade'] == 1){
            $quantidade == "INTEIRA";
        }else{
            $quantidade == $data['quantidade']." SABORES";
        }

        $tamanho = $this->acoes->getByField('pizzaTamanhos', 'id', $data['tamanhoId']);
        $sabor = $this->acoes->getByField('produtos', 'id', $data['id_produto']);
        $massa = $this->acoes->getByField('pizzaMassas', 'id', $data['massa']);

        if(is_array($data['pizza_prod'])){
            $i = 1;
            $sabor = "";
            foreach ($data['pizza_prod'] as $cart) {
                $pizzaSabor = $this->acoes->getByField('produtos', 'id', $cart);
                $sabor .= $i++.'/'.$data['quantidade'].' '.$pizzaSabor->nome.' - ';
            }
            $saborfinal = rtrim($sabor, ' - ');
            $nomePizza = "PIZZA {$tamanho->nome} {$data['quantidade']} SABORES - {$massa->nome} - {$saborfinal}";
        }else{
            $nomePizza = "PIZZA {$tamanho->nome} {$quantidade} - {$massa->nome} - {$sabor->nome}";
            //dd($nomePizza);
        }
        //dd('passou');
        $valor = new Carrinho();
        $valor->id_produto = $data['id_produto'];
        $valor->id_cliente = $this->sessao->getUser();
        $valor->id_empresa = $data['id_empresa'];
        $valor->quantidade = 1;
        $valor->variacao = $nomePizza;
        $valor->observacao = $data['observacao'];
        $valor->valor = $data['valor'];
        $valor->save();

        if ($valor->id > 0) {
            header('Content-Type: application/json');
            $json = json_encode(['id' => $valor->id, 'resp' => 'insertCart', 'mensagem' => 'Seu produto foi adicionado a Sacola!', 'error' => 'Não foi possível adicionar o produto a sacola! Tente novamente.','code' => 2 ,  'url' => 'carrinho',]);
            exit($json);
        }
       
    }
}

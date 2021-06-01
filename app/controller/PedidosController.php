<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\classes\Sessao;
use app\Models\CarrinhoPedidos;
use Browser;


class PedidosController extends Controller
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
    /**
     * Pagina do pedidos já feitos
     *
     */
    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $usuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        $empresas = $this->acoes->getFind('empresa');
        $status = $this->acoes->getFind('status');

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(),'id_empresa', $empresa->id);
        }

        $count = $this->acoes->counts('carrinhoPedidos', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $pedidos = $this->acoes->pagination('carrinhoPedidos','id_cliente', $this->sessao->getUser(), $pager->limit(), $pager->offset(), 'id ASC');
     
        $this->load('_cliente/pedidos/main', [
            'moeda' => $moeda,
            'paginacao' => $pager->render('mt-4 pagin'),
            'status' => $status,
            'pedidos' => $pedidos,
            'empresa' => $empresa,
            'empresas' => $empresas,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'usuario' => $usuario,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
        ]);
    }
    public function view($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $venda = $this->acoes->getByField('carrinhoPedidos', 'chave', $data['chave']);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);

        $this->load('_cliente/pedidos/view', [
            'empresa' => $empresa,
            'moeda' => $moeda,
            'venda' => $venda,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser()
        ]);

    }

    /**
     * Pagina do pedido Carregamento Ajax
     *
     */
    public function statusPedidoFull($data)
    {

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $venda = $this->acoes->getByField('carrinhoPedidos', 'numero_pedido', $data['numero_pedido']);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $carrinho = $this->acoes->getByFieldTwoAll('carrinho', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser());
        $carrinhoAdicional = $this->acoes->getByFieldTwoAll('carrinhoAdicional', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser());
        $carrinho = $this->acoes->getByFieldAll('carrinho', 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser());
        $usuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(),'id_empresa', $empresa->id);
        }

        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $usuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        $endereco = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        $estados = $this->acoes->getFind('estados');
        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produto = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $adicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $sabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $tipo = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
        $pagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);
        $avaliacao = $this->acoes->countsTwo('avaliacao', 'id_cliente', $this->sessao->getUser(), 'id_motoboy', $venda->id, 'id_motoboy', $empresa->id);

        if ($this->sessao->getUser()) {
            if ($this->sessao->getNivel() != 3) {
                redirect(BASE . "{$empresa->link_site}/motoboy");
            }
        } else {
            redirect(BASE . "{$empresa->link_site}");
        }

        $this->load('_cliente/pedidos/pedidoAcompanharTotal', [
            'moeda' => $moeda,
            'moeda' => $moeda,
            'carrinho' => $carrinho,
            'usuario' => $usuario,
            'endereco' => $endereco,
            'estados' => $estados,
            'delivery' => $delivery,
            'tipo' => $tipo,
            'agamento' => $pagamento,
            'deliveryEntregaExcedente' => $delivery->km_entrega_excedente * 1000,
            'carrinho' => $carrinho,
            'carrinhoAdicional' => $carrinhoAdicional,
            'produto' => $produto,
            'adicionais' => $adicionais,
            'sabores' => $sabores,
            'tipo' => $tipo,
            'pagamento' => $pagamento,
            'empresaEndereco' => $empresaEndereco,
            'avaliacao' => $avaliacao,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'venda' => $venda,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser()
        ]);
    }
    public function cancelarPedido($data)
    {
        $venda = $this->acoes->getByField('carrinhoPedidos', 'numero_pedido', $data['numero_pedido']);

        $valor = (new CarrinhoPedidos())->findById($venda->id);
        $valor->status = 6;
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Pedido cancelado com sucesso!', 'error' => 'Erro ao cancelar seu pedido']);
        exit($json);
    }
}

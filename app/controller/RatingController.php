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
use app\Models\Avaliacao;
use Browser;
use Mobile_Detect;

class RatingController extends Controller
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
        $pedido = $this->acoes->getByField('carrinhoPedidos', 'numero_pedido', $data['numero_pedido']);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $usuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        $this->load('_geral/rating/main', [
            'estabelecimento' => $estabelecimento,
            'pedido' => $pedido->numero_pedido,
            'id_motoboy' => $pedido->id_motoboy,
            'id_cliente' => $this->sessao->getUser(),
            'data_compra' => $pedido->created_at,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'usuarioLogado' => $usuario,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->data_inicio,
        ]);
    }

    public function rating($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $valor = new Avaliacao();
        $valor->numero_pedido = $data['numero_pedido'];
        $valor->id_cliente = $data['id_cliente'];
        $valor->id_motoboy = $data['id_motoboy'];
        $valor->avaliacao_pedido = $data['avaliacao_pedido'];
        $valor->avaliacao_motoboy = $data['avaliacao_motoboy'];
        $valor->observacao = $data['observacao'];
        $valor->data_compra = $data['data_compra'];
        $valor->id_empresa = $empresa->id;
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Agradecemos pela sua avaliação!', 'error' => 'Não foi posível avaliar o pedido', 'url' => 'meus-pedidos',]);
        exit($json);
    }
}

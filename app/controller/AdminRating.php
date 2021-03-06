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


class AdminRating extends Controller
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $rating = $this->acoes->counts('avaliacao', 'id_empresa', $empresa->id);
        $ratingAll = $this->acoes->getByFieldAll('avaliacao', 'id_empresa', $empresa->id);
        $ratingPedidos = $this->acoes->getByFieldAll('avaliacao', 'id_empresa', $empresa->id);
        $ratingEntrega = $this->acoes->getByFieldAll('avaliacao', 'id_empresa', $empresa->id);


        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $day = date('w');
        $domingo = date('Y-m-d', strtotime('-' . $day . ' days'));
        $noventa = date('Y-m-d', strtotime('-' . (90 - $day) . ' days'));

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                if ($this->sessao->getNivel() == 3) {
                    redirect(BASE . $empresa->link_site);
                }
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/avaliacao/main', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'noventa' => $noventa,
            'planoAtivo' => $planoAtivo,
            'hoje' => $domingo,
            'domingo' => $domingo,
            'ratingAll' => $ratingAll,
            'rating' => $rating,
            'votacaoEntrega' => $ratingEntrega[0]->avaliacao_motoboy,
            'votacaoPedidos' => $ratingPedidos[0]->avaliacao_pedido,
            'nivelUsuario' => $this->sessao->getNivel(),
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $caixa->status
        ]);
    }
}

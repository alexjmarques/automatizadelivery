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
use app\Models\Empresa;

//use MatheusHack\IFood\Restaurant;

class AdminDashboard extends Controller
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
        $moeda = $this->acoes->getByField('moeda','id', $empresa->id_moeda);
        
        if ($this->sessao->getUser()) {
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }
        /**
         * Contagem dos Itens da Empresa
         */
        
        $resultCategorias = $this->acoes->countCompany('categorias', 'id_empresa', $empresa->id);
        $resultProdutos = $this->acoes->countCompany('produtos', 'id_empresa', $empresa->id);
        $resultUsuarios = $this->acoes->countCompany('usuariosEmpresa', 'id_empresa', $empresa->id);
        $resultMotoboys = $this->acoes->countCompany('motoboy', 'id_empresa', $empresa->id);
        $resultPedidosAll = $this->acoes->countCompany('carrinhoPedidos', 'id_empresa', $empresa->id);
        
        $resultProdutosEsgotados = $this->acoes->countStatusCompany('produtos', 'id_empresa', $empresa->id, 0);
        $resultProdutosAtivos = $this->acoes->countStatusCompany('produtos', 'id_empresa', $empresa->id, 1);
        
        /**
         * Contagem dos Itens da Empresa do Dia Atual
         */
        $resultPedidos = $this->acoes->countCompanyDay('carrinhoPedidos', 'id_empresa', $empresa->id, 'data_pedido');
        //dd($resultCategorias);
        $resultRecebidos = $this->acoes->countStatusCompanyDay('carrinhoPedidos', 'id_empresa', $empresa->id, 1, 'data_pedido');
        $resultProducao = $this->acoes->countStatusCompanyDay('carrinhoPedidos', 'id_empresa', $empresa->id, 2, 'data_pedido');
        $resultSaiuEntrega = $this->acoes->countStatusCompanyDay('carrinhoPedidos', 'id_empresa', $empresa->id, 3, 'data_pedido');
        $resultEntregas = $this->acoes->countStatusCompanyDay('carrinhoPedidos', 'id_empresa', $empresa->id, 4, 'data_pedido');
        $resultRecusado = $this->acoes->countStatusCompanyDay('carrinhoPedidos', 'id_empresa', $empresa->id, 5, 'data_pedido');
        $resultCancelados = $this->acoes->countStatusCompanyDay('carrinhoPedidos', 'id_empresa', $empresa->id, 6, 'data_pedido');
        $resultMaisVendidos = $this->acoes->limitOrder('produtos', 'id_empresa', $empresa->id, 5, 'vendas', 'DESC');
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        
        //dd($resultPedidos);

        $day = date('w');
        $domingo = date('Y-m-d', strtotime('-' . $day . ' days'));
        $segunda = date('Y-m-d', strtotime('+' . (1 - $day) . ' days'));
        $terca = date('Y-m-d', strtotime('+' . (2 - $day) . ' days'));
        $quarta = date('Y-m-d', strtotime('+' . (3 - $day) . ' days'));
        $quinta = date('Y-m-d', strtotime('+' . (4 - $day) . ' days'));
        $sexta = date('Y-m-d', strtotime('+' . (5 - $day) . ' days'));
        $sabado = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));


        $this->load('_admin/dashboard/main', [
            'moeda' => $moeda,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),
            
            'categorias' => $resultCategorias,
            'empresa' => $empresa,
            'planoAtivo' => $planoAtivo,
            'produtos' => $resultProdutos,
            'produtosAtivos' => $resultProdutosAtivos,
            'produtosEsgotado' => $resultProdutosEsgotados,
            'usuarios' => $resultUsuarios,
            'motoboys' => $resultMotoboys,
            'recebidos' => $resultRecebidos,
            'producao' => $resultProducao,
            'saiuEntrega' => $resultSaiuEntrega,
            'entregas' => $resultEntregas,
            'cancelados' => $resultCancelados,
            'pedidos' => $resultPedidos,
            'pedidosAll' => $resultPedidosAll,
            'categorias' => $resultCategorias,
            'maisVendidos' => $resultMaisVendidos,
            'caixa' => $estabelecimento[0]->data_final,
            'domingo' => $domingo,
            'segunda' => $segunda,
            'terca' => $terca,
            'quarta' => $quarta,
            'quinta' => $quinta,
            'sexta' => $sexta,
            'sabado' => $sabado
        ]);
    }

    public function relatorioSemanal($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/dashboard/relatorioSemanal', [
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'planoAtivo' => $planoAtivo,
            'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_final,
        ]);
    }

    public function caixaLista($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $countCaixa = $this->acoes->counts('empresaCaixa', 'id_empresa', $empresa->id);

        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$countCaixa, 10, $page);
        $resultCaixa = $this->acoes->pagination('empresaCaixa','id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id DESC');


        $this->load('_admin/dashboard/caixaLista', [
            'caixas' => $resultCaixa,
            'paginacao' => $pager->render('mt-4 pagin'),
            'empresa' => $empresa,
            'moeda' => $moeda,
            'trans' => $this->trans,
            'planoAtivo' => $planoAtivo,
            'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_final,
        ]);
    }

    public function caixaDados($data)
    {
        $empresaCaixa = $this->acoes->getByField('empresaCaixa', 'id', $data['id']);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);

        if ($this->sessao->getUser()) {
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }
        
        $totalPedidos = $this->acoes->countCompanyVar('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_caixa', $empresaCaixa->id);
        $totalEntregas = $this->acoes->countCompanyVar('carrinhoPedidos', 'id_caixa', $empresaCaixa->id, 'status', 4);
        $totalCancelados = $this->acoes->countCompanyVar('carrinhoPedidos', 'id_caixa', $empresaCaixa->id, 'status', 6);
        $totalRecusado = $this->acoes->countCompanyVar('carrinhoPedidos', 'id_caixa', $empresaCaixa->id, 'status', 5);
        
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        
        //$totasEntregas = $this->acoes->sumFiels('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_caixa', $empresaCaixa->id,'valor_frete');
        
        
        $pedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $empresaCaixa->id);
        $status = $this->acoes->getFind('status');
        $tipoPagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);
        $tipoDelivery = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
        
        $totasVendas = $this->acoes->sumFiels('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_caixa', $empresaCaixa->id,'total_pago');
        $totasEntregas =$this->acoes->sumFielsTreeM('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_caixa', $empresaCaixa->id,'status',6, 'valor_frete');
        $totalFinal =$this->acoes->sumFielsTreeM('carrinhoPedidos', 'id_empresa', $empresa->id, 'id_caixa', $empresaCaixa->id,'status',5, 'total_pago');

        $this->load('_admin/dashboard/caixaDados', [
            'entregas' => $totasEntregas,
            'moeda' => $moeda,
            'tipoPagamento' => $tipoPagamento,
            'tipoDelivery' => $tipoDelivery,
            'pedidos' => $pedidos,
            'status' => $status,
            'totalPedidos' => $totalPedidos,
            'totalEntregas' => $totalEntregas,
            'totalRecusado' => $totalRecusado,
            'totalCancelados' => $totalCancelados,
            'vendas' => $totasVendas,
            'totalFinal' => $totalFinal,
            'caixaDados' => $empresaCaixa,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'planoAtivo' => $planoAtivo,
            'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_final
        ]);
    }


    public function relatorioGeral($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        if ($this->sessao->getUser()) {
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }


        $totalPedidos = $this->acoes->counts('carrinhoPedidos', 'id_empresa', $empresa->id);
        $totalEntregas = $this->acoes->countCompanyVar('carrinhoPedidos', 'id_empresa', $empresa->id, 'status', 4);
        $totalCancelados = $this->acoes->countCompanyVar('carrinhoPedidos', 'id_empresa', $empresa->id, 'status', 6);
        $totalRecusado = $this->acoes->countCompanyVar('carrinhoPedidos', 'id_empresa', $empresa->id, 'status', 5);
        $totalEntregas = $this->acoes->countCompanyVar('carrinhoPedidos', 'id_empresa', $empresa->id, 'status', 4);
  
        $resultVendasCanceladas = $this->acoes->sumFiels('carrinhoPedidos', 'id_empresa', $empresa->id, 'status', 6, 'total_pago');
        $resultVendasRecusadas = $this->acoes->sumFiels('carrinhoPedidos', 'id_empresa', $empresa->id, 'status', 5, 'total_pago');
        $resultVendas = $this->acoes->sumFiels('carrinhoPedidos', 'id_empresa', $empresa->id, 'status', 4, 'total_pago');

        $entregas = $this->acoes->sumFielsM('carrinhoPedidos', 'id_empresa', $empresa->id, 'status', 5, 'valor_frete');

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa',$empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/dashboard/caixaVisaoGeral', [
            'caixa' => $estabelecimento[0]->data_final,
            
            'estabelecimento' => $estabelecimento,
            'isLogin' => $this->sessao->getUser(),
            'totalPedidos' => $totalPedidos,
            'totalEntregas' => $totalEntregas,
            'totalCancelados' => $totalCancelados,
            'totalRecusado' => $totalRecusado,

            'vendasCanceladas' => $resultVendasCanceladas,
            'vendasRecusadas' => $resultVendasRecusadas,
            'vendas' => $resultVendas,
            'entregas' => $entregas,
            'moeda' => $moeda,
            'planoAtivo' => $planoAtivo,
            'trans' => $this->trans,
            'empresa' => $empresa,

        ]);
    }
}

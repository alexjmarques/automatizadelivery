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
use app\Models\CarrinhoEntregas;
use app\Models\CarrinhoPedidos;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\LinuxPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\Printer;
use Browser;


class AdminPedidos extends Controller
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
        $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $resultClientes = $this->acoes->getFind('usuarios');
        $resultMotoboy = $this->acoes->getByFieldAll('motoboy', 'id_empresa', $empresa->id);
        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);
        }

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $usuario = $this->acoes->getFind('usuarios');
        $count = $this->acoes->counts('motoboy', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $retorno = $this->acoes->pagination('motoboy', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/pedidos/main', [
            'motoboys' => $retorno,
            'usuario' => $usuario,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixaId' => $estabelecimento[0]->id,
            'caixa' => $estabelecimento[0]->data_inicio,
            'nivelUsuario' => $this->sessao->getNivel(),
            'pedidos' => $resultPedidos,
            'clientes' => $resultClientes,
            'motoboy' => $resultMotoboy,
        ]);
    }

    public function pedidosRecebido($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);

            $resultClientes = $this->acoes->getFind('usuarios');
            $resultMotoboy = $this->acoes->getByField('motoboy', 'id_empresa', $empresa->id);


            $this->load('_admin/pedidos/pedidoListaRecebido', [
                'planoAtivo' => $planoAtivo,
                'empresa' => $empresa,
                'trans' => $this->trans,
                'isLogin' => $this->sessao->getUser(),
                'nivelUsuario' => $this->sessao->getNivel(),
                'caixa' => $estabelecimento[0]->data_inicio,
                'caixaId' => $estabelecimento[0]->id,
                'pedidos' => $resultPedidos,
                'clientes' => $resultClientes,
                'motoboy' => $resultMotoboy
            ]);
        } else {
            echo 0;
        }
    }

    public function pedidosProducao($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $resultClientes = $this->acoes->getFind('usuarios');
        $resultMotoboy = $this->acoes->getByField('motoboy', 'id_empresa', $empresa->id);
        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);

            if ($this->sessao->getUser()) {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            }

            $this->load('_admin/pedidos/pedidoListaProducao', [
                'planoAtivo' => $planoAtivo,
                'empresa' => $empresa,
                'moeda' => $moeda,
                'trans' => $this->trans,
                'usuarioLogado' => $usuarioLogado,
                'isLogin' => $this->sessao->getUser(),
                'nivelUsuario' => $this->sessao->getNivel(),
                'caixa' => $estabelecimento[0]->data_inicio,
                'caixaId' => $estabelecimento[0]->id,
                'pedidos' => $resultPedidos,
                'clientes' => $resultClientes,
                'motoboy' => $resultMotoboy
            ]);
        } else {
            echo 0;
        }
    }


    public function pedidosGeral($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);
            $resultClientes = $this->acoes->getFind('usuarios');
            $resultMotoboy = $this->acoes->getByField('motoboy', 'id_empresa', $empresa->id);

            if ($this->sessao->getUser()) {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            }

            $this->load('_admin/pedidos/pedidoListaGeral', [
                'planoAtivo' => $planoAtivo,
                'empresa' => $empresa,
                'trans' => $this->trans,
                'usuarioLogado' => $usuarioLogado,
                'isLogin' => $this->sessao->getUser(),
                'nivelUsuario' => $this->sessao->getNivel(),
                'caixa' => $estabelecimento[0]->data_inicio,
                'caixaId' => $estabelecimento[0]->id,
                'pedidos' => $resultPedidos,
                'clientes' => $resultClientes,
                'motoboy' => $resultMotoboy
            ]);
        } else {
            echo 0;
        }
    }


    public function pedidoMostrar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $pedido = $this->acoes->getByField('carrinhoPedidos', 'id', $data['id']);
        $cliente = $this->acoes->getByField('usuarios', 'id', $pedido->id_cliente);
        $endereco = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $pedido->id_cliente);

        $tipoPagamento = $this->acoes->getByField('formasPagamento', 'id', $pedido->tipo_pagamento);
        $tipoFrete = $this->acoes->getByField('tipoDelivery', 'id', $pedido->tipo_frete);
        $status = $this->acoes->getByField('status', 'id', $pedido->status);

        $motoboys = $this->acoes->getByFieldAll('motoboy', 'id_empresa', $empresa->id);
        $usuarios = $this->acoes->getByFieldAll('usuarios', 'nivel', 1);

        $sabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $produtosAdicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $carrinhoAdicional = $this->acoes->getByFieldAll('carrinhoAdicional', 'numero_pedido', $pedido->numero_pedido);
        $clientePagamento = $this->acoes->getByFieldAll('carrinhoPedidoPagamento', 'numero_pedido', $pedido->numero_pedido);

        if ($empresa->nf_paulista == 1) {
            $nfPaulista = $this->acoes->getByFieldAll('carrinhoCPFNota', 'numero_pedido', $pedido->numero_pedido);
        }

        $produtos = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);
        $carrinho = $this->acoes->getByFieldAllTwo('carrinho', 'id_empresa', $empresa->id, 'numero_pedido', $pedido->numero_pedido);

        $cupomVerifica = $this->acoes->counts('cupomDesconto', 'id_empresa', $empresa->id);
        $cupomVerificaUtilizadores = $this->acoes->counts('cupomDescontoUtilizadores', 'id_empresa', $empresa->id);

        if ($cupomVerifica > 0 && $cupomVerificaUtilizadores) {
            $cupomUtilizado = $this->acoes->getByField('cupomDescontoUtilizadores', 'numero_pedido', $pedido->numero_pedido);
            $cupomValida = $this->acoes->getByField('cupomDesconto', 'id_cupom', $cupomUtilizado->id);

            if ((int)$cupomValida->tipo_cupom == 1) {
                $valor = $pedido->total;
                $porcentagem = floatval($cupomValida->valor_cupom);
                $resul = $valor * ($porcentagem / 100);
                $resultado = $resul;
            } else {
                $resultado = $cupomValida->valor_cupom;
            }
        }

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        }

        $this->load('_admin/pedidos/pedidoMostrar', [
            'moeda' => $moeda,
            'planoAtivo' => $planoAtivo,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $estabelecimento[0]->data_inicio,
            'estabelecimento' => $estabelecimento[0]->id,
            'pedido' => $pedido,
            'cliente' => $cliente,
            'usuarios' => $usuarios,
            'pagamento' => $tipoPagamento,
            'tipoFrete' => $tipoFrete,
            'status' => $status,
            'motoboys' => $motoboys,
            'endereco' => $endereco,
            'produtos' => $produtos,
            'carrinho' => $carrinho,
            'cupomValor' => $resultado,
            'adicionais' => $produtosAdicionais,
            'sabores' => $sabores,
            'carrinhoAdicional' => $carrinhoAdicional,
            'nfPaulista' => $nfPaulista,
            'clientePagamento' => $clientePagamento

        ]);
    }

    public function pedidosFinalizados($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $tipoPagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);
        $tipoDelivery = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);

        $resultClientes = $this->acoes->getFind('usuarios');
        $resultMotoboy = $this->acoes->getByField('motoboy', 'id_empresa', $empresa->id);
        $status = $this->acoes->getFind('status');


        $count = $this->acoes->counts('carrinhoPedidos', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $resultPedidos = $this->acoes->pagination('carrinhoPedidos', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'created_at DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
        }

        $this->load('_admin/pedidos/pedidos', [
            'planoAtivo' => $planoAtivo,
            'paginacao' => $pager->render('mt-4 pagin'),
            'moeda' => $moeda,
            'tipoDelivery' => $tipoDelivery,
            'tipoPagamento' => $tipoPagamento,
            'status' => $status,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $estabelecimento[0]->data_inicio,
            'caixaId' => $estabelecimento[0]->id,
            'pedidos' => $resultPedidos,
            'clientes' => $resultClientes,
            'motoboy' => $resultMotoboy
        ]);
    }

    public function mudarStatus($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $pedidos = $this->acoes->getByField('carrinhoPedidos', 'id', $data['id']);

        $valor = (new CarrinhoPedidos())->findById($data['id']);
        $valor->status = $data['status'];
        if ($planoAtivo > 2) {
            $valor->id_motoboy = $data['motoboy'];
        } else {
            $valor->id_motoboy = 0;
        }
        $valor->save();

        $count = $this->acoes->getByFieldTwo('carrinhoEntregas', 'numero_pedido', $pedidos->numero_pedido, 'id_empresa', $data['id_empresa']);
        $pedido = $this->acoes->getByFieldTwo('carrinhoEntregas', 'numero_pedido', $pedidos->numero_pedido, 'id_empresa', $data['id_empresa']);
        if ($planoAtivo > 2) {
            if ($data['motoboy'] > 0) {
                if (!$count) {
                    $entregas = new CarrinhoEntregas();
                    $entregas->id_motoboy = $data['motoboy'];
                    $entregas->id_caixa = $data['id_caixa'];
                    $entregas->id_cliente = $data['id_cliente'];
                    $entregas->id_empresa = $data['id_empresa'];
                    $entregas->numero_pedido = $data['numero_pedido'];
                    $entregas->status = $data['status'];
                    $entregas->save();
                } else {
                    $entregas = (new CarrinhoEntregas())->findById($pedido->id);
                    $entregas->status = $data['status'];
                    $entregas->save();
                }
            }
        } else {
            if (!$count) {
                $entregas = new CarrinhoEntregas();
                $entregas->id_motoboy = 0;
                $entregas->id_caixa = $data['id_caixa'];
                $entregas->id_cliente = $data['id_cliente'];
                $entregas->id_empresa = $data['id_empresa'];
                $entregas->numero_pedido = $data['numero_pedido'];
                $entregas->status = $data['status'];
                $entregas->save();
            } else {
                $entregas = (new CarrinhoEntregas())->findById($pedido->id);
                $entregas->status = $data['status'];
                $entregas->id_motoboy = 0;
                $entregas->save();
            }
        }
        echo "Status alterado com sucesso";
    }


    public function pedidoTestImprimir($data)
    {
        try {
            $connector = new FilePrintConnector("/dev/usb/lp0");
            //$connector = new NetworkPrintConnector("159.65.220.187", 9100);
            //$connector = new WindowsPrintConnector("smb://computername/Receipt Printer");
            
            /* Print a "Hello world" receipt" */
            $printer = new Printer($connector);
            $printer -> text("Hello World!\n");
            $printer -> cut();
            
            /* Close printer */
            $printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }

        // try {
        //     $connector = new NetworkPrintConnector("localhost", 9100);
        //     $printer = new Printer($connector);
        //     $printer -> text("Hello World!\n");
        //     $printer -> cut();
            
        //     /* Close printer */
        //     $printer -> close();
        // } catch (Exception $e) {
        //     echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        // }
    }

    // public function pedidoImprimir($data)
    // {
    //     $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
    //     setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    //     date_default_timezone_set('America/Sao_Paulo');

    //     $empresa = $this->configEmpresaModel->getById($empresaAct[':id']);
    //     $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
    //     $moeda = $this->moedaModel->getById($empresa[':moeda']);
    //     //$pedido = $this->adminVendasModel->getById(11);
    //     $pedido = $this->adminVendasModel->getById($data['id']);
    //     $cliente = $this->adminUsuarioModel->getClienteById($pedido[':id_cliente']);
    //     $resultPagamento = $this->adminPagamentoModel->getById($pedido[':tipo_pagamento']);

    //     $endereco = $this->adminEnderecoModel->getByIdPedido($cliente[':id']);
    //     $resultFrete = $this->adminTipoModel->getById($pedido[':tipo_frete']);

    //     //Recuperando Produtos
    //     $carrinho = $this->adminCarrinhoModel->getPedidoFeito($pedido[':numero_pedido'], $empresaAct[':id']);
    //     $produtos = $this->adminProdutosModel->getAllPorEmpresa($empresaAct[':id']);

    //     $adicionais = $this->adminProdutosAdicionaisModel->getAllPorEmpresa($empresaAct[':id']);
    //     $sabores = $this->adminProdutosSaboresModel->getAllPorEmpresa($empresaAct[':id']);

    //     $carrinhoAdicional = $this->adminCarrinhoAdicionaisModel->getPedidoFeito($pedido[':numero_pedido'], $empresaAct[':id']);
    //     $nfPaulista = $this->carrinhoNFPaulistaModel->getBynumero_pedidoCLiente($pedido[':numero_pedido'], $pedido[':id_cliente'], $empresaAct[':id']);
    //     $resultPagamentoCli = $this->pedidosPagamentoModel->getPedidoFeito($pedido[':numero_pedido'], $empresaAct[':id']);

    //     $nf = $nfPaulista[':cpf'] != "" ? "NOTA FISCAL " . $nfPaulista[':cpf'] : "";

    //     // foreach($carrinho as $car)
    //     //     {
    //     //         foreach($produtos as $prod)
    //     //         {
    //     //             if($pedido[':numero_pedido'] == $car[':numero_pedido']){
    //     //                 if($car[':id_produto'] == $prod[':id']){
    //     //                     echo $car[':quantidade'].'x - '.$prod[':nome'];

    //     //                    foreach($sabores as $s){
    //     //                     echo $s[':id'] == $car[':id_sabores'] ? ' | Sabor.: '.$s[':nome'].' | ' : "";
    //     //                    }

    //     //                    echo ' '.$moeda[':simbolo'].' '.number_format(($car[':valor'] * $car[':quantidade']), 2, '.', '');

    //     //                    foreach ($carrinhoAdicional as $cartAd) {
    //     //                        if ($prod[':id'] == $cartAd[':id_produto']) {
    //     //                            if ($car[':chave'] == $cartAd[':chave']) {
    //     //                                foreach ($adicionais as $a) {
    //     //                                    if ($a[':id'] == $cartAd[':id_adicional']) {
    //     //                                        echo "\n<br/> -". $cartAd[':quantidade']. 'x '. $a[':nome'] .' '. $moeda[':simbolo']. ' '.number_format(($a[':valor'] * $cartAd[':quantidade']), 2, '.', '');
    //     //                                    }
    //     //                                }
    //     //                            }
    //     //                        }
    //     //                    }
    //     //                    echo $car[':observacao'] != "" ? "\n<br/>(Obs.:".$car[':observacao'].')': "";

    //     //                 }
    //     //             }

    //     //         }

    //     //     }

    //     //     dd();

    //     /* Fill in your own connector here */
    //     //$connector = new FilePrintConnector("php://stdout");
    //     $profile = CapabilityProfile::load("simple");
    //     $connector = new WindowsPrintConnector("smb://computer/printer");


    //     /* Information for the receipt */
    //     $subtotal = new item('Subtotal', $moeda[':simbolo'] . ' ' . number_format($pedido[':total'], 2, '.', ''));
    //     $tax = $pedido[':tipo_frete'] == 2 ? new item('Taxa de Entrega', $pedido[':valor_frete']) : new item('Taxa de Entrega', 'Grátis');

    //     $total = new item('Total', $moeda[':simbolo'] . ' ' . number_format($pedido[':total_pago'], 2, '.', ''), true);
    //     /* Date is kept the same for testing */
    //     // $date = date('l jS \of F Y h:i:s A');

    //     $date = strftime('%A, %d de %B de %Y', strtotime('today'));

    //     /* Start the printer */
    //     //$logo = EscposImage::load(UPLOADS_BASE . $empresa[':logo'], false);
    //     //$printer = new Printer($connector);
    //     $printer = new Printer($connector, $profile);

    //     /* Print top logo */
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
    //     //$printer->graphics($logo);

    //     /* Name of shop */
    //     $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    //     $printer->text($empresa . nome_fantasia  . "\n");
    //     $printer->selectPrintMode();
    //     $printer->text("Numero do Pedido. " . $pedido[':numero_pedido'] . "\n");
    //     $printer->feed();

    //     /* Title of receipt */
    //     $printer->setEmphasis(true);
    //     $printer->text("PEDIDO DE VENDA\n");
    //     $printer->setEmphasis(false);

    //     /* Dados Entrega */
    //     $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    //     $printer->setJustification(Printer::JUSTIFY_LEFT);
    //     $printer->setEmphasis(true);
    //     $printer->text($cliente[':nome'] . "\n");
    //     $printer->text($cliente[':telefone'] . "\n");
    //     $printer->text($endereco[':rua'] . "\n");
    //     $printer->text("Nº" . $endereco[':numero'] . "\n");
    //     $printer->text($endereco[':complemento'] . "\n");
    //     $printer->text($endereco[':bairro'] . "\n");
    //     $printer->text($endereco[':cidade'] . "\n");
    //     $printer->text($endereco[':cep'] . "\n");
    //     $printer->setEmphasis(false);

    //     /* Items */
    //     $printer->setJustification(Printer::JUSTIFY_LEFT);
    //     $printer->setEmphasis(true);
    //     $printer->text(new item('', $moeda[':simbolo']));
    //     $printer->setEmphasis(false);
    //     foreach ($carrinho as $car) {
    //         foreach ($produtos as $prod) {
    //             if ($pedido[':numero_pedido'] == $car[':numero_pedido']) {
    //                 if ($car[':id_produto'] == $prod[':id']) {
    //                     $printer->text($car[':quantidade'] . 'x - ' . $prod[':nome']);

    //                     foreach ($sabores as $s) {
    //                         $printer->text($s[':id'] == $car[':id_sabores'] ? ' | Sabor.: ' . $s[':nome'] . ' | ' : "");
    //                     }

    //                     $printer->text(' ' . $moeda[':simbolo'] . ' ' . number_format(($car[':valor'] * $car[':quantidade']), 2, '.', ''));

    //                     foreach ($carrinhoAdicional as $cartAd) {
    //                         if ($prod[':id'] == $cartAd[':id_produto']) {
    //                             if ($car[':chave'] == $cartAd[':chave']) {
    //                                 foreach ($adicionais as $a) {
    //                                     if ($a[':id'] == $cartAd[':id_adicional']) {
    //                                         $printer->text("\n<br/> -" . $cartAd[':quantidade'] . 'x ' . $a[':nome'] . ' ' . $moeda[':simbolo'] . ' ' . number_format(($a[':valor'] * $cartAd[':quantidade']), 2, '.', ''));
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                     $printer->text($car[':observacao'] != "" ? "\n (Obs.:" . $car[':observacao'] . ')' : "");
    //                 }
    //             }
    //         }
    //     }
    //     $printer->setEmphasis(true);
    //     $printer->text($subtotal);
    //     $printer->setEmphasis(false);
    //     $printer->feed();

    //     /* Tax and total */
    //     $printer->text($tax);
    //     $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    //     $printer->text($total);
    //     $printer->selectPrintMode();

    //     /* NF PAULIST */
    //     $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
    //     $printer->setJustification(Printer::JUSTIFY_LEFT);
    //     $printer->setEmphasis(true);
    //     $printer->text($nf . "\n");
    //     $printer->setEmphasis(false);

    //     /* Footer */
    //     $printer->feed(2);
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
    //     $printer->text("AGRADECEMOS A PREFERÊNCIA!\n");
    //     $printer->text("WHATSAPP " . $empresa[':telefone'] . "\n");
    //     $printer->feed(2);
    //     $printer->text($date . "\n");

    //     /* Cut the receipt and open the cash drawer */

    //     //print_r($printer);
    //     $printer->cut();
    //     $printer->pulse();

    //     $printer->close();
    // }

}

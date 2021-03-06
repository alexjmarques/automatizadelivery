<?php

namespace app\controller;

use Dompdf\Dompdf;
use chillerlan\QRCode\QRCode;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\item;
use app\classes\Cache;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\classes\Sessao;
use app\Models\Carrinho;
use app\Models\CarrinhoEntregas;
use app\Models\CarrinhoPedidos;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\LinuxPrintConnector;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Exception;
// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $resultClientes = $this->acoes->getFind('usuarios');
        $resultMotoboy = $this->acoes->getByFieldAll('motoboy', 'id_empresa', $empresa->id);
        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);
        }

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                if ($this->sessao->getNivel() == 3) {
                    redirect(BASE . $empresa->link_site);
                }
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $usuario = $this->acoes->getFind('usuarios');
        $count = $this->acoes->counts('motoboy', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 30, $page);
        $retorno = $this->acoes->pagination('motoboy', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/pedidos/main', [
            'motoboys' => $retorno,
            'usuario' => $usuario,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixaId' => $estabelecimento[0]->id,
            'caixa' => $caixa->status,
            'nivelUsuario' => $this->sessao->getNivel(),
            'pedidos' => $resultPedidos,
            'clientes' => $resultClientes,
            'motoboy' => $resultMotoboy,
        ]);
    }

    public function pedidosRecebido($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);

            $resultClientes = $this->acoes->getFind('usuarios');
            $resultMotoboy = $this->acoes->getByField('motoboy', 'id_empresa', $empresa->id);


            $this->load('_admin/pedidos/pedidoListaRecebido', [
                'planoAtivo' => $planoAtivo,
                'empresa' => $empresa,
                'endEmp' => $endEmp,
                'funcionamento' => $funcionamento,
                'dias' => $dias,
                'trans' => $this->trans,
                'isLogin' => $this->sessao->getUser(),
                'nivelUsuario' => $this->sessao->getNivel(),
                'caixa' => $caixa->status,
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        if ($empresa) {
            $planoAtivo = $this->geral->verificaPlano($empresa->id);
        }
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $resultClientes = $this->acoes->getFind('usuarios');
        $resultMotoboy = $this->acoes->getByField('motoboy', 'id_empresa', $empresa->id);
        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);

            if ($this->sessao->getUser()) {
                if ($this->sessao->getUser() != 'undefined') {
                    $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                }
            }
            $this->load('_admin/pedidos/pedidoListaProducao', [
                'planoAtivo' => $planoAtivo,
                'empresa' => $empresa,
                'endEmp' => $endEmp,
                'funcionamento' => $funcionamento,
                'dias' => $dias,
                'moeda' => $moeda,
                'trans' => $this->trans,
                'usuarioLogado' => $usuarioLogado,
                'isLogin' => $this->sessao->getUser(),
                'nivelUsuario' => $this->sessao->getNivel(),
                'caixa' => $caixa->status,
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);
            $resultClientes = $this->acoes->getFind('usuarios');
            $resultMotoboy = $this->acoes->getByField('motoboy', 'id_empresa', $empresa->id);

            if ($this->sessao->getUser()) {
                if ($this->sessao->getUser() != 'undefined') {
                    $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                }
            }
            if ($resultPedidos) {
                $this->load('_admin/pedidos/pedidoListaGeral', [
                    'planoAtivo' => $planoAtivo,
                    'empresa' => $empresa,
                    'endEmp' => $endEmp,
                    'funcionamento' => $funcionamento,
                    'dias' => $dias,
                    'trans' => $this->trans,
                    'usuarioLogado' => $usuarioLogado,
                    'isLogin' => $this->sessao->getUser(),
                    'nivelUsuario' => $this->sessao->getNivel(),
                    'caixa' => $caixa->status,
                    'caixaId' => $estabelecimento[0]->id,
                    'pedidos' => $resultPedidos,
                    'clientes' => $resultClientes,
                    'motoboy' => $resultMotoboy
                ]);
            }
        } else {
            echo 0;
        }
    }


    public function pedidoMostrar($data)
    {
        //dd($data);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $pedido = $this->acoes->getByField('carrinhoPedidos', 'id', $data['id']);
        $cliente = $this->acoes->getByField('usuarios', 'id', $pedido->id_cliente);
        $endereco = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $pedido->id_cliente);

        if ($pedido->status > 3) {
            $entrega = $this->acoes->getByField('carrinhoEntregas', 'numero_pedido', $pedido->numero_pedido);
        }

        $tipoPagamento = $this->acoes->getByField('formasPagamento', 'id', $pedido->tipo_pagamento);
        $tipoFrete = $this->acoes->getByFieldTwo('tipoDelivery', 'code', $pedido->tipo_frete, 'id_empresa', $empresa->id);
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
        $carrinho = $this->acoes->getByFieldAllTwoInt('carrinho', 'numero_pedido', $pedido->numero_pedido, 'id_empresa', $empresa->id);

        $cupomVerifica = $this->acoes->counts('cupomDesconto', 'id_empresa', $empresa->id);
        $cupomVerificaUtilizadores = $this->acoes->counts('cupomDescontoUtilizadores', 'id_empresa', $empresa->id);

        if ($cupomVerifica > 0 && $cupomVerificaUtilizadores) {
            $cupomUtilizado = $this->acoes->getByField('cupomDescontoUtilizadores', 'numero_pedido', $pedido->numero_pedido);
            if ($cupomUtilizado) {
                $cupomValida = $this->acoes->getByField('cupomDesconto', 'id', $cupomUtilizado->id_cupom);

                if ((int)$cupomValida->tipo_cupom == 1) {
                    $valor = $pedido->total;
                    $porcentagem = floatval($cupomValida->valor_cupom);
                    $resul = $valor * ($porcentagem / 100);
                    $resultado = $resul;
                } else {
                    $resultado = $cupomValida->valor_cupom;
                }
            }
        }
        //dd($resultado);

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            }
        }
        $this->load('_admin/pedidos/pedidoMostrar', [
            'moeda' => $moeda,
            'planoAtivo' => $planoAtivo,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
            'estabelecimento' => $estabelecimento[0]->id,
            'pedido' => $pedido,
            'entrega' => $entrega,
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

    public function pedidoImprimirPDF($data)
    {
        //dd($data);
        $dompdf = new Dompdf();

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $print = $this->acoes->getByField('imprimir', 'id_empresa', $empresa->id);

        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $pedido = $this->acoes->getByField('carrinhoPedidos', 'id', $data['id']);
        //dd($pedido);
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
        $carrinho = $this->acoes->getByFieldAll('carrinho', 'numero_pedido', $pedido->numero_pedido, 'id_empresa', $empresa->id);
        $nf = $nfPaulista->cpf != "" ? "NOTA FISCAL " . $nfPaulista->cpf : 0;

        $tax = $pedido->tipo_frete == 2 ? "<tr style='border-bottom:2px dotted #ccc; width: 100%;'><td style=' width: 80%;padding-bottom: 10px;'>Taxa de Entrega</td><td style=' width: 20%; text-align:right;  padding-bottom: 10px;'><strong>" . $moeda->simbolo . " " . $pedido->valor_frete . "</strong></td></tr>" : "<td style=' width: 80%;padding-bottom: 10px;'>Taxa de Entrega</td><td style=' width: 20%;padding-bottom: 10px;'><strong>Gr??tis</strong></td></tr>";

        $total = "<tr style='border-bottom:2px dotted #ccc; width: 100%;'><td style=' width: 80%;padding-bottom: 10px;'>Total</td><td style=' width: 20%;padding-bottom: 10px; text-align:right; '><strong>" . $moeda->simbolo . " " . number_format($pedido->total_pago, 2, '.', '') . "</strong></td></tr>";
        $subtotal = "<tr style='border-bottom:2px dotted #ccc; width: 100%;'><td style=' width: 80%;padding-bottom: 10px;'>Subtotal</td><td style=' width: 20%; text-align:right; padding-bottom: 10px;'><strong>" . $moeda->simbolo . " " . number_format($pedido->total, 2, '.', '') . "</strong></td></tr>";

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $date = strftime('%A, %d de %B de %Y', strtotime('today'));

        $print = "<h3 style='text-align:center; margin-top:0; margin-bottom:0; width: 100%;'>{$empresa->nome_fantasia}</h3>";
        //$print .= "<h3 style='text-align:center; margin-top:0; margin-bottom:0; width: 100%;'>WHATSAPP ".$this->mascTelefone($empresa->telefone)."</h3>";
        $url = "https://automatizadelivery.com.br/" . $data['linkSite'];
        $print .= '<h2 style="text-align:center;"><img src="' . (new QRCode)->render($url) . '" alt="QR Code"/></h2>';
        $print .= "<h2 style='text-align:center; margin-top:0; margin-bottom:10px; width: 100%;'>PEDIDO #{$pedido->numero_pedido}</h2>";
        $print .= "<hr>";

        $print .= "<h4 style='text-align:center; margin-top:0; margin-bottom:0;'>ITENS DO PEDIDO</h4>";
        $print .= "<table style='text-align:left; margin-top:0; margin-bottom:0; border-collapse: collapse;width: 100%;'>";
        foreach ($carrinho as $car) {

            foreach ($produtos as $prod) {
                if ($pedido->numero_pedido == $car->numero_pedido) {
                    if ($car->id_produto == $prod->id) {
                        $print .= "<tr style='border-bottom:2px dotted #ccc; width: 100%;'>";
                        $print .= "<td style=' width: 80%;padding-bottom: 10px;'>";
                        $print .= $car->quantidade . 'x - ' . $prod->nome;

                        foreach ($sabores as $s) {
                            $print .= $s->id == $car->id_sabores ? ' | Sabor.: ' . $s->nome . ' | ' : "";
                        }
                        $print .= "<br/>";


                        foreach ($carrinhoAdicional as $cartAd) {
                            if ($prod->id == $cartAd->id_produto) {
                                if ($car->chave == $cartAd->chave) {
                                    foreach ($produtosAdicionais as $a) {
                                        if ($a->id == $cartAd->id_adicional) {
                                            $print .= " - " . $cartAd->quantidade . 'x ' . $a->nome;
                                            $print .= "<br/>";
                                        }
                                    }
                                }
                            }
                        }
                        $print .= $car->observacao != "" ? "<strong>(Obs.:" . $car->observacao . ')</strong>' : "";
                        $print .= "<br/>";

                        $print .= "</td>";
                        $print .= "<td style=' width: 20%; text-align:right; padding-bottom: 10px;'>";
                        $print .= "<strong>{$moeda->simbolo} " . number_format(($car->valor * $car->quantidade), 2, '.', '') . "</strong>";

                        $print .= "</td>";
                        $print .= "</tr>";
                    }
                }
            }
        }
        $print .= "</table>";
        $print .= "<br/>";
        $print .= "<hr>";
        $print .= "<table style='text-align:left; margin-top:0; margin-bottom:0; border-collapse: collapse;width: 100%;'>";
        $print .= $subtotal;
        $print .= $tax;
        $print .= $total;
        $print .= "</table>";

        /* Dados Entrega */
        $print .= "<hr>";
        $print .= "<h3 style='text-align:left; margin-top:0; margin-bottom:0;'>DADOS CLIENTE</h3>";
        $print .= "<br/>";
        $print .= "<h3 style='text-align:left; margin-top:0; margin-bottom:0;'>{$cliente->nome}</h3>";
        $print .= "<strong>TELEFONE </strong>" . $this->mascTelefone($cliente->telefone);
        $print .= "<br/>";
        $print .= "<strong>ENDERE??O </strong>" . $endereco->rua . " " . $endereco->numero . " - " . $endereco->bairro;
        $print .= "<br/>";
        $print .= "<strong>COMP </strong>" . $endereco->complemento;
        $print .= "<hr>";

        /* NF PAULISTA */
        if ($nf != 0) {
            $print .= $nf;
            $print .= "<hr>";
        }

        /* Footer */
        $print .= "AGRADECEMOS A PREFER??NCIA!";
        $print .= "<br/>";
        $print .= $date;
        $print .= "<br/>";
        $print .= "Automatiza Delivery";

        //dd($print);
        $dompdf->loadHtml($print);
        //$dompdf->setPaper($papel, $orientacao); //portrait ou landscap
        $dompdf->render();
        $dompdf->stream("pedido.pdf", ["Attachment" => false]);
    }


    public function pedidoMostrarImprimir($data)
    {
        //dd($data);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $pedido = $this->acoes->getByField('carrinhoPedidos', 'id', $data['id']);
        $cliente = $this->acoes->getByField('usuarios', 'id', $pedido->id_cliente);
        $endereco = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $pedido->id_cliente);

        if ($pedido->status > 3) {
            $entrega = $this->acoes->getByField('carrinhoEntregas', 'numero_pedido', $pedido->numero_pedido);
        }

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
        $carrinho = $this->acoes->getByFieldAllTwoInt('carrinho', 'numero_pedido', $pedido->numero_pedido, 'id_empresa', $empresa->id);

        $cupomVerifica = $this->acoes->counts('cupomDesconto', 'id_empresa', $empresa->id);
        $cupomVerificaUtilizadores = $this->acoes->counts('cupomDescontoUtilizadores', 'id_empresa', $empresa->id);

        if ($cupomVerifica > 0 && $cupomVerificaUtilizadores) {
            $cupomUtilizado = $this->acoes->getByField('cupomDescontoUtilizadores', 'numero_pedido', $pedido->numero_pedido);
            if ($cupomUtilizado) {
                $cupomValida = $this->acoes->getByField('cupomDesconto', 'id', $cupomUtilizado->id_cupom);

                if ((int)$cupomValida->tipo_cupom == 1) {
                    $valor = $pedido->total;
                    $porcentagem = floatval($cupomValida->valor_cupom);
                    $resul = $valor * ($porcentagem / 100);
                    $resultado = $resul;
                } else {
                    $resultado = $cupomValida->valor_cupom;
                }
            }
        }
        //dd($resultado);

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            }
        }

        $this->load('_admin/pedidos/pedidoImprimir', [
            'moeda' => $moeda,
            'planoAtivo' => $planoAtivo,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
            'estabelecimento' => $estabelecimento[0]->id,
            'pedido' => $pedido,
            'entrega' => $entrega,
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        $tipoPagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);
        $tipoDelivery = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);

        $resultClientes = $this->acoes->getFind('usuarios');
        $resultMotoboy = $this->acoes->getByField('motoboy', 'id_empresa', $empresa->id);
        $status = $this->acoes->getFind('status');


        $count = $this->acoes->counts('carrinhoPedidos', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 30, $page);
        $resultPedidos = $this->acoes->pagination('carrinhoPedidos', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'created_at DESC');

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            }
        }
        $this->load('_admin/pedidos/pedidos', [
            'planoAtivo' => $planoAtivo,
            'paginacao' => $pager->render('mt-4 pagin'),
            'moeda' => $moeda,
            'tipoDelivery' => $tipoDelivery,
            'tipoPagamento' => $tipoPagamento,
            'status' => $status,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
            'caixaId' => $estabelecimento[0]->id,
            'pedidos' => $resultPedidos,
            'clientes' => $resultClientes,
            'motoboy' => $resultMotoboy
        ]);
    }

    public function mudarStatus($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $pedido = $this->acoes->getByField('carrinhoPedidos', 'id', $data['id']);


        $valor = (new CarrinhoPedidos())->findById($pedido->id);
        $valor->status = $data['status'];
        if ($planoAtivo > 2) {
            $valor->id_motoboy = $data['motoboy'];
        } else {
            $valor->id_motoboy = 0;
        }
        $valor->save();

        $count = $this->acoes->getByFieldTwo('carrinhoEntregas', 'numero_pedido', $pedido->numero_pedido, 'id_empresa', $data['id_empresa']);
        $entrega = $this->acoes->getByFieldTwo('carrinhoEntregas', 'numero_pedido', $pedido->numero_pedido, 'id_empresa', $data['id_empresa']);
        if ($planoAtivo > 2) {
            //dd('1');
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
                    $entregas = (new CarrinhoEntregas())->findById($entrega->id);
                    $entregas->status = $data['status'];
                    $entregas->save();
                }
            }
        } else {
            //dd('2');
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
                $entregas = (new CarrinhoEntregas())->findById($entrega->id);
                $entregas->status = $data['status'];
                $entregas->id_motoboy = 0;
                $entregas->save();
            }
        }
        echo "Status alterado com sucesso";
    }

    public function mascTelefone($telefone)
    {
        $tam = strlen(preg_replace("/[^0-9]/", "", $telefone));
        if ($tam == 13) { // COM C??DIGO DE ??REA NACIONAL E DO PAIS e 9 d??gitos
            return "+" . substr($telefone, 0, $tam - 11) . "(" . substr($telefone, $tam - 11, 2) . ")" . substr($telefone, $tam - 9, 5) . "-" . substr($telefone, -4);
        }
        if ($tam == 12) { // COM C??DIGO DE ??REA NACIONAL E DO PAIS
            return "+" . substr($telefone, 0, $tam - 10) . "(" . substr($telefone, $tam - 10, 2) . ")" . substr($telefone, $tam - 8, 4) . "-" . substr($telefone, -4);
        }
        if ($tam == 11) { // COM C??DIGO DE ??REA NACIONAL e 9 d??gitos
            return "(" . substr($telefone, 0, 2) . ")" . substr($telefone, 2, 5) . "-" . substr($telefone, 7, 11);
        }
        if ($tam == 10) { // COM C??DIGO DE ??REA NACIONAL
            return "(" . substr($telefone, 0, 2) . ")" . substr($telefone, 2, 4) . "-" . substr($telefone, 6, 10);
        }
        if ($tam <= 9) { // SEM C??DIGO DE ??REA
            return substr($telefone, 0, $tam - 4) . "-" . substr($telefone, -4);
        }
    }
    public function pedidoTestImprimir($data)
    {
        // $connector = new FilePrintConnector("php://stdout");
        // $printer   = new Printer($connector);
        // $printer->text("Hello World!\n");
        // $printer->cut();
        // $printer->close();

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $print = $this->acoes->getByField('imprimir', 'id_empresa', $empresa->id);
        //$connector = new CupsPrintConnector("{$print->code}");
        //$connector = new CupsPrintConnector("EPSON_TM_T88V");


        //dd($print);

        try {
            //$connector = new CupsPrintConnector("STMicroelectronics_POS58_Printer_USB");
            $connector = new NetworkPrintConnector("159.65.220.187", 3240);
            //$connector = new NetworkPrintConnector("159.65.220.187", 9100);
            //$connector = new FilePrintConnector("php://stdout");
            //$connector = new FilePrintConnector("/dev/ttyS0?baud=115200");

            //$connector = new FilePrintConnector("/dev/usb/lp0");

            $printer = new Printer($connector);

            /* Print some bold text */
            $printer->setEmphasis(true);
            $printer->text("FOO CORP Ltd.\n");
            $printer->setEmphasis(false);
            $printer->feed();
            $printer->text("Receipt for whatever\n");
            $printer->feed(4);

            /* Bar-code at the end */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text(">>> PEDIDO DE VENDA TESTE <<<");
            $printer->cut();
            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }

    public function pedidoImprimir($data)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $print = $this->acoes->getByField('imprimir', 'id_empresa', $empresa->id);

        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
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
        $carrinho = $this->acoes->getByFieldAll('carrinho', 'numero_pedido', $pedido->numero_pedido, 'id_empresa', $empresa->id);
        $nf = $nfPaulista->cpf != "" ? "NOTA FISCAL " . $nfPaulista->cpf : 0;


        try {
            $connector = new CupsPrintConnector("{$print->code}");
            $subtotal = 'Subtotal ' . $moeda->simbolo . ' ' . number_format($pedido->total, 2, '.', '');
            $tax = $pedido->tipo_frete == 2 ? 'Taxa de Entrega' . $pedido->valor_frete : 'Taxa de Entrega' . 'Gr??tis';

            $total = 'Total' . $moeda->simbolo . ' ' . number_format($pedido->total_pago, 2, '.', '');
            /* Date is kept the same for testing */
            // $date = date('l jS \of F Y h:i:s A');

            $date = strftime('%A, %d de %B de %Y', strtotime('today'));
            $printer = new Printer($connector);
            //$printer->selectPrintMode();
            /* Print top logo */

            // Most simple example
            $printer->setEmphasis(true);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text('');
            $printer->feed(2);
            $printer->feed(2);
            $printer->feed(2);
            $printer->feed(2);
            $printer->setEmphasis(false);

            $printer->feed(2);
            $printer->setEmphasis(true);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text(">>> PEDIDO DE VENDA <<<");
            $printer->feed(2);
            $printer->setEmphasis(false);
            $printer->text("PEDIDO #" . $pedido->numero_pedido . "\n\n");
            $printer->text("--------------------------------\n");
            $printer->setEmphasis(false);
            $printer->feed();

            /* Items */
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(false);
            $printer->text(">>> ITENS DO PEDIDO <<<\n");
            $printer->feed();
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(false);
            foreach ($carrinho as $car) {
                foreach ($produtos as $prod) {
                    if ($pedido->numero_pedido == $car->numero_pedido) {
                        if ($car->id_produto == $prod->id) {
                            $printer->text($car->quantidade . 'x - ' . $prod->nome);

                            foreach ($sabores as $s) {
                                $printer->text($s->id == $car->id_sabores ? ' | Sabor.: ' . $s->nome . ' | ' : "");
                            }

                            $printer->text(" {$moeda->simbolo} " . number_format(($car->valor * $car->quantidade), 2, '.', '') . "\n");

                            foreach ($carrinhoAdicional as $cartAd) {
                                if ($prod->id == $cartAd->id_produto) {
                                    if ($car->chave == $cartAd->chave) {
                                        foreach ($produtosAdicionais as $a) {
                                            if ($a->id == $cartAd->id_adicional) {
                                                $printer->text(" - " . $cartAd->quantidade . 'x ' . $a->nome . "\n");
                                                $printer->feed();
                                            }
                                        }
                                    }
                                }
                            }
                            $printer->text($car->observacao != "" ? "\n(Obs.:" . $car->observacao . ')' : "");
                        }
                    }
                }
            }
            $printer->feed(1);
            /* Tax and total */
            $printer->text("--------------------------------\n");
            $printer->feed(1);
            $printer->text($subtotal);
            $printer->feed();
            $printer->text($tax);
            $printer->feed();
            $printer->setEmphasis(true);
            $printer->text($total);
            $printer->setEmphasis(false);

            /* Dados Entrega */
            $printer->feed(1);
            $printer->text("--------------------------------\n");
            $printer->setEmphasis(false);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("\nDADOS CLIENTE\n");
            $printer->setEmphasis(false);

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setEmphasis(false);
            $printer->text($cliente->nome . "\n");
            $printer->text("TELEFONE " . $this->mascTelefone($cliente->telefone) . "\n");
            $printer->text($endereco->rua . " " . $endereco->numero . "\n");
            $printer->text("COMP " . $endereco->complemento . "\n");
            $printer->text($endereco->bairro . "\n");
            $printer->text("\n--------------------------------\n");
            $printer->setEmphasis(false);

            /* NF PAULISTA */
            if ($nf != 0) {
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setEmphasis(true);
                $printer->text($nf . "\n");
                $printer->setEmphasis(false);
            }

            /* Footer */
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("AGRADECEMOS A PREFER??NCIA!");
            $printer->feed();
            $printer->feed(1);
            $printer->text($empresa->nome_fantasia  . "\n");
            $printer->text("WHATSAPP " . $this->mascTelefone($empresa->telefone) . "\n");
            $printer->feed(1);
            $printer->text($date . "\n");
            $printer->text("Automatiza Delivery\n\n");
            $printer->feed(1);
            /* Cut the receipt and open the cash drawer */

            //print_r($printer);
            $printer->cut();
            $printer->pulse();

            $printer->close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
        }
    }

    public function cancelarPedido($data)
    {

        $valor = (new CarrinhoPedidos())->findById($data['id']);
        $valor->status = 6;
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Pedido cancelado com sucesso!', 'error' => 'Erro ao cancelar seu pedido']);
        exit($json);
    }
}

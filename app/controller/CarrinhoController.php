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
use app\Models\UsuariosEnderecos;
use Bcrypt\Bcrypt;
use Browser;
use Mobile_Detect;

class CarrinhoController extends Controller
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);

        //dd($funcionamento);
        $dias = $this->acoes->getFind('dias');

        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produto = $this->acoes->getByField('produtos', 'id', $data['id']);
        $resultProdutoAdicional = $this->acoes->getByFieldAll('produtoAdicional', 'id', $empresa->id);
        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $resulTipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $resultchave = md5(uniqid(rand(), true));
        $resultCarrinhoQtd = 0;
        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
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
        }

        $this->load('produto/main', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'dias' => $dias,
            'funcionamento' => $funcionamento,
            'moeda' => $moeda,
            'produto' => $produto,
            'enderecoAtivo' => $enderecoAtivo,
            'delivery' => $delivery,
            'produtoAdicional' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'chave' => $resultchave,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }

    public function insert($data)
    {
        $id_sabores = $data['sabores'][0] ? $data['sabores'][0] : null;
        $id_adicional = $data['adicional'] ? $data['adicional'] : null;

        $valor = new Carrinho();
        $valor->id_produto = $data['id_produto'];
        $valor->id_cliente = $this->sessao->getUser();
        $valor->id_empresa = $data['id_empresa'];
        $valor->quantidade = $data['quantity'];
        $valor->id_sabores = $id_sabores;
        $valor->id_adicional = $id_adicional;
        $valor->observacao = $data['observacao'];
        $valor->valor = $data['valor'];
        $valor->save();

        header('Content-Type: application/json');
        if ($valor->id_adicional != null) {
            $json = json_encode(['id' => $valor->id, 'resp' => 'insertCart', 'var' => $valor->id_adicional, 'mensagem' => 'Seu produto foi adicionado a sacola aguarde que tem mais!', 'error' => 'N??o foi poss??vel adicionar o produto a sacola! Tente novamente.', 'code' => 2,  'url' => 'produto/adicional']);
        } else {
            $json = json_encode(['id' => $valor->id, 'resp' => 'insertCart', 'mensagem' => 'Seu produto foi adicionado a Sacola!', 'error' => 'N??o foi poss??vel adicionar o produto a sacola! Tente novamente.', 'code' => 2,  'url' => 'carrinho',]);
        }
        exit($json);
    }


    public function carrinhoAdicional($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $carrinho = $this->acoes->getByField('carrinho', 'id', $data['id']);
        $produto = $this->acoes->getByField('produtos', 'id', $carrinho->id_produto);
        $resultProdutoAdicional = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $resulTipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id_empresa', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);

        $resultchave = md5(uniqid(rand(), true));
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            if ($this->sessao->getNivel() == 1) {
                redirect(BASE . "{$empresa->link_site}/motoboy");
            }

            if ($this->sessao->getNivel() == 0) {
                redirect(BASE . "{$empresa->link_site}/admin");
            }
        }
        $this->load('produto/adicional', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'moeda' => $moeda,
            'delivery' => $delivery,
            'produto' => $produto,
            'carrinho' => $carrinho,
            'enderecoAtivo' => $enderecoAtivo,
            'produtoAdicional' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }

    public function insertUpdateProdutoAdicional($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $id_cliente = $this->sessao->getUser() ? $this->sessao->getUser() : 0;
        if ($data['quantidade'] > 0) {
            $verificaCadastro = $this->acoes->countsTree('carrinhoAdicional', 'id_carrinho', $data['id_carrinho'], 'id_adicional', $data['id_adicional'], 'id_produto', $data['id_produto']);
            if ($verificaCadastro == 0) {
                $valor = new CarrinhoAdicional();
                $valor->id_carrinho = $data['id_carrinho'];
                $valor->id_cliente = $id_cliente;
                $valor->id_produto = $data['id_produto'];
                $valor->id_adicional = $data['id_adicional'];
                $valor->valor = $data['valor'];
                $valor->quantidade = $data['quantidade'];
                $valor->id_empresa = $empresa->id;
                $valor->save();
            } else {
                $carrinhoAdicional = $this->acoes->getByFieldTree('carrinhoAdicional', 'id_carrinho', $data['id_carrinho'], 'id_adicional', $data['id_adicional'], 'id_produto', $data['id_produto']);
                $valor = (new CarrinhoAdicional())->findById($carrinhoAdicional->id);
                $valor->valor = $data['valor'];
                $valor->quantidade = $data['quantidade'];
                $valor->save();
            }
            echo 'Adicional Cadastrado!';
        } else {

            $carrinhoAdicional = $this->acoes->getByFieldTree('carrinhoAdicional', 'id_carrinho', $data['id_carrinho'], 'id_adicional', $data['id_adicional'], 'id_produto', $data['id_produto']);
            $valor = (new CarrinhoAdicional())->findById($carrinhoAdicional->id);
            $valor->destroy();

            echo 'Adicional Deletado!';
        }
    }


    //  PAGINA - Produto { EDITAR }
    public function carrinhoProdutoEditar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $produto = $this->acoes->getByField('produtos', 'id', $data['id_produto']);
        $carrinho = $this->acoes->getByFieldTwo('carrinho', 'id_produto', $data['id_produto'], 'id', $data['id_carrinho']);

        $resultProdutoAdicional = $this->acoes->getByFieldAll('produtoAdicional', 'id', $empresa->id);
        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $resulTipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $resultchave = md5(uniqid(rand(), true));
        $resultCarrinhoQtd = 0;
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            if ($this->sessao->getNivel() == 1) {
                redirect(BASE . "{$empresa->link_site}/motoboy");
            }

            if ($this->sessao->getNivel() == 0) {
                redirect(BASE . "{$empresa->link_site}/admin");
            }
        }

        $this->load('produto/editar', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'moeda' => $moeda,
            'carrinho' => $carrinho,
            'produto' => $produto,
            'delivery' => $delivery,
            'enderecoAtivo' => $enderecoAtivo,
            'produtoAdicional' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'produtoSabores' => $resultSabores,
            'chave' => $resultchave,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }


    public function carrinho($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if (!$this->sessao->getUser()) {
            redirect(BASE . "{$empresa->link_site}/");
        }
        $verificaEnd = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');

        if (!$verificaEnd) {
            redirect(BASE . "{$empresa->link_site}/endereco/novo/cadastro");
        }

        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);


        $usu = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $this->sessao->getUser(), 'id_empresa', $empresa->id);

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            if ($this->sessao->getNivel() == 1) {
                redirect(BASE . "{$empresa->link_site}/motoboy");
            }

            if ($this->sessao->getNivel() == 0) {
                redirect(BASE . "{$empresa->link_site}/admin");
            }

            $carrinho = $this->acoes->getByFieldTreeNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'numero_pedido', 'null');
            $usuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $endereco = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);

            $estados = $this->acoes->getFind('estados');
            $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
            $carrinhoAdicional = $this->acoes->getByFieldAll('carrinhoAdicional', 'id_cliente', $this->sessao->getUser());
            $produtos = $this->acoes->getByFieldAll('produtos', 'id_empresa', $empresa->id);

            $adicionais = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
            $sabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
            $tipo = $this->acoes->getByFieldAll('tipoDelivery', 'id_empresa', $empresa->id);
            $pagamento = $this->acoes->getByFieldAll('formasPagamento', 'id_empresa', $empresa->id);

            $resultSoma = $this->acoes->sumFielsTreeNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
            $resultSomaAdicional = $this->acoes->sumFielsTreeNull('carrinhoAdicional', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
            $resultVendasFeitas = $this->acoes->countsTwo('carrinhoPedidos', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            $valorCarrinho = ((float) $resultSoma->total + (float) $resultSomaAdicional->total);

            if (!$endereco->bairro) {
                $geo = array();
                $addr = str_replace(" ", "+", $endereco->rua . ' ' . $endereco->numero . ', ' . $empresaEndereco->cidade . ' - ' . $empresaEndereco->estado);
                $address = utf8_encode($addr);

                $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=AIzaSyAxhvl-7RHUThhX4dNvCGEkPuOoT6qbuDQ');
                $output = json_decode($geocode);

                foreach ($output->results[0]->address_components as $component) {
                    $componentType = $component->types[0];
                    switch ($componentType) {
                        case "route": {
                                $rua = $component->long_name;
                                break;
                            }
                        case "postal_code": {
                                $cep = $component->long_name;
                                break;
                            }
                        case "administrative_area_level_2": {
                                $cidade = $component->long_name;
                                break;
                            }
                        case "administrative_area_level_1": {
                                $estado = $component->short_name;
                                break;
                            }
                        case "sublocality":
                            $bairro = $component->short_name;
                            break;
                        case "political":
                            $bairro = $component->short_name;
                            break;
                        case "sublocality_level_1":
                            $bairro = $component->short_name;
                            break;
                    }
                }

                $novo = (new UsuariosEnderecos())->findById($endereco->id);;
                $novo->rua = $rua;
                $novo->bairro = $bairro;
                $novo->cidade = $cidade;
                $novo->estado = $estado;
                $novo->cep = $cep;
                $novo->save();

                if ($novo->id > 0) {
                    redirect(BASE . "{$empresa->link_site}/carrinho");
                }
            }

            $cFrete = $this->calculoFrete->calculo($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);
            $infoKm = $this->calculoFrete->infoKm($endereco->rua, $endereco->numero, $endereco->bairro, $endereco->cep, $empresa->id);

            //dd($cFrete);
            
            $termo = 'km';
            $pattern = '/' . $termo . '/';
            if (preg_match($pattern, $infoKm)) {
                $cFrete = $cFrete;
            } else {
                $cFrete = 1;
            }

            
            
            $taxa_entrega = $delivery->taxa_entrega;
            $km_entrega = $delivery->km_entrega;

            // $taxa_entrega2 = $delivery->taxa_entrega2;
            // $km_entrega2 = $delivery->km_entrega2;

            // $taxa_entrega3 = $delivery->taxa_entrega3;
            // $km_entrega3 = $delivery->km_entrega3;

            $km_entrega_excedente = $delivery->km_entrega_excedente;
            $valor_excedente = $delivery->valor_excedente;

            
            //dd(round($cFrete));
            if ($cFrete <= $km_entrega) {
                //dd($km_entrega);
                $total = $taxa_entrega;

                
            }

            if ($cFrete > $km_entrega && $cFrete <= $km_entrega_excedente) {
                $kmACalcular = (ceil($cFrete) - $delivery->km_entrega);
                $freteVezes = ($kmACalcular * $valor_excedente);
                $taxa_entregaNova = $taxa_entrega + $freteVezes;
                $total = $taxa_entregaNova;
            }

            // if ($cFrete <= $km_entrega_excedente) {
                

            //     // $kmACalcular = ((int)$cFrete - $delivery->km_entrega);
            //     // $freteVezes = ($kmACalcular * $valor_excedente);
            //     // $taxa_entregaNova = $taxa_entrega + $freteVezes;
            //     // $total = $taxa_entregaNova;

                
            // }
            if ($delivery->km_entrega_excedente != 0) {
                $deliveryEntregaExcedente = $delivery->km_entrega_excedente;
            }

            // if ($km_entrega2 != 0.00) {
            //     if ($cFrete > $km_entrega && $cFrete <= $km_entrega2) {
            //         $total = $taxa_entrega2;
            //     }

            //     if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega_excedente) {
            //         $kmACalcular = ((int)$cFrete - $delivery->km_entrega2);
            //         $freteVezes = ($kmACalcular * $valor_excedente);
            //         $taxa_entregaNova = $taxa_entrega2 + $freteVezes;
            //         $total = $taxa_entregaNova;

            //         //dd($total);
            //     }

            //     if ($delivery->km_entrega_excedente == 0) {
            //         $deliveryEntregaExcedente = $delivery->km_entrega2;
            //     }
            // }

            // if ($km_entrega3 != 0.00) {
            //     if ($cFrete > $km_entrega2 && $cFrete <= $km_entrega3) {
            //         $total = $taxa_entrega3;
            //     }

            //     if ($cFrete > $km_entrega3 && $cFrete <= $km_entrega_excedente) {
            //         $kmACalcular = ((int)$cFrete - $delivery->km_entrega3);
            //         $freteVezes = ($kmACalcular * $valor_excedente);
            //         $taxa_entregaNova = $taxa_entrega3 + $freteVezes;
            //         $total = $taxa_entregaNova;
            //     }

            //     if ($delivery->km_entrega_excedente == 0) {
            //         $deliveryEntregaExcedente = $delivery->km_entrega3;
            //     }
            // }

            if ($delivery->frete_status == 1) {
                if ($delivery->valor <= $valorCarrinho) {
                    $total = 0;
                }
            }

            if ($delivery->primeira_compra == 1) {
                if ($resultVendasFeitas == 0) {
                    $total = 0;
                }
            }
            //dd($total);

            $this->sessao->sessaoNew('numeroPedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));
            $cupomVerifica = $this->acoes->countsTwoNull('cupomDescontoUtilizadores', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);

            if ($cupomVerifica > 0) {
                $cupomUtilizacoesId = $this->acoes->getByField('cupomDescontoUtilizadores', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id,);
                $cupomValida = $this->acoes->getByField('cupomDesconto', 'id', $cupomUtilizacoesId->id_cupom);

                if ((int)$cupomValida->tipo_cupom == 1) {
                    $valor = $valorCarrinho;
                    $porcentagem = floatval($cupomValida->valor_cupom);
                    $resul = $valor * ($porcentagem / 100);
                    $resultado = $resul;
                } else {
                    $resultado = $cupomValida->valor_cupom;
                }
                $valorCarrinho = $valorCarrinho - $resultado;
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/carrinho/dados");
        }
        $resultchave = md5(uniqid(rand(), true));

        $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);

        if ($resultCarrinhoQtd == 0) {
            redirect(BASE . "{$empresa->link_site}");
        }


//dd($total);

        $this->load('_cliente/carrinho/main', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'moeda' => $moeda,
            'usuario' => $usuario,
            'endereco' => $endereco,
            'estados' => $estados,
            'delivery' => $delivery,
            'enderecoAtivo' => $enderecoAtivo,
            'deliveryEntregaExcedente' => $deliveryEntregaExcedente,
            'carrinho' => $carrinho,
            'carrinhoAdicional' => $carrinhoAdicional,
            'produtos' => $produtos,
            'adicionais' => $adicionais,
            'sabores' => $sabores,
            'tipo' => $tipo,
            'pagamento' => $pagamento,
            'km' => $cFrete,
            'empresaEndereco' => $empresaEndereco,
            'numero_pedido' => $this->sessao->getSessao('numeroPedido'),
            'valorPedido' => $valorCarrinho,
            'calculoFrete' => $total,
            'cupomVerifica' => $cupomVerifica,
            'chave' => $resultchave,
            'cupomValor' => $resultado,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }


    public function carrinhoValidaCupom($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $cupomValidaCount = $this->acoes->getByField('cupomDesconto', 'nome_cupom', $data['cupomDesconto'], 'id_empresa', $empresa->id);

        //$cupomValidaCount = $this->acoes->countsTwo('cupomDesconto', 'id_empresa', $empresa->id, 'nome_cupom', $data['cupomDesconto']);

        if (!isset($cupomValidaCount->id)) {
            echo 'Cupom de desconto inv??lido';
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'apply', 'mensagem' => 'Cupom de desconto inv??lido']);
            exit($json);
        } else {
            //Verifica se pode utilizar esse cupom novamente
            $cupomValida = $this->acoes->getByField('cupomDesconto', 'nome_cupom', $data['cupomDesconto'], 'id_empresa', $empresa->id);
            $cupomValidaCliente = $this->acoes->getByFieldTree('cupomDescontoUtilizadores', 'id_cupom', $cupomValida->id, 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser());
            if ($cupomValidaCliente) {
                $cupomValidaUtil = $this->acoes->countsTree('cupomDescontoUtilizadores', 'id_cupom', $cupomValida->id, 'id_empresa', $empresa->id, 'id_cliente', $this->sessao->getUser());
                if ($cupomValidaUtil != 0) {
                    if ($cupomValidaCliente->id_cliente == $this->sessao->getUser()) {
                        //dd($cupomValidaUtil);
                        if ($cupomValidaUtil == $cupomValida->qtd_utilizacoes) {
                            header('Content-Type: application/json');
                            $json = json_encode(['id' => 0, 'resp' => 'apply', 'mensagem' => 'Voc?? excedeu o n??mero de vezes para utiliza????o deste Cupom']);
                            exit($json);
                            exit;
                        }
                    }
                }
            }


            $resultSoma = $this->acoes->sumFielsTreeNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');
            $resultSomaAdicional = $this->acoes->sumFielsTreeNull('carrinhoAdicional', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id, 'numero_pedido', 'null', 'valor * quantidade');


            $valorCarrinho = ((float) $resultSoma->total + (float) $resultSomaAdicional->total);

            if ((int)$cupomValida->tipo_cupom == 1) {
                $valor = $valorCarrinho;
                $porcentagem = floatval($cupomValida->valor_cupom);
                $resul = $valor * ($porcentagem / 100);
                $resultado = $resul;
            } else {
                $resultado = $cupomValida->valor_cupom;
            }

            $valor = new CupomDescontoUtilizadores();
            $valor->id_cupom = $cupomValida->id;
            $valor->id_cliente = $this->sessao->getUser();
            $valor->numero_pedido = $this->sessao->getSessao('numeroPedido');
            $valor->id_empresa = $empresa->id;
            $valor->save();

            header('Content-Type: application/json');
            $json = json_encode(['id' => $resultado, 'resp' => 'apply', 'mensagem' => 'Cupom Aplicado com sucesso']);
            exit($json);
        }
    }


    public function carrinhoCadastro($data)
    {
        // dd($_SESSION);
        // dd($this->sessao->getSessao('carrinho'));
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }
        $this->load('_cliente/carrinho/cadastro', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }

    public function carrinhoCadastroValida($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $getTelefone = $this->acoes->getByField('usuarios', 'telefone', preg_replace('/[^0-9]/', '', $data['telefone']));

        if ($getTelefone) {
            $getUsuario = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_empresa', $empresa->id, 'id_usuario', $getTelefone->id);
            if (!$getUsuario) {
                //dd($getUsuario);
                $valorEmp = new UsuariosEmpresa();
                $valorEmp->id_usuario = $getTelefone->id;
                $valorEmp->id_empresa = $empresa->id;
                $valorEmp->nivel = $getTelefone->nivel;
                $valorEmp->pedidos = 0;
                $valorEmp->save();
            }

            $this->sessao->sessaoNew('codeValida', substr(number_format(time() * Rand(), 0, '', ''), 0, 4));
            $codeValida = $this->sessao->getSessao('codeValida');
            $mensagem = $empresa->nome_fantasia . ": seu codigo de autorizacao e " . $codeValida . ". Por seguranca, nao o compartilhe com mais ninguem";
            $numeroTelefone = preg_replace('/[^0-9]/', '', $data['telefone']);
            $ddi = '+55';
            $numerofinal = $ddi . $numeroTelefone;

            // $client = new Client(TWILIO['account_sid'], TWILIO['auth_token']);
            // $client->messages->create($numerofinal, array('from' => TWILIO['number'], 'body' => $mensagem));

            // header('Content-Type: application/json');
            // $json = json_encode(['id' => 1, 'resp' => 'send', 'mensagem' => 'Enviamos em seu celular um c??digo para validar seu acesso!', 'url' => "valida/acesso/code/{$getTelefone->id}"]);
            // exit($json);

            $endCliente = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $getTelefone->id);

            $telNumero = substr($data['telefone'], -4);

            header('Content-Type: application/json');
            $json = json_encode(['id' => 1, 'resp' => 'send', 'mensagem' => "N??mero Validado!", 'duomensagem' => "<p>Confirme os dados para continuar</p><ul><li><strong>Nome:</strong> {$getTelefone->nome}</li><li class='number'><strong>Telefone final</strong>(**) **** - *{$telNumero}</li> <li class='ends'><strong>Endere??o:</strong> {$endCliente->rua} **** - {$endCliente->bairro}</li></ul>", 'code' => 2,  'url' => "user/valida/acesso/{$getTelefone->id}/up"]);
            exit($json);

            $usuario = $this->acoes->getByField('usuarios', 'telefone', $data['telefone']);
        } else {
            $getSenha = preg_replace('/[^0-9]/', '', $data['telefone']);
            $senha = $this->bcrypt->encrypt($getSenha, '2a');

            $hash =  md5(uniqid(rand(), true));
            $email = $hash . 'ath@automatizadelivery.com.br';

            $valor = new Usuarios();
            $valor->nome = $data['nome'];
            $valor->email = $email;
            $valor->telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
            $valor->senha = $senha;
            $valor->nivel = 3;
            $valor->save();

            $valoEmp = new UsuariosEmpresa();
            $valoEmp->id_usuario = $valor->id;
            $valoEmp->id_empresa = $empresa->id;
            $valoEmp->pedidos = 0;
            $valoEmp->nivel = 3;
            $valoEmp->save();


            $usuario = $this->acoes->getByField('usuarios', 'id', $valor->id);
            $carrinhoSessao = $this->sessao->getSessao('carrinho');

            $this->sessao->sessaoNew('carrinho', $carrinhoSessao);
            $this->sessao->sessaoNew('id_usuario', $usuario->id);
            $this->sessao->sessaoNew('usuario', $usuario->email);
            $this->sessao->sessaoNew('nivel', $usuario->nivel);

            //$this->sessao->add($usuario->id, $usuario->email, $usuario->nivel);

            $cart = (new Carrinho())->findById($this->sessao->getSessao('carrinho'));
            $cart->id_cliente = $usuario->id;
            $cart->save();

            $cartAdicional = $this->acoes->counts('carrinhoAdicional', 'id_carrinho', $this->sessao->getSessao('carrinho'));
            if ($cartAdicional > 0) {
                $cartAdicional = $this->acoes->getByFieldAllLoop('carrinhoAdicional', 'id_carrinho', $this->sessao->getSessao('carrinho'), 'id_empresa', $empresa->id);
                foreach ($cartAdicional as $res) {
                    $resAdd = (new CarrinhoAdicional())->findById($res->id);
                    $resAdd->id_cliente = $usuario->id;
                    $resAdd->save();
                }
            }

            header('Content-Type: application/json');
            $json = json_encode(['id' => $cart->id, 'resp' => 'insert', 'mensagem' => 'Legal, agora preciso que me informe os dados para entrega!', 'code' => 2,  'url' => 'endereco/novo/cadastro']);
            exit($json);
        }
    }

    public function validaAcessoPage($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $usuario = $this->acoes->getByField('usuarios', 'id', $data['id']);
        $isLogin = $this->sessao->getUser() ? redirect(BASE . "{$empresa->link_site}") : null;

        $this->load('_cliente/carrinho/validaAcesso', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'usuario' => $usuario,
            'trans' => $this->trans,
            'isLogin' => $isLogin,
            'detect' => new Mobile_Detect()
        ]);
    }

    public function usuarioValidaAcessoCode($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $codeValida = $this->sessao->getSessao('codeValida');
        if ($codeValida == $data['codeValida']) {
            $usuario = $this->acoes->getByField('usuarios', 'id', $data['id']);

            $valor = (new Carrinho())->findById($this->sessao->getSessao('carrinho'));
            $valor->id_cliente = $usuario->id;
            $valor->save();

            $cartAdicional = $this->acoes->counts('carrinhoAdicional', 'id_carrinho', $this->sessao->getSessao('carrinho'));
            if ($cartAdicional > 0) {
                $cartAdicional = $this->acoes->getByField('carrinhoAdicional', 'id_carrinho', $this->sessao->getSessao('carrinho'));
                $adicional = (new CarrinhoAdicional())->findById($cartAdicional->id);
                $adicional->id_cliente = $usuario->id;
                $adicional->save();
            }
            $this->sessao->add($usuario->id, $usuario->email, $usuario->nivel);

            if ($this->sessao->getUser()) {
                header('Content-Type: application/json');
                $json = json_encode(['id' => 1, 'resp' => 'insert', 'mensagem' => 'OK Vai para os carrinho', 'code' => 2,  'url' => 'carrinho']);
                exit($json);
            }
        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'error' => 'C??digo inv??lido! Verifique se digitou corretamente', 'url' => '']);
            exit($json);
        }
    }

    public function carrinhoValidaAcessoCode($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $codeValida = $this->sessao->getSessao('codeValida');
        if ($codeValida == $data['codeValida']) {
            $usuario = $this->acoes->getByField('usuarios', 'telefone', $data['telefone']);


            if ($this->sessao->getUser()) {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $valor = (new Carrinho())->findById($this->sessao->getSessao('carrinho'));
                $valor->id_cliente = $usuario->id;
                $valor->save();

                $cartAdicional = $this->acoes->counts('carrinhoAdicional', 'id_carrinho', $this->sessao->getSessao('carrinho'));
                if ($cartAdicional > 0) {
                    $cartAdicional = $this->acoes->getByField('carrinhoAdicional', 'id_carrinho', $this->sessao->getSessao('carrinho'));
                    $adicional = (new CarrinhoAdicional())->findById($cartAdicional->id);
                    $adicional->id_cliente = $usuario->id;
                    $adicional->save();
                }
                $getTelefone = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $this->sessao->getUser(), 'id_empresa', $empresa->id);
                if (!$getTelefone) {
                    $valorEmp = new UsuariosEmpresa();
                    $valorEmp->id_usuario = $usuario->id;
                    $valorEmp->id_empresa = $empresa->id;
                    $valorEmp->pedidos = 0;
                    $valorEmp->nivel = 3;
                    $valorEmp->save();
                }
                $this->sessao->add($usuario->id, $usuario->email, $usuario->nivel);
                header('Content-Type: application/json');
                $json = json_encode(['id' => $usuario->id, 'resp' => 'insert', 'mensagem' => 'OK Vai para o carrinho', 'code' => 2,  'url' => 'carrinho']);
                exit($json);
            }
        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'error' => 'C??digo inv??lido! Verifique se digitou corretamente', 'url' => '']);
            exit($json);
        }
    }


    public function carrinhoCheckoutAdicionalUpdate($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $resultDelivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $resultCarrinho = $this->acoes->getByField('carrinho', 'id', $data['id']);
        $produto = $this->acoes->getByField('produtos', 'id', $resultCarrinho->id_produto);
        $resultProdutoAdicionalCart = $this->acoes->getByFieldAll('carrinhoAdicional', 'id_carrinho', $data['id'], 'id_empresa', $empresa->id);


        $resultCarrinhoQtd = 0;
        $somaAdicional = $this->acoes->sumFielsTree('carrinhoAdicional', 'id_carrinho', $data['id'], 'id_produto', $produto->id, 'id_empresa', $empresa->id, 'quantidade * valor');
        $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);

        $resultProdutoAdicional = $this->acoes->getByFieldAll('produtoAdicional', 'id_empresa', $empresa->id);
        $resultSabores = $this->acoes->getByFieldAll('produtoSabor', 'id_empresa', $empresa->id);
        $resulTipoAdicional = $this->acoes->getByFieldAll('categoriaTipoAdicional', 'id', $empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }

        $this->load('produto/adicionalEditar', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'moeda' => $moeda,
            'delivery' => $resultDelivery,
            'produto' => $produto,
            'enderecoAtivo' => $enderecoAtivo,
            'produtoAdicional' => $resultProdutoAdicional,
            'tipoAdicional' => $resulTipoAdicional,
            'produtoAdicionalCart' => $resultProdutoAdicionalCart,
            'produtoSabores' => $resultSabores,
            'somaAdicional' => $somaAdicional,
            'carrinho' => $resultCarrinho,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }


    public function carrinhoProdutoAcao($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $resultProduto = $this->acoes->getByField('produtos', 'id', $data['id_produto']);
            $resultCarrinho = $this->acoes->getByFieldTwo('carrinho', 'id', $data['id_carrinho'], 'id_produto', $data['id_produto']);

            if ($resultCarrinho->id_sabores != null) {
                $resultSabores = $this->acoes->getByField('produtoSabor', 'id', $resultCarrinho->id_sabores);

                echo $resultProduto->nome . ' - ' . $resultSabores->nome;
            } else {
                echo $resultProduto->nome;
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/login");
        }
    }
    public function deletarProdutoCarrinho($data)
    {
        $resultProduto = $this->acoes->getByFieldAll('carrinhoAdicional', 'id_carrinho', $data['id_carrinho']);

        $valor = (new Carrinho())->findById($data['id_carrinho']);
        $valor->destroy();

        if ($resultProduto) {
            foreach ($resultProduto as $res) {
                $valorAd = (new CarrinhoAdicional())->findById($res->id);
                $valorAd->destroy();
            }
            redirect(BASE . "{$data['linkSite']}/carrinho");
        }
        redirect(BASE . "{$data['linkSite']}/carrinho");
    }

    public function carrinhoCheckoutUpdate($data)
    {
        $valor = (new Carrinho())->findById($data['id_carrinho']);
        $valor->quantidade = $data['quantity'];
        $valor->observacao = $data['observacao'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Seu produto foi adicionado a sacola aguarde que tem mais!', 'code' => 2,  'url' => 'produto/adicional/atualiza']);
        exit($json);
    }

    public function carrinhoCheckoutFinal($data)
    {
        $carrinho = $this->acoes->getByFieldAllTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $data['id_empresa']);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $data['id_empresa'], 1, 'id', 'DESC');
        $user = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $this->sessao->getUser(), 'id_empresa', $data['id_empresa']);
        if (!$user) {
            $userNovo = new UsuariosEmpresa();
            $userNovo->id_usuario = $this->sessao->getUser();
            $userNovo->id_empresa = $data['id_empresa'];
            $userNovo->nivel = $this->sessao->getNivel();
            $userNovo->pedidos = 0;
            $userNovo->save();
        }
        $user = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $this->sessao->getUser(), 'id_empresa', $data['id_empresa']);
        if ($carrinho) {
            foreach ($carrinho as $cart) {
                $cartAdicional = (new Carrinho())->findById($cart->id);
                $cartAdicional->numero_pedido = $data['numero_pedido'];
                $cartAdicional->save();
            }
        }

        $carrinhoAdicional = $this->acoes->getByFieldAllTwoNull('carrinhoAdicional', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $data['id_empresa']);

        if ($carrinhoAdicional) {
            foreach ($carrinhoAdicional as $cartAdic) {
                $cartAdicional = (new CarrinhoAdicional())->findById($cartAdic->id);
                $cartAdicional->numero_pedido = $data['numero_pedido'];
                $cartAdicional->save();
            }
        }

        if ($data['cpf'] != null) {
            $cpf = new CarrinhoCPFNota();
            $cpf->id_cliente = $this->sessao->getUser();
            $cpf->id_empresa = $data['id_empresa'];
            $cpf->numero_pedido = $data['numero_pedido'];
            $cpf->cpf = $data['cpf'];
            $cpf->save();
        }


        $pagamento = $data['tipo_pagamento'] == 7 ? $data['dinheiro'] : 0;

        if ($data['tipo_pagamento'] == 7) {
            $pagamento = $data['dinheiro'];
            $pagamentoCart??o = $data['dinheiro'] - $data['total_pago'];
        } else {
            $pagamentoCart??o = $data['total_pago'];
        }


        $cpp = new CarrinhoPedidoPagamento();
        $cpp->pag_dinheiro = $pagamento;
        $cpp->pag_cartao = $pagamentoCart??o;
        $cpp->id_cliente = $this->sessao->getUser();
        $cpp->id_tipo_pagamento = $data['tipo_pagamento'];
        $cpp->numero_pedido = $data['numero_pedido'];
        $cpp->id_empresa = $data['id_empresa'];
        $cpp->save();


        $pedido = new CarrinhoPedidos();
        $pedido->id_caixa = $estabelecimento[0]->id;
        $pedido->id_cliente = $this->sessao->getUser();
        $pedido->id_empresa = $data['id_empresa'];
        $pedido->total = $data['total'];
        $pedido->total_pago = $data['total_pago'];
        $pedido->troco = $data['troco'];
        $pedido->tipo_pagamento = $data['tipo_pagamento'];
        $pedido->tipo_frete = $data['tipo_frete'];
        $pedido->data_pedido = date('Y-m-d');
        $pedido->hora = date('H:i:s');
        $pedido->status = 1;
        $pedido->pago = 0;
        $pedido->observacao = $data['observacao'];
        $pedido->numero_pedido = $data['numero_pedido'];
        $pedido->valor_frete = $data['valor_frete'];
        $pedido->km = $data['km'];
        $pedido->chave = $data['chave'];
        $pedido->save();

        if ($pedido->id > 0) {
            $userUp = (new UsuariosEmpresa())->findById($user->id);
            $userUp->pedidos = $user->pedidos == null ? 1 : $user->pedidos + 1;
            $userUp->save();
        } else {
            dd($pedido);
        }

        header('Content-Type: application/json');
        $json = json_encode(['id' => $pedido->id, 'resp' => 'insert', 'mensagem' => 'Pedido finalizado com sucesso', 'code' => 2,  'url' => 'admin/pedidos']);
        exit($json);
    }
}

<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Preferencias;
use app\classes\Estados;
use app\classes\Dispositivo;
use app\core\Controller;
use app\controller\AllController;
use Aura\Session\SessionFactory;
use app\Models\AdminCategoriaModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;
use app\Models\AdminConfigFreteModel;
use app\Models\AdminPagamentoModel;
use app\Models\AdminProdutoAdicionalModel;
use app\Models\AdminProdutoModel;
use app\Models\AdminUsuarioModel;
use app\Models\ContatoModel;
use app\Models\DiasModel;
use app\Models\EnderecosModel;
use app\Models\EstadosModel;
use app\Models\MoedaModel;
use app\Models\VendasModel;
use app\Models\CarrinhoModel;
use app\Models\FavoritosModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use MordiSacks\LocalStorage\LocalStorage;

use Browser;

class PagesController extends Controller
{
    //Instancia da Classe AdminConfigEmpresaModel
    private $configEmpresaModel;
    private $deliveryModel;
    private $moedaModel;
    private $categoriaModel;
    private $produtoModel;
    private $diasModel;
    private $usuarioModel;
    private $enderecosModel;
    private $estadosModel;
    private $contatoModel;
    private $produtoAdicionalModel;
    private $carrinhoModel;
    private $vendasModel;
    private $favoritoModel;
    private $allController;
    private $formPagModel;
    private $sessionFactory;
    private $estados;
    private $preferencias;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->preferencias = new Preferencias();
        $this->allController = new AllController();
        $this->sessionFactory = new SessionFactory();
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
        $this->moedaModel = new MoedaModel();
        $this->deliveryModel = new AdminConfigFreteModel();
        $this->formPagModel = new AdminPagamentoModel();
        $this->estados = new Estados();
        $this->dispositivo = new Dispositivo();
        $this->categoriaModel = new AdminCategoriaModel();
        $this->produtoModel = new AdminProdutoModel();
        $this->produtoAdicionalModel = new AdminProdutoAdicionalModel();
        $this->diasModel = new DiasModel();
        $this->usuarioModel = new AdminUsuarioModel();
        $this->enderecosModel = new EnderecosModel();
        $this->estadosModel = new EstadosModel();
        $this->vendasModel = new VendasModel();
        $this->contatoModel = new ContatoModel();
        $this->carrinhoModel = new CarrinhoModel();
        $this->favoritoModel = new FavoritosModel();
    }

    public function index($data)
    {
        
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        // if (!$this->dispositivo->tipo()){
        //     redirect(BASE.'acesso-computador');
        // }
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $segment->set('numero_pedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));

        $SessionIdUsuario = $segment->get('id_usuario');

        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);

        $resultMoeda = $this->moedaModel->getById($empresaAct[':moeda']);

        $resultDias = $this->diasModel->getAll();
        $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultProdutosTop5 = $this->produtoModel->getTop3($empresaAct[':id']);

        $resultUsuario = $this->usuarioModel->getAll();
        $resultEnderecos = $this->enderecosModel->getAll();
        $resultEstados = $this->estadosModel->getAll();

        $resultProdutoQtd = $this->produtoModel->produtoQtd();

        if (isset($SessionIdUsuario)) {
            $verificaLogin = $this->allController->verificaPrimeiroAcesso($empresaAct[':id']);
            $resultFavoritos = $this->favoritoModel->getAllCli($SessionIdUsuario);
            $resultverifyFavoritos = $this->favoritoModel->verifyFavoritoUsuario($SessionIdUsuario,$empresaAct[':id']);
            $resultVendas = $this->vendasModel->getAllUser($SessionIdUsuario);
            $resultUltimaVenda = $this->vendasModel->getLast($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        }
        //dd($resultProdutoQtd);

        if ($resultProdutoQtd == 0) {
            redirect(BASE . $empresaAct[':link_site'] . 'novo-por-aqui');
        }

        $hoje = date('w', strtotime(date('Y-m-d')));

        if ($hoje == 0) {
            $hoje = 7;
        }
        $c = new \CoffeeCode\Cropper\Cropper(UPLOADS_BASE."cache");

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('home/main', [
            'crop' => $c,
            'empresa' => $empresaAct,
            'moeda' => $resultMoeda,
            'delivery' => $resultDelivery,
            'categoria' => $resultCategoria,
            'produto' => $resultProdutos,
            'produtoTop5' => $resultProdutosTop5,
            'dias' => $resultDias,
            'usuario' => $resultUsuario,
            'enderecos' => $resultEnderecos,
            'estados' => $resultEstados,
            'vendas' => $resultVendas,
            'ultimaVenda' => $resultUltimaVenda,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'veriFavoritos' => $resultverifyFavoritos,
            'favoritos' => $resultFavoritos,
            'produtoQtd' => $resultProdutoQtd,
            'sessaoLogin' =>  $SessionIdUsuario,
            'hoje' =>  $hoje,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function home($data)
    {
        $empresaAct = $this->configEmpresaModel->getAll();
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $segment->set('numero_pedido', substr(number_format(time() * Rand(), 0, '', ''), 0, 6));

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $empresas = $this->configEmpresaModel->getAll();
        // $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        // $resultMoeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        // $resultDias = $this->diasModel->getAll();
        // $resultCategoria = $this->categoriaModel->getAllPorEmpresa($empresaAct[':id']);
        // $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        // $resultProdutosTop5 = $this->produtoModel->getTop3($empresaAct[':id']);

        // $resultEnderecos = $this->enderecosModel->getAll();
        // $resultEstados = $this->estadosModel->getAll();
        
        // $resultProdutoQtd = $this->produtoModel->produtoQtd();
        
        
        
        if (isset($SessionIdUsuario)) {
            $resultUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            //$verificaLogin = $this->allController->verificaPrimeiroAcesso($empresaAct[':id']);
            //$resultFavoritos = $this->favoritoModel->getAllCli($SessionIdUsuario);
            //$resultverifyFavoritos = $this->favoritoModel->verifyFavoritoUsuario($SessionIdUsuario,$empresaAct[':id']);
            //$resultVendas = $this->vendasModel->getAllUser($SessionIdUsuario);
            //$resultUltimaVenda = $this->vendasModel->getLast($SessionIdUsuario);
            //$resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        }

        // if ($resultProdutoQtd == 0) {
        //     redirect(BASE . $empresaAct[':link_site'] . 'novo-por-aqui');
        // }

        // $hoje = date('w', strtotime(date('Y-m-d')));

        // if ($hoje == 0) {
        //     $hoje = 7;
        // }
        $c = new \CoffeeCode\Cropper\Cropper(UPLOADS_BASE."cache");
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('home/home', [
            'empresas' => $empresas,
            'crop' => $c,
            // 'moeda' => $resultMoeda,
            // 'delivery' => $resultDelivery,
            // 'categoria' => $resultCategoria,
            // 'produto' => $resultProdutos,
            // 'produtoTop5' => $resultProdutosTop5,
            // 'dias' => $resultDias,
            // 'enderecos' => $resultEnderecos,
            // 'estados' => $resultEstados,
            // 'vendas' => $resultVendas,
            // 'ultimaVenda' => $resultUltimaVenda,
            // 'carrinhoQtd' => $resultCarrinhoQtd,
            // 'veriFavoritos' => $resultverifyFavoritos,
            // 'favoritos' => $resultFavoritos,
            // 'produtoQtd' => $resultProdutoQtd,
            'sessaoLogin' =>  $SessionIdUsuario,
            'usuario' =>  $resultUsuario,
            // 'hoje' =>  $hoje,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function pcIndex($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);

        $estado = $this->estados->uf($resultEmpresa[':estado']);
        $options = new QROptions([
            'version' => 5,
            'eccLevel' => QRCode::ECC_L,
        ]);
        $qrCode = (new QRCode($options))->render($resultempresa.link_site);


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_acessoPc/main', [
            'empresa' => $resultEmpresa,
            'estado' => $estado,
            'qrCode' => $qrCode,
        ]);
    }



    public function ultimaVenda($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resultVendas = $this->vendasModel->getAllUser($SessionIdUsuario);
            $resultUltimaVenda = $this->vendasModel->getLast($SessionIdUsuario);
        }


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/pedidos/pedidoStatusHome', [
            'empresa' => $empresaAct,
            'ultimaVenda' => $resultUltimaVenda,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function quemSomos($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        }

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultEstados = $this->estadosModel->getAll();
        $resultPagamentos = $this->formPagModel->getAllPorEmpresa($empresaAct[':id']);


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_geral/quem-somos/main', [
            'empresa' => $resultEmpresa,
            'estados' => $resultEstados,
            'formaPagamento' => $resultPagamentos,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function bemVindo($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_geral/bemVindo/main', [
            'empresa' => $resultEmpresa,

        ]);
    }

    public function novoDelivery($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultProdutoQtd = $this->produtoModel->produtoQtd();
        if ($resultProdutoQtd > 0) {
            redirect(BASE . $empresaAct[':link_site']);
        }

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_geral/bemVindo/semProduto', [
            'empresa' => $resultEmpresa,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }



    public function contato($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        }
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_geral/contato/main', [
            'empresa' => $resultEmpresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function contatoSend($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $contato = $this->getInput();
        $result = $this->contatoModel->insert($contato);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        if ($result > 0) {
            echo 'Mensagem enviada com sucesso!';
        } else {
            echo 'Erro ao enviar sua mensagem';
        }
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'oi@automatiza.app';
            $mail->Password = '1@ut98l1znapp0xl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom($resultEmpresa[':emailContato'], $resultEmpresa[':razaoSocial'] . ' - Contato Cliente');
            $mail->addReplyTo(Input::post('email'), Input::post('nome'));
            $mail->addAddress($resultEmpresa[':emailContato'], 'Contato Cliente Automatiza App');
            $mail->isHTML(true);
            $mail->Subject = utf8_decode('Contato - Dúvida ou sugestão ');
            $mail->Body = utf8_decode('<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="max-width:600px; background-color:#ffffff;border:1px solid #e4e2e2;border-collapse:separate !important; border-radius:4px;border-spacing:0;color:#242128; margin:0;padding:40px;" heigth="auto">
            <tbody>
                <tr>
                    <td colspan="2" style="padding-top:20px;border-top:0px solid #e4e2e2">
                        <h3 style="color:#303030; font-size:18px; line-height: 1.6; font-weight:500;">Olá ' . Input::post('nome') . '!!</h3>
                        <p style="color:#8f8f8f; font-size: 14px; padding-bottom: 20px; line-height: 1.4;">
                        Nome: ' . Input::post('nome') . '<br/>
                        Email: ' . Input::post('email') . '<br/>
                        Telefone: ' . Input::post('telefone') . '<br/>
                        Mansagem: ' . Input::post('mensagem') . '<br/>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>');
            $mail->AltBody = Input::post('mensagem');

            $mail->send();
            echo 'Mensagem Enviado com sucesso';
        } catch (Exception $e) {
            echo "Não foi possível enviar a mensagem. Erro Mailer: {$mail->ErrorInfo}";
        }
    }

    public function delivery($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        if (isset($SessionIdUsuario)) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        }
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_geral/delivery/main', [
            'empresa' => $resultEmpresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function termosUso($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        }
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_geral/termosUso/main', [
            'empresa' => $resultEmpresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }
    public function politicaPrivacidade($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        if (isset($SessionIdUsuario)) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        }
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_geral/politicaPrivacidade/main', [
            'empresa' => $resultEmpresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    /**
     * @param array $data
     */
    public function notfound(array $data): void
    {
        echo "<h3>Whoops!</h3>", "<pre>", print_r($data, true), "</pre>";
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {
        return (object) [
            'nome' => Input::post('nome'),
            'email' => Input::post('email'),
            'telefone' => Input::post('telefone'),
            'mensagem' => Input::post('mensagem'),
            'dataEnvio' => date('Y-m-d H:i:s'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }


    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputVisitante()
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

        return (object) [
            'id_cliente' => $resulUsuario[':id'],
            'sessao_id' => session_id(),
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}

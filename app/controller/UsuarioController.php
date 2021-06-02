<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use CoffeeCode\DataLayer\DataLayer;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use Aura\Session\SessionFactory;
use function JBZoo\Data\json;
use app\classes\Sessao;
use Twilio\Rest\Client;
use app\Models\Usuarios;
use app\Models\Empresa;
use app\classes\SMS;
use Bcrypt\Bcrypt;
use Mobile_Detect;

class UsuarioController extends Controller
{

    private $empresa;
    private $acoes;
    private $usuario;
    private $sessao;
    private $bcrypt;
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
        $this->empresa = new Empresa();
        $this->usuario = new Usuarios();
        $this->bcrypt = new Bcrypt();
        $this->acoes = new Acoes();
    }
    /**
     * Login Geral Clientes
     *
     * @param [type] $data
     * @return void
     */
    public function login($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $isLogin = $this->sessao->getUser() ? redirect(BASE . $empresa->link_site) : null;

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('login/main', [
            'empresa' => $empresa,
            'isLogin' => $isLogin,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),

        ]);
    }
    /**
     * Login Geral Estabelecimentos
     *
     * @param [type] $data
     * @return void
     */
    public function loginEstabelecimento($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $isLogin = $this->sessao->getUser() ? redirect(BASE . $empresa->link_site . '/admin') : null;

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/login/main', [
            'empresa' => $empresa,
            'isLogin' => $isLogin,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()
        ]);
    }
    /**
     * Login Administração dos Estabelecimentos
     *
     * @param [type] $data
     * @return void
     */
    public function loginAdmin($data)
    {
        $isLogin = $this->sessao->getUser() ? redirect(BASE . 'admin') : null;

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/login/main', [
            'trans' => $this->trans,
            'isLogin' => $isLogin,
            'detect' => new Mobile_Detect()
        ]);
    }
    /**
     * Persistir acesso do usuario
     *
     * @return void
     */
    public function verificaLoginJs()
    {
        header('Content-Type: application/json');
        $json = json_encode(['user' => $this->sessao->getUser(), 'nivel' => $this->sessao->getNivel()]);
        exit($json);
    }

    /**
     * Valida Acesso do usuario Admin
     *
     * @param [type] $data
     * @return void
     */
    public function loginValida($data)
    {
        $email = Input::post('email');
        $senha = Input::post('senha');

        $usuario = $this->acoes->getByField('usuarios', 'email', $email);
        if ($usuario <= 0) {
            echo 'Email não encontrado em nossa plataforma! Cadastre-se.';
        } else {

            if ($this->bcrypt->verify($senha, $usuario->senha)) {
                $this->sessao->add($usuario->id, $usuario->email, $usuario->nivel);
                if ($data['linkSite'] == null) {
                    header('Content-Type: application/json');
                    $json = json_encode(['url' => "/admin", 'mensagem' => "Aguarde estamos redirecionando para a pagina inicial"]);
                    exit($json);
                } else {
                    $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
                    header('Content-Type: application/json');
                    $json = json_encode(['url' => "/{$empresa->link_site}/admin", 'resp' => 'login', 'mensagem' => "Aguarde estamos redirecionando para a pagina inicial"]);
                    exit($json);
                }
            } else {
                header('Content-Type: application/json');
                $json = json_encode(['link' => "", 'resp' => 'login', 'error' => "Senha incorreta. Verifique se digitou sua senha corretamente!"]);
                exit($json);
            }
        }
    }

    // public function login($data)
    // {
    //     // if (preg_match("/\(?\d{2}\)?\s?\d{5}\-?\d{4}/", Input::post('emailOurTel'))) {

    //     // } else {
    //     //     $getEmail = Input::post('emailOurTel');
    //     //     $result = $this->usuarioModel->verifyEmailCadastrado($getEmail);
    //     //     if ($result <= 0) {
    //     //         echo 'Não foi encontrado uma conta associada aos dados informados! Cadastre-se.';
    //     //         exit();
    //     //     }
    //     // }

    //     $validacaoEmailPhone = Input::post('emailOurTel');
    //     if (isset($validacaoEmailPhone)) {
    //         $result = $this->usuarioModel->verifyTelefoneCadastrado($validacaoEmailPhone);
    //         if ($result <= 0) {
    //             echo 'Não foi encontrado uma conta associada aos dados informados! Cadastre-se.';
    //             exit();
    //         } else {
    //             $result = $this->usuarioModel->getByTelefone($validacaoEmailPhone);
    //             $getEmail = $result[':email'];
    //         }
    //     }

    //     $empresaAct = $this->empresa->getByName($data['linkSite']);
    //     $getTelefone = $this->usuarioModel->verifyTelefoneCadastrado(Input::post('emailOurTel'));
    //     if ($getTelefone > 0) {
    //         $session = $this->sessionFactory->newInstance($_COOKIE);
    //         $segment = $session->getSegment('Vendor\Aura\Segment');
    //         $segment->set('codeValida', substr(number_format(time() * Rand(), 0, '', ''), 0, 4));
    //         $codeValida = $segment->get('codeValida');

    //         $mensagem = $empresaAct[':nomeFantasia'] . ": seu codigo de autorizacao e " . $codeValida . ". Por seguranca, nao o compartilhe com mais ninguem";
    //         $numeroTelefone = preg_replace('/[^0-9]/', '', Input::post('emailOurTel'));
    //         $ddi = '+55';
    //         $numerofinal = $ddi . $numeroTelefone;

    //         //$resultado = $this->smsClass->envioSMS($numerofinal, $mensagem);
    //$client = new Client(TWILIO['account_sid'], TWILIO['auth_token']);
   // $client->messages->create($numerofinal,array('from' => TWILIO['number'],'body' => $mensagem));

    //         $client = new Client($account_sid, $auth_token);
    //         $client->messages->create(
    //             $numerofinal,
    //             array(
    //                 'from' => '+19096555675',
    //                 'body' => $mensagem
    //             )
    //         );
    //         echo 'Enviado o Código agora e só validar';
    //         //dd($client);

    //         // if ($retorno->status == "success") {
    //         // } else {
    //         //     echo 'Não foi posível enviar validação de senha, tente novamente mais tarde!';
    //         // }
    //         exit;
    //     } else {
    //         echo '';
    //     }

    //     // $bcrypt = new Bcrypt();
    //     // $getSenha = Input::post('senha');
    //     // $bcrypt_version = '2a';
    //     // $ciphertext = $bcrypt->encrypt($getSenha, $bcrypt_version);

    //     // if ($bcrypt->verify($getSenha, $result[':senha'])) {
    //     //     echo "Aguarde estamos redirecionando para a pagina inicial";
    //     //     $session = $this->sessionFactory->newInstance($_COOKIE);
    //     //     $segment = $session->getSegment('Vendor\Aura\Segment');

    //     //     $session->setCookieParams(array('lifetime' => '2592000'));
    //     //     $session->setCookieParams(array('path' => BASE . 'cache/session'));
    //     //     $session->setCookieParams(array('domain' => 'automatiza.app'));

    //     //     $_SESSION = array(
    //     //         'Vendor\Aura\Segment' => array(
    //     //             'id_usuario' => $result[':id'],
    //     //             'usuario' => $result[':email'],
    //     //             'nivel' => $result[':nivel'],
    //     //         ),
    //     //     );
    //     // } else {
    //     //     echo "Senha incorreta. Verifique se digitou sua senha corretamente!";
    //     // }

    // }

    public function usuarioValidaAcessoCode($data)
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $codeValida = $segment->get('codeValida');

        if ($codeValida == $data['codeValida']) {
            $resultUp = $this->usuarioModel->getByTelefone($data['telefone']);
            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');

            $_SESSION = array(
                'Vendor\Aura\Segment' => array(
                    'id_usuario' => $resultUp[':id'],
                    'usuario' => $resultUp[':email'],
                    'nivel' => $resultUp[':nivel'],
                    'numero_pedido' => substr(number_format(time() * Rand(), 0, '', ''), 0, 6),
                ),
            );
            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');
            $SessionIdUsuario = $segment->get('id_usuario');

            if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
                echo 'Aguarde estamos redirecionando para a pagina inicial';
            }
        }
    }

    public function usuarioLogin($data)
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $codeValida = $segment->get('codeValida');

        $resultUp = $this->usuarioModel->getById($data['u']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        if (!$this->sessao->getUser()) {
            $session->setCookieParams(array('lifetime' => '2592000'));
            $_SESSION = array(
                'Vendor\Aura\Segment' => array(
                    'id_usuario' => $resultUp[':id'],
                    'usuario' => $resultUp[':email'],
                    'nivel' => $resultUp[':nivel'],
                    'numero_pedido' => substr(number_format(time() * Rand(), 0, '', ''), 0, 6),
                ),
            );
        }
    }


    public function atendentes($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $count = $this->acoes->counts('usuariosEmpresa', 'id_empresa', $empresa->id);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 10, $page);
        $resultCategorias = $this->acoes->pagination('usuariosEmpresa', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/atendentes/main', [
            'categorias' => $resultCategorias,
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }
}

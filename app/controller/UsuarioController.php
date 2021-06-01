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
//use app\classes\SMS;
use Bcrypt\Bcrypt;

class UsuarioController extends Controller
{
    
    private $empresa;
    private $acoes;
    private $usuario;
    private $sessao;
    private $bcrypt;
    private $geral;
    private $trans;
    private $sms;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        
        $this->sessao = new Sessao();
        $this->geral = new AllController();
        $this->empresa = new Empresa();
        $this->usuario = new Usuarios();
        $this->bcrypt = new Bcrypt();
        $this->acoes = new Acoes();
        //$this->sms = new SMS();
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
        $isLogin = $this->sessao->getUser() ? redirect(BASE.$empresa->link_site) : null;

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa','id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('login/main', [
            'empresa' => $empresa,
            'isLogin' => $isLogin,
            'trans' => $this->trans,
            
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
        $isLogin = $this->sessao->getUser() ? redirect(BASE.$empresa->link_site.'/admin') : null;

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa','id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/login/main', [
            'empresa' => $empresa,
            'isLogin' => $isLogin,
            'trans' => $this->trans,
            
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
        $isLogin = $this->sessao->getUser() ? redirect(BASE.'admin') : null;

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa','id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/login/main', [
            'trans' => $this->trans,
            'isLogin' => $isLogin,
            
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
                if ($data['linkSite'] == null){
                    echo "Aguarde estamos redirecionando para a pagina inicial";
                }else{
                    $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
                    header('Content-Type: application/json');
                    $json = json_encode(['link' => $empresa->link_site, 'mensagem' => "Aguarde estamos redirecionando para a pagina inicial"]);
                    exit($json);
                }
            } else {
                echo "Senha incorreta. Verifique se digitou sua senha corretamente!";
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

    //         $account_sid = 'AC3891f3248b6bd5bd3f299c1a89886814';
    //         $auth_token = '3ce669b5e06e3a12578e1824dc75f132';

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

        if($codeValida == $data['codeValida']){
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

    public function cadastro($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        // $SessionUsuarioEmail = $segment->get('usuario');
        // $SessionNivel = $segment->get('nivel');

        //Verifica se esta logado e bloqueia o acesso as paginas de login e Cadastro
        $verificaLogin = $this->allController->verificaNivel($empresaAct[':id']);
        $resultEmpresa = $this->empresa->getById($empresaAct[':id']);

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario);
        }

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('login/cadastro', [
            'empresa' => $resultEmpresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            
        ]);
    }

    public function cadastroAtendente($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        // $SessionUsuarioEmail = $segment->get('usuario');
        // $SessionNivel = $segment->get('nivel');

        //Verifica se esta logado e bloqueia o acesso as paginas de login e Cadastro
        $verificaLogin = $this->allController->verificaNivel($empresaAct[':id']);
        $resultEmpresa = $this->empresa->getById($empresaAct[':id']);

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario);
        }

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('login/cadastroAtendente', [
            'empresa' => $resultEmpresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            
        ]);
    }

    public function cadastroMotoca($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');


        $SessionIdUsuario = $segment->get('id_usuario');
        // $SessionUsuarioEmail = $segment->get('usuario');
        // $SessionNivel = $segment->get('nivel');

        $verificaLogin = $this->allController->verificaNivel($empresaAct[':id']);
        $resultEmpresa = $this->empresa->getById($empresaAct[':id']);

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario);
        }

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('login/cadastroMotoca', [
            'empresa' => $resultEmpresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            
        ]);
    }

    public function senhaPerdida($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);
        $verificaLogin = $this->allController->verificaNivel($empresaAct[':id']);
        $resultEmpresa = $this->empresa->getById($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('login/senhaPerdida', [
            'empresa' => $resultEmpresa,
            'trans' => $trans,
            
        ]);
    }

    public function senhaPerdidaRecupera($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);

        $telefone = Input::post('emailOurTel');
        $pegarUsuario =  $this->usuarioModel->getByTelefone($telefone);
        $geradorSenha =  $this->allController->geraSenha();
        $resultEmpresa = $this->empresa->getById($empresaAct[':id']);

        $bcrypt = new Bcrypt();
        $bcrypt_version = '2a';
        $senha = $bcrypt->encrypt($geradorSenha, $bcrypt_version);
        $result = $this->usuarioModel->updateSenha($pegarUsuario[':id'], $senha);

        if ($result <= 0) {
            echo 'Erro ao atualizar sua senha';
        } else {
            $mensagem = "Olá " . $pegarUsuario[':nome'] . " segue a nova senha para acessar sua conta no " . $resultempresa.nome_fantasia  . "! Sua senha é: " . $geradorSenha;
            $numeroTelefone = preg_replace('/[^0-9]/', '', $telefone);
            $ddi = 55;
            $numerofinal = $ddi . $numeroTelefone;

            $resultado = $this->smsClass->envioSMS($numerofinal, $mensagem);
            $retorno =  json($resultado);
            if ($retorno->status == "success") {
                echo 'Sua nova senha foi enviada com Sucesso!';
            } else {
                echo 'Não foi posível enviar sua nova senha, tente novamente mais tarde!';
            }
        }
    }

    public function novaSenhaPerdida($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        //$SessionUsuarioEmail = $segment->get('usuario');
        //$SessionNivel = $segment->get('nivel');

        $resultEmpresa = $this->empresa->getById($empresaAct[':id']);
        $resultUsuario = $this->usuarioModel->getById($data['id']);

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario);
        }

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('login/senhaPerdidaLogin', [
            'empresa' => $resultEmpresa,
            'usuario' => $resultUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            
        ]);
    }

    public function endereco($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);
        $verificaLogin = $this->allController->verificaLogin($empresaAct[':id']);
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/endereco/main', [
            'empresa' => $empresaAct
        ]);
    }

    public function insert($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);
        $usuario = $this->getInput();

        //$getEmail = $this->usuarioModel->getByEmail(Input::post('email'));
        $getTelefone = $this->usuarioModel->verifyTelefoneCadastrado(Input::post('telefone'));

        //dd($getTelefone);
        if ($getTelefone > 0) {
            echo 'Este Número de Telefone já esta cadastrado em nossa base de dados! Faça o <a href="' . BASE . $empresaAct[':link_site'] . '/sair">login</a> ou solicite a recuperação de senha!';
            exit();
        } else {
            echo '';
        }

        $result = $this->usuarioModel->insert($usuario);

        if ($result <= 0) {
            echo 'Erro ao cadastrar um novo usuario';
        } else {
            $resultUp = $this->usuarioModel->getByTelefone(Input::post('telefone'));

            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');

            $session->setCookieParams(array('lifetime' => '2592000'));
            $session->setCookieParams(array('path' => BASE . $empresaAct[':link_site'] . 'cache/session'));
            $session->setCookieParams(array('domain' => 'automatiza.app'));

            $_SESSION = array(
                'Vendor\Aura\Segment' => array(
                    'id_usuario' => $resultUp[':id'],
                    'usuario' => $resultUp[':email'],
                    'nivel' => $resultUp[':nivel'],
                ),
            );
            echo 'Cadastro Realizado com Sucesso!';
        }
    }


    public function insertSocial($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);
        $usuario = $this->getInputFacebook();

        $result = $this->usuarioModel->insert($usuario);
        if ($result <= 0) {
            echo 'Erro ao cadastrar o novo usuario';
        } else {
            echo 'Cadastro Realizado com Sucesso!';
            $getEmail = Input::post('email');
            $resultUp = $this->usuarioModel->getByEmail($getEmail);

            $session = $this->sessionFactory->newInstance($_COOKIE);
            $segment = $session->getSegment('Vendor\Aura\Segment');

            $session->setCookieParams(array('lifetime' => '2592000'));
            $session->setCookieParams(array('path' => BASE . $empresaAct[':link_site'] . 'cache/session'));
            $session->setCookieParams(array('domain' => 'automatiza.app'));

            $_SESSION = array(
                'Vendor\Aura\Segment' => array(
                    'id_usuario' => $resultUp[':id'],
                    'usuario' => $resultUp[':email'],
                    'nivel' => $resultUp[':nivel'],
                ),
            );
            //redirect(BASE . $empresaAct[':link_site']); 
        }
    }

    public function insertRecuperacaoSenha($data)
    {
        $empresaAct = $this->empresa->getByName($data['linkSite']);
        $usuario = $this->getInputRecuperacao();
        //dd($usuario);
        $result = $this->usuarioModel->update($usuario);
        if ($result <= 0) {
            echo 'Erro ao atualizar sua nova senha';
        } else {
            echo 'Senha Atualizada com Sucesso!';
        }
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputRecuperacao()
    {
        $resultUsuario = $this->usuarioModel->getById(Input::post('id'));

        $bcrypt = new Bcrypt();

        $bcrypt_version = '2a';
        $getSenha = Input::post('senha');
        $senha = $bcrypt->encrypt($getSenha, $bcrypt_version);

        return (object) [
            'id' => $resultUsuario[':id'],
            'nome' => $resultUsuario[':nome'],
            'email' => $resultUsuario[':email'],
            'telefone' => $resultUsuario[':telefone'],
            'senha' => $senha,
            'nivel' => $resultUsuario[':nivel'],
        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputFacebook()
    {
        $bcrypt = new Bcrypt();

        $bcrypt_version = '2a';
        $getSenha = 'mud@r123';
        $senha = $bcrypt->encrypt($getSenha, $bcrypt_version);

        return (object) [
            'nome' => Input::post('nome'),
            'email' => Input::post('email'),
            'telefone' => Input::post('telefone'),
            'senha' => $senha,
            'nivel' => 3,
        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {
        $bcrypt = new Bcrypt();

        $bcrypt_version = '2a';
        $getSenha = Input::post('senha');
        $senha = $bcrypt->encrypt($getSenha, $bcrypt_version);

        $geradorSenha =  $this->allController->geraSenha();
        $email = $geradorSenha . '@automatiza.app';

        return (object) [
            'nome' => Input::post('nome'),
            'email' => $email,
            'telefone' => Input::post('telefone'),
            'senha' => $senha,
            'nivel' => Input::post('nivel'),

        ];
    }


    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputUpdate()
    {
        return (object) [
            'nome' => Input::post('nome'),
            'email' => Input::post('email'),
            'telefone' => Input::post('telefone'),
            'senha' => Input::post('senha'),
            'nivel' => Input::post('nivel'),
        ];
    }
}

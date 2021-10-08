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
use app\classes\Email;
use app\classes\Sessao;
use Twilio\Rest\Client;
use app\Models\Usuarios;
use app\Models\Empresa;
use app\classes\SMS;
use app\Models\UsuariosEmpresa;
use app\Models\UsuariosEnderecos;
use Bcrypt\Bcrypt;
use Mobile_Detect;

class UsuarioController extends Controller
{

    private $empresa;
    private $acoes;
    private $email;
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
        $this->email = new Email();
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $isLogin = $this->sessao->getUser() ? redirect(BASE . $empresa->link_site) : null;

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $this->load('login/main', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $isLogin = $this->sessao->getUser() ? redirect(BASE . $empresa->link_site . '/admin') : null;

        $this->load('_admin/login/main', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'isLogin' => $isLogin,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()
        ]);
    }

    /**
     * Login Geral Estabelecimentos
     *
     * @param [type] $data
     * @return void
     */
    public function loginGeral($data)
    {

        $this->load('_admin/login/main', [
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
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

    public function usuarioLogin($data)
    {
        if ($data['u'] != $this->sessao->getUser()) {
            $this->sessao->sessaoNew('id_usuario', $data['u']);
            $this->sessao->sessaoNew('nivel', $data['n']);
        }

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
        $email = $data['email'];
        $senha = $data['senha'];
        $usuario = $this->acoes->getByField('usuarios', 'email', $email);

        if ($usuario->id <= 0) {
            echo 'Email não encontrado em nossa plataforma! Cadastre-se.';
        } else {
            if ($this->bcrypt->verify($senha, $usuario->senha)) {
                $this->sessao->add($usuario->id, $usuario->email, $usuario->nivel);
                if ($data['idEmpresa']) {
                    $usuId = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $usuario->id, 'id_empresa', $data['idEmpresa']);
                    if ($usuId->id > 0) {

                        $empresa = $this->acoes->getByField('empresa', 'id', $data['idEmpresa']);
                        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
                        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
                        $dias = $this->acoes->getFind('dias');

                        header('Content-Type: application/json');
                        $json = json_encode(['id' => 1, 'code' => 4, 'url' => "/{$empresa->link_site}/admin", 'resp' => 'login', 'mensagem' => "Aguarde estamos redirecionando para a pagina inicial"]);
                    } else {
                        $empresa = $this->acoes->getByField('empresa', 'id', $data['idEmpresa']);
                        header('Content-Type: application/json');
                        $json = json_encode(['id' => 1, 'code' => 4, 'url' => "/{$empresa->link_site}/admin", 'mensagem' => "Aguarde estamos redirecionando para a pagina inicial"]);
                    }
                } else {
                    $empresa = $this->acoes->getByField('empresa', 'id', $data['idEmpresa']);
                    header('Content-Type: application/json');
                    $json = json_encode(['id' => 1, 'code' => 4, 'url' => "/{$empresa->link_site}/admin", 'mensagem' => "Aguarde estamos redirecionando para a pagina inicial"]);
                }
            } else {
                header('Content-Type: application/json');
                $json = json_encode(['code' => 4, 'resp' => 'login', 'mensagem' => "Senha incorreta. Verifique se digitou sua senha corretamente!"]);
            }
            exit($json);
        }
    }

    public function validaAcesso($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $getTelefone = $this->acoes->getByField('usuarios', 'telefone', preg_replace('/[^0-9]/', '', $data['telefone']));

        if ($getTelefone) {
            $getUsuario = $this->acoes->getByField('usuariosEmpresa', 'id_usuario', $getTelefone->id);
            if (!$getUsuario) {
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
            // $json = json_encode(['id' => 1, 'resp' => 'send', 'mensagem' => 'Enviamos em seu celular um código para validar seu acesso!', 'url' => "valida/acesso/code/{$getTelefone->id}"]);
            // exit($json);

            $endCliente = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $getTelefone->id);

            $telNumero = substr($data['telefone'], -4);

            header('Content-Type: application/json');
            $json = json_encode(['id' => 1, 'resp' => 'send', 'mensagem' => "Número Validado!", 'duomensagem' => "<p>Confirme os dados para continuar</p><ul><li><strong>Nome:</strong> {$getTelefone->nome}</li><li class='number'><strong>Telefone final</strong>(**) **** - *{$telNumero}</li> <li class='ends'><strong>Endereço:</strong> {$endCliente->rua} **** - {$endCliente->bairro}</li></ul>", 'code' => 2,  'url' => "user/valida/acesso/{$getTelefone->id}/up"]);
            exit($json);

        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'error' => 'Você precisa precisa se cadastrar antes de fazer um pedido', 'url' => '/']);
            exit($json);
        }
    }

    public function validaAcessoPage($data)
    {
        $isLogin = $this->sessao->getUser() ? redirect(BASE . 'admin') : null;
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $usuario = $this->acoes->getByField('usuarios', 'id', $data['id']);

        $this->load('login/validaAcesso', [
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

    public function usuarioValidaAcessoNovo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $usuario = $this->acoes->getByField('usuarios', 'id', $data['id']);
        $this->sessao->add($usuario->id, $usuario->email, $usuario->nivel);

            if ($this->sessao->getUser()) {
                redirect(BASE . $empresa->link_site);
            }
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
            $this->sessao->add($usuario->id, $usuario->email, $usuario->nivel);

            if ($this->sessao->getUser()) {
                if ($this->sessao->getUser() != 'undefined') {
                    header('Content-Type: application/json');
                    $json = json_encode(['id' => 1, 'resp' => 'insert', 'mensagem' => 'OK Vai para os pedidos', 'url' => '']);
                    exit($json);
                }
            }
        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'error' => 'Código inválido! Verifique se digitou corretamente', 'url' => '']);
            exit($json);
        }
    }


    public function atendentes($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $usuarios = $this->acoes->getByFieldAll('usuarios', 'nivel', 2);
        $count = $this->acoes->countsTwo('usuariosEmpresa', 'id_empresa', $empresa->id, 'nivel', 2);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 30, $page);
        $retorno = $this->acoes->pagination('usuariosEmpresa', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/atendentes/main', [
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'usuarios' => $usuarios,
            'retorno' => $retorno,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function atendenteNovo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $this->load('_admin/atendentes/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function atendenteEditar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $retorno = $this->acoes->getByField('usuarios', 'id', $data['id']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $this->load('_admin/atendentes/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }



    public function clientes($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $usuarios = $this->acoes->getByFieldAll('usuarios', 'nivel', 3);
        $count = $this->acoes->countsTwo('usuariosEmpresa', 'id_empresa', $empresa->id, 'nivel', 3);

        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 30, $page);
        $retorno = $this->acoes->pagination('usuariosEmpresa', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id_usuario ASC');

        $this->load('_admin/clientes/main', [
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'usuarios' => $usuarios,
            'retorno' => $retorno,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $caixa->status
        ]);
    }

    public function clienteEndereco($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $usuario = $this->acoes->getByField('usuarios', 'id', $data['id']);
        $enderecos = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $data['id'], 'principal', 1);

        header('Content-Type: application/json');
        $json = json_encode([
            'nome' => $usuario->nome,
            'telefone' => $usuario->telefone,
            'rua' => $enderecos->rua,
            'numero' => $enderecos->numero,
            'complemento' => $enderecos->complemento,
            'cep' => $enderecos->cep
        ]);
        exit($json);
    }



    public function clienteNovo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $this->load('_admin/clientes/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function clienteEditar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $retorno = $this->acoes->getByField('usuarios', 'id', $data['id']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $this->load('_admin/clientes/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }


    public function administradores($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $usuarios = $this->acoes->getByFieldAll('usuarios', 'nivel', 0);
        $count = $this->acoes->countsTwo('usuariosEmpresa', 'id_empresa', $empresa->id, 'nivel', 1);
        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $pager = new \CoffeeCode\Paginator\Paginator();
        $pager->pager((int)$count, 30, $page);
        $retorno = $this->acoes->pagination('usuariosEmpresa', 'id_empresa', $empresa->id, $pager->limit(), $pager->offset(), 'id ASC');

        $this->load('_admin/administradores/main', [
            'paginacao' => $pager->render('mt-4 pagin'),
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'usuarios' => $usuarios,
            'retorno' => $retorno,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function administradorNovo($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $this->load('_admin/administradores/novo', [
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }

    public function administradorEditar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $retorno = $this->acoes->getByField('usuarios', 'id', $data['id']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

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

        $this->load('_admin/administradores/editar', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect(),
            'caixa' => $estabelecimento[0]->data_inicio
        ]);
    }


    public function insert($data)
    {
        $email = $data['email'];
        if ($data['email'] == null) {
            $hash =  md5(uniqid(rand(), true));
            $email = $hash . '@automatizadelivery.com.br';
        }

        $senha = $data['senha'];
        if ($data['senha'] == null) {
            $getSenha = preg_replace('/[^0-9]/', '', $data['telefone']);
            $senha = $this->bcrypt->encrypt($getSenha, '2a');
        } else {
            $senha = $this->bcrypt->encrypt($data['senha'], '2a');
        }

        if ($senha && $email) {

            $valor = new Usuarios();
            $valor->nome = $data['nome'];
            $valor->email = $email;
            $valor->telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
            $valor->senha = $senha;
            $valor->nivel = $data['nivel'];
            $valor->save();

            if ($valor->id > 0) {
                $valorEmp = new UsuariosEmpresa();
                $valorEmp->id_usuario = $valor->id;
                $valorEmp->id_empresa = $data['id_empresa'];
                $valorEmp->nivel = $data['nivel'];
                $valorEmp->pedidos = 0;
                $valorEmp->save();

                if ($valorEmp->id > 0) {
                    header('Content-Type: application/json');
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => $data['mensagemSuccess'], 'error' => $data['mensagemError'], 'url' => $data['url']]);
                    exit($json);
                }
            }
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'error' => $data['mensagemError']]);
            exit($json);
        }
        header('Content-Type: application/json');
        $json = json_encode(['id' => 0, 'error' => 'Preencha os campos necessários']);
        exit($json);
    }

    public function update($data)
    {
        $valor = (new Usuarios())->findById($data['id']);
        $valor->nome = $data['nome'];
        $valor->email = $data['email'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => $data['mensagemSuccess'], 'error' => $data['mensagemError'], 'url' => $data['url']]);
        exit($json);
    }

    public function deletar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $usuarioEmpresa = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $data['id'], 'id_empresa', $empresa->id);
        $valor = (new Usuarios())->findById($data['id']);
        $valor->destroy();

        $valorE = (new UsuariosEmpresa())->findById($usuarioEmpresa->id);
        $valorE->destroy();

        switch ($data['url_dell']) {
            case 0:
                $url_dell = 'admin/administradores';
                break;
            case 1:
                $url_dell = 'admin/motoboys';
                break;
            case 2:
                $url_dell = 'admin/atendentes';
                break;
            case 3:
                $url_dell = 'admin/clientes';
                break;
            default:
                $url_dell = 'admin/clientes';
                break;
        }

        redirect(BASE . "{$empresa->link_site}/{$url_dell}");
    }


    public function senhaPerdida($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                redirect(BASE . "{$empresa->link_site}/admin");
            }
        }
        $this->load('_admin/login/senhaPerdida', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }

    public function senhaPerdidaRecupera($data)
    {
        $usuario = $this->acoes->getByField('usuarios', 'email', $data['email']);
        $email = $this->email->recuperacaoSenha($usuario->nome, $usuario->email, $usuario->id, $data['linkSite']);

        header('Content-Type: application/json');
        $json = json_encode(['id' => $email, 'resp' => 'send', 'mensagem' => 'Enviamos instruções para que você possa recuperar sua senha!', 'error' => 'Não foi possivel enviar o email o email de recuperação', 'url' => "admin/login"]);
        exit($json);
    }

    public function novaSenhaPerdida($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $usuario = $this->acoes->getByField('usuarios', 'id', $data['id']);
        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                redirect(BASE . "{$empresa->link_site}/admin");
            }
        }
        $this->load('_admin/login/senhaPerdidaLogin', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'usuario' => $usuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'isLogin' => $this->sessao->getUser(),
        ]);
    }

    public function insertRecuperacaoSenha($data)
    {
        $senha = $this->bcrypt->encrypt($data['senha'], '2a');

        $valor = (new Usuarios())->findById($data['id']);
        $valor->senha = $senha;
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Senha atualizada com sucesso', 'error' => 'Não foi posível atualizar sua senha', 'url' => 'admin/login',]);
        exit($json);
    }


    public function cadastro($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            }
        }
        $this->load('login/cadastro', [
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

    public function verificaCadastro($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $getTelefone = $this->acoes->getByField('usuarios', 'telefone', preg_replace('/[^0-9]/', '', $data['telefone']));
        if ($getTelefone) {
            $clienteEmpresa = $this->acoes->getByFieldTwo('usuariosEmpresa', 'id_usuario', $getTelefone->id, 'id_empresa', $empresa->id);
            if ($clienteEmpresa) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function cadastroInsert($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $getTelefone = $this->acoes->getByField('usuarios', 'telefone', preg_replace('/[^0-9]/', '', $data['telefoneVeri']));

        if ($getTelefone) {
            $valorEmp = new UsuariosEmpresa();
            $valorEmp->id_usuario = $getTelefone->id;
            $valorEmp->id_empresa = $empresa->id;
            $valorEmp->nivel = $getTelefone->nivel;
            $valorEmp->pedidos = 0;
            $valorEmp->save();

            $this->sessao->add($valorEmp->id, $valorEmp->email, $valorEmp->nivel);

            header('Content-Type: application/json');
            $json = json_encode(['id' => $valorEmp->id, 'resp' => 'insert', 'mensagem' => 'Seu cadastro foi realizado com sucesso', 'url' => '/']);
            exit($json);
        } else {
            $getSenha = preg_replace('/[^0-9]/', '', $data['telefoneVeri']);
            $senha = $this->bcrypt->encrypt($getSenha, '2a');

            $hash =  md5(uniqid(rand(), true));
            $email = $hash . 'ath@automatizadelivery.com.br';

            if ($data['numero']) {
                $valor = new Usuarios();
                $valor->nome = $data['nome'];
                $valor->email = $email;
                $valor->telefone = preg_replace('/[^0-9]/', '', $data['telefoneVeri']);
                $valor->senha = $senha;
                $valor->nivel = 3;
                $valor->save();

                if ($valor->id > 0) {
                    $valorEnd = new UsuariosEnderecos();
                    $valorEnd->id_usuario = $valor->id;
                    $valorEnd->nome_endereco = "Padrão";
                    $valorEnd->rua = $data['rua'];
                    $valorEnd->numero = $data['numero'];
                    $valorEnd->complemento = $data['complemento'];
                    $valorEnd->bairro = $data['bairro'];
                    $valorEnd->cidade = $data['cidade'];
                    $valorEnd->estado = $data['estado'];
                    $valorEnd->cep = $data['cep'];
                    $valorEnd->principal = 1;
                    $valorEnd->save();
                } else {
                    dd($valor);
                }

                if ($valor->id > 0 && $valorEnd->id > 0) {
                    $valoEmp = new UsuariosEmpresa();
                    $valoEmp->id_usuario = $valor->id;
                    $valoEmp->id_empresa = $empresa->id;
                    $valoEmp->pedidos = 0;
                    $valoEmp->nivel = 3;
                    $valoEmp->save();
                } else {
                    dd($valorEnd);
                }

                if ($valor->id > 0 && $valorEnd->id > 0 && $valoEmp->id > 0) {
                    $this->sessao->add($valor->id, $valor->email, $valor->nivel);
                }

                header('Content-Type: application/json');
                $json = json_encode(['id' => $valoEmp->id, 'resp' => 'insert', 'mensagem' => 'Seu cadastro foi realizado com sucesso', 'url' => '/']);
                exit($json);
            } else {
                header('Content-Type: application/json');
                $json = json_encode(['id' => 0, 'resp' => 'insert', 'error' => 'Vi que não informou o número, informe como exemplo a seguir! (Ex.: Avenida Paulista 2073)']);
                exit($json);
            }
        }
    }
}

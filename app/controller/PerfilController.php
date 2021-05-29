<?php

namespace app\controller;

use CoffeeCode\Router\Router;
use app\classes\Input;
use app\classes\Preferencias;
use app\core\Controller;
use app\controller\AllController;
use app\Models\AdminCategoriaModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;
use app\Models\AdminConfigFreteModel;
use app\Models\AdminProdutoAdicionalModel;
use app\Models\CarrinhoModel;
use app\Models\AdminProdutoModel;
use Aura\Session\SessionFactory;
use app\Models\DiasModel;
use app\Models\EnderecosModel;
use app\Models\EstadosModel;
use app\Models\MoedaModel;
use app\Models\UsuarioModel;
use app\Models\VendasModel;
use Bcrypt\Bcrypt;

class PerfilController extends Controller
{
    //Instancia da Classe AdminConfigEmpresaModel
    private $configEmpresaModel;
    private $deliveryModel;
    private $moedaModel;
    private $categoriaModel;
    private $produtoModel;
    private $diasModel;
    private $usuarioModel;
    private $enderecoModel;
    private $estadosModel;
    private $produtoAdicionalModel;
    private $vendasModel;
    private $allController;
    private $carrinhoModel;
    private $sessionFactory;
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
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
        $this->moedaModel = new MoedaModel();
        $this->deliveryModel = new AdminConfigFreteModel();
        $this->categoriaModel = new AdminCategoriaModel();
        $this->produtoModel = new AdminProdutoModel();
        $this->produtoAdicionalModel = new AdminProdutoAdicionalModel();
        $this->diasModel = new DiasModel();
        $this->usuarioModel = new UsuarioModel();
        $this->enderecoModel = new EnderecosModel();
        $this->estadosModel = new EstadosModel();
        $this->vendasModel = new VendasModel();
        $this->sessionFactory = new SessionFactory();
        $this->carrinhoModel = new CarrinhoModel();
        $this->allController = new AllController();
    }

    public function index($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $csrf_value = $session->getCsrfToken()->getValue();
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
            $verificaAcesso = $this->allController->verificaPrimeiroAcesso($empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/main', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }
    public function perfil($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/perfil', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function dadosCadastrais($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/dadosCadastrais', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }


    public function enderecos($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resulEnderecos = $this->enderecoModel->getAll();
        $resulEstados = $this->estadosModel->getAll();



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/enderecos', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'enderecos' => $resulEnderecos,
            'estadosSelecao' => $resulEstados,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias

        ]);
    }


    public function novoEndereco($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resulEnderecos = $this->enderecoModel->checkById($SessionIdUsuario);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultEstados = $this->estadosModel->getAll();



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/endereco', [
            'empresa' => $resultEmpresa,
            'resulEnderecos' => $resulEnderecos,
            'estadosSelecao' => $resultEstados,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function novoEnderecoPrimeiro($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resulEnderecos = $this->enderecoModel->checkById($SessionIdUsuario);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);

        if (isset($SessionIdUsuario)) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultEstados = $this->estadosModel->getAll();



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/primeiroEndereco', [
            'empresa' => $resultEmpresa,
            'resulEnderecos' => $resulEnderecos,
            'estadosSelecao' => $resultEstados,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function insertEndereco($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resulEnderecos = $this->enderecoModel->checkById($SessionIdUsuario);
        $resultEnderecoAntigo = $this->enderecoModel->getByIdPedido($SessionIdUsuario);

        $usuario = $this->getInput();
        if ($resulEnderecos > 0) {
            if (Input::post('principal') == 1) {
                if ($resultEnderecoAntigo[':principal'] != null) {
                    $result = $this->enderecoModel->removePrincipal($resultEnderecoAntigo[':id']);
                }
            }
            $result = $this->enderecoModel->insert($usuario);
            if ($result <= 0) {
                echo 'Erro ao cadastrar um novo endereço';
            } else {
                echo 'Endereço cadastrado com Sucesso!';
            }
        } else {
            $result = $this->enderecoModel->insert($usuario);
            if ($result <= 0) {
                echo 'Erro ao cadastrar seu primeiro endereço';
            } else {
                echo 'Primeiro endereço cadastrado com Sucesso!';
            }
        }
    }

    public function editarEndereco($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $verificaLogin = $this->allController->verificaLogin($empresaAct[':id']);
        $resulEnderecos = $this->enderecoModel->checkById($SessionIdUsuario);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resulEndereco = $this->enderecoModel->getById($data['id']);
        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        $resultEstados = $this->estadosModel->getAll();



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/editar', [
            'empresa' => $resultEmpresa,
            'resulEnderecos' => $resulEnderecos,
            'enderecoAtivo' => $resulEndereco,
            'estadosSelecao' => $resultEstados,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function updateEndereco($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $endereco = $this->getInputUpdate();

        $result = $this->enderecoModel->update($endereco);
        if ($result > 0) {
            echo 'Endereço atualizado com Sucesso!';
        } else {
            echo 'Erro ao atualizar seu endereço';
        }
    }

    public function updateDados($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $dados = $this->getInputDados();

        $result = $this->usuarioModel->updateEmail($dados);
        if ($result > 0) {
            echo 'Dados atualizado com Sucesso!';
        } else {
            echo 'Erro ao atualizar seus dados';
        }
    }

    public function senha($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/mudarSenha', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    public function telefone($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $csrf_value = $session->getCsrfToken()->getValue();
        $SessionIdUsuario = $segment->get('id_usuario');

        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/perfil/mudarTelefone', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $trans,
            'preferencias' => $this->preferencias
        ]);
    }

    /**
     *
     * Faz a atualização da pagina de proutos
     *
     */
    public function deletarEndereco($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $result = $this->enderecoModel->delete($data['id']);
        if ($result > 0) {
            redirect(BASE.$empresaAct[':link_site'].'/enderecos');
            exit;
        }
        redirect(BASE.$empresaAct[':link_site'].'/enderecos');
    }

    public function updateSenha($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $senha = $this->getInputUpdateSenha();
        //dd($senha);
        $result = $this->usuarioModel->update($senha);
        if ($result > 0) {
            echo 'Senha atualizado com Sucesso!';
        } else {
            echo 'Erro ao atualizar sua senha';
        }
    }

    public function updateTelefone($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $telefone = $this->getInputUpdateTelefone();
        $result = $this->usuarioModel->update($telefone);
        if ($result > 0) {
            echo 'Telefone atualizado com Sucesso!';
        } else {
            echo 'Erro ao atualizar seu telefone';
        }
    }


    public function editarPrincipal($data)
    {
        $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');
        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionNivel = $segment->get('nivel');
        $resultEndereco = $this->enderecoModel->getByIdPedido($SessionIdUsuario);
        $result = $this->enderecoModel->removePrincipal($resultEndereco[':id']);
        $result .= $this->enderecoModel->informPrincipal($data['id']);
        if ($result > 0) {
            if ($result > 0) {
                echo 'Endereço definido como principal';
            }
        } else {
            echo 'Erro ao definir o endereço como principal';
        }
    }



    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputUpdateSenha()
    {
        $bcrypt = new Bcrypt();

        $bcrypt_version = '2a';
        $getSenha = Input::post('senha');
        $senha = $bcrypt->encrypt($getSenha, $bcrypt_version);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

        return (object) [
            'id' => $resulUsuario[':id'],
            'nome' => $resulUsuario[':nome'],
            'email' => $resulUsuario[':email'],
            'telefone' => $resulUsuario[':telefone'],
            'senha' => $senha,
            'nivel' => $resulUsuario[':nivel']
        ];
    }


    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputUpdateTelefone()
    {
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');

        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);

        return (object) [
            'id' => $resulUsuario[':id'],
            'nome' => $resulUsuario[':nome'],
            'email' => $resulUsuario[':email'],
            'telefone' => Input::post('telefone'),
            'senha' => $resulUsuario[':senha'],
            'nivel' => $resulUsuario[':nivel']
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
            'id' => Input::post('id'),
            'id_usuario' => Input::post('id_usuario'),
            'email' => Input::post('email'),
            'nome_endereco' => Input::post('nome_endereco'),
            'rua' => Input::post('rua'),
            'numero' => Input::post('numero'),
            'complemento' => Input::post('complemento'),
            'bairro' => Input::post('bairro'),
            'cidade' => Input::post('cidade'),
            'estado' => Input::post('estado'),
            'cep' => Input::post('cep'),
            'principal' => Input::post('principal')

        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInput()
    {

        return (object) [
            'id_usuario' => Input::post('id_usuario'),
            'email' => Input::post('email'),
            'nome_endereco' => Input::post('nome_endereco'),
            'rua' => Input::post('rua'),
            'numero' => Input::post('numero'),
            'complemento' => Input::post('complemento'),
            'bairro' => Input::post('bairro'),
            'cidade' => Input::post('cidade'),
            'estado' => Input::post('estado'),
            'cep' => Input::post('cep'),
            'principal' => Input::post('principal')
        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputDados()
    {
        return (object) [
            'id' => Input::post('id_usuario'),
            'email' => Input::post('email'),
            
        ];
    }
}

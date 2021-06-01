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
use app\Models\AdminProdutoModel;
use app\Models\AdminMotoboyModel;
use Aura\Session\SessionFactory;
use app\Models\DiasModel;
use app\Models\EnderecosModel;
use app\Models\EstadosModel;
use app\Models\MoedaModel;
use app\Models\UsuarioModel;
use app\Models\VendasModel;

use Bcrypt\Bcrypt;

class PerfilMotoboyController extends Controller
{
    //Instancia da Classe AdminConfigEmpresaModel
    private $configEmpresaModel;
    private $deliveryModel;
    private $moedaModel;
    private $sessionFactory;
    private $categoriaModel;
    private $produtoModel;
    private $diasModel;
    
    private $usuarioModel;
    private $enderecoModel;
    private $estadosModel;
    private $produtoAdicionalModel;
    private $vendasModel;
    private $allController;
    private $motoboyModel;


    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
        $this->moedaModel = new MoedaModel();
        $this->deliveryModel = new AdminConfigFreteModel();
        $this->categoriaModel = new AdminCategoriaModel();
        $this->produtoModel = new AdminProdutoModel();
        $this->produtoAdicionalModel = new AdminProdutoAdicionalModel();
        $this->diasModel = new DiasModel();
        $this->sessionFactory = new SessionFactory();
        $this->usuarioModel = new UsuarioModel();
        $this->enderecoModel = new EnderecosModel();
        $this->estadosModel = new EstadosModel();
        $this->vendasModel = new VendasModel();
        $this->allController = new AllController();
        $this->motoboyModel = new AdminMotoboyModel();
    }

    /**
     * Pagina da listagem do perfil do Motoboy
     */
    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            //if($resulUsuario[':nivel'] != 3){redirect(BASE . $empresaAct[':link_site']);}
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $verificaLogin = $this->allController->verificaLogin($empresaAct[':id']);
        $resultCarrinhoQtd = $this->vendasModel->carrinhoQtdListMoto($SessionIdUsuario,$empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/perfil/main', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            
        ]);
    }
    /**
     * Editar ou ver dados de sua diaria
     */
    public function editar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            $resultCarrinhoQtd = $this->vendasModel->carrinhoQtdListMoto($SessionIdUsuario,$empresaAct[':id']);
            //if($resulUsuario[':nivel'] != 3){redirect(BASE. 'motoboy');}
            $resulMotoboy = $this->motoboyModel->getByid_motoboy($SessionIdUsuario,$empresaAct[':id']);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/perfil/perfil', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'motoboy' => $resulMotoboy,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'empresa' => $resultEmpresa,
            'moeda' => $moeda,
            'trans' => $trans,
            
        ]);
    }
    /**
     * Pagina de Update de senha
     */
    public function senha($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');
        if (!$this->sessao->getUser()) {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }

        $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $verificaLogin = $this->allController->verificaLogin($empresaAct[':id']);
        $resultCarrinhoQtd = $this->adminCarrinhoModel->carrinhoQtdList($SessionIdUsuario);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_motoboy/perfil/mudarSenha', [
            'empresa' => $resultEmpresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            
        ]);
    }

    /**
     *
     * Faz a atualização da pagina de proutos
     *
     */
    public function deletarEndereco($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $result = $this->enderecoModel->delete($data['id']);

        if ($result <= 0) {
            redirect(BASE.$empresaAct[':link_site'].'/enderecos');
            exit;
        }
        redirect(BASE.$empresaAct[':link_site'].'/enderecos');
    }

    /**
     *
     * Faz a atualização da senha
     *
     */
    public function updateSenha($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $senha = $this->getInputUpdateSenha();
        $result = $this->usuarioModel->update($senha);
        if ($result > 0) {
            echo 'Senha atualizado com Sucesso!';
        } else {
            echo 'Erro ao atualizar sua senha';
        }
    }

    /**
     *
     * Faz a atualização da placa
     *
     */
    public function updatePlaca($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $dadosMoto = $this->getInputUpdatePlaca();
        $result = $this->motoboyModel->update($dadosMoto);
        if ($result > 0) {
            echo 'Placa atualizado com Sucesso!';
        } else {
            echo 'Erro ao atualizar sua placa';
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
        ];
    }

    /**
     * Retorna os dados do formulário em uma classe padrão stdObject
     *
     * @return object
     */
    private function getInputUpdatePlaca()
    {
        return (object) [
            'id' => Input::post('id'),
            'id_usuario' => Input::post('id_usuario'),
            'diaria' => Input::post('diaria'),
            'taxa' => Input::post('taxa'),
            'placa' => Input::post('placa'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}

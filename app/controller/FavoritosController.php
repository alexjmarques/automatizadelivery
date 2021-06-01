<?php

namespace app\controller;

use app\classes\Preferencias;
use app\controller\AllController;
use app\core\Controller;
use app\Models\AdminCategoriaModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;
use app\Models\AdminConfigFreteModel;
use app\Models\AdminProdutoAdicionalModel;
use app\Models\AdminProdutoModel;
use app\Models\AdminUsuarioModel;
use app\Models\CarrinhoModel;
use app\Models\DiasModel;
use app\Models\EnderecosModel;
use app\Models\EstadosModel;
use app\Models\FavoritosModel;
use app\Models\MoedaModel;
use app\Models\VendasModel;
use Aura\Session\SessionFactory;

class FavoritosController extends Controller
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
    private $produtoAdicionalModel;
    private $sessionFactory;
    private $vendasModel;
    private $allController;
    private $favoritosModel;
    private $carrinhoModel;
    

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->allController = new AllController();
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
        $this->moedaModel = new MoedaModel();
        $this->deliveryModel = new AdminConfigFreteModel();
        $this->sessionFactory = new SessionFactory();
        $this->categoriaModel = new AdminCategoriaModel();
        $this->produtoModel = new AdminProdutoModel();
        $this->produtoAdicionalModel = new AdminProdutoAdicionalModel();
        $this->diasModel = new DiasModel();
        $this->usuarioModel = new AdminUsuarioModel();
        $this->enderecosModel = new EnderecosModel();
        $this->estadosModel = new EstadosModel();
        $this->carrinhoModel = new CarrinhoModel();
        $this->vendasModel = new VendasModel();
        $this->favoritosModel = new FavoritosModel();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');


        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');


        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $resultDelivery = $this->deliveryModel->getByid_empresa($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $resultDias = $this->diasModel->getAll();
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultUsuario = $this->usuarioModel->getAll();


        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(),'id_empresa', $empresa->id);
            $verificaLogin = $this->allController->verificaPrimeiroAcesso($empresaAct[':id']);
            $favoritos = $this->favoritosModel->getAllCli($SessionIdUsuario);
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/favoritos/main', [
            'empresa' => $resultEmpresa,
            'moeda' => $moeda,
            'delivery' => $resultDelivery,
            'produto' => $resultProdutos,
            'dias' => $resultDias,
            'usuario' => $resultUsuario,
            'favoritos' => $favoritos,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $trans,
            

        ]);
    }

    /**
     *
     * Faz a atualização da pagina de proutos
     *
     */
    public function deletarFavorito($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $result = $this->favoritosModel->delete($data['id']);

        if ($result <= 0) {
            redirect(BASE . $empresaAct[':link_site'] . '/favoritos');
            exit;
        }
        redirect(BASE . $empresaAct[':link_site'] . 'favoritos');
    }

    public function inserirFavorito($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $verifyFavorito = $this->favoritosModel->verifyFavorito($data['id']);
        if ($verifyFavorito == 0) {
            $result = $this->favoritosModel->insert($SessionIdUsuario, $data['id'], $empresaAct[':id']);

            if ($result <= 0) {
                echo "Favorito não cadastrado";
            } else {
                echo "Favorito Cadastrado";
            }
        } else {
            $result = $this->favoritosModel->delete($data['id']);
            if ($result <= 0) {
                echo "Não foi possível Deletado";
            } else {
                echo "Favorito Deletado";
            }
        }
    }
}

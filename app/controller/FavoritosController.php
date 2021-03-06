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
use Browser;
use Mobile_Detect;

class FavoritosController extends Controller
{
    private $acoes;
    private $sessao;
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
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');

        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');


        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');


        $resultDelivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $resultDias = $this->diasModel->getAll();
        $resultProdutos = $this->produtoModel->getAllPorEmpresa($empresaAct[':id']);
        $resultUsuario = $this->usuarioModel->getAll();


        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(),'id_empresa', $empresa->id);
            $verificaLogin = $this->allController->verificaPrimeiroAcesso($empresaAct[':id']);
            $favoritos = $this->favoritosModel->getAllCli($SessionIdUsuario);
            $resulUsuario = $this->usuarioModel->getById($SessionIdUsuario);
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . 'login');
        }
        $resultCarrinhoQtd = $this->carrinhoModel->carrinhoQtdList($SessionIdUsuario,$empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_cliente/favoritos/main', [
            'empresa' => $empresa,
            'moeda' => $moeda,
            'delivery' => $resultDelivery,
            'produto' => $resultProdutos,
            'dias' => $resultDias,
            'usuario' => $resultUsuario,
            'favoritos' => $favoritos,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
'isLogin' => $this->sessao->getUser(),

        ]);
    }

    /**
     *
     * Faz a atualiza????o da pagina de proutos
     *
     */
    public function deletarFavorito($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        $verifyFavorito = $this->favoritosModel->verifyFavorito($data['id']);
        if ($verifyFavorito == 0) {
            $result = $this->favoritosModel->insert($SessionIdUsuario, $data['id'], $empresaAct[':id']);

            if ($result <= 0) {
                echo "Favorito n??o cadastrado";
            } else {
                echo "Favorito Cadastrado";
            }
        } else {
            $result = $this->favoritosModel->delete($data['id']);
            if ($result <= 0) {
                echo "N??o foi poss??vel Deletado";
            } else {
                echo "Favorito Deletado";
            }
        }
    }
}

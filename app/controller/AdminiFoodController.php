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


//use MatheusHack\IFood\Restaurant;

class AdminIfoodController extends Controller
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
        $result = $this->configEmpresaModel->getById($empresaAct[':id']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            $resulUsuario = $this->adminUsuarioModel->getById($SessionIdUsuario);
            if ($resulUsuario[':nivel'] == 3) {
                redirect(BASE . $empresaAct[':link_site']);
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/login');
        }

        $estabelecimento = $this->allController->verificaEstabelecimento($empresaAct[':id']);;;
        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $resulifood = $this->marketplace->getById(1);
        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);

        //dd($this->cache->read('tokenIfood'));

        $status = 0;
        if ($this->cache->read('tokenIfood') != null) {
            $status = $this->ifoodMerchant->status();
            if ($status == 401){
                $autorizacao = $this->authetication->autorizarCliente();
                $status = 0;
            }else{
                if($status[0]->state != 'ERROR'){
                    $status = $status[0]->available;
                }
            }
        }



        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/marketplaces/ifood', [
            'empresa' => $empresaAct,
            'nivelUsuario' => $SessionNivel,
            'statusiFood' => $resulifood,
            'status' => $status,
            'planoAtivo' => $planoAtivo,
            'usuarioLogado' => $resulUsuario,
            'estabelecimento' => $estabelecimento,
            'trans' => $trans,
            'nivelUsuario'=> $this->sessao->getNivel(),
            'caixa' => $resulCaixa,

        ]);
    }


    public function autorizar($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $autorizacao = $this->authetication->autorizarCliente();
        if($autorizacao){
            $id_marketplaces = 1;
            $idLoja = Input::post('idLoja');
            $authorizationCode = $autorizacao->authorizationCodeVerifier;
            $result = $this->marketplace->updateU(1, $id_marketplaces, $idLoja, $authorizationCode, $empresaAct[':id']);
            echo $autorizacao->verificationUrlComplete;
        }
        
    }


    public function autorizarCode($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $userCode = Input::post('userCode');
        $result = $this->marketplace->updateCode(1, $userCode);
        $dd = $this->authetication->gerarToken();
        $dd = $this->authetication->refreshToken();
        //redirect(BASE . $empresaAct[':link_site'] . '/admin/ifood');
        //echo "Code OK";

        if ($dd == 401) {
            echo "Não foi possível atualizar Code";
        } else {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/ifood');
            echo "Code OK";
        }
    }

    public function polling($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
     if($this->cache->readTime('tokenIfood')){
        $time = $this->cache->readTime('tokenIfood') - time();
        if($time < 500){
            $this->authetication->refreshToken();
        }
        echo $this->ifoodOrder->eventsPolling();
     }
    }

    
    public function syncCategory($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulifood = $this->marketplace->getById(1);
        if($resulifood[':idLoja'] != null){
            $catalogs = $this->ifoodCatalog->catalogs();
            $idCategory = Input::post('id');
            $category = $this->adminCategoriaModel->getById($idCategory);
            $name = $category[':nome'];
            $slug =  $category[':slug'];
            $externalCode = $slug.$idCategory;

            foreach ((array)$catalogs as $value) {
                $status = $value->status;
                $catalogId = $value->catalogId;

                if ($status == "AVAILABLE") {
                    $catalogs = $this->ifoodCatalogCategory->create($catalogId, $name, $externalCode);
                    $dd = $this->ifoodCatalogCategory->list($catalogId);
                    foreach((array)$dd as $value){
                        if($name == $value->name){
                            $verify = $this->adminIfoodCategoriasModel->getById($idCategory);
                            if($verify[':idCategory'] == $idCategory){
                                $result = $this->adminIfoodCategoriasModel->insert($idCategory, $value->id);
                            }else{
                                $result = $this->adminIfoodCategoriasModel->update($idCategory, $idCategory, $value->id);
                            }
                            exit;
                        }else{
                            $catalogs = $this->ifoodCatalogCategory->create($catalogId, $name, $externalCode);
                            foreach((array)$dd as $value){
                                if($name == $value->name){
                                    $result = $this->adminIfoodCategoriasModel->insert($idCategory, $value->id);
                                }
                            }
                            exit;
                        }
                    }

                }

            }
        }
    }

    public function syncProduct($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulifood = $this->marketplace->getById(1);
        if($resulifood[':idLoja'] != null){
            $idProduct = Input::post('id');
            //Recuperar Dados do Produto
            $product = $this->adminProdutosModel->getById($idProduct);
            $category = $this->adminIfoodCategoriasModel->getByIdCategory($product[':categoria']);
            
            
            if($product[':valor_promocional'] == 0.00){
                $valor_promocional = null;
            }else{
                $valor_promocional = $product[':valor_promocional'];
            }
            $valor = $product[':valor_promocional'];
            //dd($newProduct->id,);
            $newProduct = $this->ifoodCatalogProduct->create($product[':id'], $product[':nome'], $product[':descricao']);
            $newProductCat = $this->ifoodCatalogItem->create($category[':idIfood'], $newProduct->id);
            $result = $this->adminIfoodProdutoModel->insert($product[':id'], $newProduct->id, $empresaAct[':id']);
            dd($newProductCat);
            
        }
    }
    
    

    public function ifoodTest($data)
    {
$empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $dd = $this->cache->read('tokenIfood');
        //$time = $this->cache->readTime('tokenIfood') - time();

        //print_r($dd);
        //print_r($time);
        //$dd = $this->authetication->autorizarCliente();
        //$dd = $this->authetication->gerarToken();
        //$dd = $this->authetication->refreshToken();
        //$dd = $this->ifoodMerchant->listCurrent();
        //$dd = $this->ifoodMerchant->status();
        $dd = $this->ifoodCatalogCategory->list('0a276985-df4f-4934-b38b-3f408cca702e');
        //$dd = $this->ifoodCatalogProduct->list(1, 10);
        
        //$dd = $this->ifoodCatalogProduct->create('hytdftgy','Teste Produto', 'Teste descricao');
        $dd = $this->ifoodCatalogItem->create('67da1e87-2641-4bd1-9e41-9d00d7aee49f', '0aee5c21-5195-43eb-a0b0-e9a50202a66b');
        // if($catalogs[0]){
        //     $delivery = $catalogs[0]->status;
        //     $deliveryID = $catalogs[0]->catalogId;
        //     if ($delivery == "AVAILABLE") {
        //         $dd = $this->ifoodCatalogCategory->list($deliveryID);
        //         foreach($dd as $value){
        //             if($name == $value->name){
        //                 $verify = $this->adminIfoodCategoriasModel->getById($idCategory);
        //                 if($verify[':idCategory'] == $idCategory){
        //                     $result = $this->adminIfoodCategoriasModel->insert($idCategory, $value->id);
        //                 }else{
        //                     $result = $this->adminIfoodCategoriasModel->update($idCategory, $value->id);
        //                 }
        //                 exit;
        //             }else{
        //                 $catalogs = $this->ifoodCatalogCategory->create($deliveryID, $name, $externalCode);
        //                 foreach($dd as $value){
        //                     if($name == $value->name){
        //                         $result = $this->adminIfoodCategoriasModel->insert($idCategory, $value->id);
        //                     }
        //                 }
        //                 exit;
        //             }
        //         }
        //     }
        // }

        //$dd = $this->ifoodMerchant->statusOperation('delivery');
        //$dd = $this->ifoodMerchant->listInterruption();
        //$dd = $this->ifoodMerchant->createInterruption('Paramos pois tivemos um problema interno', "2021-05-15T13:55:00.638Z", "2021-05-15T13:57:00.638Z");
        //$dd = $this->ifoodMerchant->deleteInterruption('5c7ba4f9-2bae-4e76-985c-885e28cd9bff');
        
        //dd('rr'.exec($dd));
        //exec( "php segundoPlano.php > /tmp/segundoPlanoIndex.log &");
        //exec('php /Users/alexmarques/Localhost/automatiza/app/classes/segundoPlano.php >  /Users/alexmarques/Localhost/automatiza/app/classes/tmp/segundoPlanoIndex.log &');
        //dd($dd[0]->available);
        //$catalogs = $this->ifoodCatalog->catalogs();
        //$dd = $this->ifoodCatalog->categoryNew('0a276985-df4f-4934-b38b-3f408cca702e', 'Bebidas', 'bebidas5');


        dd($dd);
    }
}
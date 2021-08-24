<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\api\iFood\Authetication;
use app\api\iFood\Merchants;
use app\api\iFood\Order;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\classes\Sessao;
use app\Models\EmpresaMarketplaces;
use Browser;


//use MatheusHack\IFood\Restaurant;

class AdminIfoodController extends Controller
{
    private $acoes;
    private $sessao;
    private $geral;
    private $trans;
    private $ifood;
    private $validacao;
    private $ifoodOrder;


    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->trans = new Translate(new PhpFilesLoader("../app/language"), ["default" => "pt_BR"]);
        $this->validacao = new Authetication();
        $this->ifoodOrder = new Order();
        $this->ifood = new Merchants();
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
        $ifoodVerif = $this->acoes->getByFieldTwo('empresaMarketplaces', 'id_empresa', $empresa->id, 'id_marketplaces', 1);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $resultClientes = $this->acoes->getFind('usuarios');
        $resultMotoboy = $this->acoes->getByFieldAll('motoboy', 'id_empresa', $empresa->id);
        if ($estabelecimento) {
            $resultPedidos = $this->acoes->getByFieldAll('carrinhoPedidos', 'id_caixa', $estabelecimento[0]->id);
        }

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

        $status = 0;
        if ($this->cache->read("tokenIfood-{$empresa->id}") != null) {
            $status = $this->ifood->status($empresa->id, $ifoodVerif->id_loja);
            $id_loja = $this->ifood->list('704976e1-4b34-40d9-8b09-bc73bb6f964e');

            dd($id_loja);
            if ($status == 401) {
                $autorizacao = $this->validacao->autorizarCliente();
                $status = 0;
            } else {

                if ($status[0]->state != 'ERROR') {
                    $status = $status[0]->available;
                }
            }
        }

        $this->load('_admin/marketplaces/ifood', [
            'statusiFood' => $ifoodVerif,
            'status' => $status,

            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'caixaId' => $estabelecimento[0]->id,
            'caixa' => $caixa->status,
            'nivelUsuario' => $this->sessao->getNivel(),
            'pedidos' => $resultPedidos,
            'clientes' => $resultClientes,
            'motoboy' => $resultMotoboy,
        ]);
    }


    public function autorizar($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $ifoodVerif = $this->acoes->getByFieldTwo('empresaMarketplaces', 'id_empresa', $empresa->id, 'id_marketplaces', 1);
        $autorizacao = $this->validacao->autorizarCliente();

        $authorizationCode = $autorizacao->authorizationCodeVerifier;

        if ($ifoodVerif) {
            $valor = (new EmpresaMarketplaces())->findById($data['idIfood']);
            $valor->id_loja = $data['idLoja'];
            $valor->authorization_code = $authorizationCode;
            $valor->save();
        } else {
            $valor = new EmpresaMarketplaces();
            $valor->id_loja = $data['idLoja'];
            $valor->authorization_code = $authorizationCode;
            $valor->id_marketplaces = 1;
            $valor->id_empresa = $empresa->id;
            $valor->save();
        }
        if ($autorizacao) {
            echo $autorizacao->verificationUrlComplete;
        }
    }

    public function autorizarCode($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $ifoodVerif = $this->acoes->getByFieldTwo('empresaMarketplaces', 'id_empresa', $empresa->id, 'id_marketplaces', 1);

        $valor = (new EmpresaMarketplaces())->findById($ifoodVerif->id);
        $valor->user_code = $data['userCode'];
        $valor->save();

        if ($valor->id > 0) {
            // dd($data);
            $dd = $this->validacao->gerarToken($empresa->id, $data['userCode'], $ifoodVerif->authorization_code);
            if ($dd == 401) {
                echo "Não foi possível atualizar Code";
            } else {
                redirect(BASE . "{$empresa->link_site}/admin/ifood");
                echo "Code OK";
            }
        }
    }

    public function polling()
    {
        if ($this->cache->readTime('tokenIfood')) {
            $time = $this->cache->readTime('tokenIfood') - time();
            if ($time < 500) {
                $this->validacao->refreshToken();
            }
            echo $this->ifoodOrder->eventsPolling();
        } else {
            $this->validacao->gerarToken();
        }
    }


    public function syncCategory($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $resulifood = $this->marketplace->getById(1);
        if ($resulifood[':idLoja'] != null) {
            $catalogs = $this->ifoodCatalog->catalogs();
            $idCategory = Input::post('id');
            $category = $this->adminCategoriaModel->getById($idCategory);
            $name = $category[':nome'];
            $slug =  $category[':slug'];
            $externalCode = $slug . $idCategory;

            foreach ((array)$catalogs as $value) {
                $status = $value->status;
                $catalogId = $value->catalogId;

                if ($status == "AVAILABLE") {
                    $catalogs = $this->ifoodCatalogCategory->create($catalogId, $name, $externalCode);
                    $dd = $this->ifoodCatalogCategory->list($catalogId);
                    foreach ((array)$dd as $value) {
                        if ($name == $value->name) {
                            $verify = $this->adminIfoodCategoriasModel->getById($idCategory);
                            if ($verify[':idCategory'] == $idCategory) {
                                $result = $this->adminIfoodCategoriasModel->insert($idCategory, $value->id);
                            } else {
                                $result = $this->adminIfoodCategoriasModel->update($idCategory, $idCategory, $value->id);
                            }
                            exit;
                        } else {
                            $catalogs = $this->ifoodCatalogCategory->create($catalogId, $name, $externalCode);
                            foreach ((array)$dd as $value) {
                                if ($name == $value->name) {
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $resulifood = $this->marketplace->getById(1);
        if ($resulifood[':idLoja'] != null) {
            $idProduct = Input::post('id');
            //Recuperar Dados do Produto
            $product = $this->adminProdutosModel->getById($idProduct);
            $category = $this->adminIfoodCategoriasModel->getByIdCategory($product[':categoria']);


            if ($product[':valor_promocional'] == 0.00) {
                $valor_promocional = null;
            } else {
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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $ifoodVerif = $this->acoes->getByFieldTwo('empresaMarketplaces', 'id_empresa', $empresa->id, 'id_marketplaces', 1);
        //dd($ifoodVerif);
        //$dd = $this->cache->read('tokenIfood-1');
        //$time = $this->cache->readTime('tokenIfood') - time();

        //print_r($dd);
        //print_r($time);
        //$dd = $this->validacao->autorizarCliente();
        //$dd = $this->validacao->gerarToken();
        // print_r($empresa->id);
        // print_r($ifoodVerif->user_code);
        // print_r($ifoodVerif->authorization_code);

        //        print_r($this->cache->read("tokenIfood-{$empresa->id}"));
        //$dd = $this->validacao->gerarToken();
        //$dd = $this->validacao->refreshToken(1, 'FNSR-ZVNW', 'mbu1treoa4m0vemth0vm0jg60daoosd4574pwet4j26p8mmk3rsl5wr561uj7c0ne5bz1hks4n8kv1o7qb96xl3igc32yhpe4q7');
        //$dd = $this->ifood->listInterruptions($ifoodVerif->id_loja);

        //$dd = $this->ifood->status($ifoodVerif->id_loja);

        //$dd = $this->ifood->delete($ifoodVerif->id_loja, 'c5e94367-e5b5-4f47-8e6f-7f2bf9de8b31');



        //$dd =  $this->ifoodOrder->eventsPolling();
        dd($this->cache->readTime('tokenIfood'));
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

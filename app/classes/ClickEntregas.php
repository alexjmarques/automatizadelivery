<?php

namespace app\classes;

use GuzzleHttp\Client;
use app\classes\Cache;
use app\core\Controller;
use app\Models\EstadosModel;
use app\Models\AdminMarketplacesModel;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;

class ClickEntregas extends Controller
{

    private $apiUrl;
    private $apiKey;
    private $build;
    private $cache;
    private $client;
    private $clientId;
    private $callBack;
    private $endPoint;
    private $marketplace;
    private $clientSecret;
    private $estadosModel;
    private $configEmpresaModel;
    /**
     * Payment constructor.
     */
    public function __construct()
    {
        

        $live = false;
        if($live){
            $this->apiUrl = "https://robot.clickentregas.com/api/business/1.1";
        }else{
            $this->apiUrl = "https://robotapitest.clickentregas.com/api/business/1.1";
        }

        $this->cache = new Cache();
        $this->client = new Client();
        $this->estadosModel = new EstadosModel();
        $this->marketplace = new AdminMarketplacesModel();
        $this->configEmpresaModel = new AdminConfigEmpresaModel();

        

        $this->token = "03372A9F41340662B04BF1964BA52D721B4F92E5";
        $this->callBack = "29A251222B17E4281A833E1EAED6C94C59BAFB02";
    }

    /**
     * @param string $holder_name
     * @param string $card_number
     * @param string $expiration_date
     * @param int $cvv
     * @return $this
     */
    public function conecao()
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = $this->endPoint = '';

        $response = $this->client->request('GET', $this->apiUrl.$endPoint, [
            "headers" => [
                "X-DV-Auth-Token" => $this->token
            ]
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        return $result;
    }

    public function listOrder(string $status)
    {
        //new
        // available
        // active
        // completed
        // reactivated
        // draft
        // canceled
        // delayed

        $endPoint = $this->endPoint = '/orders?status='.$status;

        $response = $this->client->request('GET', $this->apiUrl.$endPoint, [
            "headers" => [
                "X-DV-Auth-Token" => $this->token
            ]
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        return $result;
    }

    public function courierOrder(int $idPedido)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = $this->endPoint = '/courier?order_id='.$idPedido;

        $response = $this->client->request('GET', $this->apiUrl.$endPoint, [
            "headers" => [
                "X-DV-Auth-Token" => $this->token
            ]
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        return $result;
    }

    public function client()
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = $this->endPoint = '/client';

        $response = $this->client->request('GET', $this->apiUrl.$endPoint, [
            "headers" => [
                "X-DV-Auth-Token" => $this->token
            ]
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        return $result;
    }

    public function calculateOrder(string $enderecoCliente)
    {
        //$enderecoCliente = 'Av. Paulista, 1439 - 12 - Bela Vista, São Paulo - SP, 01310-100';

        $empresa = $this->configEmpresaModel->getById(1);
        $estado = $this->estadosModel->getById($empresa[':estado']);
        
        $endPoint = $this->endPoint = '/calculate-order';

        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl.$endPoint); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token: '.$this->token]); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        
        $data = [
            'matter' => "Documents",
            'total_weight_kg' => 0,
            'is_route_optimizer_enabled' => true,
            'payment_method' => "cash",
            'points' => [ 
                [ 
                    'address' => $empresa[':rua'].', '.$empresa[':numero'].' - '.$empresa[':bairro'].', '.$empresa[':cidade'].' - '.$estado['uf'].', '.$empresa[':cep'],
                ], 
                [ 
                    'address' => $enderecoCliente,
                ], 
            ], 
        ];
        
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
        
        $result = curl_exec($curl); 
        $result = json_decode($result);
        return $result;
    }


    public function createOrder(string $enderecoCliente, string $telefoneCliente)
    {
        $empresa = $this->configEmpresaModel->getById(1);
        $estado = $this->estadosModel->getById($empresa[':estado']);

        $numeroTelefone = preg_replace('/[^0-9]/', '', $telefoneCliente);
        $numeroTelefoneEmpresa = preg_replace('/[^0-9]/', '', $empresa[':telefone']);
        $ddi = 55;

        $endPoint = $this->endPoint = '/create-order';

        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl.$endPoint); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token: '.$this->token]); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        
        $data = [
            'matter' => "Documents",
            'total_weight_kg' => 0,
            'is_route_optimizer_enabled' => true,
            'payment_method' => "cash",
            'points' => [ 
                [ 
                    'address' => $empresa[':rua'].', '.$empresa[':numero'].' - '.$empresa[':bairro'].', '.$empresa[':cidade'].' - '.$estado['uf'].', '.$empresa[':cep'],
                    'contact_person' => [ 
                        'phone' => $ddi.$numeroTelefoneEmpresa, 
                    ], 
                ], 
                [ 
                    'address' => $enderecoCliente,
                    'contact_person' => [ 
                        'phone' => $ddi.$numeroTelefone, 
                    ], 
                ], 
            ], 
        ];
        
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
        
        $result = curl_exec($curl); 
        $result = json_decode($result);
        return $result;
    }


    public function cancelOrder(string $idPedido)
    {   
        $endPoint = $this->endPoint = '/cancel-order';

        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl.$endPoint); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token: '.$this->token]); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        
        $data = [ 
            'order_id' => $idPedido, 
        ]; 
        
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
        
        $result = curl_exec($curl); 
        $result = json_decode($result);
        return $result;
    }


    public function createDeliveries(string $enderecoCliente, string $telefoneCliente)
    {   
        $empresa = $this->configEmpresaModel->getById(1);
        $estado = $this->estadosModel->getById($empresa[':estado']);

        $numeroTelefone = preg_replace('/[^0-9]/', '', $telefoneCliente);
        $numeroTelefoneEmpresa = preg_replace('/[^0-9]/', '', $empresa[':telefone']);
        $ddi = 55;

        $endPoint = $this->endPoint = '/create-deliveries';

        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl.$endPoint); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token: '.$this->token]); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        
        $data = [
            'matter' => "Documents",
            'total_weight_kg' => 0,
            'is_route_optimizer_enabled' => true,
            'payment_method' => "cash",
            'points' => [ 
                [ 
                    'address' => $empresa[':rua'].', '.$empresa[':numero'].' - '.$empresa[':bairro'].', '.$empresa[':cidade'].' - '.$estado['uf'].', '.$empresa[':cep'],
                    'contact_person' => [ 
                        'phone' => $ddi.$numeroTelefoneEmpresa, 
                    ], 
                ], 
                [ 
                    'address' => $enderecoCliente,
                    'contact_person' => [ 
                        'phone' => $ddi.$numeroTelefone, 
                    ], 
                ], 
            ], 
        ]; 
        
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
        
        $result = curl_exec($curl); 
        $result = json_decode($result);
        return $result;
    }

    public function deleteDeliveries(string $idPedido)
    {   
        $endPoint = $this->endPoint = '/delete-deliveries';

        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl.$endPoint); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token: '.$this->token]); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        
        $data = [ 
            'delivery_ids' => $idPedido, 
        ]; 
        
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
        
        $result = curl_exec($curl); 
        $result = json_decode($result);
        return $result;
    }
    

    public function makeDeliveriesRoutes(object $deliveryId)
    {   
        $empresa = $this->configEmpresaModel->getById(1);
        $estado = $this->estadosModel->getById($empresa[':estado']);

        $endPoint = $this->endPoint = '/make-deliveries-routes';

        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl.$endPoint); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token: '.$this->token]); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        
        $data = [
            $data = [ 
                'start_point' => [ 
                    'address' => $empresa[':rua'].', '.$empresa[':numero'].' - '.$empresa[':bairro'].', '.$empresa[':cidade'].' - '.$estado['uf'].', '.$empresa[':cep'], 
                    'required_start_datetime' => '2021-05-13T01:05:59-03:00', 
                    'required_finish_datetime' => '2021-05-13T01:35:59-03:00', 
                ], 
                'deliveries' => [ 
                    ['delivery_id' => 11712], 
                    ['delivery_id' => 11713], 
                    ['delivery_id' => 11714], 
                    ['delivery_id' => 11715], 
                ],
            ] 
            ]; 
        
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); 
        
        $result = curl_exec($curl); 
        $result = json_decode($result);
        return $result;
    }

    public function listDeliveries(string $status)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = $this->endPoint = '/deliveries';

        $response = $this->client->request('GET', $this->apiUrl.$endPoint, [
            "headers" => [
                "X-DV-Auth-Token" => $this->token
            ]
        ]);

        $body = $response->getBody();
        $result = json_decode($body);

        return $result;
    }

}
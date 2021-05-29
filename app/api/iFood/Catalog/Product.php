<?php

namespace app\api\iFood\Catalog;

use app\core\Controller;
use app\Models\AdminMarketplacesModel;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class Product extends Controller
{

    private $marketplace;
    private $client;
    private $cache;
    private $resulifood;
    /**
     * Payment constructor.
     */
    public function __construct()
    {
        $this->marketplace = new AdminMarketplacesModel();
        $this->cache = new Cache();
        $this->client = new HTTP_Request2();
        $this->resulifood = $this->marketplace->getById(1);
    }

    /**
     * Product
     *
     * @return void
     */
    public function list(int $page, int $limit)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] . '/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/products?page=' . $page . '&limit=' . $limit;
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_GET);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token
        ));
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                return $response->getStatus();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function create(string $productId, string $productName, string $description)
    {
        //https://merchant-api.ifood.com.br/catalog/v1.0/merchants/6b487a27-c4fc-4f26-b05e-3967c2331882/products
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] . '/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/products';
        $token = $this->cache->read('tokenIfood');

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
            $this->client->setConfig(array('follow_redirects' => TRUE));
            $this->client->setHeader(array(
                'Authorization' => 'Bearer '.$token,
                'Content-Type' => 'application/json'
            ));
            $this->client->setBody('{
                "name": "' . $productName . '",
                "description": "' . $description . '",
                "externalCode": "BG-'.$productId.'",
                "image": "",
                "shifts": [
                  {
                    "startTime": "00:00",
                    "endTime": "23:59",
                    "monday": true,
                    "tuesday": true,
                    "wednesday": true,
                    "thursday": true,
                    "friday": true,
                    "saturday": true,
                    "sunday": true
                  }
                ],
                "status": "AVAILABLE",
                "price": {
                "value": 30
                },
                "optionGroups": false,
                "serving": "SERVES_1",
                "dietaryRestrictions": [
                  "ORGANIC"
                ],
                "ean": ""
               }');
            try {
                $response = $this->client->send();
                if ($response->getStatus() == 201) {
                    $body = $response->getBody();
                    return json_decode($body);
                } else {
                    return $response->getStatus();
                }
            } catch (HTTP_Request2_Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
    }

    public function update(string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] . '/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/products/' . $productId;
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod('PATCH');
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->setBody('{
            \n    "name": "Default Product",
            \n    "description": "Default Description",
            \n    "serving": "SERVES_1",
            \n    "dietaryRestrictions": [
            \n        "ORGANIC",
            \n        "VEGAN"
            \n    ],
            \n    "shifts": [
            \n        {
            \n            "startTime": "00:00",
            \n            "endTime": "23:59",
            \n            "monday": true,
            \n            "tuesday": true,
            \n            "wednesday": true,
            \n            "thursday": true,
            \n            "friday": true,
            \n            "saturday": true,
            \n            "sunday": true
            \n        }
            \n    ]
            \n}');
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                return $response->getStatus();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function delete(string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] . '/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/products/' . $productId;
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_DELETE);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token
        ));
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                return $response->getStatus();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function updateStatus(string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] . '/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/products/' . $productId . '/status';
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod('PATCH');
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->addPostParameter(array(
            'status' => 'AVAILABLE'
        ));
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                return $response->getStatus();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function batchUpdateStatus(string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] . '/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/products/status';
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod('PATCH');
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ));
        $this->client->setBody('[
            \n  {
            \n    "productId": ' . $productId . ',
            \n    "status": "AVAILABLE",
            \n    "resources": [
            \n      "ITEM",
            \n      "OPTION"
            \n    ]
            \n  }
            \n]');
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                return $response->getStatus();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function batchUpdatePrice(string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] . '/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/products/price';
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod('PATCH');
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->addPostParameter(array(
            'productId' => $productId,
            'price.value' => '1'
        ));
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                return $response->getStatus();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

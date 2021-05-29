<?php

namespace app\api\iFood\Catalog;

use app\core\Controller;
use app\Models\AdminMarketplacesModel;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class PizzaProduct extends Controller
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
     * Pizza Product
     *
     * @return void
     */
    public function list()
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/pizzas';
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
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function listToCategory(string $pizzaId, string $categoryId, string $catalogId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/pizzas/' . $pizzaId . '/categories/' . $categoryId;
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
        $this->client->setBody('{
            \n  "catalogId": ' . $catalogId . ',
            \n  "crusts": [
            \n    {
            \n      "id": "125fdc0d-6d31-421e-bb2a-6b8d2c90f681",
            \n      "price": {
            \n          "value": 1,
            \n          "originalValue": 2
            \n      }
            \n    }
            \n  ],
            \n  "edges": [
            \n    {
            \n      "id": "82037e4e-cd7f-4981-b02e-e22fad6a3027",
            \n      "price": {
            \n          "value": 1,
            \n          "originalValue": 2
            \n      }
            \n    }
            \n  ],
            \n  "toppings": [
            \n    {
            \n      "id": "11bbcb69-e3a0-442a-93c5-ba880047e813",
            \n      "prices": {
            \n          "value": 20,
            \n          "originalValue": 30
            \n      }
            \n    }
            \n  ]
            \n}');
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function create(string $name)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/pizzas';
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_POST);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->setBody('{
            \n    "sizes": [
            \n        {
            \n            "name": ' . $name . ',
            \n            "status": "AVAILABLE",
            \n            "slices": 8,
            \n            "acceptedFractions": [
            \n                1,
            \n                2
            \n            ]
            \n        }
            \n    ],
            \n    "crusts": [
            \n        {
            \n            "name": "Default Crust",
            \n            "status": "AVAILABLE"
            \n        }
            \n    ],
            \n    "edges": [
            \n        {
            \n            "name": "Default Edge",
            \n            "status": "AVAILABLE"
            \n        }
            \n    ],
            \n    "toppings": [
            \n        {
            \n            "name": "Default Topping",
            \n            "status": "AVAILABLE"
            \n        }
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
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function update(string $pizzaId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/pizzas/' . $pizzaId;
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_PUT);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->setBody('{
            \n    "sizes": [
            \n        {
            \n            "name": "Default Size",
            \n            "status": "AVAILABLE",
            \n            "slices": 8,
            \n            "acceptedFractions": [
            \n                1,
            \n                2
            \n            ]
            \n        }
            \n    ],
            \n    "crusts": [
            \n        {
            \n            "name": "Default Crust",
            \n            "status": "AVAILABLE"
            \n        }
            \n    ],
            \n    "edges": [
            \n        {
            \n            "name": "Default Edge",
            \n            "status": "AVAILABLE"
            \n        }
            \n    ],
            \n    "toppings": [
            \n        {
            \n            "name": "Default Topping",
            \n            "status": "AVAILABLE"
            \n        }
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
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function delete(string $pizzaId, string $categoryId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/pizzas/' . $pizzaId . '/categories/' . $categoryId;
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
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function updateStatus(string $pizzaId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/pizzas/' . $pizzaId;
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
            \n  "status": "AVAILABLE",
            \n  "sizeIds": [
            \n    "1c296c3c-e482-48d6-ba10-429f025a72fa"
            \n  ],
            \n  "crustIds": [
            \n    "125fdc0d-6d31-421e-bb2a-6b8d2c90f681"
            \n  ],
            \n  "edgeIds": [
            \n    "82037e4e-cd7f-4981-b02e-e22fad6a3027"
            \n  ],
            \n  "toppingIds": [
            \n    "11bbcb69-e3a0-442a-93c5-ba880047e813"
            \n  ]
            \n}');
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function batchUpdatePrice(string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/pizzas/price';
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_POST);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->setBody('{
            \n  "catalogId": "42baaf3e-939c-4387-bab6-3561dcae4b4c",
            \n  "crusts": [
            \n    {
            \n      "id": "125fdc0d-6d31-421e-bb2a-6b8d2c90f681",
            \n      "price": {
            \n          "value": 1,
            \n          "originalValue": 2
            \n      }
            \n    }
            \n  ],
            \n  "edges": [
            \n    {
            \n      "id": "82037e4e-cd7f-4981-b02e-e22fad6a3027",
            \n      "price": {
            \n          "value": 1,
            \n          "originalValue": 2
            \n      }
            \n    }
            \n  ],
            \n  "toppings": [
            \n    {
            \n      "id": "11bbcb69-e3a0-442a-93c5-ba880047e813",
            \n      "prices": {
            \n          "value": 20,
            \n          "originalValue": 30
            \n      }
            \n    }
            \n  ]
            \n}');
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                return json_decode($body);
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

<?php

namespace app\api\iFood\Catalog;

use app\core\Controller;
use app\Models\AdminMarketplacesModel;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class Item extends Controller
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
     * Item
     *
     * @return void
     */

    public function list(string $catalogId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/catalogs/' . $catalogId . '/categories';
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


    public function create($categoryId, $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/categories/' . $categoryId . '/products' . $productId;
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);

        $this->client->setMethod(HTTP_Request2::METHOD_POST);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ));
        $this->client->setBody('{
            "status": "AVAILABLE",
            "price": {
                "value": 0,
                "originalValue": 0
            },
            "externalCode": "BG-rrf",
            "index": 0,
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
            "optionGroups": false
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


    public function updateStatus(string $itemId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/items/' . $itemId . '/status';
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl(IFOOD['URL'] . $endPoint,);
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
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function update(string $categoryId, string $productId, string $name)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/categories/' . $categoryId . '/products/' . $productId;
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
        $this->client->setBody('{
            \n  "status": "AVAILABLE",
            \n  "price": {
            \n    "value": 20,
            \n    "originalValue": 30
            \n  },
            \n  "shifts": [
            \n    {
            \n      "startTime": "00:00",
            \n      "endTime": "23:59",
            \n      "monday": true,
            \n      "tuesday": true,
            \n      "wednesday": true,
            \n      "thursday": true,
            \n      "friday": true,
            \n      "saturday": true,
            \n      "sunday": true
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

    public function delete(string $categoryId, string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/categories/' . $categoryId . '/products/' . $productId;
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_DELETE);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Authorization' => 'Bearer ' . $token,
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
}

<?php

namespace app\api\iFood\Catalog;

use app\core\Controller;
use app\Models\AdminMarketplacesModel;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class Option extends Controller
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
     * Option
     *
     * @return void
     */

    public function create(string $optionGroupId, string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/optionGroups/' . $optionGroupId . '/products' . $productId . '/option';
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
                \n  "status": "AVAILABLE",
                \n  "price": {
                \n    "value": 20
                \n  }
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

    public function update(string $optionGroupId, string $productId, string $name)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/optionGroups/' . $optionGroupId . '/products/' . $productId . '/option';
        $token = $this->cache->read('tokenIfood');

        if ($token)
            $this->client->setUrl($endPoint);
        $this->client->setMethod('PATCH');
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

    public function delete(string $optionGroupId, string $productId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/optionGroups/' . $optionGroupId . '/products/' . $productId . '/option';
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
}

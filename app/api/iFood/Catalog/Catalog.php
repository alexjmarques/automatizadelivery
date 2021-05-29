<?php

namespace app\api\iFood\Catalog;

use app\core\Controller;
use app\Models\AdminMarketplacesModel;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class Catalog extends Controller
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
     * Catalogs
     *
     * @return void
     */
    public function catalogs()
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/catalogs';
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

    public function changelog(string $catalogId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/catalogs/' . $catalogId . '/changelog';
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

    public function unsellableItems(string $catalogId)
    {
        $merchantId = $this->resulifood[':idLoja'];
        $endPoint = IFOOD['URL'] .'/catalog/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/catalogs/' . $catalogId . '/unsellableItems';
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
}

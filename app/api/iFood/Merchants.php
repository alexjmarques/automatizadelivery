<?php

namespace app\api\iFood;

use app\core\Controller;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class Merchants extends Controller
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
        $this->cache = new Cache();
        $this->client = new HTTP_Request2();
    }

    

    /**
     * Merchants
     *
     * @return void
     */
    public function list()
    {
        $endPoint = IFOOD['URL'] .'/merchant/' . IFOOD['VERSION'] . '/merchants';
        $token = $this->cache->read("tokenIfood");

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_GET);
            $this->client->setConfig(array(
                'follow_redirects' => true
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


    public function listInterruptions(string $merchantId)
    {

        
        $endPoint = IFOOD['URL'] .'/merchant/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/interruptions';
        $token = $this->cache->read("tokenIfood");

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_GET);
            $this->client->setConfig(array(
                'follow_redirects' => true
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

    public function details(string $merchantId)
    {
        $endPoint = IFOOD['URL'] .'/merchant/' . IFOOD['VERSION'] . '/merchants/' . $merchantId;
        $token = $this->cache->read("tokenIfood");

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_GET);
            $this->client->setConfig(array(
                'follow_redirects' => true
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


    public function status(string $merchantId)
    {
        //2021-02-01
        $endPoint = IFOOD['URL'] .'/merchant/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/status';
        $token = $this->cache->read("tokenIfood");

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_GET);
            $this->client->setConfig(array(
                'follow_redirects' => true
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
                    unlink($token);
                    return $response->getStatus();
                }
            } catch (HTTP_Request2_Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
    }

    public function statusOperation(string $operation, string $merchantId)
    {
        //delivery
        $endPoint = IFOOD['URL'] .'/merchant/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/status/' . $operation;
        $token = $this->cache->read("tokenIfood");

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_GET);
            $this->client->setConfig(array(
                'follow_redirects' => true
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



    public function create(string $merchantId, string $description, string $start, string $end)
    {
        //'2021-03-01T12:10:00.000'
        $endPoint = IFOOD['URL'] .'/merchant/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/interruptions';
        $token = $this->cache->read("tokenIfood");

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
            $this->client->setConfig(array(
                'follow_redirects' => true
            ));
            $this->client->setHeader(array(
                'Authorization' => 'Bearer ' . $token
            ));

            $this->client->addPostParameter(array(
                'start' => $start,
                'end' => $end,
                'description' => $description
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

    public function delete(string $merchantId,string $interruptionId)
    {
        //'2021-03-01T12:10:00.000'
        $endPoint = IFOOD['URL'] .'/merchant/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/interruptions/' . $interruptionId;
        $token = $this->cache->read("tokenIfood");

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_DELETE);
            $this->client->setConfig(array(
                'follow_redirects' => true
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
}

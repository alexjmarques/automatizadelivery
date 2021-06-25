<?php

namespace app\api\iFood;

use app\core\Controller;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class Financial extends Controller
{
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
     * Financial
     *
     * @return void
     */
    public function grossRevenue(string $merchantId)
    {
        
        $endPoint = IFOOD['URL'] .'/financial/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/grossRevenue';
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

    public function dailyGrossRevenue(string $merchantId)
    {

        
        $endPoint = IFOOD['URL'] .'/financial/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/dailyGrossRevenue';
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


    public function sales(string $merchantId, string $dateBegin, string $dateEnd)
    {
        //2021-02-01
        
        $endPoint = IFOOD['URL'] .'/financial/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/sales?beginLastProcessingDate=' . $dateBegin . '&endLastProcessingDate=' . $dateEnd;
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

    public function payments(string $merchantId, string $dateBegin, string $dateEnd)
    {
        //2021-02-01
        
        $endPoint = IFOOD['URL'] .'/financial/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/payments?beginExpectedExecutionDate=' . $dateBegin . '&endExpectedExecutionDate=' . $dateEnd;
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

    public function occurrences(string $merchantId, string $dateBegin, string $dateEnd)
    {
        //2021-02-01
        
        $endPoint = IFOOD['URL'] .'/financial/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/occurrences?transactionDateBegin=' . $dateBegin . '&transactionDateEnd=' . $dateEnd;
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

    public function maintenanceFees(string $merchantId, string $dateBegin, string $dateEnd)
    {
        //2021-02-01
        
        $endPoint = IFOOD['URL'] .'/financial/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/maintenanceFees?transactionDateBegin=' . $dateBegin . '&transactionDateEnd=' . $dateEnd;
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

    public function incomeTaxes(string $merchantId, string $dateBegin, string $dateEnd)
    {
        //2021-02-01
        
        $endPoint = IFOOD['URL'] .'/financial/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/incomeTaxes?transactionDateBegin=' . $dateBegin . '&transactionDateEnd=' . $dateEnd;
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

    public function chargeCancellations(string $merchantId, string $dateBegin, string $dateEnd)
    {
        //2021-02-01
        
        $endPoint = IFOOD['URL'] .'/financial/' . IFOOD['VERSION'] . '/merchants/' . $merchantId . '/chargeCancellations?transactionDateBegin=' . $dateBegin . '&transactionDateEnd=' . $dateEnd;
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
}

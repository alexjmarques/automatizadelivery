<?php

namespace app\api\iFood;

use app\core\Controller;
use app\Models\AdminMarketplacesModel;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class Order extends Controller
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
     * Order Events
     *
     * @return void
     */
    public function eventsPolling()
    {
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/events:polling';
        $token = $this->cache->read('tokenIfood');

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
    public function eventsAcknowledge()
    {
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/events/acknowledgment';
        $token = $this->cache->read('tokenIfood');

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
            $this->client->setConfig(array(
                'follow_redirects' => true
            ));
            $this->client->setHeader(array(
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ));
            $this->client->setBody('[]');
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
    /**
     * Order Details
     *
     * @param string $orderId
     * @return void
     */
    public function orderDetails(string $orderId)
    {
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/orders/' . $orderId;
        $token = $this->cache->read('tokenIfood');

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
    /**
     * Order Actions
     *
     * @param string $orderId
     * @return void
     */
    public function actionsConfirm(string $orderId)
    {
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/orders/' . $orderId . '/confirm';
        $token = $this->cache->read('tokenIfood');

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
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

    public function readyToPickup(string $orderId)
    {
        
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/orders/' . $orderId . '/readyToPickup';
        $token = $this->cache->read('tokenIfood');

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
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



    public function dispatch(string $orderId)
    {
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/orders/' . $orderId . '/dispatch';
        $token = $this->cache->read('tokenIfood');

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
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

    public function requestCancellation(string $orderId, string $clientId, string $cancellationCode, string $cancellationReason)
    {
        //'75e08a83-c4b8-4c88-834b-a927ca5cbc0f'
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/orders/' . $orderId . '/requestCancellation';
        $token = $this->cache->read('tokenIfood');

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
            $this->client->setConfig(array(
                'follow_redirects' => true
            ));
            $this->client->setHeader(array(
                'Authorization' => 'Bearer ' . $token,
                'x-client-id' => $clientId,
                'Content-Type' => 'application/json'
            ));

            $this->client->setBody('{\n"cancellationCode": '.$cancellationCode. ',\n    "reason": '.$cancellationReason.'\n}');
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


    public function acceptCancellation(string $orderId)
    {
        //'75e08a83-c4b8-4c88-834b-a927ca5cbc0f'
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/orders/' . $orderId . '/acceptCancellation';
        $token = $this->cache->read('tokenIfood');

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
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

    public function denyCancellation(string $orderId)
    {
        //'75e08a83-c4b8-4c88-834b-a927ca5cbc0f'
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/orders/' . $orderId . '/denyCancellation';
        $token = $this->cache->read('tokenIfood');

        if ($token) {
            $this->client->setUrl($endPoint);
            $this->client->setMethod(HTTP_Request2::METHOD_POST);
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


    /**
     * Order Delivery
     *
     * @param string $orderId
     * @return void
     */
    public function tracking(string $orderId)
    {
        $endPoint = IFOOD['URL'] .'/order/' . IFOOD['VERSION'] . '/orders/' . $orderId . '/tracking';
        $token = $this->cache->read('tokenIfood');

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
}

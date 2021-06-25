<?php

namespace app\api\iFood;

use app\core\Controller;
use HTTP_Request2;
use HTTP_Request2_Exception;
use app\classes\Cache;

class Authetication extends Controller
{
    private $cache;
    private $client;
    /**
     * Payment constructor.
     */
    public function __construct()
    {
        $this->cache = new Cache();
        $this->client = new HTTP_Request2();
    }

    /**
     * Authentication
     *
     * @return void
     */
    public function autorizarCliente()
    {
        $endPoint = IFOOD['URL'] .'/authentication/' . IFOOD['VERSION'] . '/oauth/userCode';

        $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_POST);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->addPostParameter(array(
            'clientId' => IFOOD['CLIENT_ID']
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
            return 'Error: ' . $e->getMessage();
        }
    }

    public function gerarToken(int $empresa)
    {
        $endPoint = IFOOD['URL'] .'/authentication/' . IFOOD['VERSION'] . '/oauth/token';
        $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_POST);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        
        $this->client->setHeader(array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->addPostParameter(array(
            'grantType' => "client_credentials",
            'clientId' => IFOOD['CLIENT_ID'],
            'clientSecret' => IFOOD['CLIENT_SECRET']
        ));
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                $result = json_decode($body);
                return $this->cache->save("tokenIfood-{$empresa}", $result->accessToken, '6 hours');
            } else {
                return $response->getStatus();
            }
        } catch (HTTP_Request2_Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    // public function gerarToken(int $empresa, string $user, string $authorization)
    // {
    //     //dd($user);
    //     $endPoint = IFOOD['URL'] .'/authentication/' . IFOOD['VERSION'] . '/oauth/token';
    //     $this->client->setUrl($endPoint);
    //     $this->client->setMethod(HTTP_Request2::METHOD_POST);
    //     $this->client->setConfig(array(
    //         'follow_redirects' => TRUE
    //     ));
    //     $this->client->setHeader(array(
    //         'Content-Type' => 'application/x-www-form-urlencoded'
    //     ));
    //     $this->client->addPostParameter(array(
    //         'grantType' => "authorization_code",
    //         'clientId' => IFOOD['CLIENT_ID'],
    //         'clientSecret' => IFOOD['CLIENT_SECRET'],
    //         'authorizationCode' => $user,
    //         'authorizationCodeVerifier' => $authorization
    //     ));
    //     try {
    //         $response = $this->client->send();
    //         if ($response->getStatus() == 200) {
    //             $body = $response->getBody();
    //             $result = json_decode($body);
    //             return $this->cache->save("tokenIfood-{$empresa}", $result->accessToken, '6 hours');
    //         } else {
    //             return $response->getStatus();
    //         }
    //     } catch (HTTP_Request2_Exception $e) {
    //         return 'Error: ' . $e->getMessage();
    //     }
    // }

    public function refreshToken(int $empresa, string $user, string $authorization)
    {
        $endPoint = IFOOD['URL'] .'/authentication/' . IFOOD['VERSION'] . '/oauth/token';
        $token = $this->cache->read("tokenIfood-{$empresa}");
        $this->client->setUrl($endPoint);
        $this->client->setMethod(HTTP_Request2::METHOD_POST);
        $this->client->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->client->setHeader(array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        ));
        $this->client->addPostParameter(array(
            'grantType' => "refresh_token",
            'clientId' => IFOOD['CLIENT_ID'],
            'clientSecret' => IFOOD['CLIENT_SECRET'],
            'authorizationCode' => $user,
            'authorizationCodeVerifier' => $authorization,
            'refreshToken' => $token
        ));
        try {
            $response = $this->client->send();
            if ($response->getStatus() == 200) {
                $body = $response->getBody();
                $result = json_decode($body);
                $this->cache->save("tokenIfood-{$empresa}", $result->accessToken, '60 hours');
            } else {
                return $response->getStatus();
            }
        } catch (HTTP_Request2_Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}

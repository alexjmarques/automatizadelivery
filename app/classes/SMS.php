<?php

namespace app\classes;

use app\core\Controller;
use Twilio\Rest\Client;

class SMS extends Controller
{
    public function __construct()
    {
        $this->sms = new Client();
    }

    public function envioSMS(string $para, string $mensagem)
    {
        $account_sid = TWILIO['clientId'];
        $auth_token = TWILIO['secrettId'];

        $twilio_number = "+19096555675";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $para,
            array(
            'from' => $twilio_number,
            'body' => $mensagem
        )
        );
    }
}

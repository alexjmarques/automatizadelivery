<?php

namespace app\classes;

use app\core\Controller;
use app\classes\Preferencias;
use app\controller\AllController;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;

class SMS extends Controller
{
    private $urlApi;
    private $tokenBasic;

    /**
     * 
     * Metodo Construtor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->urlApi = "https://messaging.o2c.cloud/api/v2/sms/";
        $this->token = "7f266a9cf9c11939c09f9d549f6bbcd6e1120476";

        $this->tokenBasic = "automatiza:02W@9889forev";
        $this->preferencias = new Preferencias();
        $this->allController = new AllController();
        $this->configEmpresaModel = new AdminConfigEmpresaModel();
    }

    public function envioSMS(string $para, string $mensagem)
    {
        $curl = curl_init();
        $data = [
            "sendSmsRequest" => [
                "to" => $para,
                "message" => $mensagem
            ],
        ];

        $tokenBasic = base64_encode($this->tokenBasic);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->urlApi,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".$tokenBasic."",
                "Content-Type: application/json",
                "Accept: application/json"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}

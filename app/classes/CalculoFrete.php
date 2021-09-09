<?php

namespace app\classes;

use app\core\Controller;
use app\classes\Acoes;
use app\Models\AdminConfigEmpresaModel;
use DElfimov\Translate\Translate;
use DElfimov\Translate\Loader\PhpFilesLoader;

class CalculoFrete extends Controller
{

    private $acoes;

    /**
     * 
     * Metodo Construtor
     * 
     * @return void
     */
    public function __construct()
    {

        $this->acoes = new Acoes();
    }

    public function number_format_short( $n, $precision = 1 ) {
        if ($n < 90) {
            $n_format = number_format($n / 10, $precision);
            $suffix = '';
        } else if ($n < 999) {
            $n_format = 1;
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
    
      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
    
        return $n_format;
    }

    /**
     * Calcular rota de entrega
     *
     * @param  string $param
     * @param  int $filter
     * @return mixed
     */
    public function calculo(string $rua, string $numero, string $bairro, string $cep, int $id_empresa)
    {
        $resultEmpresa = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $id_empresa);

        $empresa = $resultEmpresa->rua . ' ' . $resultEmpresa->numero . ' ' . $resultEmpresa->bairro;
        $cliente = $rua . ' ' . $numero . ' ' . $bairro . ' ' . $cep;

        $empresa = urlencode($empresa);
        $cliente = urlencode($cliente);
        $data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $empresa . '&destinations=' . $cliente . '&language=pt-BR&sensor=false&mode=driving&language=pt-BR&key=AIzaSyAxhvl-7RHUThhX4dNvCGEkPuOoT6qbuDQ'); //&key=AIzaSyDAJ05io1966D_KmF7lbRsucehr8GtUBqk');
        $data = json_decode($data);
        $time = 0;
        $text = 0;
        $distance = 0;
        foreach ($data->rows[0]->elements as $road) {
            $time += $road->duration->value;
            $text = $road->distance->text;
            $distance += $road->distance->value;
        }
        //dd($distance);
        return $this->number_format_short($distance);
        //return $distance;
    }

    public function infoKm(string $rua, string $numero, string $bairro, string $cep, int $id_empresa)
    {
        $resultEmpresa = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $id_empresa);
        $empresa = $resultEmpresa->rua . ' ' . $resultEmpresa->numero . ' ' . $resultEmpresa->bairro;
        $cliente = $rua . ' ' . $numero . ' ' . $bairro . ' ' . $cep;

        $empresa = urlencode($empresa);
        $cliente = urlencode($cliente);
        $data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $empresa . '&destinations=' . $cliente . '&language=pt-BR&sensor=false&mode=driving&language=pt-BR&key=AIzaSyAxhvl-7RHUThhX4dNvCGEkPuOoT6qbuDQ'); //&key=AIzaSyDAJ05io1966D_KmF7lbRsucehr8GtUBqk');
        $data = json_decode($data);
        $time = 0;
        $text = 0;
        $distance = 0;
        foreach ($data->rows[0]->elements as $road) {
            $time += $road->duration->value;
            $text = $road->distance->text;
            $distance += $road->distance->value;
        }

        return $text;
    }
}

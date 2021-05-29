<?php

namespace app\classes;

class Estados
{

    /**
     * Retorna um valor via parâmetro get
     *
     * @param  string $param
     * @param  int $filter
     * @return mixed
     */
    public static function uf(int $id)
    {
        switch ($id) {
            case 1:
                return 'AC';
                break;
            case 2:
                return 'AL';
                break;
            case 3:
                return 'AM';
                break;
            case 4:
                return 'AP';
                break;
            case 5:
                return 'BA';
                break;
            case 6:
                return 'CE';
                break;
            case 7:
                return 'DF';
                break;
            case 8:
                return 'ES';
                break;
            case 9:
                return 'GO';
                break;
            case 10:
                return 'MA';
                break;
            case 11:
                return 'MG';
                break;
            case 12:
                return 'MS';
                break;
            case 13:
                return 'MT';
                break;
            case 14:
                return 'PA';
                break;
            case 15:
                return 'PB';
                break;
            case 16:
                return 'PE';
                break;
            case 17:
                return 'PI';
                break;
            case 18:
                return 'PR';
                break;
            case 19:
                return 'RJ';
                break;
            case 20:
                return 'RN';
                break;
            case 21:
                return 'RO';
                break;
            case 22:
                return 'RR';
                break;
            case 23:
                return 'RS';
                break;
            case 24:
                return 'SC';
                break;
            case 25:
                return 'SE';
                break;
            case 26:
                return 'SP';
                break;
            case 27:
                return 'TO';
                break;
            case 99:
                return 'EX';
                break;
        }
    }
}

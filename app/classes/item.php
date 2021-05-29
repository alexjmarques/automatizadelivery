<?php

namespace app\classes;

use app\core\Controller;

class item extends Controller
{

    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '')
    {
        $this->name = $name;
        $this->price = $price;
        $this->dollarSign = $dollarSign;
    }
    
    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 38;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;
        
        $sign = ($this -> dollarSign ? 'R$ ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}

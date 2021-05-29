<?php

namespace app\classes;

class Preferencias
{

    /**
     * Preferencias do Projeto
     *
     * @param  string $param
     * @param  int $filter
     * @return mixed
     */
    public static function cor()
    {
        return COR;
    }
    
    public static function corSecundaria()
    {
        return CORSECUNDARIA;
    }

    public static function sabores()
    {
        return SABORES;
    }

    public static function sabor()
    {
        return SABOR;
    }
}

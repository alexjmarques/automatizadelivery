<?php

namespace app\classes;

class Dispositivo
{

    /**
     * Retorna um valor via parâmetro get
     *
     * @param  string $param
     * @param  int $filter
     * @return mixed
     */
    public static function tipo()
    {
        $mobile = FALSE;
        $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric", "X-Frame-Options: SAMEORIGIN");
        foreach($user_agents as $user_agent){
            if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
                $mobile = TRUE;
                $modelo	= $user_agent;
            break;
            }
        }
        return $mobile;
    }
}

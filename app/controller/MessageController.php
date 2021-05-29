<?php

namespace app\controller;

use app\core\Controller;

class MessageController extends Controller
{
    public function message(string $title, string $message, $code = 404)
    {
        http_response_code($code);
        
        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('message/main', [
            'title' => $title,
            'message' => $message,
            
        ]);
    }
}

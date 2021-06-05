<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\core\Controller;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\classes\Sessao;
use Browser;
use Mobile_Detect;

class InstitucionalController extends Controller
{
    private $acoes;
    private $sessao;
    private $geral;
    private $trans;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->trans = new Translate(new PhpFilesLoader("../app/language"), ["default" => "pt_BR"]);
        $this->sessao = new Sessao();
        $this->geral = new AllController();
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }

    public function index($data)
    {
        dd($data);
        $this->load('_geral/quem-somos/sobre', [
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function termosUso($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }
        $this->load('_geral/termosUso/main', [
            'empresa' => $empresa,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()
        ]);
    }

    public function politicaPrivacidade($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        }
        $this->load('_geral/politicaPrivacidade/main', [
            'empresa' => $empresa,
            'enderecoAtivo' => $enderecoAtivo,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()
        ]);
    }

    

    public function visaoValores($data)
    {
        $this->load('home/visaoValores', [
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function trabalheConosco($data)
    {
        $this->load('home/trabalheConosco', [
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function contatoConosco($data)
    {
        $this->load('home/contato', [
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    

    
}

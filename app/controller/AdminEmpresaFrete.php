<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\core\Controller;
use app\api\iFood\Authetication;
use DElfimov\Translate\Loader\PhpFilesLoader;
use DElfimov\Translate\Translate;
use app\controller\AllController;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\classes\Sessao;
use app\Models\EmpresaFrete;

class AdminEmpresaFrete extends Controller
{
    //Instancia da Classe AdminConfigEmpresaModel
    
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
        //$this->ifood = new iFood();
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $retorno = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }
        
        $this->load('_admin/configuracao/delivery', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_inicio,
        ]);
    }

    public function update($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $retorno = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);

        $valor = (new EmpresaFrete())->findById($retorno->id);
        $valor->previsao_minutos = Input::post('previsao_minutos');
        $valor->taxa_entrega = $this->geral->brl2decimal(Input::post('taxa_entrega'));
        $valor->km_entrega = Input::post('km_entrega');
        $valor->km_entrega_excedente = Input::post('km_entrega_excedente');
        $valor->valor_excedente = $this->geral->brl2decimal(Input::post('valor_excedente'));
        $valor->taxa_entrega_motoboy = $this->geral->brl2decimal(Input::post('taxa_entrega_motoboy'));
        $valor->valor = $this->geral->brl2decimal(Input::post('valor'));
        $valor->frete_status = Input::post('frete_status');
        $valor->primeira_compra = Input::post('switch');

        $valor->id_empresa = Input::post('id_empresa');
        $valor->save();
        
        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id,'resp' => 'update','mensagem' => 'Dados de Entrega atualizado com sucesso','error' => 'Não foi possível atualizar os dados de entrega','url' => 'admin/conf/delivery/e',]);
        exit($json);

    }


}

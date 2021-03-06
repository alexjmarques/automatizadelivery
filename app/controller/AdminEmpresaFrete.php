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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $retorno = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                if ($this->sessao->getNivel() == 3) {
                    redirect(BASE . $empresa->link_site);
                }
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/configuracao/delivery', [
            'retorno' => $retorno,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario' => $this->sessao->getNivel(),
            'caixa' => $caixa->status,
        ]);
    }

    public function update($data)
    {
        //dd($data);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $retorno = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);

        if ($data['frete_status']) {
            $frete_status = $data['frete_status'];
        } else {
            $frete_status = 0;
        }

        if ($data['switch']) {
            $primeira_compra = $data['switch'];
        } else {
            $primeira_compra = 0;
        }

        $valor = (new EmpresaFrete())->findById($retorno->id);
        $valor->previsao_minutos = $data['previsao_minutos'];
        $valor->taxa_entrega = $this->geral->brl2decimal($data['taxa_entrega']);
        $valor->km_entrega = $data['km_entrega'];
        $valor->taxa_entrega2 = $this->geral->brl2decimal($data['taxa_entrega2']);
        $valor->km_entrega2 = $data['km_entrega2'];
        $valor->taxa_entrega3 = $this->geral->brl2decimal($data['taxa_entrega3']);
        $valor->km_entrega3 = $data['km_entrega3'];
        $valor->km_entrega_excedente = $data['km_entrega_excedente'];
        $valor->valor_excedente = $this->geral->brl2decimal($data['valor_excedente']);
        $valor->taxa_entrega_motoboy = $this->geral->brl2decimal($data['taxa_entrega_motoboy']);
        $valor->valor = $this->geral->brl2decimal($data['valor']);
        $valor->frete_status = $frete_status;
        $valor->primeira_compra = $primeira_compra;
        $valor->save();
        //print_r($valor);

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Dados de Entrega atualizado com sucesso', 'error' => 'N??o foi poss??vel atualizar os dados de entrega', 'code' => 2,  'url' => 'admin/conf/delivery/e',]);
        exit($json);
    }
}

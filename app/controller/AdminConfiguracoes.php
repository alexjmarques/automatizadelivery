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
use app\Models\Empresa;
use app\Models\EmpresaEnderecos;
use app\Models\EmpresaFrete;

class AdminConfiguracoesController extends Controller
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
        $endereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $moedas = $this->acoes->getFind('moeda');
        $estadosSelecao = $this->acoes->getFind('estados');
        $diaSelecao = $this->acoes->getFind('dias');

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

        $this->load('_admin/configuracao/main', [
            'endereco' => $endereco,
            'moedas' => $moedas,
            'estadosSelecao' => $estadosSelecao,
            'dias' => $diaSelecao,
            'planoAtivo' => $planoAtivo,
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
        $nf_paulista = $data['switch'] ? $data['switch'] : 0;
        $diasSelecionados = $_POST['dias'] ? implode(',', $_POST['dias']) : null;

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $retorno = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);

        $files = $_FILES;
        $file = $files["capa"];
        if (!empty($file["name"])) {
            $upload = new \CoffeeCode\Uploader\Image(UPLOADS_BASE, "images");
            try {
                $uploaded = $upload->upload($file, $file["name"]);
                $partes = explode("/uploads", $uploaded);
                $capa = $partes[1];
            } catch (\Exception $e) {
                echo "<p>(!) {$e->getMessage()}</p>";
            }
        } else {
            $capa = $data['imagemNomeCapa'];
        }

        $valor = (new Empresa())->findById($empresa->id);
        $valor->nome_fantasia = $data['nomeFantasia'];
        $valor->id_moeda = $data['moeda'];
        $valor->telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
        $valor->sobre = $data['sobre'];
        $valor->logo = $data['imagemNome'];
        $valor->capa = $capa;
        $valor->dias_atendimento = $diasSelecionados;
        $valor->email_contato = $data['email_contato'];
        $valor->nf_paulista = $nf_paulista;
        $valor->save();


        if ($valor->id > 0) {

            $valorEnd = (new EmpresaEnderecos())->findById($retorno->id);
            $valorEnd->cep = $data['cep_end'];
            $valorEnd->rua = $data['rua_end'];
            $valorEnd->numero = $data['numero_end'];
            $valorEnd->complemento = $data['complemento_end'];
            $valorEnd->bairro = $data['bairro_end'];
            $valorEnd->cidade = $data['cidade_end'];
            $valorEnd->estado = $data['estado_end'];
            $valorEnd->save();

            //dd($valorEnd);
            header('Content-Type: application/json');
            $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Configura????es da empresa atualizada com sucesso', 'error' => 'N??o foi pos??vel atualizar as informa????es da sua empresa', 'code' => 2,  'url' => 'admin/conf/e',]);
            exit($json);
        }
    }
}

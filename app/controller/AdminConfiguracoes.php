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
        $endereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        
        $moedas = $this->acoes->getFind('moeda');
        $estadosSelecao = $this->acoes->getFind('estados');
        $diaSelecao = $this->acoes->getFind('dias');
        
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() != 0) {
                redirect(BASE . $empresa->link_site);
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
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario'=> $this->sessao->getNivel(),
            'caixa' => $estabelecimento[0]->data_inicio,

        ]);
    }

    public function update($data)
    {
        if($data['imagemNome'] != null){
            $caminhoLogo = $data['imagemNome'];
        }else{
            $caminhoLogo = $data['logoUpdate'];
        }

        if($data['switch']){
            $nf_paulista = $data['switch'];
        }else{
            $nf_paulista = 0;
        }

        if ($_FILES['capa']['name'] != "") {
            $extensao = pathinfo($_FILES['capa']['name']);
            $extensao = "." . $extensao['extension'];
            $capa = time() . uniqid(md5('automatizaApp')) . $extensao;

            $caminhoCapaSalv = UPLOADS_BASE . $capa;
            $caminhoCapa = $capa;
            $capaTemp = $_FILES['capa']['tmp_name'];
            move_uploaded_file($capaTemp, $caminhoCapaSalv);
        } else {
            $caminhoCapa = $data['capaUpdate'];
        }

        $diasSt = $_POST['dias'];
        if ($diasSt != null) {
            $diasSelecionados = implode(',', $diasSt);
        }

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $retorno = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);

        $valor = (new Empresa())->findById($empresa->id);
        $valor->nome_fantasia = $data['nomeFantasia'];
        $valor->id_moeda = $data['moeda'];
        $valor->telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
        $valor->sobre = $data['sobre'];
        $valor->logo = $caminhoLogo;
        $valor->capa = $caminhoCapa;
        $valor->dias_atendimento = $diasSelecionados;
        $valor->email_contato = $data['email_contato'];
        $valor->nf_paulista = $nf_paulista;
        $valor->save();


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
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Configurações da empresa atualizada com sucesso', 'error' => 'Não foi posível atualizar as informações da sua empresa', 'url' => 'admin/conf/e',]);
        exit($json);
    }
}

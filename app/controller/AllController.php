<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\core\Controller;
use app\api\iFood\Authetication;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\classes\Sessao;
use app\Models\EmpresaCaixa;
use app\Models\EmpresaFrete;
use Twilio\Rest\Client;
use Bcrypt\Bcrypt;

class AllController extends Controller
{
    //Instancia da Classe Adminempresa
    
    private $acoes;
    private $sessao;
    private $bcrypt;
    private $trans;
    private $sms;

    /**
     *
     * Metodo Construtor
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->bcrypt = new Bcrypt();
        //$this->ifood = new iFood();
        $this->sessao = new Sessao();
        $this->acoes = new Acoes();
    }

    public function verificaPlano($data)
    {
        $assinatura = $this->acoes->getByFieldTwo('assinatura', 'status', 'paid','id_empresa', $data);
        $plano = 0;
        if ($assinatura->plano_id != null) {
            $getPlanId = $this->acoes->getByField('planos', 'plano_id', $assinatura->plano_id);
            $plano = $getPlanId->id;
        }
        return $plano;
    }

    public function verificaPlanoLimit($data)
    {
        $assinatura = $this->acoes->getByField('assinatura', 'id_empresa', $data);
        $limitPlano = 0;
        if ($assinatura->id) {
            $getPlanId = $this->acoes->getByField('planos', 'plano_id', $assinatura->plano_id);
            $limitPlano = $getPlanId->limit;
        }
        return $limitPlano;
    }

    public function sair($data)
    {
        $empresa = $data['linkSite'] ? $data['linkSite'] : "";
        $this->sessao->sair($empresa);
    }

    public function sairAdmin($data)
    {
        $empresa = $data['linkSite'] ? $data['linkSite'] : "";
        $this->sessao->sair($empresa);
    }

    public function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';

        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;

        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

    public function verificaNivel($data)
    {
        if (is_int($data)) {
            $empresaAct = $this->acoes->getByField('empresa', 'id', $data);;
        } else {
            $empresaAct = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        }

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 0) {
                redirect(BASE . "{$empresaAct->link_site}/admin");
            } else if ($this->sessao->getNivel() == 1) {
                redirect(BASE . "{$empresaAct->link_site}/motoboy/entregas");
            } else if ($this->sessao->getNivel() == 2) {
                redirect(BASE . "{$empresaAct->link_site}/admin");
            } else if ($this->sessao->getNivel() == 3) {
                if ($this->sessao->getUser() == 0) {
                } else {
                    $resulEnderecos = $this->acoes->countCompanyVar('usuariosEmpresa','id_empresa', $empresaAct->id, 'id_usuario', $this->sessao->getUser());
                    if ($resulEnderecos == 0) {
                        redirect(BASE . "{$empresaAct->link_site}/endereco/novo/cadastro");
                    } else {
                        redirect(BASE . $empresaAct->link_site);
                    }
                }
            }
        }
    }

    public function verificaAdmin($data)
    {
        if (is_int($data)) {
            $empresaAct = $this->acoes->getByField('empresa', 'id', $data);;
        } else {
            $empresaAct = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        }

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 0) {
            } else if ($this->sessao->getNivel() == 1) {
                redirect(BASE . "{$empresaAct->link_site}/motoboy/entregas");
            } else if ($this->sessao->getNivel() == 2) {
                redirect(BASE . "{$empresaAct->link_site}/admin");
            } else if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresaAct->link_site);
            }
        }
    }

    public function verificaLogin($data)
    {
        if (is_int($data)) {
            $empresaAct = $this->acoes->getByField('empresa', 'id', $data);;
        } else {
            $empresaAct = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        }

        if ($this->sessao->getUser())
            redirect(BASE . $empresaAct->link_site . '/login');
    }
    public function verificaLoginAdm($data)
    {
        if (is_int($data)) {
            $empresaAct = $this->acoes->getByField('empresa', 'id', $data);;
        } else {
            $empresaAct = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        }

        if ($this->sessao->getUser())
            redirect(BASE . $empresaAct->link_site . '/admin/login/');
    }

    public function verificaEstabelecimento($data)
    {
        if (is_int($data)) {
            $empresaAct = $this->acoes->getByField('empresa', 'id', $data);;
        } else {
            $empresaAct = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        }

        $resultEstab = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresaAct->id);

        if ($resultEstab->status == 1) {
            //$this->iFoods->available();
            return 1;
        } else {
            //$this->iFoods->unavailable("Estabelecimento Fechado");
            return 0;
        }
    }

    public function verificaPrimeiroAcesso($data)
    {
        if (is_int($data)) {
            $empresaAct = $this->acoes->getByField('empresa', 'id', $data);;
        } else {
            $empresaAct = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        }

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            $resulEnderecos = $this->acoes->countCompanyVar('usuariosEmpresa', 'id_empresa',$empresaAct->id, 'id_usuario', $this->sessao->getUser());
            if ($resulEnderecos == 0) {
                redirect(BASE . "{$empresaAct->link_site}/endereco/novo/cadastro");
                exit;
            }
        }
    }

    public function brl2decimal($brl, $casasDecimais = 2) {
        if(preg_match('/^\d+\.{1}\d+$/', $brl))
            return (float) number_format($brl, $casasDecimais, '.', '');
        $brl = preg_replace('/[^\d\.\,]+/', '', $brl);
        $decimal = str_replace('.', '', $brl);
        $decimal = str_replace(',', '.', $decimal);
        return (float) number_format($decimal, $casasDecimais, '.', '');
    }

    function formataTelefone($numero){
        $formata = substr($numero, 0, 2);
        $formata_2 = substr($numero, 3, 5);
        $formata_3 = substr($numero, 4, 4);
        return "(".$formata.") " . $formata_2 . "-". $formata_3;
     }


    public function iniciarAtendimento($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $planoAtivo = $this->verificaPlano($empresa->id);
        
        if ($planoAtivo == 4) {
            $resulifood = $this->marketplace->getById(1);
            $conecao = $this->ifood->gerarToken();
        }

        if ($planoAtivo == 0) {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Você não possuí um plano contratado', 'error' => 'Você não possuí um plano contratado', 'url' => 'admin/planos']);
            exit($json);
        }

        $plano = $this->acoes->getByField('planos', 'plano_id', $planoAtivo);

        if ($plano->id <= 2) {
            $qtdPedidos = $this->acoes->countStatusMes('carrinhoPedidos', 'id_empresa', $empresa->id, 'data_pedido');
            if ($plano->limite < $qtdPedidos) {
                header('Content-Type: application/json');
                $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Você ultrapassou o limite contratado para este mês', 'error' => 'Você ultrapassou o limite contratado para este mês', 'url' => 'admin/planos']);
                exit($json);
                exit;
            }
        }

        // if ($planoAtivo->status) {
        //     $pagarme = new \PagarMe\Client(pagarme_api_key);
        //     $subscription = $pagarme->subscriptions()->get([
        //         'id' => $planoAtivo->subscription_id
        //     ]);

        //     if ($subscription->current_transaction->status == $planoAtivo->status) {

        //         $statusDiario = $this->assinaturaModel->update($subscription->current_transaction->status, $planoAtivo->id);
        //     } else {
        //         $statusDiario = $this->assinaturaModel->update($subscription->current_transaction->status, $planoAtivo->id);
        //         echo 'Não foi possível processar seu pagamento, atualize os dados de seu cartão!';
        //         exit;
        //     }
        // }

        $caixa = new EmpresaCaixa();
        $caixa->data_inicio = date('Y-m-d');
        $caixa->hora_inicio = date('H:m:s');
        $caixa->id_empresa = $empresa->id;
        $caixa->save();

        $valor = (new EmpresaFrete())->findById($delivery->id);
        $valor->status = 1;
        $valor->save();


        header('Content-Type: application/json');
        $json = json_encode(['id' => $caixa->id, 'resp' => 'insert', 'mensagem' => 'Atendimento iniciado com sucesso', 'error' => 'Não foi possível iniciar o atendimento']);
        exit($json);
    }


    public function finalizarAtendimento($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $delivery = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');

        $caixa = (new EmpresaCaixa())->findById($estabelecimento->id);
        $caixa->data_inicio = date('Y-m-d');
        $caixa->hora_inicio = date('H:m:s');
        $caixa->id_empresa = $empresa->id;
        $caixa->save();

        $valor = (new EmpresaFrete())->findById($delivery->id);
        $valor->status = 0;
        $valor->save();

        echo "Atendimento finalizado com sucesso";
        $_SESSION['caixaAtendimento'] = 0;
        unset($_SESSION['caixaAtendimento']);

        //$resulifood == null ? '' : $this->ifoodAuthetication->refreshToken();
    }

    public function verificaEmpresaUser(int $idEmpresa, int $idUsuario)
    {
        $usuario = $this->acoes->getByField('usuariosEmpresa', 'id_usuario', $idUsuario);
        if($usuario){
            $empresa = $this->acoes->getByField('empresa', 'id', $usuario->id_empresa);
            if($idEmpresa != $empresa->id_empresa){
                dd($empresa->id_empresa);
                redirect(BASE."{$empresa->link_site}/admin");
            }
        }
    }
}

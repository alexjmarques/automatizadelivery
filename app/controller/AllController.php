<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Cache;
use app\core\Controller;
use app\api\iFood\Authetication;
use Aura\Session\SessionFactory;
use function JBZoo\Data\json;
use app\classes\Preferencias;
use app\classes\Sessao;
use Twilio\Rest\Client;
use Bcrypt\Bcrypt;

class AllController extends Controller
{
    //Instancia da Classe Adminempresa
    private $preferencias;
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
        $this->preferencias = new Preferencias();
        $this->bcrypt = new Bcrypt();
        //$this->ifood = new iFood();
        $this->acoes = new Acoes();
    }

    public function verificaPlano($data)
    {
        $assinatura = $this->acoes->getByField('assinatura', 'id_empresa', $data);
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
        if (is_int($data)) {
            $empresaAct = $this->empresa->getById($data);
            $this->acoes->getByField('empresa', 'id', $data);
        } else {
            $empresaAct = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        }
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $session->destroy();
        redirect(BASE . $empresaAct->link_site);
        exit();
    }

    public function sairAdmin($data)
    {
        if (is_int($data)) {
            $empresaAct = $this->acoes->getByField('empresa', 'id', $data);;
        } else {
            $empresaAct = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        }
        $session = $this->sessao->newInstance($_COOKIE);
        $session->destroy();
        redirect(BASE . "{$empresaAct->link_site}/admin/login");
        exit();
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






    // public function iniciarAtendimento($data)
    // {
    //     $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
    //     $resulifood = $this->marketplace->getById(1);


    //     // if ($planoAtivo[':id'] == 4 || $planoAtivo[':id'] == 6 || $planoAtivo[':id'] == 7 || $planoAtivo[':id'] == 8) {
    //     //     $conecao = $this->ifood->gerarToken();
    //     // }

    //     // $planoAtivo = $this->apdPlanosModel->getAtivo();
    //     // if ($planoAtivo[':status'] == null) {
    //     //     echo 'Cliente não contratou plano';
    //     //     exit;
    //     // }

    //     // if ($planoAtivo[':status'] == 1) {
    //     //     $qtdPedidos = $this->adminVendasModel->qtdVendasMes();
    //     //     if ($planoAtivo[':limit'] != null) {
    //     //         if ($planoAtivo[':limit'] < $qtdPedidos) {
    //     //             echo 'Você ultrapassou o limite contratado para este mês';
    //     //             exit;
    //     //         }
    //     //     }
    //     // }

    //     $statusAssinatura = $this->assinaturaModel->getUll($empresaAct[':id']);
    //     if ($statusAssinatura[':status']) {
    //         $pagarme = new \PagarMe\Client(pagarme_api_key);
    //         $subscription = $pagarme->subscriptions()->get([
    //             'id' => $statusAssinatura[':subscription_id']
    //         ]);

    //         if ($subscription->current_transaction->status == $statusAssinatura[':status']) {
    //             $statusDiario = $this->assinaturaModel->update($subscription->current_transaction->status, $statusAssinatura[':id']);
    //         } else {
    //             $statusDiario = $this->assinaturaModel->update($subscription->current_transaction->status, $statusAssinatura[':id']);
    //             echo 'Não foi possível processar seu pagamento, atualize os dados de seu cartão!';
    //             exit;
    //         }
    //     }

    //     $caixa = $this->getInputInicio();


    //     $idDelivery = $this->deliveryModel->getAllPorEmpresa($empresaAct[':id']);
    //     $result = $this->adminCaixaModel->insert($caixa);
    //     $result2 = $this->deliveryModel->updateAtendimento(1, $idDelivery[0][':id']);
    //     if ($result <= 0) {
    //         echo "Não foi possível iniciar o atendimento";
    //         $_SESSION['caixaAtendimento'] = 0;
    //     } else {

    //         $resulifood == null ? '' : $this->ifoodAuthetication->refreshToken();
    //         echo "Atendimento iniciado com sucesso";
    //         $_SESSION['caixaAtendimento'] = 1;
    //     }
    // }


    // public function finalizarAtendimento($data)
    // {
    //     $empresaAct = $this->configEmpresaModel->getByName($data['clienteID']);
    //     $idDelivery = $this->deliveryModel->getAllPorEmpresa($empresaAct[':id']);
    //     $resulifood = $this->marketplace->getById(1);
    //     //$caixa = $this->getInputFim();
    //     $result = $this->adminCaixaModel->update($caixa);
    //     $result2 = $this->deliveryModel->updateAtendimento(0, $idDelivery[0][':id']);
    //     if ($result <= 0) {
    //         echo "Não foi possível finalizar o atendimento";
    //         $_SESSION['caixaAtendimento'] = 1;
    //     } else {
    //         $resulifood == null ? '' : $this->ifoodAuthetication->refreshToken();
    //         echo "Atendimento finalizado com sucesso";
    //         $_SESSION['caixaAtendimento'] = 0;
    //         unset($_SESSION['caixaAtendimento']);
    //     }
    // }
}

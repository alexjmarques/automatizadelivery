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


class AdminPlanos extends Controller
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
        //$this->ifood = new iFood();
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            $resulUsuario = $this->adminUsuarioModel->getById($SessionIdUsuario);
            if ($resulUsuario[':nivel'] == 3) {
                redirect(BASE . $empresaAct[':link_site']);
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/login');
        }

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $estabelecimento = $this->allController->verificaEstabelecimento($empresaAct[':id']);
        $resultPlanos = $this->apdPlanosModel->getAll();
        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);

        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/planos/main', [
            'empresa' => $empresaAct,
            'trans' => $trans,
            
            'usuarioLogado' => $resulUsuario,
            'planoAtivo' => $planoAtivo,
            'estabelecimento' => $estabelecimento,
            'moeda' => $moeda,
            'planos' => $resultPlanos,
            'caixa' => $resulCaixa,
        ]);
    }

    public function plano($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $session = $this->sessionFactory->newInstance($_COOKIE);
        $segment = $session->getSegment('Vendor\Aura\Segment');

        $SessionIdUsuario = $segment->get('id_usuario');
        $SessionUsuarioEmail = $segment->get('usuario');
        $SessionNivel = $segment->get('nivel');

        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios','id', $this->sessao->getUser());
            $resulUsuario = $this->adminUsuarioModel->getById($SessionIdUsuario);
            if ($resulUsuario[':nivel'] == 3) {
                redirect(BASE . $empresaAct[':link_site']);
            }
        } else {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/login');
        }

        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $moeda = $this->moedaModel->getById($resultEmpresa[':moeda']);

        $estabelecimento = $this->allController->verificaEstabelecimento($empresaAct[':id']);;;
        $resultPlano = $this->apdPlanosModel->getById($data['id']);
        $resultEstados = $this->adminEstadosModel->getAll();
        $resulCaixa = $this->adminCaixaModel->getUll($empresaAct[':id']);
        $resulifood = $this->marketplace->getById(1);
        $planoAtivo = $this->allController->verificaPlano($empresaAct[':id']);


        $trans = new Translate(new PhpFilesLoader("../app/language"),["default" => "pt_BR"]);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $estabelecimento = $this->acoes->limitOrder('empresaCaixa', $empresa->id, 1, 'id', 'DESC');

        $this->load('_admin/planos/view', [
            'empresa' => $empresaAct,
            'usuarioLogado' => $resulUsuario,
            'estabelecimento' => $estabelecimento,
            'estadosSelecao' => $resultEstados,
            'planoAtivo' => $planoAtivo,
            'moeda' => $moeda,
            'plano' => $resultPlano,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'planoAtivo' => $planoAtivo,
            'usuarioLogado' => $usuarioLogado,
'isLogin' => $this->sessao->getUser(),
            
            'caixa' => $estabelecimento[0]->data_inicio,
        ]);
    }

    public function criarPlano($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $pagarme = new \PagarMe\Client(pagarme_api_key);
        $plan = $pagarme->plans()->create([
            'amount' => 74990,
            'days' => 30,
            'name' => 'Solução Completa - Atendimento Presencial, IFood, UberEats, Rappy',
            'trial_days' => '7',
            'charges' => '3',
            'installments' => 1,
            'invoice_reminder' => 10
        ]);
    }

    public function updatePlano($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $pagarme = new \PagarMe\Client(pagarme_api_key);
        $plan = $pagarme->plans()->update([
            'id' => '574399',
            'name' => 'Plano Inicial',
            'trial_days' => '0'
        ]);

        dd($plan);
    }

    public function cobrancaPlano($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resultEmpresa = $this->configEmpresaModel->getById($empresaAct[':id']);
        $pagarme = new \PagarMe\Client(pagarme_api_key);
        $statusAssinatura = $this->assinaturaModel->getUll($empresaAct[':id']);
        if ($statusAssinatura[':subscription_id']) {
            //$trocarPlano = $this->apdPlanosModel->updateDisable($planoAtivo[':id']);
            $canceledSubscription = $pagarme->subscriptions()->cancel([
                'id' => $statusAssinatura[':subscription_id']
            ]);
        }

        /**
         * Crio o cartão para verificar se o mesmo e válido!
         */
        $card = $pagarme->cards()->create(['holder_name' => Input::post('name'), 'number' => Input::post('number'), 'expiration_date' => preg_replace("/[^0-9]/", "", Input::post('expiry')), 'cvv' => Input::post('cvc')]);
        if ($card->valid == 1) {
            /**
             * Executo o processo de assinatura do plano!
             */
            $result = $this->adminCreditCardModel->insert($card->holder_name, $card->id, $card->brand, $card->last_digits, $empresaAct[':id']);
            if ($result > 0) {
                $result = $this->adminCreditCardModel->getByIdHash($card->id);
                $orderId = substr(number_format(time() * Rand(), 0, '', ''), 0, 6);
                $subscription = $pagarme->subscriptions()->create([
                    'plan_id' => Input::post('planId'),
                    'payment_method' => 'credit_card',
                    'card_number' => Input::post('number'),
                    'card_holder_name' => Input::post('name'),
                    'card_expiration_date' => preg_replace("/[^0-9]/", "", Input::post('expiry')),
                    'card_cvv' => Input::post('cvc'),
                    'postback_url' => $resultempresa->link_site . '/admin/planos/status',
                    'customer' => [
                        'email' => Input::post('email'),
                        'name' => Input::post('nome'),
                        'document_number' => preg_replace("/[^0-9]/", "", Input::post('cpf')),
                        'address' => [
                            'street' => Input::post('rua'),
                            'street_number' => Input::post('numero'),
                            'complementary' => Input::post('complemento'),
                            'neighborhood' => Input::post('bairro'),
                            'zipcode' => Input::post('cep')
                        ],
                        'phone' => [
                            'ddd' => preg_replace("/[^0-9]/", "", Input::post('ddd')),
                            'number' => preg_replace("/[^0-9]/", "", Input::post('celular'))
                        ]
                    ],
                    'metadata' => [
                        'idPedido' => $orderId . '-' . Input::post('planNome')
                    ]
                ]);

                if ($subscription->status == 'paid' || $subscription->status == 'authorized' || $subscription->status == 'trialing') {
                    if ($subscription->status == 'trialing') {
                        $result = $this->assinaturaModel->insert($subscription->id, 'paid', $subscription->plan->id, $empresaAct[':id']);

                    } else {
                        $result = $this->assinaturaModel->insert($subscription->current_transaction->subscription_id, $subscription->current_transaction->status, $subscription->plan->id, $empresaAct[':id']);
                    }
                    //$result = $this->apdPlanosModel->updateTransaction($subscription->plan->id, 1);

                    echo "Plano contratado com sucesso!";
                    exit;
                }
                if ($subscription->status == 'processing' || $subscription->status == 'waiting_payment') {
                    $result = $this->assinaturaModel->insert($subscription->current_transaction->subscription_id, $subscription->current_transaction->status, $subscription->plan->id, $empresaAct[':id']);
                    echo "Aguarde! Estamos aguardando o processamento do pagamento!";
                    exit;
                } else {
                    echo "Pagamento não foi aprovado! Verifique com sua credora de cartão";
                    exit;
                }
            }
        } else {
            echo 'Cartão inválido';
        }
    }


    /**
     *
     * Faz a atualização da pagina de proutos
     *
     */
    public function atualizarPlano($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $result = $this->adminCategoriaModel->delete($data['id']);
        if ($result <= 0) {
            redirect(BASE . $empresaAct[':link_site'] . '/admin/planos');
            exit;
        }
        redirect(BASE . $empresaAct[':link_site'] . '/admin/planos');
    }

    /**
     * Retorna os dados do formulario em uma classe stdObject
     * 
     * @return object
     */
    private function getInput()
    {
        return (object)[
            'name' => Input::post('name'),
            'number' => Input::post('number'),
            'expiry' => Input::post('expiry'),
            'cvc' => Input::post('cvc'),
            'plan' => Input::post('plan'),
            'val' => Input::post('val'),
            'period' => Input::post('period'),
            'id_empresa' => Input::post('id_empresa')
        ];
    }
}

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
use app\classes\Sessao;
use app\Models\Assinatura;
use app\Models\CartaoCredito;

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
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }

    public function index($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $planosAutomatiza = $this->acoes->getFind('planos');
        
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/planos/main', [
            'planos' => $planosAutomatiza,
            'planoAtivo' => $planoAtivo,
            'estabelecimento' => $estabelecimento,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario'=> $this->sessao->getNivel(),
            'caixa' => $caixa->status
        ]);
    }

    public function plano($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $plano = $this->acoes->getByField('planos', 'id', $data['id']);
        
        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        $moeda = $this->acoes->getByField('moeda', 'id', $empresa->id_moeda);
        $caixa = $this->acoes->getByField('empresaFrete', 'id_empresa', $empresa->id);
$estabelecimento = $this->acoes->limitOrder('empresaCaixa', 'id_empresa', $empresa->id, 1, 'id', 'DESC');
        
        if ($this->sessao->getUser()) {
            $verificaUser = $this->geral->verificaEmpresaUser($empresa->id, $this->sessao->getUser());
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            if ($this->sessao->getNivel() == 3) {
                redirect(BASE . $empresa->link_site);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}/admin/login");
        }

        $this->load('_admin/planos/view', [
            'empresa' => $empresa,
            'plano' => $plano,
            'estabelecimento' => $estabelecimento,
            'planoAtivo' => $planoAtivo,
            'estabelecimento' => $estabelecimento,
            'moeda' => $moeda,
            'empresa' => $empresa,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'nivelUsuario'=> $this->sessao->getNivel(),
            'caixa' => $caixa->status
        ]);
    }

    

    public function cobrancaPlano($data)
    {
        $pagarme = new \PagarMe\Client(pagarme_api_key);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);


        $planoAtivo = $this->geral->verificaPlano($empresa->id);
        if($planoAtivo > 0){
            //dd($empresa->id);
            $statusAssinatura = $this->acoes->getByFieldTwo('assinatura', 'status', 'paid','id_empresa', $empresa->id);
            if ($statusAssinatura->subscription_id) {
                $canceledSubscription = $pagarme->subscriptions()->cancel([
                    'id' => $statusAssinatura->subscription_id
                ]);
                $valor = (new Assinatura())->findById($statusAssinatura->id);
                $valor->status = 'canceled';
                $valor->save();
            }
        }
        /**
         * Crio o cartão para verificar se o mesmo e válido!
         */
        $card = $pagarme->cards()->create([
                'holder_name' => $data['name'],
                'number' => preg_replace("/[^0-9]/", "", $data['number']),
                'expiration_date' => preg_replace("/[^0-9]/", "", $data['expiry']),
                'cvv' => $data['cvc']
        ]);
        if ($card->valid == 1) {
            /**
             * Executo o processo de assinatura do plano!
             */
            $valor = new CartaoCredito();
            $valor->id_empresa = $empresa->id;
            $valor->user_holder = $card->holder_name;
            $valor->hash = $card->id;
            $valor->brand = $card->brand;
            $valor->last_digits = $card->last_digits;
            $valor->save();
            
            
            if ($valor->id > 0) {
                $result = $this->acoes->getByField('cartaoCredito', 'hash', $card->id);
                $orderId = substr(number_format(time() * Rand(), 0, '', ''), 0, 6);

                $subscription = $pagarme->subscriptions()->create([
                    'plan_id' => $data['planId'],
                    'payment_method' => 'credit_card',
                    'card_number' => preg_replace("/[^0-9]/", "", $data['number']),
                    'card_holder_name' => $data['name'],
                    'card_expiration_date' => preg_replace("/[^0-9]/", "", $data['expiry']),
                    'card_cvv' => $data['cvc'],
                    'postback_url' => BASE."{$empresa->link_site}/admin/planos/status",
                    'customer' => [
                        'email' => $data['email'],
                        'name' => $data['nome'],
                        'document_number' => preg_replace("/[^0-9]/", "", $data['cpf']),
                        'address' => [
                            'street' => $data['rua'],
                            'street_number' => $data['numero'],
                            'complementary' => $data['complemento'],
                            'neighborhood' => $data['bairro'],
                            'zipcode' => $data['cep']
                        ],
                        'phone' => [
                            'ddd' => preg_replace("/[^0-9]/", "", $data['ddd']),
                            'number' => preg_replace("/[^0-9]/", "", $data['celular'])
                        ]
                    ],
                    'metadata' => [
                        'idPedido' => $orderId . '-' . $data['planNome']
                    ]
                ]);

                if ($subscription->status == 'paid' || $subscription->status == 'authorized' || $subscription->status == 'trialing') {
                    if ($subscription->status == 'trialing') {
                        $valor = new Assinatura();
                        $valor->subscription_id = $subscription->id;
                        $valor->status = 'paid';
                        $valor->plano_id = $subscription->plan->id;
                        $valor->id_empresa = $empresa->id;
                        $valor->save();

                    } else {
                        $valor = new Assinatura();
                        $valor->subscription_id = $subscription->current_transaction->subscription_id;
                        $valor->status = $subscription->current_transaction->status;
                        $valor->plano_id = $subscription->plan->id;
                        $valor->id_empresa = $empresa->id;
                        $valor->save();
                    }
                    header('Content-Type: application/json');
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Plano contratado com sucesso!', 'error' => 'Não foi posível contratar o Plano!','code' => 2 ,  'url' => 'admin/planos']);
                    exit($json);
                }
                if ($subscription->status == 'processing' || $subscription->status == 'waiting_payment') {
                    $valor = new Assinatura();
                    $valor->subscription_id = $subscription->current_transaction->subscription_id;
                    $valor->status = $subscription->current_transaction->status;
                    $valor->plano_id = $subscription->plan->id;
                    $valor->id_empresa = $empresa->id;
                    $valor->save();

                    header('Content-Type: application/json');
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Aguarde! Estamos aguardando o processamento do pagamento!','code' => 2 ,  'url' => 'admin/planos']);
                    exit($json);
                } else {
                    header('Content-Type: application/json');
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Pagamento não foi aprovado! Verifique com sua credora de cartão', 'error' => 'Pagamento não foi aprovado! Verifique com sua credora de cartão','code' => 2 ,  'url' => 'admin/planos']);
                    exit($json);
                }
            }
        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Cartão inválido', 'error' => 'Cartão inválido']);
            exit($json);
        }
    }


    /**
     *
     * Faz a atualização do Status de pagamento do plano contratado
     *
     */
    public function atualizarPlano($data)
    {
        // $statusAssinatura = $this->acoes->getByFieldTwo('assinatura', 'id_empresa', $empresa->id, 'status', 'paid');
        //     if ($statusAssinatura->subscription_id) {
        //         $canceledSubscription = $pagarme->subscriptions()->cancel([
        //             'id' => $statusAssinatura->subscription_id
        //         ]);
        //         $valor = (new Assinatura())->findById($statusAssinatura->id);
        //         $valor->status = 'canceled';
        //         $valor->save();
        //     }

        // header('Content-Type: application/json');
        // $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Plano Atualizado', 'error' => 'Não mudou nada no plano']);
        // exit($json); 
    }



    // public function criarPlano($data)
    // {
    //     $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
    //     $pagarme = new \PagarMe\Client(pagarme_api_key);
    //     $plan = $pagarme->plans()->create([
    //         'amount' => 74990,
    //         'days' => 30,
    //         'name' => 'Solução Completa - Atendimento Presencial, IFood, UberEats, Rappy',
    //         'trial_days' => '7',
    //         'charges' => '3',
    //         'installments' => 1,
    //         'invoice_reminder' => 10
    //     ]);
    // }

    // public function updatePlano($data)
    // {
    //     $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
    //     $pagarme = new \PagarMe\Client(pagarme_api_key);
    //     $plan = $pagarme->plans()->update([
    //         'id' => '574399',
    //         'name' => 'Plano Inicial',
    //         'trial_days' => '0'
    //     ]);

    //     dd($plan);
    // }
}

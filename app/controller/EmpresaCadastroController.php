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
use app\Models\Assinatura;
use app\Models\CartaoCredito;
use app\Models\Empresa;
use app\Models\EmpresaEnderecos;
use app\Models\EmpresaFrete;
use app\Models\FormasPagamento;
use app\Models\Planos;
use app\Models\TipoDelivery;
use app\Models\Usuarios;
use app\Models\UsuariosEmpresa;
use Bcrypt\Bcrypt;
use Browser;
use Mobile_Detect;

class EmpresaCadastroController extends Controller
{
    private $acoes;
    private $sessao;
    private $geral;
    private $trans;
    private $bcrypt;

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
        $this->bcrypt = new Bcrypt();
        $this->cache = new Cache();
        $this->acoes = new Acoes();
    }
    public function index($data)
    {
        $empresas = $this->acoes->getFind('empresa');
        $moeda = $this->acoes->getByField('moeda', 'id', 4);
        $plano = $this->acoes->getByField('planos', 'slug', $data['plano']);
        $empresaDelivery = $this->acoes->getFind('empresaFrete');
        $categoria = $this->acoes->getFind('categoriaSeguimentoSub');
        $pedidos = $this->acoes->getFind('carrinhoPedidos');
        $links = $this->acoes->getFind('paginas');

        $this->load('_planos/main', [
            'empresas' => $empresas,
            'links' => $links,
            'plano' => $plano,
            'moeda' => $moeda,
            'empresaDelivery' => $empresaDelivery,
            'categoria' => $categoria,
            'pedidos' => $pedidos,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function pagamento($data)
    {
        if ($this->sessao->getUser()) {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $empresa = $this->acoes->getByField('empresa', 'email_contato', $this->sessao->getEmail());
            $endereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        } else {
            redirect(BASE);
        }

        $moeda = $this->acoes->getByField('moeda', 'id', 4);
        $plano = $this->acoes->getByField('planos', 'slug', $data['plano']);
        $empresas = $this->acoes->getFind('empresa');
        $empresaDelivery = $this->acoes->getFind('empresaFrete');
        $categoria = $this->acoes->getFind('categoriaSeguimentoSub');
        $pedidos = $this->acoes->getFind('carrinhoPedidos');
        $links = $this->acoes->getFind('paginas');

        $this->load('_planos/pagamento', [
            'empresas' => $empresas,
            'links' => $links,
            'endereco' => $endereco,
            'empresa' => $empresa,
            'usuario' => $usuarioLogado,
            'moeda' => $moeda,
            'plano' => $plano,
            'empresaDelivery' => $empresaDelivery,
            'categoria' => $categoria,
            'pedidos' => $pedidos,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function insert($data)
    {
        $verificacao_link = $this->acoes->getByField('empresa', 'link_site', $data['link_site']);
        $verificacao_razao = $this->acoes->getByField('empresa', 'razao_social', $data['razao_social']);
        $plano = $this->acoes->getByField('planos', 'id', $data['plano_id']);
        $verificacao = $this->acoes->getByField('usuarios', 'email', $data['email']);
        
        //dd($plano);
        if($verificacao_link && $verificacao_razao){
            //dd('1');
            //header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Empresa já cadastrada em nosso sistema', 'code' => 9]);
        }else if($verificacao){
            //dd('2');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Email já cadastrada em nosso sistema, tente outro email', 'code' => 9]);
        }else{
            //dd('Entrou');
            $senha = $this->bcrypt->encrypt($data['senha'], '2a');
            $telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
            //dd($data);

            dd($data);
            $empresa = new Empresa();
            $empresa->id_categoria = 7;
            $empresa->nome_fantasia = $data['nome_fantasia'];
            $empresa->razao_social = $data['razao_social'];
            $empresa->cnpj = $data['cnpj'];
            $empresa->telefone = $telefone;
            $empresa->id_moeda = 4;
            $empresa->nf_paulista = 0;
            $empresa->dias_atendimento = '1,2,3,4,5,6,7';
            $empresa->email_contato = $data['email'];
            $empresa->link_site = $data['link_site'];
            $empresa->save();
            //print_r($empresa);
            
            $empresaEnderecos = new EmpresaEnderecos();
            $empresaEnderecos->id_empresa = $empresa->id;
            $empresaEnderecos->rua = $data['rua'];
            $empresaEnderecos->numero = $data['numero'];
            $empresaEnderecos->complemento = $data['complemento'];
            $empresaEnderecos->bairro = $data['bairro'];
            $empresaEnderecos->cidade = $data['cidade'];
            $empresaEnderecos->estado = $data['estado'];
            $empresaEnderecos->cep = $data['cep'];
            $empresaEnderecos->save();
            //print_r($empresaEnderecos);

            $formasPagamento = new FormasPagamento();
            $formasPagamento->tipo = 'Dinheiro';
            $formasPagamento->code = 1;
            $formasPagamento->status = 1;
            $formasPagamento->id_empresa = $empresa->id;
            $formasPagamento->save();
            //print_r($formasPagamento);

            $formasPagamento2 = new FormasPagamento();
            $formasPagamento2->tipo = 'Cartão de Débito';
            $formasPagamento2->code = 2;
            $formasPagamento2->status = 1;
            $formasPagamento2->id_empresa = $empresa->id;
            $formasPagamento2->save();
            //print_r($formasPagamento2);

            $formasPagamento3 = new FormasPagamento();
            $formasPagamento3->tipo = 'Cartão Crédito';
            $formasPagamento3->code = 3;
            $formasPagamento3->status = 1;
            $formasPagamento3->id_empresa = $empresa->id;
            $formasPagamento3->save();
            //print_r($formasPagamento3);

            $formasPagamento4 = new FormasPagamento();
            $formasPagamento4->tipo = 'QR Code';
            $formasPagamento4->code = 4;
            $formasPagamento4->status = 1;
            $formasPagamento4->id_empresa = $empresa->id;
            $formasPagamento4->save();
            //print_r($formasPagamento4);

            $formasPagamento5 = new FormasPagamento();
            $formasPagamento5->tipo = 'Vale Refeição';
            $formasPagamento5->code = 5;
            $formasPagamento5->status = 1;
            $formasPagamento5->id_empresa = $empresa->id;
            $formasPagamento5->save();
            //print_r($formasPagamento5);

            $formasPagamento6 = new FormasPagamento();
            $formasPagamento6->tipo = 'Vale Alimentação';
            $formasPagamento6->code = 6;
            $formasPagamento6->status = 1;
            $formasPagamento6->id_empresa = $empresa->id;
            $formasPagamento6->save();
            //print_r($formasPagamento6);

            $formasPagamento7 = new FormasPagamento();
            $formasPagamento7->tipo = 'Dinheiro + Cartão';
            $formasPagamento7->code = 7;
            $formasPagamento7->status = 1;
            $formasPagamento7->id_empresa = $empresa->id;
            $formasPagamento7->save();
            //print_r($formasPagamento7);

            $formasPagamento8 = new FormasPagamento();
            $formasPagamento8->tipo = 'PIX - CODE PIX';
            $formasPagamento8->code = 8;
            $formasPagamento8->status = 1;
            $formasPagamento8->id_empresa = $empresa->id;
            $formasPagamento8->save();
            //print_r($formasPagamento8);

            $tipoDelivery = new TipoDelivery();
            $tipoDelivery->tipo = 'Entrega';
            $tipoDelivery->code = 2;
            $tipoDelivery->status = 1;
            $tipoDelivery->id_empresa = $empresa->id;
            $tipoDelivery->save();
            //print_r($tipoDelivery);

            $tipoDelivery2 = new TipoDelivery();
            $tipoDelivery2->tipo = 'Retirada';
            $tipoDelivery2->code = 1;
            $tipoDelivery2->status = 1;
            $tipoDelivery2->id_empresa = $empresa->id;
            $tipoDelivery2->save();
            //print_r($tipoDelivery2);
            
            $empresaFrete = new EmpresaFrete();
            $empresaFrete->status = 0;
            $empresaFrete->previsao_minutos = 0;
            $empresaFrete->taxa_entrega = 0;
            $empresaFrete->km_entrega = 0;
            $empresaFrete->km_entrega_excedente = 0;
            $empresaFrete->valor_excedente = 0;
            $empresaFrete->taxa_entrega_motoboy = 0;
            $empresaFrete->valor = 0;
            $empresaFrete->frete_status = 0;
            $empresaFrete->primeira_compra = 0;
            $empresaFrete->id_empresa = $empresa->id;
            $empresaFrete->save();
            //print_r($empresaFrete);
            
            $usuarios = new Usuarios();
            $usuarios->nome = $data['nome'];
            $usuarios->email = $data['email'];
            $usuarios->telefone = $telefone;
            $usuarios->senha = $senha;
            $usuarios->nivel = 0;
            $usuarios->save();
            //print_r($usuarios);
            
            $usuariosEmpresa = new UsuariosEmpresa();
            $usuariosEmpresa->id_usuario = $usuarios->id;
            $usuariosEmpresa->id_empresa = $empresa->id;
            $usuariosEmpresa->nivel = 0;
            $usuariosEmpresa->save();
            //print_r($usuariosEmpresa);

            $this->sessao->sessaoNew('id_usuario', $usuarios->id);
            $this->sessao->sessaoNew('usuario', $usuarios->email);
            $this->sessao->sessaoNew('nivel', $usuarios->nivel);

            if($data['plano_id'] == 1){
                $code = substr(number_format(time() * Rand(), 0, '', ''), 0, 10);
                $usuarios = new Assinatura();
                $usuarios->subscription_id = "free-{$code}";
                $usuarios->plano_id = $plano->plano_id;
                $usuarios->status = 'paid';
                $usuarios->id_empresa = $empresa->id;
                $usuarios->save();

                header('Content-Type: application/json');
                $json = json_encode(['id' => $usuarios->id, 'resp' => 'insert', 'mensagem' => 'Cadastro realizado com sucesso! Clique em OK para efetuar o login e começar a utilizar nossos serviços', 'error' => 'Não foi possivel efetuar seu cadastro! Tente novamente mais tarde', 'url' => "{$data['link_site']}/admin/login", 'code' => 10 ]);
            }else{
                header('Content-Type: application/json');
                $json = json_encode(['id' => $usuariosEmpresa->id, 'resp' => 'insert', 'mensagem' => 'Cadastro realizado com sucesso! Aguarde para efetuar o pagamento do seu plano', 'error' => 'Não foi possivel efetuar seu cadastro! Tente novamente mais tarde', 'url' => "cadastro/empresa/{$plano->slug}/pagamento", 'code' => 11 ]);
            }

        }
        exit($json);
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
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Plano contratado com sucesso!', 'error' => 'Não foi posível contratar o Plano!', 'url' => "{$empresa->link_site}/admin", 'code' => 10]);
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
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Aguarde! Estamos aguardando o processamento do seu pagamento!', 'url' => "{$empresa->link_site}/admin", 'code' => 10]);
                    exit($json);
                } else {
                    header('Content-Type: application/json');
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Pagamento não foi aprovado! Verifique com sua credora de cartão', 'error' => 'Pagamento não foi aprovado! Verifique com sua credora de cartão', 'url' => "{$empresa->link_site}/admin", 'code' => 9]);
                    exit($json);
                }
            }
        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Cartão inválido', 'error' => 'Cartão inválido', 'code' => 9]);
            exit($json);
        }
    }
}

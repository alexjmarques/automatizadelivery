<?php

namespace app\controller;

use app\classes\Input;
use app\classes\Acoes;
use app\classes\Email;
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
    private $email;
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
        $this->email = new Email();
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
            if ($this->sessao->getUser() != 'undefined') {
            $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
            $empresa = $this->acoes->getByField('empresa', 'email_contato', $this->sessao->getEmail());
            $endereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
            }
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
        
        if($verificacao_link && $verificacao_razao){
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Empresa j?? cadastrada em nosso sistema', 'code' => 9]);
        }else if($verificacao){
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Email j?? cadastrada em nosso sistema, tente outro email', 'code' => 9]);
        }else{
            $senha = $this->bcrypt->encrypt($data['senha'], '2a');
            $telefone = preg_replace('/[^0-9]/', '', $data['telefone']);

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
            $empresaEnderecos->rua = $data['rua_end'];
            $empresaEnderecos->numero = $data['numero_end'];
            $empresaEnderecos->complemento = $data['complemento_end'];
            $empresaEnderecos->bairro = $data['bairro_end'];
            $empresaEnderecos->cidade = $data['cidade_end'];
            $empresaEnderecos->estado = $data['estado_end'];
            $empresaEnderecos->cep = $data['cep_end'];
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
            $formasPagamento2->tipo = 'Cart??o de D??bito';
            $formasPagamento2->code = 2;
            $formasPagamento2->status = 1;
            $formasPagamento2->id_empresa = $empresa->id;
            $formasPagamento2->save();
            //print_r($formasPagamento2);

            $formasPagamento3 = new FormasPagamento();
            $formasPagamento3->tipo = 'Cart??o Cr??dito';
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
            $formasPagamento5->tipo = 'Vale Refei????o';
            $formasPagamento5->code = 5;
            $formasPagamento5->status = 1;
            $formasPagamento5->id_empresa = $empresa->id;
            $formasPagamento5->save();
            //print_r($formasPagamento5);

            $formasPagamento6 = new FormasPagamento();
            $formasPagamento6->tipo = 'Vale Alimenta????o';
            $formasPagamento6->code = 6;
            $formasPagamento6->status = 1;
            $formasPagamento6->id_empresa = $empresa->id;
            $formasPagamento6->save();
            //print_r($formasPagamento6);

            $formasPagamento7 = new FormasPagamento();
            $formasPagamento7->tipo = 'Dinheiro + Cart??o';
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


            $formasPagamento9 = new FormasPagamento();
            $formasPagamento9->tipo = 'Transfer??ncia Banc??ria';
            $formasPagamento9->code = 9;
            $formasPagamento9->status = 1;
            $formasPagamento9->id_empresa = $empresa->id;
            $formasPagamento9->save();
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
            $empresaFrete->taxa_entrega2 = 0;
            $empresaFrete->km_entrega2 = 0;
            $empresaFrete->taxa_entrega3 = 0;
            $empresaFrete->km_entrega3 = 0;
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
            $usuariosEmpresa->pedidos = 0;
            $usuariosEmpresa->nivel = 0;
            $usuariosEmpresa->save();
            //print_r($usuariosEmpresa);

            if($data['plano_id'] == 1){
                $code = substr(number_format(time() * Rand(), 0, '', ''), 0, 10);
                $assin = new Assinatura();
                $assin->subscription_id = "free-{$code}";
                $assin->plano_id = $plano->plano_id;
                $assin->status = 'paid';
                $assin->id_empresa = $empresa->id;
                $assin->save();

                $sessao = $this->sessao->add($usuarios->id, $usuarios->email, $usuarios->nivel);
                $emailEnvia = $this->email->bemVindo($data['nome'], $usuarios->email, $data['senha'], $data['link_site']);

                header('Content-Type: application/json');
                $json = json_encode(['id' => $usuarios->id, 'resp' => 'insert', 'mensagem' => 'Cadastro realizado com sucesso! Clique em OK para efetuar o login e come??ar a utilizar nossos servi??os', 'error' => 'N??o foi possivel efetuar seu cadastro! Tente novamente mais tarde','code' => 2 ,  'url' => "{$data['link_site']}/admin/login", 'code' => 10 ]);
            }else{
                $sessao = $this->sessao->add($usuarios->id, $usuarios->email, $usuarios->nivel);
                $emailEnvia = $this->email->bemVindo($data['nome'], $usuarios->email, $data['senha'], $data['link_site']);

                header('Content-Type: application/json');
                $json = json_encode(['id' => $usuariosEmpresa->id, 'resp' => 'insert', 'mensagem' => 'Cadastro realizado com sucesso! Aguarde para efetuar o pagamento do seu plano', 'error' => 'N??o foi possivel efetuar seu cadastro! Tente novamente mais tarde','code' => 2 ,  'url' => "{$data['link_site']}/admin/login", 'code' => 11 ]);
            }

        }
        exit($json);
    }

    public function pagamentoInsert($data)
    {
        $pagarme = new \PagarMe\Client(pagarme_api_key);
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');

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
         * Crio o cart??o para verificar se o mesmo e v??lido!
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
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Plano contratado com sucesso!', 'error' => 'N??o foi pos??vel contratar o Plano!','code' => 2 ,  'url' => "{$empresa->link_site}/admin", 'code' => 10]);
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
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Aguarde! Estamos aguardando o processamento do seu pagamento!','code' => 2 ,  'url' => "{$empresa->link_site}/admin", 'code' => 10]);
                    exit($json);
                } else {
                    header('Content-Type: application/json');
                    $json = json_encode(['id' => $valor->id, 'resp' => 'insert', 'mensagem' => 'Pagamento n??o foi aprovado! Verifique com sua credora de cart??o', 'error' => 'Pagamento n??o foi aprovado! Verifique com sua credora de cart??o','code' => 2 ,  'url' => "{$empresa->link_site}/admin", 'code' => 9]);
                    exit($json);
                }
            }
        } else {
            $this->email->plano($data['nome'], $data['email'], $data['planNome']);

            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'mensagem' => 'Cart??o inv??lido', 'error' => 'Cart??o inv??lido', 'code' => 9]);
            exit($json);
        }
    }
}

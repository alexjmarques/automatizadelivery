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
use app\Models\Empresa;
use app\Models\EmpresaEnderecos;
use app\Models\EmpresaFrete;
use app\Models\FormasPagamento;
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
        $empresaDelivery = $this->acoes->getFind('empresaFrete');
        $categoria = $this->acoes->getFind('categoriaSeguimentoSub');
        $pedidos = $this->acoes->getFind('carrinhoPedidos');

        $this->load('_geral/cadastro/main', [
            'empresas' => $empresas,
            'empresaDelivery' => $empresaDelivery,
            'categoria' => $categoria,
            'pedidos' => $pedidos,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect()

        ]);
    }

    public function insert($data)
    {
        $senha = $this->bcrypt->encrypt($data['senha'], '2a');

        $empresa = new Empresa();
        $empresa->id_categoria = 7;
        $empresa->nome_fantasia = $data['nome_fantasia'];
        $empresa->razao_social = $data['razao_social'];
        $empresa->cnpj = $data['cnpj'];
        $empresa->telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
        $empresa->id_moeda = 4;
        $empresa->nf_paulista = 0;
        $empresa->dias_atendimento = '1,2,3,4,5,6,7';
        $empresa->email_contato = $data['email'];
        $empresa->link_site = $data['link_site'];
        $empresa->save();

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

        $formasPagamento = new FormasPagamento();
        $formasPagamento->tipo = 'Dinheiro';
        $formasPagamento->code = 1;
        $formasPagamento->status = 1;
        $formasPagamento->id_empresa = $empresa->id;
        $formasPagamento->save();

        $formasPagamento2 = new FormasPagamento();
        $formasPagamento2->tipo = 'Cartão de Débito';
        $formasPagamento2->code = 2;
        $formasPagamento2->status = 1;
        $formasPagamento2->id_empresa = $empresa->id;
        $formasPagamento2->save();

        $formasPagamento3 = new FormasPagamento();
        $formasPagamento3->tipo = 'Cartão Crédito';
        $formasPagamento3->code = 3;
        $formasPagamento3->status = 1;
        $formasPagamento3->id_empresa = $empresa->id;
        $formasPagamento3->save();

        $formasPagamento4 = new FormasPagamento();
        $formasPagamento4->tipo = 'QR Code';
        $formasPagamento4->code = 4;
        $formasPagamento4->status = 1;
        $formasPagamento4->id_empresa = $empresa->id;
        $formasPagamento4->save();

        $formasPagamento5 = new FormasPagamento();
        $formasPagamento5->tipo = 'Vale Refeição';
        $formasPagamento5->code = 5;
        $formasPagamento5->status = 1;
        $formasPagamento5->id_empresa = $empresa->id;
        $formasPagamento5->save();

        $formasPagamento6 = new FormasPagamento();
        $formasPagamento6->tipo = 'Vale Alimentação';
        $formasPagamento6->code = 6;
        $formasPagamento6->status = 1;
        $formasPagamento6->id_empresa = $empresa->id;
        $formasPagamento6->save();

        $formasPagamento7 = new FormasPagamento();
        $formasPagamento7->tipo = 'Dinheiro + Cartão';
        $formasPagamento7->code = 7;
        $formasPagamento7->status = 1;
        $formasPagamento7->id_empresa = $empresa->id;
        $formasPagamento7->save();

        $formasPagamento8 = new FormasPagamento();
        $formasPagamento8->tipo = 'PIX - CODE PIX';
        $formasPagamento8->code = 8;
        $formasPagamento8->status = 1;
        $formasPagamento8->id_empresa = $empresa->id;
        $formasPagamento8->save();

        $tipoDelivery = new TipoDelivery();
        $tipoDelivery->tipo = 'Entrega';
        $tipoDelivery->code = 2;
        $tipoDelivery->status = 1;
        $tipoDelivery->id_empresa = $empresa->id;
        $tipoDelivery->save();

        $tipoDelivery2 = new TipoDelivery();
        $tipoDelivery2->tipo = 'Retirada';
        $tipoDelivery2->code = 1;
        $tipoDelivery2->status = 1;
        $tipoDelivery2->id_empresa = $empresa->id;
        $tipoDelivery2->save();


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

        dd($empresaFrete);

        
        $usuarios = new Usuarios();
        $usuarios->nome = $data['nome'];
        $usuarios->email = $data['email'];
        $usuarios->telefone = preg_replace('/[^0-9]/', '', $data['telefone']);
        $usuarios->senha = $senha;
        $usuarios->nivel = 0;
        $usuarios->save();

        $usuariosEmpresa = new UsuariosEmpresa();
        $usuariosEmpresa->id_usuario = $usuarios->id;
        $usuariosEmpresa->id_empresa = $empresa->id;
        $usuariosEmpresa->nivel = 0;
        $usuariosEmpresa->save();
        redirect(BASE . "{$data['link_site']}/admin/login");

        // header('Content-Type: application/json');
        // $json = json_encode(['id' => $usuariosEmpresa->id, 'resp' => 'insert', 'mensagem' => 'Cadastro realizado com sucesso!', 'error' => 'Não foi possivel efetuar seu cadastro! Tente novamente mais tarde', 'url' => "{$data['link_site']}/admin/login",]);
        // exit($json);
    }
}

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
use app\Models\Usuarios;
use app\Models\UsuariosEnderecos;
use Browser;


class PerfilController extends Controller
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
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_cliente/perfil/main', [
            'empresa' => $empresa,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }
    public function perfil($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_cliente/perfil/perfil', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }

    public function dadosCadastrais($data)
    {

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_cliente/perfil/dadosCadastrais', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }


    public function enderecos($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        $resulEnderecos = $this->acoes->getByFieldAll('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
        $resulEstados = $this->acoes->getFind('estados');

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_cliente/perfil/enderecos', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'enderecos' => $resulEnderecos,
            'estados' => $resulEstados,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }


    public function novoEndereco($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        $resulEnderecos = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
        $resulEstados = $this->acoes->getFind('estados');

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_cliente/perfil/endereco', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'enderecos' => $resulEnderecos,
            'estadosSelecao' => $resulEstados,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }

    public function novoEnderecoPrimeiro($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        $resulEnderecos = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
        $resulEstados = $this->acoes->getFind('estados');

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_cliente/perfil/primeiroEndereco', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'resulEnderecos' => $resulEnderecos,
            'estadosSelecao' => $resulEstados,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }


    public function editarEndereco($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        $resulEnderecos = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
        $resulEstados = $this->acoes->getFind('estados');

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_cliente/perfil/editar', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'enderecoAtivo' => $resulEnderecos,
            'estadosSelecao' => $resulEstados,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }


    public function telefone($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

        $resulEnderecos = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
        $resulEstados = $this->acoes->getFind('estados');

        if ($this->sessao->getUser()) {
            $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
        }

        $this->load('_cliente/perfil/mudarTelefone', [
            'empresa' => $empresa,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'resulEnderecos' => $resulEnderecos,
            'estadosSelecao' => $resulEstados,
            'trans' => $this->trans,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }

    public function insertEndereco($data)
    {
        $enderecos = $this->acoes->counts('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
        $resulEnderecos = $this->acoes->countsTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        if ($resulEnderecos > 0) {
            $endereco = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            $valor = (new UsuariosEnderecos())->findById($endereco->id);
            $valor->principal = 0;
            $valor->save();
        }
        if ($enderecos > 0) {
            $nome_endereco =  $data['nome_endereco'];
            $principal =  $data['principal'];
        } else {
            $nome_endereco =  'Principal';
            $principal =  1;
        }

        $novo = new UsuariosEnderecos();
        $novo->id_usuario = $data['id_usuario'];
        $novo->nome_endereco = $nome_endereco;
        $novo->rua = $data['rua'];
        $novo->numero = $data['numero'];
        $novo->complemento = $data['complemento'];
        $novo->bairro = $data['bairro'];
        $novo->cidade = $data['cidade'];
        $novo->estado = $data['estado'];
        $novo->cep = $data['cep'];
        $novo->principal = $principal;
        $novo->save();

        header('Content-Type: application/json');
        if ($enderecos > 0) {
            $json = json_encode(['id' => $novo->id, 'resp' => 'insert', 'mensagem' => 'Endereço cadastrado com Sucesso!', 'error' => 'Erro ao cadastrar um novo endereço', 'url' => 'enderecos',]);
        } else {
            $json = json_encode(['id' => $novo->id, 'resp' => 'insert', 'mensagem' => 'Primeiro endereço cadastrado com Sucesso!', 'error' => 'Erro ao cadastrar seu primeiro endereço', 'url' => 'carrinho',]);
        }
        exit($json);
    }

    public function updateEndereco($data)
    {
        $enderecos = $this->acoes->counts('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
        $resulEnderecos = $this->acoes->countsTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        if ($resulEnderecos > 0) {
            $endereco = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            $valor = (new UsuariosEnderecos())->findById($endereco->id);
            $valor->principal = 0;
            $valor->save();
        }
        if ($enderecos > 0) {
            $nome_endereco =  $data['nome_endereco'];
            $principal =  $data['principal'];
        } else {
            $nome_endereco =  'Principal';
            $principal =  1;
        }

        $novo = (new UsuariosEnderecos())->findById($data['id_endereco']);
        $novo->id_usuario = $data['id_usuario'];
        $novo->nome_endereco = $nome_endereco;
        $novo->rua = $data['rua'];
        $novo->numero = $data['numero'];
        $novo->complemento = $data['complemento'];
        $novo->bairro = $data['bairro'];
        $novo->cidade = $data['cidade'];
        $novo->estado = $data['estado'];
        $novo->cep = $data['cep'];
        $novo->principal = $principal;
        $novo->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Endereço atualizado com Sucesso!', 'error' => 'Erro ao atualizar o endereço', 'url' => 'enderecos',]);
        exit($json);
    }

    public function deletarEndereco($data)
    {
        $valor = (new UsuariosEnderecos())->findById($data['id']);
        $valor->destroy();
        redirect(BASE . "{$data['linkSite']}/enderecos");
    }

    public function updateDados($data)
    {
        $valor = (new Usuarios())->findById($data['id_usuario']);
        $valor->email = $data['email'];
        $valor->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Dados atualizado com sucesso', 'error' => 'Erro ao atualizar o seus dados', 'url' => 'perfil',]);
        exit($json);
    }
}

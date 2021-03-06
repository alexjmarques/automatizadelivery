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
use Mobile_Detect;


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
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            }
        }

        $this->load('_cliente/perfil/main', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'usuarioAtivo' => $resulUsuario,
            'trans' => $this->trans,
            'detect' => new Mobile_Detect(),
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }
    public function perfil($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            }
        }

        $this->load('_cliente/perfil/perfil', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'detect' => new Mobile_Detect(),
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }

    public function dadosCadastrais($data)
    {

        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');

        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            }
        }

        $this->load('_cliente/perfil/dadosCadastrais', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'detect' => new Mobile_Detect(),
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }


    public function enderecos($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');


        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resulEnderecos = $this->acoes->getByFieldAll('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
                $resulEstados = $this->acoes->getFind('estados');
                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            }
        }

        $this->load('_cliente/perfil/enderecos', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'detect' => new Mobile_Detect(),
            'enderecos' => $resulEnderecos,
            'estados' => $resulEstados,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }


    public function novoEndereco($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

                $resulEnderecos = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
                $resulEstados = $this->acoes->getFind('estados');

                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            }
        }

        $this->load('_cliente/perfil/endereco', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'detect' => new Mobile_Detect(),
            'enderecos' => $resulEnderecos,
            'estadosSelecao' => $resulEstados,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }



    public function novoEnderecoPrimeiro($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        $empresaEndereco = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $enderecoAtivo = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
            }
        } else {
            redirect(BASE . "{$empresa->link_site}");
        }
        $this->load('login/endereco', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'enderecoAtivo' => $enderecoAtivo,
            'empresaEndereco' => $empresaEndereco,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),
            'detect' => new Mobile_Detect()
        ]);
    }


    public function editarEndereco($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

                $resulEnderecos = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
                $resulEstados = $this->acoes->getFind('estados');

                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            }
        }
        $this->load('_cliente/perfil/editar', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'detect' => new Mobile_Detect(),
            'enderecoAtivo' => $resulEnderecos,
            'estadosSelecao' => $resulEstados,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }


    public function telefone($data)
    {
        $empresa = $this->acoes->getByField('empresa', 'link_site', $data['linkSite']);
        $endEmp = $this->acoes->getByField('empresaEnderecos', 'id_empresa', $empresa->id);
        $funcionamento = $this->acoes->getByFieldAll('empresaFuncionamento', 'id_empresa', $empresa->id);
        $dias = $this->acoes->getFind('dias');
        if ($this->sessao->getUser()) {
            if ($this->sessao->getUser() != 'undefined') {
                $usuarioLogado = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());
                $resulUsuario = $this->acoes->getByField('usuarios', 'id', $this->sessao->getUser());

                $resulEnderecos = $this->acoes->getByField('usuariosEnderecos', 'id_usuario', $this->sessao->getUser());
                $resulEstados = $this->acoes->getFind('estados');

                $resultCarrinhoQtd = $this->acoes->countsTwoNull('carrinho', 'id_cliente', $this->sessao->getUser(), 'id_empresa', $empresa->id);
            }
        }

        $this->load('_cliente/perfil/mudarTelefone', [
            'empresa' => $empresa,
            'endEmp' => $endEmp,
            'funcionamento' => $funcionamento,
            'dias' => $dias,
            'usuarioAtivo' => $resulUsuario,
            'carrinhoQtd' => $resultCarrinhoQtd,
            'resulEnderecos' => $resulEnderecos,
            'detect' => new Mobile_Detect(),
            'estadosSelecao' => $resulEstados,
            'trans' => $this->trans,
            'usuarioLogado' => $usuarioLogado,
            'isLogin' => $this->sessao->getUser(),

        ]);
    }

    public function insertPrimeiroEndereco($data)
    {

        $geo = array();
        $addr = str_replace(" ", "+", $data['rua'] . ' ' . $data['numero'] . ', ' . $data['cidade'] . ' - ' . $data['estado']);
        $address = utf8_encode($addr);

        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=AIzaSyAxhvl-7RHUThhX4dNvCGEkPuOoT6qbuDQ');
        $output = json_decode($geocode);

        foreach ($output->results[0]->address_components as $component) {
            $componentType = $component->types[0];
            switch ($componentType) {
                case "street_number": {
                        $street_number = $component->long_name;
                        break;
                    }
                case "route": {
                        $rua = $component->long_name;
                        break;
                    }
                case "postal_code": {
                        $cep = $component->long_name;
                        break;
                    }
                case "administrative_area_level_2": {
                        $cidade = $component->long_name;
                        break;
                    }
                case "administrative_area_level_1": {
                        $estado = $component->short_name;
                        break;
                    }
                case "sublocality":
                    $bairro = $component->short_name;
                    break;
                case "political":
                    $bairro = $component->short_name;
                    break;
                case "sublocality_level_1":
                    $bairro = $component->short_name;
                    break;
            }
        }

        if ($data['numero']) {
            $novo = new UsuariosEnderecos();
            $novo->id_usuario = $this->sessao->getUser();
            $novo->nome_endereco = "Principal";
            $novo->rua = $rua;
            $novo->numero = $data['numero'];
            $novo->complemento = $data['complemento'];
            $novo->bairro = $bairro;
            $novo->cidade = $cidade;
            $novo->estado = $estado;
            $novo->cep = $cep;
            $novo->principal = 1;
            $novo->save();

            header('Content-Type: application/json');
            $json = json_encode(['id' => $novo->id, 'resp' => 'insert', 'mensagem' => 'Primeiro endere??o cadastrado com Sucesso!', 'error' => 'Erro ao cadastrar seu primeiro endere??o', 'code' => 2,  'url' => 'carrinho',]);
            exit($json);
        } else {
            header('Content-Type: application/json');
            $json = json_encode(['id' => 0, 'resp' => 'insert', 'error' => 'Vi que n??o informou o n??mero, informe como exemplo a seguir! (Ex.: Avenida Paulista 2073)']);
            exit($json);
        }
    }

    public function mudarEnderecoPrincipal($data)
    {
        $resulEnderecos = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
        if ($data['id'] != $resulEnderecos->id) {
            $valor = (new UsuariosEnderecos())->findById($resulEnderecos->id);
            $valor->principal = 0;
            $valor->save();

            if ($valor > 0) {
                $valorNovo = (new UsuariosEnderecos())->findById($data['id']);
                $valorNovo->principal = 1;
                $valorNovo->save();

                header('Content-Type: application/json');
                $json = json_encode(['id' => $valorNovo->id, 'resp' => 'insert', 'mensagem' => 'Endere??o definido como principal', 'url' => 'enderecos']);
                exit($json);
            }
        }
    }

    public function insertEndereco($data)
    {
        if ($data['principal'] == 1) {
            $resulEnderecos = $this->acoes->countsTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);

            if ($resulEnderecos > 0) {
                $endereco = $this->acoes->getByFieldTwo('usuariosEnderecos', 'id_usuario', $this->sessao->getUser(), 'principal', 1);
                $valor = (new UsuariosEnderecos())->findById($endereco->id);
                $valor->principal = 0;
                $valor->save();
            }
        }

        $geo = array();
        $addr = str_replace(" ", "+", $data['rua'] . ' ' . $data['numero'] . ', ' . $data['cidade'] . ' - ' . $data['estado']);
        $address = utf8_encode($addr);

        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=AIzaSyAxhvl-7RHUThhX4dNvCGEkPuOoT6qbuDQ');
        $output = json_decode($geocode);

        foreach ($output->results[0]->address_components as $component) {
            $componentType = $component->types[0];
            switch ($componentType) {
                case "street_number": {
                        $street_number = $component->long_name;
                        break;
                    }
                case "route": {
                        $rua = $component->long_name;
                        break;
                    }
                case "postal_code": {
                        $cep = $component->long_name;
                        break;
                    }
                case "administrative_area_level_2": {
                        $cidade = $component->long_name;
                        break;
                    }
                case "administrative_area_level_1": {
                        $estado = $component->short_name;
                        break;
                    }
                case "sublocality":
                    $bairro = $component->short_name;
                    break;
                case "political":
                    $bairro = $component->short_name;
                    break;
                case "sublocality_level_1":
                    $bairro = $component->short_name;
                    break;
            }
        }

        $novo = new UsuariosEnderecos();
        $novo->id_usuario = $this->sessao->getUser();
        $novo->nome_endereco = $data['nome_endereco'];
        $novo->rua = $rua;
        $novo->numero = $data['numero'];
        $novo->complemento = $data['complemento'];
        $novo->bairro = $bairro;
        $novo->cidade = $cidade;
        $novo->estado = $estado;
        $novo->cep = $cep;
        $novo->principal = $data['principal'];
        $novo->save();

        header('Content-Type: application/json');
        $json = json_encode(['id' => $novo->id, 'resp' => 'insert', 'mensagem' => 'Endere??o cadastrado com Sucesso!', 'error' => 'Erro ao cadastrar um novo endere??o', 'code' => 2,  'url' => 'enderecos',]);
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
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Endere??o atualizado com Sucesso!', 'error' => 'Erro ao atualizar o endere??o', 'code' => 2,  'url' => 'enderecos',]);
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
        $json = json_encode(['id' => $valor->id, 'resp' => 'update', 'mensagem' => 'Dados atualizado com sucesso', 'error' => 'Erro ao atualizar o seus dados', 'code' => 2,  'url' => 'perfil',]);
        exit($json);
    }
}

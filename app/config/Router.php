<?php
use CoffeeCode\Router\Router;
/*
    Inclusão das Controllers
*/
require "../app/controller/AdminGeral.php";
require "../app/controller/AdminCupom.php";
require "../app/controller/AdminStatus.php";
require "../app/controller/AdminPlanos.php";
require "../app/controller/AdminRating.php";
require "../app/controller/AdminPedidos.php";
require "../app/controller/AllController.php";
require "../app/controller/AdminMotoboys.php";
require "../app/controller/AdminProdutos.php";
require "../app/controller/AdminDashboard.php";
require "../app/controller/PagesController.php";
require "../app/controller/AdminCategorias.php";
require "../app/controller/AdminAtendimento.php";
require "../app/controller/PerfilController.php";
require "../app/controller/RatingController.php";
require "../app/controller/MessageController.php";
require "../app/controller/AdminDeliveryTipo.php";
require "../app/controller/PedidosController.php";
require "../app/controller/UsuarioController.php";
require "../app/controller/AdminEmpresaFrete.php";
require "../app/controller/TestAPIController.php";
require "../app/controller/CarrinhoController.php";
require "../app/controller/AdminConfiguracoes.php";
require "../app/controller/AdminTipoAdicional.php";
require "../app/controller/FavoritosController.php";
require "../app/controller/AdminProdutoSabores.php";
require "../app/controller/AdminFormasPagamento.php";
require "../app/controller/AdminiFoodController.php";
require "../app/controller/AdminUberEatsController.php";
require "../app/controller/PerfilMotoboyController.php";
require "../app/controller/AdminProdutosAdicionais.php";
require "../app/controller/InstitucionalController.php";
require "../app/controller/PedidosMotoboyController.php";
require "../app/controller/EmpresaCadastroController.php";
require "../app/controller/AdminPedidosBalcaoController.php";
require "../app/controller/AdminClickEntregasController.php";



$router = new Router(BASE);
$router->namespace("app\controller");

/*
    Paginas do portal
*/
$router->group(null);
$router->get('/', 'PagesController:index');
$router->get('/', 'PagesController:index');

$router->get('/sobre-nos', 'InstitucionalController:index');
$router->get('/visao-valores', 'InstitucionalController:visaoValores');
$router->get('/trabalhe-conosco', 'InstitucionalController:trabalheConosco');
$router->get('/contato', 'InstitucionalController:contatoConosco');

$router->get('/cadastro/empresa', 'EmpresaCadastroController:index');
$router->post('/cadastro/empresa/i', 'EmpresaCadastroController:insert');


$router->get('/{linkSite}', 'PagesController:home');
$router->get('/{linkSite}/', 'PagesController:home');
$router->get('/{linkSite}/intro', 'PagesController:bemVindo');
$router->get('/{linkSite}/novo-por-aqui', 'PagesController:novoDelivery');
$router->get('/{linkSite}/delivery', 'PagesController:quemSomos');
$router->get('/{linkSite}/fale-conosco', 'PagesController:contato');
$router->post('/{linkSite}/contato/i', 'PagesController:contatoSend');
$router->get('/{linkSite}/termos-de-uso', 'PagesController:termosUso');
$router->get('/{linkSite}/politica-de-privacidade', 'PagesController:politicaPrivacidade');

/**
 * Listagem para tempo de execução
 */
$router->get('/{linkSite}/home/ultimaVenda', 'PagesController:ultimaVenda');
$router->get('/{linkSite}/login', 'UsuarioController:login');
$router->post('/{linkSite}/login/valida', 'UsuarioController:login');
$router->get('/{linkSite}/login/validaFacebook', 'UsuarioController:loginFacebook');
$router->get('/{linkSite}/login/n', 'AllController:verificaNivel');
$router->get('/{linkSite}/sair', 'AllController:sair');
$router->get('/{linkSite}/recuperar-senha', 'UsuarioController:senhaPerdida');
$router->post('/{linkSite}/recuperar-senha/recuperar', 'UsuarioController:senhaPerdidaRecupera');
$router->get('/{linkSite}/recuperar/98e4011142eeb9842091bf4812f81656a7d80eac/{id}', 'UsuarioController:novaSenhaPerdida');
$router->post('/{linkSite}/recuperar/senha/i', 'UsuarioController:insertRecuperacaoSenha');
$router->get('/{linkSite}/cadastro', 'UsuarioController:cadastro');
$router->get('/{linkSite}/cadastro/motoboy', 'UsuarioController:cadastroMotoca');
$router->get('/{linkSite}/cadastro/atendente', 'UsuarioController:cadastroAtendente');
$router->post('/{linkSite}/cadastro/novo', 'UsuarioController:insert');
$router->get('/{linkSite}/cadastro/finaliza', 'UsuarioController:cadastroSocial');
$router->post('/{linkSite}/cadastro/finaliza/social', 'UsuarioController:insertSocial');

$router->get('/{linkSite}/valida/acesso', 'UsuarioController:validaAcesso');
$router->post('/{linkSite}/valida/acesso/code', 'UsuarioController:usuarioValidaAcessoCode');
$router->get('/{linkSite}/u/valid', 'UsuarioController:verificaLoginJs');
$router->post('/{linkSite}/u/l/val', 'UsuarioController:usuarioLogin');


/*
    Cliente
*/
$router->get('/{linkSite}/produto/{id}', 'CarrinhoController:index');
$router->post('/{linkSite}/produto/addCarrinho/{id}', 'CarrinhoController:insert');
$router->post('/{linkSite}/produto/updateCarrinho/{id}', 'CarrinhoController:carrinhoCheckoutUpdate');

$router->get('/{linkSite}/produto/adicional/{id}', 'CarrinhoController:carrinhoAdicional');
$router->get('/{linkSite}/produto/adicional/atualiza/{id}', 'CarrinhoController:carrinhoCheckoutAdicionalUpdate');
$router->post('/{linkSite}/produto/addCarrinho/adicionais', 'CarrinhoController:insertUpdateProdutoAdicional');
$router->post('/{linkSite}/carrinho/finaliza', 'CarrinhoController:carrinhoCheckoutFinal');
$router->get('/{linkSite}/carrinho/pedido/acao/{id_produto}/{id_carrinho}', 'CarrinhoController:carrinhoProdutoAcao');
$router->get('/{linkSite}/carrinho/{id_produto}/d/{id_carrinho}', 'CarrinhoController:deletarProdutoCarrinho');

// $router->get('/{linkSite}/produto/adicional/atualiza/{chave}/{id}', 'CarrinhoController:carrinhoCheckoutAdicionalUpdate');
// $router->get('/{linkSite}/produto/removeCarrinho/adicionalis/{chave}', 'CarrinhoController:removeCarrinhoCheckoutAdicional');

$router->get('/{linkSite}/carrinho', 'CarrinhoController:carrinho');

$router->get('/{linkSite}/carrinho/dados', 'CarrinhoController:carrinhoCadastro');
$router->post('/{linkSite}/carrinho/cadastro/valida', 'CarrinhoController:carrinhoCadastroValida');

$router->get('/{linkSite}/carrinho/valida/acesso', 'CarrinhoController:carrinhoVisitanteCadastroValida');
$router->post('/{linkSite}/carrinho/valida/acesso/code', 'CarrinhoController:carrinhoValidaAcessoCode');
$router->get('/{linkSite}/carrinho/entrega', 'CarrinhoController:carrinhoVisitanteEndereco');
$router->get('/{linkSite}/produto/{id_produto}/e/{id_carrinho}', 'CarrinhoController:carrinhoProdutoEditar');


$router->post('/{linkSite}/cupomDesconto', 'CarrinhoController:carrinhoValidaCupom');

$router->get('/{linkSite}/avaliacao/{numero_pedido}', 'RatingController:index');
$router->post('/{linkSite}/avaliar/pedido', 'RatingController:rating');
$router->get('/{linkSite}/meus-pedidos', 'PedidosController:index');
$router->get('/{linkSite}/meu-pedido/{chave}', 'PedidosController:view');
$router->post('/{linkSite}/meu-pedido/cancelar', 'PedidosController:cancelarPedido');


/**
 * Listagem para tempo de execução
 */
$router->get('/{linkSite}/meu-pedido/acompanharStatusPedido/{numero_pedido}', 'PedidosController:statusPedidoFull');
$router->get('/{linkSite}/favoritos', 'FavoritosController:index');
$router->get('/{linkSite}/favorito/{id}', 'FavoritosController:inserirFavorito');
$router->get('/{linkSite}/favorito/d/{id}', 'FavoritosController:deletarFavorito');
$router->get('/{linkSite}/perfil', 'PerfilController:index');
$router->get('/{linkSite}/perfil/{id}', 'PerfilController:editar');
$router->get('/{linkSite}/alterar-senha', 'PerfilController:senha');
$router->get('/{linkSite}/dados-cadastrais', 'PerfilController:dadosCadastrais');
$router->post('/{linkSite}/dados-cadastrais/u', 'PerfilController:updateDados');


$router->get('/{linkSite}/enderecos', 'PerfilController:enderecos');
$router->get('/{linkSite}/endereco/novo', 'PerfilController:novoEndereco');
$router->get('/{linkSite}/endereco/novo/cadastro', 'PerfilController:novoEnderecoPrimeiro');
$router->get('/{linkSite}/endereco/{id}/editar', 'PerfilController:editarEndereco');
$router->post('/{linkSite}/endereco/principal/{id}', 'PerfilController:editarPrincipal');

$router->post('/{linkSite}/endereco/i', 'PerfilController:insertEndereco');
$router->post('/{linkSite}/endereco/u', 'PerfilController:updateEndereco');
$router->get('/{linkSite}/endereco/d/{id}', 'PerfilController:deletarEndereco');

/*
    Admin Aplicação Motoboy
*/
$router->get('/{linkSite}/motoboy', 'PedidosMotoboyController:relatorio');
$router->get('/{linkSite}/motoboy/', 'PedidosMotoboyController:relatorio');
$router->get('/{linkSite}/motoboy/entregas', 'PedidosMotoboyController:index');
$router->get('/{linkSite}/motoboy/entrega/{numero_pedido}', 'PedidosMotoboyController:view');
$router->get('/{linkSite}/motoboy/pegar/entrega', 'PedidosMotoboyController:pesquisarEntrega');
$router->get('/{linkSite}/motoboy/pegar/entrega/busca', 'PedidosMotoboyController:getEntrega');
$router->post('/{linkSite}/motoboy/pegar/entrega/mudarStatus', 'PedidosMotoboyController:mudarStatusMotoboy');
$router->post('/{linkSite}/motoboy/entrega/mudarStatus', 'PedidosMotoboyController:mudarStatus');
$router->get('/{linkSite}/motoboy/buscar/entregas/mes', 'PedidosMotoboyController:relatorioMes');

/**
 * Listagem para tempo de execução
 */
$router->get('/{linkSite}/motoboy/pedido/listar', 'PedidosMotoboyController:entregaListar');
$router->get('/{linkSite}/motoboy/pedido/listar/qtd', 'PedidosMotoboyController:numeroEntregaListar');
$router->get('/{linkSite}/motoboy/perfil', 'PerfilMotoboyController:index');
$router->get('/{linkSite}/motoboy/dados-veiculo', 'PerfilMotoboyController:editar');
$router->get('/{linkSite}/motoboy/alterar-senha', 'PerfilMotoboyController:senha');
$router->get('/{linkSite}/motoboy/alterar-telefone', 'PerfilMotoboyController:telefone');
$router->post('/{linkSite}/motoboy/perfil/senha/u', 'PerfilMotoboyController:updateSenha');
$router->post('/{linkSite}/motoboy/perfil/telefone/u', 'PerfilMotoboyController:updateTelefone');
$router->post('/{linkSite}/motoboy/placa/editar', 'PerfilMotoboyController:updatePlaca');
$router->post('/{linkSite}/motoboy/senha/u', 'PerfilMotoboyController:updateSenha');

/*
    Admin Aplicação
*/

$router->get('/admin', 'AdminDashboard:index');


$router->get('/{linkSite}/admin', 'AdminDashboard:index');
$router->get('/{linkSite}/admin/', 'AdminDashboard:index');
$router->get('/{linkSite}/admin/sair', 'AllController:sairAdmin');
$router->get('/{linkSite}/admin/caixa/visao-geral', 'AdminDashboard:relatorioGeral');
$router->get('/{linkSite}/admin/caixa/relatorio', 'AdminDashboard:caixaLista');
$router->get('/{linkSite}/admin/caixa/dia/{id}', 'AdminDashboard:caixaDados');

$router->get('/{linkSite}/admin/avaliacao', 'AdminRating:index');
$router->get('/{linkSite}/admin/docs', 'AdminGeral:index');

/**
 * Planos de utilização Estabelecimento
 */
$router->get('/{linkSite}/admin/planos', 'AdminPlanos:index');
$router->get('/{linkSite}/admin/plano/{id}/{slug}', 'AdminPlanos:plano');
$router->post('/{linkSite}/admin/plano/selecionado/contratar', 'AdminPlanos:cobrancaPlano');
$router->post('/{linkSite}/admin/plano/novo', 'AdminPlanos:criarPlano');
$router->post('/{linkSite}/admin/plano/relatorio', 'AdminPlanos:planosCobrancas');
$router->put('/{linkSite}/admin/plano/cancelar', 'AdminPlanos:cancelarCobranca');

$router->get('/admin/login', 'UsuarioController:loginAdmin');
$router->get('/{linkSite}/admin/login', 'UsuarioController:loginEstabelecimento');
$router->post('/admin/login/valida', 'UsuarioController:loginValida');

$router->get('/admin/login', 'UsuarioController:loginGeral');

$router->get('/{linkSite}/admin/login/validaFacebook', 'UsuarioController:loginFacebook');
$router->get('/{linkSite}/admin/recuperar-senha', 'UsuarioController:senhaPerdida');
$router->post('/{linkSite}/admin/recuperar-senha/recuperar', 'UsuarioController:senhaPerdidaRecupera');
$router->get('/{linkSite}/admin/recuperar/98e4011142eeb9842091bf4812f81656a7d80eac/{id}', 'UsuarioController:novaSenhaPerdida');
$router->post('/{linkSite}/admin/recuperar/senha/i', 'UsuarioController:insertRecuperacaoSenha');
$router->post('/{linkSite}/admin/iniciar-atendimento', 'AllController:iniciarAtendimento');
$router->post('/{linkSite}/admin/finalizar-atendimento', 'AllController:finalizarAtendimento');
$router->get('/{linkSite}/admin/pedidos', 'AdminPedidos:index');
$router->get('/{linkSite}/admin/pedidos-finalizados', 'AdminPedidos:pedidosFinalizados');
$router->get('/{linkSite}/admin/pedidos-cancelados', 'AdminPedidos:pedidosCancelados');
$router->get('/{linkSite}/admin/todas-entregas', 'AdminPedidos:todasEntregas');

$router->get('/{linkSite}/admin/entregas', 'AdminMotoboys:entregas');
$router->get('/{linkSite}/admin/entregas-finalizadas', 'AdminMotoboys:entregasFinalizados');

/**
 * Busca das entregas de cada Motoboy
 */
$router->post('/{linkSite}/admin/buscar/entregas', 'AdminMotoboys:entregasBuscar');
$router->get('/{linkSite}/admin/informar/pagamento/entregas', 'AdminMotoboys:entregasPagamento');

/**
 * Listagem para tempo de execução
 */
$router->get('/{linkSite}/admin/pedidos/recebido', 'AdminPedidos:pedidosRecebido');
$router->get('/{linkSite}/admin/pedidos/producao', 'AdminPedidos:pedidosProducao');
$router->get('/{linkSite}/admin/pedidos/geral', 'AdminPedidos:pedidosGeral');
$router->get('/{linkSite}/admin/pedido/mostrar/{id}/{numero_pedido}', 'AdminPedidos:pedidoMostrar');
$router->get('/{linkSite}/admin/pedido/imprimir/{id}', 'AdminPedidos:pedidoImprimir');
$router->get('/{linkSite}/admin/pedido/imprimirtest', 'AdminPedidos:pedidoTestImprimir');

$router->post('/{linkSite}/admin/pedido/mudar/{id}/{status}/{id_caixa}/{motoboy}', 'AdminPedidos:mudarStatus');


$router->get('/{linkSite}/admin/pedido/novo', 'AdminPedidosBalcaoController:index');
$router->post('/{linkSite}/admin/novo/cliente', 'AdminPedidosBalcaoController:carrinhoCadastroValida');

$router->get('/{linkSite}/admin/pedido/novo/produtos', 'AdminPedidosBalcaoController:produtos');

$router->post('/{linkSite}/admin/produto/addCarrinho/produto/{id}', 'AdminPedidosBalcaoController:carrinhoAddProduto');

$router->get('/{linkSite}/admin/carrinho/qtd', 'AdminPedidosBalcaoController:carrinhoQtd');


$router->post('/{linkSite}/admin/pedido/novo/start', 'AdminPedidosBalcaoController:start');
$router->get('/{linkSite}/admin/produto/novo/mostrar/{id}', 'AdminPedidosBalcaoController:produtoMostrar');
$router->get('/{linkSite}/admin/pedido/novo/produtos/detalhes', 'AdminPedidosBalcaoController:carrinhoFinalizar');
$router->get('/{linkSite}/admin/produto/adicional/atualiza/{chave}/{id}', 'AdminPedidosBalcaoController:carrinhoCheckoutAdicionalUpdate');
$router->get('/{linkSite}/admin/produto/addCarrinho/{id}', 'AdminPedidosBalcaoController:carrinhoCheckout');
$router->get('/{linkSite}/admin/produto/addCarrinho/adicionalis/{chave}', 'AdminPedidosBalcaoController:addCarrinhoCheckoutAdicional');
$router->get('/{linkSite}/admin/produto/removeCarrinho/adicionalis/{chave}', 'AdminPedidosBalcaoController:removeCarrinhoCheckoutAdicional');

$router->get('/{linkSite}/admin/carrinho', 'AdminPedidosBalcaoController:carrinho');
$router->get('/{linkSite}/admin/carrinho/deletar/{id_produto}/{id_carrinho}', 'AdminPedidosBalcaoController:deletarItemCarrinho');
$router->post('/{linkSite}/admin/carrinho/finaliza', 'AdminPedidosBalcaoController:carrinhoFinalizarPedido');
$router->get('/{linkSite}/admin/carrinho/pedido/acao/{id_produto}/{id_carrinho}', 'CarrinhoController:carrinhoProdutoAcao');


$router->get('/{linkSite}/admin/produtos', 'AdminProdutos:index');
$router->get('/{linkSite}/admin/produto/novo', 'AdminProdutos:novo');
$router->get('/{linkSite}/admin/produto/editar/{id}', 'AdminProdutos:editar');
$router->post('/{linkSite}/admin/produto/i', 'AdminProdutos:insert');
$router->post('/{linkSite}/admin/produto/u/{id}', 'AdminProdutos:update');
$router->get('/{linkSite}/admin/produto/d/{id}', 'AdminProdutos:deletar');
$router->post('/{linkSite}/admin/upload', 'AdminProdutos:uploadImagem');
$router->get('/{linkSite}/admin/produtos-adicionais', 'AdminProdutosAdicionais:index');
$router->get('/{linkSite}/admin/produto-adicional/novo', 'AdminProdutosAdicionais:novo');
$router->get('/{linkSite}/admin/produto-adicional/editar/{id}', 'AdminProdutosAdicionais:editar');
$router->post('/{linkSite}/admin/produto-adicional/i', 'AdminProdutosAdicionais:insert');
$router->post('/{linkSite}/admin/produto-adicional/u/{id}', 'AdminProdutosAdicionais:update');
$router->get('/{linkSite}/admin/produto-adicional/d/{id}', 'AdminProdutosAdicionais:deletar');
$router->get('/{linkSite}/admin/produtos-sabores', 'AdminProdutosSabores:index');
$router->get('/{linkSite}/admin/produto-sabor/novo', 'AdminProdutosSabores:novo');
$router->get('/{linkSite}/admin/produto-sabor/editar/{id}', 'AdminProdutosSabores:editar');
$router->post('/{linkSite}/admin/produto-sabor/insert', 'AdminProdutosSabores:insert');
$router->post('/{linkSite}/admin/produto-sabor/update', 'AdminProdutosSabores:update');
$router->get('/{linkSite}/admin/produto-sabor/d/{id}', 'AdminProdutosSabores:deletar');
$router->get('/{linkSite}/admin/categorias', 'AdminCategorias:index');
$router->get('/{linkSite}/admin/categoria/nova', 'AdminCategorias:novo');
$router->get('/{linkSite}/admin/categoria/editar/{id}', 'AdminCategorias:editar');
$router->post('/{linkSite}/admin/categoria/i', 'AdminCategorias:insert');
$router->post('/{linkSite}/admin/categoria/u/{id}', 'AdminCategorias:update');
$router->get('/{linkSite}/admin/categoria/d/{id}', 'AdminCategorias:deletar');
$router->get('/{linkSite}/admin/tipo-adicionais', 'AdminTipoAdicional:index');
$router->get('/{linkSite}/admin/tipo-adicional/nova', 'AdminTipoAdicional:novo');
$router->get('/{linkSite}/admin/tipo-adicional/editar/{id}', 'AdminTipoAdicional:editar');
$router->post('/{linkSite}/admin/tipo-adicional/i', 'AdminTipoAdicional:insert');
$router->post('/{linkSite}/admin/tipo-adicional/u/{id}', 'AdminTipoAdicional:update');
$router->get('/{linkSite}/admin/tipo-adicional/d/{id}', 'AdminTipoAdicional:deletar');
$router->get('/{linkSite}/admin/delivery', 'AdminDeliveryTipo:index');
$router->get('/{linkSite}/admin/delivery/editar/{id}', 'AdminDeliveryTipo:editar');
$router->post('/{linkSite}/admin/delivery/u/{id}', 'AdminDeliveryTipo:update');
$router->get('/{linkSite}/admin/delivery/d/{id}', 'AdminDeliveryTipo:deletar');

$router->get('/{linkSite}/admin/cupons', 'AdminCupom:index');
$router->get('/{linkSite}/admin/cupom/novo', 'AdminCupom:novo');
$router->get('/{linkSite}/admin/cupom/editar/{id}', 'AdminCupom:editar');
$router->post('/{linkSite}/admin/cupom/i', 'AdminCupom:insert');

$router->get('/{linkSite}/admin/motoboys', 'AdminMotoboys:index');
$router->get('/{linkSite}/admin/motoboy/novo', 'AdminMotoboys:novo');
$router->post('/{linkSite}/admin/motoboy/i', 'AdminMotoboys:insert');
$router->get('/{linkSite}/admin/motoboy/editar/{id}', 'AdminMotoboys:editar');
$router->post('/{linkSite}/admin/motoboy/u/{id}', 'AdminMotoboys:update');
$router->get('/{linkSite}/admin/motoboy/d/{id}/{url_dell}', 'AdminMotoboys:deletar');

$router->get('/{linkSite}/admin/usuarios', 'UsuarioController:index');
$router->get('/{linkSite}/admin/clientes', 'UsuarioController:clientes');
$router->get('/{linkSite}/admin/cliente/novo', 'UsuarioController:novoCliente');
$router->post('/{linkSite}/admin/cliente/novo/i', 'UsuarioController:insertNovoCliente');
$router->get('/{linkSite}/admin/cliente/d/{id}/{url_dell}', 'UsuarioController:deletar');

$router->get('/{linkSite}/admin/atendentes', 'UsuarioController:atendentes');
$router->post('/{linkSite}/admin/atendente/i', 'UsuarioController:insert');
$router->post('/{linkSite}/admin/atendente/u', 'UsuarioController:update');
$router->get('/{linkSite}/admin/atendente/editar/{id}', 'UsuarioController:atendenteEditar');
$router->get('/{linkSite}/admin/atendente/novo', 'UsuarioController:atendenteNovo');
$router->get('/{linkSite}/admin/atendente/d/{id}/{url_dell}', 'UsuarioController:deletar');

$router->get('/{linkSite}/admin/administradores', 'UsuarioController:administradores');
$router->post('/{linkSite}/admin/administrador/i', 'UsuarioController:insert');
$router->post('/{linkSite}/admin/administrador/u', 'UsuarioController:update');
$router->get('/{linkSite}/admin/administrador/editar/{id}', 'UsuarioController:administradorEditar');
$router->get('/{linkSite}/admin/administrador/novo', 'UsuarioController:administradorNovo');
$router->get('/{linkSite}/admin/administrador/d/{id}/{url_dell}', 'UsuarioController:deletar');

$router->get('/{linkSite}/admin/clientes', 'UsuarioController:clientes');
$router->post('/{linkSite}/admin/cliente/i', 'UsuarioController:insert');
$router->post('/{linkSite}/admin/cliente/u', 'UsuarioController:update');
$router->get('/{linkSite}/admin/cliente/editar/{id}', 'UsuarioController:clienteEditar');
$router->get('/{linkSite}/admin/cliente/novo', 'UsuarioController:clienteNovo');

$router->get('/{linkSite}/admin/conf/e', 'AdminConfiguracoesController:index');
$router->post('/{linkSite}/admin/conf/u', 'AdminConfiguracoesController:update');

$router->get('/{linkSite}/admin/conf/delivery/e', 'AdminEmpresaFrete:index');
$router->post('/{linkSite}/admin/conf/delivery/u', 'AdminEmpresaFrete:update');

$router->get('/{linkSite}/admin/conf/atendimento', 'AdminAtendimento:index');
$router->get('/{linkSite}/admin/conf/atendimento/novo', 'AdminAtendimento:novo');
$router->get('/{linkSite}/admin/conf/atendimento/editar/{id}', 'AdminAtendimento:editar');
$router->post('/{linkSite}/admin/conf/atendimento/i', 'AdminAtendimento:insert');
$router->post('/{linkSite}/admin/conf/atendimento/u', 'AdminAtendimento:update');
$router->delete('/{linkSite}/admin/conf/atendimento/delete', 'AdminAtendimento:delete');

$router->get('/{linkSite}/admin/formas-pagamento', 'AdminFormasPagamento:index');
$router->get('/{linkSite}/admin/formas-pagamento/nova', 'AdminFormasPagamento:novo');
$router->get('/{linkSite}/admin/formas-pagamento/editar/{id}', 'AdminFormasPagamento:editar');
$router->post('/{linkSite}/admin/formas-pagamento/i', 'AdminFormasPagamento:insert');
$router->post('/{linkSite}/admin/formas-pagamento/u/{id}', 'AdminFormasPagamento:update');
$router->get('/{linkSite}/admin/formas-pagamento/d/{id}', 'AdminFormasPagamento:deletar');


$router->get('/{linkSite}/admin/status', 'AdminStatus:index');
$router->get('/{linkSite}/admin/status/editar/{id}', 'AdminStatus:editar');
$router->post('/{linkSite}/admin/status/u/{id}', 'AdminStatus:update');




$router->get('/{linkSite}//adminpedidos/ifood', 'AdminIfoodController:polling');
$router->post('/{linkSite}/admin/sync/categoria/ifood', 'AdminIfoodController:syncCategory');
$router->post('/{linkSite}/admin/sync/produto/ifood', 'AdminIfoodController:syncProduct');

$router->get('/{linkSite}/admin/ifood', 'AdminIfoodController:index');

$router->post('/{linkSite}/admin/conectar/ifood', 'AdminIfoodController:autorizar');
$router->post('/{linkSite}/admin/conectar/ifood/final', 'AdminIfoodController:autorizarCode');

$router->get('/{linkSite}/admin/ifoodtest', 'AdminIfoodController:ifoodTest');

$router->get('/{linkSite}/admin/ubereats', 'AdminUberEatsController:index');
$router->get('/{linkSite}/admin/click-entregas', 'AdminClickEntregasController:index');

/**
 * Group Error
 * This monitors all Router errors. Are they: 400 Bad Request, 404 Not Found, 405 Method Not Allowed and 501 Not Implemented
 */
//$router->get("/{errcode}", "PagesController:notfound");

$router->__debugInfo();
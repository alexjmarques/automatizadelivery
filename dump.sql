CREATE TABLE usuarios (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL DEFAULT '',
  telefone VARCHAR(20) DEFAULT '',
  senha VARCHAR(255) DEFAULT '',
  nivel INT NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE empresa_dados (
  id SERIAL PRIMARY KEY,
  id_categoria INT NULL DEFAULT NULL,
  nome_fantasia VARCHAR(255) NOT NULL DEFAULT '',
  telefone CHAR(100) NOT NULL DEFAULT '',
  id_moeda INT NOT NULL,
  nf_paulista INT NOT NULL,
  razao_social VARCHAR(255) DEFAULT NULL,
  cnpj CHAR(30) DEFAULT NULL,
  sobre TEXT,
  logo VARCHAR(255) DEFAULT NULL,
  capa VARCHAR(255) DEFAULT NULL,
  dias_atendimento CHAR(22) DEFAULT NULL,
  email_contato VARCHAR(255) DEFAULT NULL,
  link_site VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE empresa_caixa (
  id SERIAL PRIMARY KEY,
  data_inicio date NOT NULL,
  hora_inicio time NOT NULL,
  data_final date DEFAULT NULL,
  hora_final time DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE categorias (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL DEFAULT '',
  descricao VARCHAR(255) DEFAULT '',
  slug VARCHAR(255) DEFAULT '',
  produtos INT DEFAULT NULL,
  posicao INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE produtos (
  id SERIAL PRIMARY KEY,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  id_categoria INT NOT NULL REFERENCES categorias(id),
  nome VARCHAR(255) NOT NULL DEFAULT '',
  valor DECIMAL(8,2) NOT NULL,
  descricao VARCHAR(255) DEFAULT '',
  observacao VARCHAR(255) DEFAULT NULL,
  valor_promocional DECIMAL(8,2) DEFAULT NULL,
  imagem TEXT,
  adicional VARCHAR(255) DEFAULT NULL,
  sabores VARCHAR(255) DEFAULT NULL,
  status INT DEFAULT NULL,
  dias_disponiveis CHAR(20) DEFAULT NULL,
  vendas INT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE apd_assinatura (
  id SERIAL PRIMARY KEY,
  subscription_id VARCHAR(255) NOT NULL DEFAULT '',
  plano_id INT NOT NULL,
  status VARCHAR(11) NOT NULL DEFAULT '',
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE apd_credit_card (
  id SERIAL PRIMARY KEY,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  user_holder VARCHAR(255) NOT NULL DEFAULT '',
  hash VARCHAR(255) DEFAULT NULL,
  brand VARCHAR(255) DEFAULT NULL,
  last_digits VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE apd_end_credit_card (
  id SERIAL PRIMARY KEY,
  id_usuario INT NOT NULL REFERENCES usuarios(id),
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  rua VARCHAR(100) DEFAULT '',
  numero VARCHAR(20) DEFAULT '',
  complemento VARCHAR(255) DEFAULT NULL,
  bairro VARCHAR(255) DEFAULT '',
  cidade VARCHAR(255) DEFAULT '',
  estado INT DEFAULT NULL,
  cep VARCHAR(80) DEFAULT '',
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE apd_planos (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL DEFAULT '',
  slug CHAR(60) DEFAULT NULL,
  descricao TEXT,
  limite INT DEFAULT NULL,
  valor DECIMAL(8,2) DEFAULT NULL,
  plano_id INT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
  
);

CREATE TABLE aux_categoria (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL DEFAULT '',
  slug VARCHAR(255) DEFAULT '',
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE aux_categoria_sub (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL DEFAULT '',
  slug VARCHAR(255) DEFAULT '',
  id_categoria INT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE aux_dias (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL DEFAULT '',
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);



CREATE TABLE aux_moeda (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) DEFAULT NULL,
  simbolo VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
  
);

CREATE TABLE aux_pagamento (
  id SERIAL PRIMARY KEY,
  tipo VARCHAR(100) DEFAULT NULL,
  code INT DEFAULT NULL,
  status INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE aux_status (
  id SERIAL PRIMARY KEY,
  delivery VARCHAR(100) NOT NULL DEFAULT '',
  retirada VARCHAR(100) DEFAULT NULL,
  class VARCHAR(11) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE aux_tipo_delivery (
  id SERIAL PRIMARY KEY,
  code INT DEFAULT NULL,
  tipo VARCHAR(200) DEFAULT NULL,
  status INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE avaliacao (
  id SERIAL PRIMARY KEY,
  numero_pedido INT DEFAULT NULL,
  id_cliente INT NOT NULL REFERENCES usuarios(id),
  id_motoboy INT DEFAULT NULL REFERENCES usuarios(id),
  avaliacao_pedido CHAR(11) DEFAULT NULL,
  avaliacao_motoboy CHAR(11) DEFAULT NULL,
  observacao TEXT,
  data_compra TIMESTAMP DEFAULT NULL,
  data_votacao TIMESTAMP DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE carrinho (
  id SERIAL PRIMARY KEY,
  id_produto INT NOT NULL,
  id_cliente INT NOT NULL REFERENCES usuarios(id),
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  quantidade INT NOT NULL,
  id_sabores INT DEFAULT NULL,
  id_adicional CHAR(20) DEFAULT NULL,
  observacao TEXT,
  valor DECIMAL(8,2) DEFAULT NULL,
  numero_pedido VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE carrinho_adicional (
  id SERIAL PRIMARY KEY,
  id_carrinho INT DEFAULT NULL,
  id_produto INT NOT NULL REFERENCES produtos(id),
  id_cliente INT NOT NULL REFERENCES usuarios(id),
  id_adicional INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  quantidade INT DEFAULT NULL,
  valor DECIMAL(8,2) DEFAULT NULL,
  numero_pedido INT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE carrinho_cpf_nota (
  id SERIAL PRIMARY KEY,
  id_cliente INT NOT NULL REFERENCES usuarios(id),
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  numero_pedido INT NOT NULL,
  cpf CHAR(70) NOT NULL DEFAULT '',
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE carrinho_entregas (
  id SERIAL PRIMARY KEY,
  id_motoboy INT NOT NULL,
  id_caixa INT NOT NULL REFERENCES empresa_caixa(id),
  id_cliente INT NOT NULL REFERENCES usuarios(id),
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  status INT DEFAULT NULL,
  observacao TEXT,
  numero_pedido VARCHAR(200) DEFAULT NULL,
  pago INT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);



CREATE TABLE carrinho_Pedido_Pagamento (
  id SERIAL PRIMARY KEY,
  id_cliente INT NOT NULL REFERENCES usuarios(id),
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  id_tipo_pagamento INT DEFAULT NULL,
  numero_pedido INT DEFAULT NULL,
  pag_cartao DECIMAL(8,2) DEFAULT NULL,
  pag_dinheiro DECIMAL(8,2) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE carrinho_pedidos (
  id SERIAL PRIMARY KEY,
  id_caixa INT NOT NULL REFERENCES empresa_caixa(id),
  id_cliente INT NOT NULL REFERENCES usuarios(id),
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  id_motoboy INT DEFAULT NULL REFERENCES usuarios(id),
  total DECIMAL(8,2) DEFAULT NULL,
  total_pago DECIMAL(8,2) DEFAULT NULL,
  troco DECIMAL(8,2) DEFAULT NULL,
  tipo_pagamento INT DEFAULT NULL,
  tipo_frete INT DEFAULT NULL,
  data_pedido date DEFAULT NULL,
  hora time DEFAULT NULL,
  status INT NOT NULL,
  pago INT DEFAULT NULL,
  observacao VARCHAR(350) DEFAULT NULL,
  numero_pedido SERIAL NOT NULL,
  valor_frete DECIMAL(8,2) DEFAULT NULL,
  km CHAR(20) DEFAULT NULL,
  chave VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);






CREATE TABLE categoria_tipo_adicional (
  id SERIAL PRIMARY KEY,
  tipo VARCHAR(255) DEFAULT NULL,
  slug VARCHAR(255) DEFAULT NULL,
  tipo_escolha INT DEFAULT NULL,
  qtd CHAR(11) DEFAULT NULL,
  status INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
  
); 


CREATE TABLE contato (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) DEFAULT NULL,
  email VARCHAR(200) DEFAULT NULL,
  telefone CHAR(15) DEFAULT NULL,
  mensagem TEXT,
  data_envio TIMESTAMP NULL DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE cupom_desconto (
  id SERIAL PRIMARY KEY,
  tipo_cupom INT DEFAULT NULL,
  nome_cupom CHAR(100) DEFAULT NULL,
  valor_cupom DECIMAL(8,2) DEFAULT NULL,
  expira TIMESTAMP NULL DEFAULT NULL,
  qtd_utilizacoes INT DEFAULT NULL,
  status INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE cupom_desconto_utilizacoes (
  id SERIAL PRIMARY KEY,
  id_cupom INT DEFAULT NULL,
  id_cliente INT NOT NULL REFERENCES usuarios(id),
  numero_pedido INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);






CREATE TABLE empresa_enderecos (
  id SERIAL PRIMARY KEY,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  rua VARCHAR(100) NOT NULL DEFAULT '',
  numero VARCHAR(20) NOT NULL DEFAULT '',
  complemento VARCHAR(255) DEFAULT NULL,
  bairro VARCHAR(255) DEFAULT '',
  cidade VARCHAR(255) DEFAULT '',
  estado CHAR(11) DEFAULT NULL,
  cep VARCHAR(80) DEFAULT '',
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE empresa_frete (
  id SERIAL PRIMARY KEY,
  status INT DEFAULT NULL,
  previsao_minutos VARCHAR(80) NOT NULL DEFAULT '',
  taxa_entrega DECIMAL(8,2) NOT NULL,
  km_entrega INT DEFAULT NULL,
  km_entrega_excedente INT DEFAULT NULL,
  valor_excedente DECIMAL(8,2) DEFAULT NULL,
  taxa_entrega_motoboy DECIMAL(8,2) DEFAULT NULL,
  valor DECIMAL(8,2) DEFAULT NULL,
  frete_status INT DEFAULT NULL,
  primeira_compra INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE empresa_funcionamento (
  id SERIAL PRIMARY KEY,
  abertura time NOT NULL,
  fechamento time NOT NULL,
  id_dia INT NOT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE empresa_marketplaces (
  id SERIAL PRIMARY KEY,
  id_marketplaces INT NOT NULL,
  id_loja VARCHAR(255) DEFAULT NULL,
  authorization_code VARCHAR(255) DEFAULT NULL,
  user_code VARCHAR(255) DEFAULT NULL,
  data_atualizacao TIMESTAMP NULL DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE enderecos (
  id SERIAL PRIMARY KEY,
  id_usuario INT NOT NULL REFERENCES usuarios(id),
  nome_endereco VARCHAR(255) NOT NULL DEFAULT '',
  rua VARCHAR(100) DEFAULT '',
  numero VARCHAR(20) DEFAULT '',
  complemento VARCHAR(255) DEFAULT NULL,
  bairro VARCHAR(255) DEFAULT '',
  cidade VARCHAR(255) DEFAULT '',
  estado INT DEFAULT NULL,
  cep VARCHAR(80) DEFAULT '',
  principal INT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE favoritos (
  id SERIAL PRIMARY KEY,
  id_usuario INT NOT NULL REFERENCES usuarios(id),
  id_produto INT NOT NULL REFERENCES produtos(id),
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE ifood_pedidos (
  id SERIAL PRIMARY KEY,
  id_ifood VARCHAR(255) NOT NULL DEFAULT '',
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  status VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE motoboy (
  id SERIAL PRIMARY KEY,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  id_usuario INT NOT NULL REFERENCES usuarios(id),
  diaria DECIMAL(8,2) DEFAULT NULL,
  taxa DECIMAL(8,2) DEFAULT NULL,
  placa CHAR(10) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL);


CREATE TABLE produto_adicional (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) DEFAULT NULL,
  valor DECIMAL(8,2) DEFAULT NULL,
  tipo_adicional INT DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);




CREATE TABLE produto_sabor (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) DEFAULT NULL,
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);



CREATE TABLE usuarios_empresa (
  id SERIAL PRIMARY KEY,
  id_usuario INT NOT NULL REFERENCES usuarios(id),
  id_empresa INT NOT NULL REFERENCES empresa_dados(id),
  nivel INT DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE TABLE paginas (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL DEFAULT '',
  slug VARCHAR(255) NOT NULL DEFAULT '',
  conteudo TEXT,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL
)



INSERT INTO apd_planos ("id", "nome", "slug", "descricao", "limite", "valor", "plano_id", "created_at", "updated_at") VALUES
(1, 'Grátis', 'gratis                                                      ', 'Planos Grátis', 50, 0.00, 2200900, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(2, 'Plano Inicial', 'inicial                                                     ', 'Profissionalize seu atendimento, plano indicado para empresas que necessita de profissionalizar e melhorar o atendimento e disposição dos produtos em seu estabelecimento', 200, 59.90, 574399, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(3, 'Plano Intermediario', 'intermediario                                               ', 'Melhore a eficiência do seu atendimento com todas as ferramentas de gestão para seu Delivery.', 1000, 129.90, 587409, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(4, 'Plano Essencial', 'essencial                                                   ', 'Melhore a eficiência do seu atendimento com todas as ferramentas de gestão para seu Delivery.', NULL, 199.90, 1275866, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(5, 'Solução Completa', 'solucao-completa                                            ', '', NULL, 599.90, 1275871, '2021-05-27 22:56:15', '2021-05-27 22:56:15');

INSERT INTO aux_categoria ("id", "nome", "slug", "created_at", "updated_at") VALUES
(1, 'Restaurante', 'restaurante', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(2, 'Lanchonete', 'lanchonete', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(3, 'Mercado', 'mercado', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(4, 'Loja', 'loja', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(5, 'Bebidas', 'bebidas', '2021-05-27 22:56:15', '2021-05-27 22:56:15');

INSERT INTO aux_categoria_sub ("id", "nome", "slug", "id_categoria", "created_at", "updated_at") VALUES
(1, 'Temakeria', 'temakeria', 1, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(2, 'Sorveteria ', 'sorveteria', 1, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(3, 'Churrascaria', 'churrascaria', 1, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(4, 'Food truck', 'food-truck', 1, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(5, 'Lanchonete', 'lanchonete', 1, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(6, 'Pizzaria', 'pizzaria', 1, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(7, 'Espetaria', 'espetaria', 1, '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(8, 'Restaurante', 'restaurante', 1, '2021-05-27 22:56:15', '2021-05-27 22:56:15');

INSERT INTO aux_dias ("id", "nome", "created_at", "updated_at") VALUES
(1, 'Segunda', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(2, 'Terça-Feira', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(3, 'Quarta-Feira', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(4, 'Quinta-Feira', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(5, 'Sexta-Feira', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(6, 'Sábado', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(7, 'Domingo', '2021-05-27 22:56:15', '2021-05-27 22:56:15');

INSERT INTO aux_moeda ("id", "nome", "simbolo", "created_at", "updated_at") VALUES
(1, 'Dólar', '$	', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(2, 'Euro', '€', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(3, 'Libras', '£', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(4, 'Real', 'R$', '2021-05-27 22:56:15', '2021-05-27 22:56:15');

INSERT INTO aux_status ("id", "delivery", "retirada", "class", "created_at", "updated_at") VALUES
(1, 'Recebido', 'Recebido', 'danger', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(2, 'Produção', 'Produção', 'warning', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(3, 'Saiu para Entrega', 'Pronto para Retirada', 'secondary', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(4, 'Entregue', 'Retirado', 'success', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(5, 'Recusado', 'Recusado', 'danger', '2021-05-27 22:56:15', '2021-05-27 22:56:15'),
(6, 'Cancelado', 'Cancelado', 'secondary', '2021-05-27 22:56:15', '2021-05-27 22:56:15');

INSERT INTO paginas ("id", "titulo", "slug", "conteudo", "created_at", "updated_at") VALUES
(1, 'Política de privacidade', 'politica-de-privacidade', '<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Pol&iacute;tica de Privacidade destes Termos e Condi&ccedil;&otilde;es de Uso tem por objetivo explicar como a Automatiza App pode coletar, guardar, processar, compartilhar, transferir e tratar os Dados Pessoais do Usu&aacute;rio durante a utiliza&ccedil;&atilde;o da Plataforma. Esta Pol&iacute;tica de Privacidade aplica-se aos Dados Pessoais do Usu&aacute;rio quando visita, navega, utiliza e adquire conte&uacute;dos na Plataforma e n&atilde;o se aplica a sites, plataformas ou servi&ccedil;os que n&atilde;o sejam de titularidade ou controlados pela Automatiza App, incluindo sites ou servi&ccedil;os de outros Usu&aacute;rios, parceiros ou anunciantes da Plataforma Automatiza Delivery e/ou da Automatiza App.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Para os fins destes&nbsp;<strong>Termos e Condi&ccedil;&otilde;es de Uso e Pol&iacute;tica de Privacidade</strong>, Dados Pessoais devem ser compreendidos como qualquer informa&ccedil;&atilde;o relacionada a pessoa natural ou jur&iacute;dica identificada ou identific&aacute;vel, de acordo com a Lei Federal n&ordm;. 13.709/2018.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><strong><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">1. &nbsp; COLETA E USO DE INFORMA&Ccedil;&Otilde;ES PESSOAIS</span></strong></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App coleta todas as informa&ccedil;&otilde;es inseridas pelos Estabelecimentos na Plataforma, tais como dados cadastrais, avalia&ccedil;&otilde;es de cursos, coment&aacute;rios, participa&ccedil;&atilde;o em pesquisas e enquetes, dentre outros. Em s&iacute;ntese, s&atilde;o coletadas pela Automatiza App todas as informa&ccedil;&otilde;es ativamente disponibilizadas pelos Usu&aacute;rios na utiliza&ccedil;&atilde;o da Plataforma, normalmente destinadas &agrave; melhoria de seu sistema e do modo de presta&ccedil;&atilde;o de servi&ccedil;os.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">O Usu&aacute;rio est&aacute; ciente de que fornece informa&ccedil;&atilde;o de forma consciente e volunt&aacute;ria por meio de [FORMUL&Aacute;RIO/ETC], ou por meio dos sites operados pela Automatiza App.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Quando o Usu&aacute;rio realiza o cadastro e/ou preenche formul&aacute;rios oferecidos pela Automatiza App, inclusive nos sites por ela operados, determinados Dados Pessoais solicitados ser&atilde;o mantidos em sigilo e ser&atilde;o utilizadas apenas para o prop&oacute;sito que motivou o cadastro.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App tamb&eacute;m coleta algumas informa&ccedil;&otilde;es, automaticamente, quando o Usu&aacute;rio acessa e utiliza a Plataforma, tais como caracter&iacute;sticas do dispositivo de acesso, do navegador, Protocolo de Internet (IP, com data e hora), origem do IP, informa&ccedil;&otilde;es sobre cliques, p&aacute;ginas acessadas, as p&aacute;ginas seguintes acessadas ap&oacute;s a sa&iacute;da da Plataforma, ou qualquer termo de busca digitado na Plataforma, dentre outros. A Automatiza App tamb&eacute;m poder&aacute; utilizar algumas tecnologias padr&otilde;es para coletar informa&ccedil;&otilde;es sobre o Usu&aacute;rio, tais como&nbsp;<em>cookies</em>,&nbsp;<em>pixel tags</em>,&nbsp;<em>beacons</em>&nbsp;e&nbsp;<em>local shared objects</em>, de modo a melhorar sua experi&ecirc;ncia de navega&ccedil;&atilde;o.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App poder&aacute; utilizar todas as informa&ccedil;&otilde;es obtidas pela Plataforma a qualquer tempo e a seu exclusivo crit&eacute;rio, seja para estudos de caso, an&aacute;lise de dados, estat&iacute;sticas, divulga&ccedil;&atilde;o de &iacute;ndices de consumo, parametriza&ccedil;&atilde;o de mercado consumidor ou para qualquer outra finalidade necess&aacute;ria &agrave; consecu&ccedil;&atilde;o dos objetivos do neg&oacute;cio da Automatiza App, sendo expressamente autorizada pelos Usu&aacute;rios a veicula&ccedil;&atilde;o desses resultados, estudos, an&aacute;lises, estat&iacute;sticas e pesquisas a terceiros.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Os Usu&aacute;rios entendem e concordam que a Plataforma Automatiza Delivery &eacute; acess&iacute;vel atrav&eacute;s de sites de busca, podendo localizar p&aacute;ginas com nome de usu&aacute;rios e/ou conte&uacute;dos por estes publicados, pelo que a remo&ccedil;&atilde;o de dados pessoais e outras informa&ccedil;&otilde;es do Usu&aacute;rio devem ser solicitadas diretamente aos servi&ccedil;os disponibilizados na web, n&atilde;o sendo de responsabilidade da Automatiza App quaisquer provid&ecirc;ncias nesse sentido.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">As informa&ccedil;&otilde;es coletadas por meio da Plataforma Automatiza Delivery s&atilde;o devidamente autorizadas pelos Usu&aacute;rios, os quais manifestam, desde j&aacute;, o seu consentimento livre, expresso e informado com rela&ccedil;&atilde;o &agrave; coleta de tais informa&ccedil;&otilde;es, para fins do disposto no artigo 7&ordm;, inciso IX, da Lei 12.965/2014 (Marco Civil da Internet).</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><strong><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">2. &nbsp; UTILIZA&Ccedil;&Atilde;O E TRATAMENTO DAS INFORMA&Ccedil;&Otilde;ES</span></strong></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App considera todas as informa&ccedil;&otilde;es coletadas por meio da Plataforma Automatiza Delivery como confidenciais. Somente ser&atilde;o utilizadas as informa&ccedil;&otilde;es da forma aqui descritas e autorizadas por qualquer dos Usu&aacute;rios e somente sobre estes restar&aacute; qualquer responsabilidade por sua utiliza&ccedil;&atilde;o. Todas as informa&ccedil;&otilde;es cadastradas e coletadas na Plataforma Automatiza Delivery s&atilde;o utilizadas para a execu&ccedil;&atilde;o das suas atividades, para melhorar a experi&ecirc;ncia de navega&ccedil;&atilde;o dos Usu&aacute;rios na Plataforma, bem como para fins publicit&aacute;rios.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App poder&aacute; a seu exclusivo crit&eacute;rio viabilizar espa&ccedil;os publicit&aacute;rios para contrata&ccedil;&atilde;o por empresas para a divulga&ccedil;&atilde;o de an&uacute;ncios aos Usu&aacute;rios durante o acesso &agrave; Plataforma. Tais empresas poder&atilde;o coletar informa&ccedil;&otilde;es sobre as visitas dos Usu&aacute;rios &agrave; Plataforma, no intuito de fornecer an&uacute;ncios personalizados sobre bens e servi&ccedil;os do seu interesse. Tais informa&ccedil;&otilde;es n&atilde;o incluem nem incluir&atilde;o nome, endere&ccedil;o, e-mail ou o n&uacute;mero de telefone dos Usu&aacute;rios. Os Usu&aacute;rios manifestam, por esta Pol&iacute;tica de Privacidade, o seu consentimento livre, expresso e informado para que a Automatiza App e seus parceiros utilizem as informa&ccedil;&otilde;es coletadas por meio da Plataforma para fins publicit&aacute;rios.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Se o Usu&aacute;rio n&atilde;o desejar receber mais e-mails promocionais, seguir as orienta&ccedil;&otilde;es constantes ao final da mensagem, a fim de viabilizar o descadastramento.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Importante atentar que a Plataforma pode conter links para outras p&aacute;ginas, inclusive de parceiros, que possuem Pol&iacute;ticas de Privacidade com previs&otilde;es diversas do disposto nesta Pol&iacute;tica de Privacidade da Automatiza Delivery. A Automatiza App n&atilde;o se responsabiliza pela coleta, utiliza&ccedil;&atilde;o, compartilhamento e armazenamento de seus dados pelos respons&aacute;veis por tais p&aacute;ginas fora de sua plataforma.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><strong><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">3. &nbsp; COMPARTILHAMENTO DE INFORMA&Ccedil;&Otilde;ES</span></strong></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App poder&aacute; compartilhar os dados coletados por meio da Plataforma: (i) Com os seus clientes e parceiros quando necess&aacute;rio e/ou apropriado &agrave; presta&ccedil;&atilde;o de servi&ccedil;os relacionados; (ii) quando necess&aacute;rio &agrave;s atividades comerciais da Automatiza App , como por exemplo, para fins de recebimento dos pagamentos dos planos adquiridos na Plataforma; (iii) para prote&ccedil;&atilde;o dos interesses da Automatiza App em qualquer tipo de conflito, incluindo a&ccedil;&otilde;es judiciais; (iv) no caso de transa&ccedil;&otilde;es e altera&ccedil;&otilde;es societ&aacute;rias envolvendo a Automatiza App, hip&oacute;tese em que a transfer&ecirc;ncia das informa&ccedil;&otilde;es ser&aacute; necess&aacute;ria para a continuidade da Plataforma Automatiza Delivery; e/ou (v) por ordem judicial ou pelo requerimento de autoridades administrativas que detenham compet&ecirc;ncia legal para sua requisi&ccedil;&atilde;o.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><strong><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">4. &nbsp; ARMAZENAMENTO DAS INFORMA&Ccedil;&Otilde;ES</span></strong></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">As informa&ccedil;&otilde;es fornecidas pelos Usu&aacute;rios na Plataforma ser&atilde;o armazenadas pela Automatiza App, em servidores pr&oacute;prios ou por ele contratados nacional, ou internacionalmente.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App emprega todos os esfor&ccedil;os razo&aacute;veis de mercado para garantir a seguran&ccedil;a de seus sistemas na guarda de referidos dados, tais como: (i) utiliza&ccedil;&atilde;o de m&eacute;todos padr&otilde;es e de mercado para criptografar e anonimizar os dados coletados; (ii) utiliza&ccedil;&atilde;o de software de prote&ccedil;&atilde;o contra acesso n&atilde;o autorizado aos sistemas da Plataforma Automatiza Delivery; (iii) autoriza&ccedil;&atilde;o de acesso somente a pessoas previamente estabelecidas aos locais onde s&atilde;o armazenadas as informa&ccedil;&otilde;es; (iv) exist&ecirc;ncia de pol&iacute;ticas internas para a manuten&ccedil;&atilde;o da seguran&ccedil;a da informa&ccedil;&atilde;o; e (v) celebra&ccedil;&atilde;o de contratos com os colaboradores que t&ecirc;m acesso &agrave;s informa&ccedil;&otilde;es dos Usu&aacute;rios, visando a estabelecer a obriga&ccedil;&atilde;o de manuten&ccedil;&atilde;o do sigilo absoluto e confidencialidade dos dados acessados, sob pena de responsabilidade civil e penal, nos moldes da legisla&ccedil;&atilde;o brasileira. No entanto, em raz&atilde;o da pr&oacute;pria natureza da Internet, n&atilde;o &eacute; poss&iacute;vel garantir que terceiros mal-intencionados n&atilde;o tenham sucesso em acessar indevidamente as informa&ccedil;&otilde;es dos Usu&aacute;rios.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Todas os Dados Pessoais ser&atilde;o guardados na base de dados mantidas &ldquo;na nuvem&rdquo; pelos fornecedores de servi&ccedil;os contratados pela Automatiza App, os quais est&atilde;o devidamente de acordo com a legisla&ccedil;&atilde;o de dados vigente.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App e seus fornecedores utilizam v&aacute;rios procedimentos de seguran&ccedil;a para proteger a confidencialidade, seguran&ccedil;a e integridade de seus Dados Pessoais, prevenindo a ocorr&ecirc;ncia de eventuais danos em virtude do tratamento desses dados.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Embora a Automatiza App utilize medidas de seguran&ccedil;a e monitore seu sistema para verificar vulnerabilidades e ataques para proteger seus Dados Pessoais contra divulga&ccedil;&atilde;o n&atilde;o autorizada, mau uso ou altera&ccedil;&atilde;o, o Usu&aacute;rio entende e concorda que n&atilde;o h&aacute; garantias de que as informa&ccedil;&otilde;es n&atilde;o poder&atilde;o ser acessadas, divulgadas, alteradas ou destru&iacute;das por viola&ccedil;&atilde;o de qualquer uma das prote&ccedil;&otilde;es f&iacute;sicas, t&eacute;cnicas ou administrativas.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><strong><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">5. &nbsp; EXCLUS&Atilde;O DAS INFORMA&Ccedil;&Otilde;ES</span></strong></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">O Usu&aacute;rio poder&aacute; solicitar a Automatiza App que as informa&ccedil;&otilde;es referidas nestes&nbsp;<strong>Termos e Condi&ccedil;&otilde;es de Uso e Pol&iacute;tica de Privacidade</strong>&nbsp;sejam exclu&iacute;das, por meio da solicita&ccedil;&atilde;o de descadastramento. A Automatiza App empreender&aacute; os melhores esfor&ccedil;os para atender a todos os pedidos de exclus&atilde;o, no menor espa&ccedil;o de tempo poss&iacute;vel. Tal exclus&atilde;o impossibilitar&aacute; novos acessos, inclusive a eventuais planos e demais conte&uacute;dos adquiridos, pelo Usu&aacute;rio. A Automatiza App respeitar&aacute; o prazo de armazenamento m&iacute;nimo de determinadas informa&ccedil;&otilde;es, conforme determinado pela legisla&ccedil;&atilde;o brasileira, ainda que o Usu&aacute;rio solicite a exclus&atilde;o de tais informa&ccedil;&otilde;es.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><strong><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">6. &nbsp; COOKIES</span></strong></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Um&nbsp;<em>cookie</em>&nbsp;&eacute; um pequeno arquivo de texto que &eacute; armazenado e/ou lido pelo navegador do usu&aacute;rio no disco r&iacute;gido do seu dispositivo final (por exemplo, computador, port&aacute;til ou smartphone) pelos websites que visita. Quase todos os websites usam tecnologia de&nbsp;<em>cookies</em>&nbsp;para otimizarem o design e as funcionalidades. Os&nbsp;<em>cookies</em>&nbsp;tamb&eacute;m tornam as suas intera&ccedil;&otilde;es com websites mais seguras e r&aacute;pidas, visto que conseguem lembrar-se das suas prefer&ecirc;ncias (por exemplo, in&iacute;cio de sess&atilde;o e idioma), enviando as informa&ccedil;&otilde;es que cont&ecirc;m de volta para o website origin&aacute;rio (cookie de primeira parte) ou para outro website a que pertencem (cookie de terceiros), quando o Usu&aacute;rio revisita o respectivo website com o mesmo dispositivo final. Com base em sua fun&ccedil;&atilde;o e sua finalidade de utiliza&ccedil;&atilde;o.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Os&nbsp;<em>cookies</em>&nbsp;estritamente necess&aacute;rios permitem ao Usu&aacute;rio deslocar-se no website e utilizar as suas fun&ccedil;&otilde;es b&aacute;sicas. Normalmente, s&atilde;o definidos apenas em resposta a a&ccedil;&otilde;es efetuadas pelo Usu&aacute;rio que equivalem a um pedido de servi&ccedil;os, tais como acesso a uma &aacute;rea segura do nosso website. Estes&nbsp;<em>cookies</em>&nbsp;s&atilde;o indispens&aacute;veis para a utiliza&ccedil;&atilde;o deste website.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Os&nbsp;<em>cookies</em>&nbsp;funcionais s&atilde;o utilizados para reconhecer quando o Usu&aacute;rio volta &agrave; Plataforma e possibilitam &agrave; Automatiza App oferecer fun&ccedil;&otilde;es melhoradas e mais personalizadas e lembrar as prefer&ecirc;ncias dos Usu&aacute;rios. Estes&nbsp;<em>cookies</em>&nbsp;recolhem informa&ccedil;&otilde;es an&ocirc;nimas e n&atilde;o podem rastrear a atividade dos Usu&aacute;rios fora do ambiente da Plataforma Automatiza Delivery.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Os&nbsp;<em>cookies</em>&nbsp;de marketing e de prefer&ecirc;ncias registram as visitas de Usu&aacute;rios na Plataforma, as p&aacute;ginas que cada Usu&aacute;rio visitou e os links que seguiu. A Automatiza App utilizar&aacute; estas informa&ccedil;&otilde;es para fornecer an&uacute;ncios mais relevantes para cada Usu&aacute;rio e para os seus interesses. Tamb&eacute;m s&atilde;o utilizados para limitar o n&uacute;mero de vezes que cada Usu&aacute;rio v&ecirc; um an&uacute;ncio e ajudam a aferir a efic&aacute;cia das campanhas publicit&aacute;rias. A Automatiza App poder&aacute; tamb&eacute;m partilhar estas informa&ccedil;&otilde;es com terceiros (como anunciantes) para esta finalidade.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A Automatiza App utiliza os servi&ccedil;os de terceiros para entender melhor o uso feito em sua Plataforma, para otimizar a experi&ecirc;ncia de cada Usu&aacute;rio e mostrar publicidade de interesse do Usu&aacute;rio. Estes terceiros (incluindo, por exemplo, redes publicit&aacute;rias e fornecedores de servi&ccedil;os externos, como servi&ccedil;os de an&aacute;lise do tr&aacute;fego da web) podem tamb&eacute;m utilizar&nbsp;<em>cookies</em>, sobre os quais n&atilde;o temos qualquer controle.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">O Usu&aacute;rio pode retirar o seu consentimento de&nbsp;<em>cookies</em>&nbsp;a qualquer momento, observados os caminhos do navegador que utilizar para acesso &agrave; Plataforma.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><strong><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">7. &nbsp; ACEITA&Ccedil;&Atilde;O</span></strong></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">A aceita&ccedil;&atilde;o desta Pol&iacute;tica de Privacidade pelo Estabelecimento se dar&aacute; no ato do seu clique no bot&atilde;o &ldquo;Li e Concordo&rdquo; ao se cadastrar na Plataforma Automatiza Delivery e, em rela&ccedil;&atilde;o aos Consumidores, os Estabelecimentos viabilizar&atilde;o a ferramenta necess&aacute;ria para tanto.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">O Usu&aacute;rio concorda e permite o acesso &agrave;s suas informa&ccedil;&otilde;es a partir de seu cadastro e/ou acesso &agrave; Plataforma, manifestando consentimento livre, expresso e informado, nos termos do artigo 43 do C&oacute;digo de Defesa do Consumidor e artigo 7&ordm;, inciso IX, da Lei 12.965/2014.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">No acesso, navega&ccedil;&atilde;o, cadastro e/ou utiliza&ccedil;&atilde;o da Plataforma, aplicam-se as disposi&ccedil;&otilde;es constantes nos Termos e Condi&ccedil;&otilde;es de Uso e na Pol&iacute;tica de Privacidade. Caso Voc&ecirc; n&atilde;o concorde com os termos destes Termos e Condi&ccedil;&otilde;es de Uso e Pol&iacute;tica de Privacidade, recomendamos que n&atilde;o prossiga com o cadastramento na Plataforma e/ou se abstenha de acess&aacute;-la e utiliz&aacute;-la.</span></p>
<p class="MsoNormal" style="font-size: 12pt; margin: 12pt 0cm 6pt; font-family: Calibri, sans-serif; text-indent: 18pt;"><span style="font-size: 10pt; font-family: ''Open Sans'', sans-serif;">Para maiores informa&ccedil;&otilde;es acerca dos n&iacute;veis de seguran&ccedil;a e privacidade das informa&ccedil;&otilde;es, favor enviar e-mail para suporte@automatiza.app.</span></p>', '2021-06-09 18:09:14', '2021-06-09 18:09:14');

INSERT INTO usuarios ("id", "nome", "email", "telefone", "senha", "nivel", "created_at", "updated_at") VALUES
(1, 'Administrador', 'contato@automatiza.app', '11980309212', '$2a$08$NDY3NTczNDY3NWYyMmU3Ne1jK5y05w.z4uTQfkJ/AyviU54qCWpiq', 0, '2021-05-23 01:59:46', '2021-05-23 01:59:46');




ALTER TABLE apd_assinatura ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE apd_credit_card ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE apd_end_credit_card ADD FOREIGN KEY ("id_usuario") REFERENCES usuarios("id");
ALTER TABLE apd_end_credit_card ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE aux_pagamento ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE aux_tipo_delivery ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE avaliacao ADD FOREIGN KEY ("id_cliente") REFERENCES usuarios("id");
ALTER TABLE avaliacao ADD FOREIGN KEY ("id_motoboy") REFERENCES usuarios("id");
ALTER TABLE avaliacao ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE carrinho ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE carrinho ADD FOREIGN KEY ("id_cliente") REFERENCES usuarios("id");
ALTER TABLE carrinho_adicional ADD FOREIGN KEY ("id_produto") REFERENCES produtos("id");
ALTER TABLE carrinho_adicional ADD FOREIGN KEY ("id_cliente") REFERENCES usuarios("id");
ALTER TABLE carrinho_adicional ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE carrinho_cpf_nota ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE carrinho_cpf_nota ADD FOREIGN KEY ("id_cliente") REFERENCES usuarios("id");
ALTER TABLE carrinho_entregas ADD FOREIGN KEY ("id_cliente") REFERENCES usuarios("id");
ALTER TABLE carrinho_entregas ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE carrinho_entregas ADD FOREIGN KEY ("id_caixa") REFERENCES empresa_caixa("id");
ALTER TABLE carrinho_pedido_pagamento ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE carrinho_pedido_pagamento ADD FOREIGN KEY ("id_cliente") REFERENCES usuarios("id");
ALTER TABLE carrinho_pedidos ADD FOREIGN KEY ("id_cliente") REFERENCES usuarios("id");
ALTER TABLE carrinho_pedidos ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE carrinho_pedidos ADD FOREIGN KEY ("id_motoboy") REFERENCES usuarios("id");
ALTER TABLE carrinho_pedidos ADD FOREIGN KEY ("id_caixa") REFERENCES empresa_caixa("id");
ALTER TABLE categoria_tipo_adicional ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE categorias ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE contato ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE cupom_desconto ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE cupom_desconto_utilizacoes ADD FOREIGN KEY ("id_cliente") REFERENCES usuarios("id");
ALTER TABLE cupom_desconto_utilizacoes ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE empresa_caixa ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE empresa_enderecos ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE empresa_frete ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE empresa_funcionamento ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE empresa_marketplaces ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE enderecos ADD FOREIGN KEY ("id_usuario") REFERENCES usuarios("id");
ALTER TABLE favoritos ADD FOREIGN KEY ("id_usuario") REFERENCES usuarios("id");
ALTER TABLE favoritos ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE favoritos ADD FOREIGN KEY ("id_produto") REFERENCES produtos("id");
ALTER TABLE ifood_pedidos ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE motoboy ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE motoboy ADD FOREIGN KEY ("id_usuario") REFERENCES usuarios("id");
ALTER TABLE produto_adicional ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE produto_sabor ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE produtos ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");
ALTER TABLE produtos ADD FOREIGN KEY ("id_categoria") REFERENCES categorias("id");
ALTER TABLE usuarios_empresa ADD FOREIGN KEY ("id_usuario") REFERENCES usuarios("id");
ALTER TABLE usuarios_empresa ADD FOREIGN KEY ("id_empresa") REFERENCES empresa_dados("id");

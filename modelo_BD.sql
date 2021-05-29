# ************************************************************
# Sequel Pro SQL dump
# Versão 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 159.65.220.187 (MySQL 5.5.5-10.1.48-MariaDB-0+deb9u2)
# Base de Dados: apd_3irmaos
# Tempo de Geração: 2021-05-19 04:51:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump da tabela apdAssinatura
# ------------------------------------------------------------

DROP TABLE IF EXISTS `apdAssinatura`;

CREATE TABLE `apdAssinatura` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` varchar(255) DEFAULT NULL,
  `plano_id` int(11) DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT NULL,
  `updatedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela apdCreditCard
# ------------------------------------------------------------

DROP TABLE IF EXISTS `apdCreditCard`;

CREATE TABLE `apdCreditCard` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userHolder` varchar(255) NOT NULL DEFAULT '',
  `hash` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `lastDigits` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT NULL,
  `updatedAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela apdPagamentos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `apdPagamentos`;

CREATE TABLE `apdPagamentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idPlano` int(11) DEFAULT NULL,
  `recorrencia` int(11) DEFAULT NULL,
  `periodInit` timestamp NULL DEFAULT NULL,
  `periodEnd` timestamp NULL DEFAULT NULL,
  `status` enum('Pago','Pendente') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela apdPlanos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `apdPlanos`;

CREATE TABLE `apdPlanos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `slug` char(60) DEFAULT NULL,
  `descricao` text,
  `status` int(11) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `planId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `apdPlanos` WRITE;
/*!40000 ALTER TABLE `apdPlanos` DISABLE KEYS */;

INSERT INTO `apdPlanos` (`id`, `nome`, `slug`, `descricao`, `status`, `limit`, `valor`, `planId`)
VALUES
	(1,'Plano Inicial','inicial','Profissionalize seu atendimento, plano indicado para empresas que necessita de profissionalizar e melhorar o atendimento e disposição dos produtos em seu estabelecimento',0,200,59.90,1275863),
	(2,'Plano Intermediario','intermediario','Melhore a eficiência do seu atendimento com todas as ferramentas de gestão para seu Delivery.',0,1000,129.90,1275864),
	(3,'Plano Essencial','essencial','Melhore a eficiência do seu atendimento com todas as ferramentas de gestão para seu Delivery.',0,NULL,199.90,1275866),
	(4,'Plano Essencial + IFood','essencial-ifood','Melhore a eficiência do seu atendimento com todas as ferramentas de gestão para seu Delivery. Aliado ao iFood ',0,NULL,399.90,1275867),
	(6,'Plano Essencial + IFood, UberEats','essencial-2','Melhore a eficiência do seu atendimento com todas as ferramentas de gestão para seu Delivery. Aliado ao iFood e UberEats',0,NULL,499.90,1275870),
	(7,'Solução Completa','solucao-completa','',0,NULL,599.90,1275871);

/*!40000 ALTER TABLE `apdPlanos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela auxDias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auxDias`;

CREATE TABLE `auxDias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auxDias` WRITE;
/*!40000 ALTER TABLE `auxDias` DISABLE KEYS */;

INSERT INTO `auxDias` (`id`, `nome`)
VALUES
	(1,'Segunda'),
	(2,'Terça-Feira'),
	(3,'Quarta-Feira'),
	(4,'Quinta-Feira'),
	(5,'Sexta-Feira'),
	(6,'Sábado'),
	(7,'Domingo');

/*!40000 ALTER TABLE `auxDias` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela auxEstados
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auxEstados`;

CREATE TABLE `auxEstados` (
  `id` int(11) NOT NULL,
  `nome` varchar(75) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Unidades Federativas';

LOCK TABLES `auxEstados` WRITE;
/*!40000 ALTER TABLE `auxEstados` DISABLE KEYS */;

INSERT INTO `auxEstados` (`id`, `nome`, `uf`)
VALUES
	(1,'Acre','AC'),
	(2,'Alagoas','AL'),
	(3,'Amazonas','AM'),
	(4,'Amapá','AP'),
	(5,'Bahia','BA'),
	(6,'Ceará','CE'),
	(7,'Distrito Federal','DF'),
	(8,'Espírito Santo','ES'),
	(9,'Goiás','GO'),
	(10,'Maranhão','MA'),
	(11,'Minas Gerais','MG'),
	(12,'Mato Grosso do Sul','MS'),
	(13,'Mato Grosso','MT'),
	(14,'Pará','PA'),
	(15,'Paraíba','PB'),
	(16,'Pernambuco','PE'),
	(17,'Piauí','PI'),
	(18,'Paraná','PR'),
	(19,'Rio de Janeiro','RJ'),
	(20,'Rio Grande do Norte','RN'),
	(21,'Rondônia','RO'),
	(22,'Roraima','RR'),
	(23,'Rio Grande do Sul','RS'),
	(24,'Santa Catarina','SC'),
	(25,'Sergipe','SE'),
	(26,'São Paulo','SP'),
	(27,'Tocantins','TO'),
	(99,'Exterior','EX');

/*!40000 ALTER TABLE `auxEstados` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela auxMoeda
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auxMoeda`;

CREATE TABLE `auxMoeda` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `simbolo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auxMoeda` WRITE;
/*!40000 ALTER TABLE `auxMoeda` DISABLE KEYS */;

INSERT INTO `auxMoeda` (`id`, `nome`, `simbolo`)
VALUES
	(1,'Dólar','$	'),
	(2,'Euro','€'),
	(3,'Libras','£'),
	(4,'Real','R$');

/*!40000 ALTER TABLE `auxMoeda` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela auxPagamento
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auxPagamento`;

CREATE TABLE `auxPagamento` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auxPagamento` WRITE;
/*!40000 ALTER TABLE `auxPagamento` DISABLE KEYS */;

INSERT INTO `auxPagamento` (`id`, `tipo`, `status`)
VALUES
	(1,'Dinheiro',1),
	(2,'Cartão de Débito',1),
	(3,'Cartão de Crédito',1),
	(4,'QR Code',1),
	(5,'Vale Refeição',1),
	(6,'Vale Alimentação',1),
	(7,'Dinheiro + Cartão',1),
	(8,'PIX',1);

/*!40000 ALTER TABLE `auxPagamento` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela auxTipo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `auxTipo`;

CREATE TABLE `auxTipo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `auxTipo` WRITE;
/*!40000 ALTER TABLE `auxTipo` DISABLE KEYS */;

INSERT INTO `auxTipo` (`id`, `tipo`, `status`)
VALUES
	(1,'Retirada',1),
	(2,'Entrega',1);

/*!40000 ALTER TABLE `auxTipo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela cartCarrinho
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cartCarrinho`;

CREATE TABLE `cartCarrinho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `id_adicional` char(20) DEFAULT NULL,
  `id_sabores` char(20) DEFAULT NULL,
  `observacao` text,
  `valor` double(8,2) DEFAULT NULL,
  `numero_pedido` varchar(255) DEFAULT '',
  `chave` varchar(255) DEFAULT '',
  `sessao_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cartCarrinho_p_produto` (`id_produto`),
  KEY `cartCarrinho_p_id_cliente` (`id_cliente`),
  CONSTRAINT `cartCarrinho_p_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `cartCarrinho_p_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela cartCarrinhoAdicional
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cartCarrinhoAdicional`;

CREATE TABLE `cartCarrinhoAdicional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_carrinho` int(11) DEFAULT NULL,
  `id_produto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_adicional` int(11) DEFAULT NULL,
  `quantidade` int(11) unsigned DEFAULT NULL,
  `valor` double(8,2) DEFAULT NULL,
  `numero_pedido` int(40) DEFAULT NULL,
  `chave` varchar(255) NOT NULL DEFAULT '',
  `sessao_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carrinho_p_adicional` (`id_carrinho`),
  KEY `cartCarrinhoAdicional_p_id_produto` (`id_produto`),
  KEY `cartCarrinhoAdicional_p_id_cliente` (`id_cliente`),
  CONSTRAINT `carrinho_p_adicional` FOREIGN KEY (`id_carrinho`) REFERENCES `cartCarrinho` (`id`),
  CONSTRAINT `cartCarrinhoAdicional_p_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `cartCarrinhoAdicional_p_id_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela cartCPFNota
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cartCPFNota`;

CREATE TABLE `cartCPFNota` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `numero_pedido` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `cpf` char(70) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela cartEntregas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cartEntregas`;

CREATE TABLE `cartEntregas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_motoboy` int(11) DEFAULT NULL,
  `id_caixa` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `observacao` text,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `numero_pedido` varchar(200) DEFAULT NULL,
  `pago` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entrega_p_motoboy` (`id_motoboy`),
  KEY `entrega_p_cliente` (`id_cliente`),
  CONSTRAINT `entrega_p_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `entrega_p_motoboy` FOREIGN KEY (`id_motoboy`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela cartPedidoPagamento
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cartPedidoPagamento`;

CREATE TABLE `cartPedidoPagamento` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `numero_pedido` int(11) DEFAULT NULL,
  `id_tipo_pagamento` int(11) DEFAULT NULL,
  `pagCartao` decimal(8,2) DEFAULT NULL,
  `pagDinheiro` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela cartPedidos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cartPedidos`;

CREATE TABLE `cartPedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_caixa` int(11) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `total_pago` decimal(8,2) DEFAULT NULL,
  `troco` decimal(8,2) DEFAULT NULL,
  `tipo_pagamento` int(11) DEFAULT NULL,
  `tipo_frete` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `status` int(11) NOT NULL,
  `pago` int(11) DEFAULT NULL,
  `observacao` varchar(350) DEFAULT NULL,
  `numero_pedido` varchar(255) DEFAULT '',
  `valor_frete` decimal(8,2) DEFAULT NULL,
  `km` char(20) DEFAULT NULL,
  `motoboy` int(20) DEFAULT NULL,
  `chave` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `carrinho_p_usuario` (`id_cliente`),
  CONSTRAINT `carrinho_p_usuario` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela categorias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `descricao` varchar(255) DEFAULT '',
  `slug` varchar(255) DEFAULT '',
  `produtos` int(11) DEFAULT NULL,
  `posicao` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela categoriaTipoAdicional
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categoriaTipoAdicional`;

CREATE TABLE `categoriaTipoAdicional` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `tipo_escolha` int(11) DEFAULT NULL,
  `qtd` char(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela chatMessage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `chatMessage`;

CREATE TABLE `chatMessage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `toUserId` int(11) NOT NULL,
  `fromUserId` int(11) NOT NULL,
  `chatMessage` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump da tabela empCaixa
# ------------------------------------------------------------

DROP TABLE IF EXISTS `empCaixa`;

CREATE TABLE `empCaixa` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data_inicio` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `data_final` date DEFAULT NULL,
  `hora_final` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela configEmpresa
# ------------------------------------------------------------

DROP TABLE IF EXISTS `configEmpresa`;

CREATE TABLE `configEmpresa` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `razaoSocial` varchar(255) DEFAULT NULL,
  `cnpj` char(30) DEFAULT '',
  `nomeFantasia` varchar(255) NOT NULL DEFAULT '',
  `cep` char(45) DEFAULT NULL,
  `rua` text NOT NULL,
  `numero` char(11) NOT NULL DEFAULT '',
  `complemento` char(100) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `estado` int(2) DEFAULT NULL,
  `telefone` char(100) DEFAULT NULL,
  `sobre` text,
  `moeda` char(11) DEFAULT NULL,
  `nfPaulista` int(11) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `capa` varchar(255) DEFAULT NULL,
  `diasAtendimento` char(22) DEFAULT NULL,
  `emailContato` varchar(255) DEFAULT NULL,
  `link_site` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `configEmpresa` WRITE;
/*!40000 ALTER TABLE `configEmpresa` DISABLE KEYS */;

INSERT INTO `configEmpresa` (`id`, `razaoSocial`, `cnpj`, `nomeFantasia`, `cep`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `telefone`, `sobre`, `moeda`, `nfPaulista`, `logo`, `capa`, `diasAtendimento`, `emailContato`, `link_site`)
VALUES
	(1,'Restaurante e Lanchonete 3 Irmãos','00.000.000/0000-00','Restaurante e Lanchonete 3 Irmãos','06850-750','R. Treze de Maio','2','','Centro','Itapecerica da Serra',26,'(11) 96091-2746','','4',NULL,NULL,NULL,'1,2,3,4,5,6','amandasoares12451@yahoo.com','https://3irmaos.automatiza.app');

/*!40000 ALTER TABLE `configEmpresa` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela configFrete
# ------------------------------------------------------------

DROP TABLE IF EXISTS `configFrete`;

CREATE TABLE `configFrete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `previsao_minutos` varchar(80) NOT NULL DEFAULT '',
  `taxa_entrega` decimal(8,2) NOT NULL,
  `abertura` time NOT NULL,
  `fechamento` time NOT NULL,
  `km_entrega` int(11) DEFAULT NULL,
  `km_entrega_excedente` int(11) DEFAULT NULL,
  `valor_excedente` decimal(8,2) DEFAULT NULL,
  `taxa_entrega_motoboy` decimal(8,2) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `frete_status` int(11) DEFAULT NULL,
  `primeira_compra` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `configFrete` WRITE;
/*!40000 ALTER TABLE `configFrete` DISABLE KEYS */;

INSERT INTO `configFrete` (`id`, `status`, `previsao_minutos`, `taxa_entrega`, `abertura`, `fechamento`, `km_entrega`, `km_entrega_excedente`, `valor_excedente`, `taxa_entrega_motoboy`, `valor`, `frete_status`, `primeira_compra`)
VALUES
	(1,NULL,'30-90',5.00,'18:00:00','23:30:00',5,7,1.00,1.00,100.00,NULL,NULL);

/*!40000 ALTER TABLE `configFrete` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela empMarketplaces
# ------------------------------------------------------------

DROP TABLE IF EXISTS `empMarketplaces`;

CREATE TABLE `empMarketplaces` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_marketplaces` int(255) DEFAULT NULL,
  `idLoja` varchar(255) DEFAULT NULL,
  `authorizationCode` varchar(255) DEFAULT NULL,
  `userCode` varchar(255) DEFAULT NULL,
  `dataAtualizacao` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `empMarketplaces` WRITE;
/*!40000 ALTER TABLE `empMarketplaces` DISABLE KEYS */;

INSERT INTO `empMarketplaces` (`id`, `id_marketplaces`, `idLoja`, `authorizationCode`, `userCode`, `dataAtualizacao`)
VALUES
	(1,1,NULL,'','',NULL),
	(2,2,NULL,'','',NULL),
	(3,3,NULL,'','',NULL);

/*!40000 ALTER TABLE `empMarketplaces` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela contato
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contato`;

CREATE TABLE `contato` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `telefone` char(15) DEFAULT NULL,
  `mensagem` longtext,
  `dataEnvio` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela cupomDesconto
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cupomDesconto`;

CREATE TABLE `cupomDesconto` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_cupom` int(11) DEFAULT NULL,
  `nome_cupom` char(100) DEFAULT NULL,
  `valor_cupom` decimal(8,2) DEFAULT NULL,
  `expira` timestamp NULL DEFAULT NULL,
  `qtd_utilizacoes` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela cupomDescontoUtilizacoes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cupomDescontoUtilizacoes`;

CREATE TABLE `cupomDescontoUtilizacoes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cupom` char(100) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `numero_pedido` int(11) DEFAULT NULL,
  `dataUtilizacao` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela enderecos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `enderecos`;

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `nome_endereco` varchar(255) NOT NULL,
  `rua` varchar(100) DEFAULT '',
  `numero` varchar(20) DEFAULT '',
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT '',
  `cidade` varchar(255) DEFAULT '',
  `estado` int(11) DEFAULT NULL,
  `cep` varchar(80) DEFAULT '',
  `principal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela favoritos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `favoritos`;

CREATE TABLE `favoritos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela ifoodCategorias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ifoodCategorias`;

CREATE TABLE `ifoodCategorias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `idIfood` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ifood_p_Cat` (`id_categoria`),
  CONSTRAINT `ifood_p_Cat` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela ifoodPedidos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ifoodPedidos`;

CREATE TABLE `ifoodPedidos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `idIfood` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ifood_p_Cat` (`id_categoria`),
  CONSTRAINT `ifoodpedidos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela ifoodProdutos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ifoodProdutos`;

CREATE TABLE `ifoodProdutos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) DEFAULT NULL,
  `idIfood` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ifood_p_prod` (`id_produto`),
  CONSTRAINT `ifood_p_prod` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela locais
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locais`;

CREATE TABLE `locais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela motoboy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `motoboy`;

CREATE TABLE `motoboy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `diaria` double(8,2) DEFAULT NULL,
  `taxa` double(8,2) DEFAULT NULL,
  `placa` char(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `motoboy_p_usuario_val` (`id_usuario`),
  CONSTRAINT `motoboy_p_usuario_val` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump da tabela produtoAdicional
# ------------------------------------------------------------

DROP TABLE IF EXISTS `produtoAdicional`;

CREATE TABLE `produtoAdicional` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `tipoAdicional` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela produtos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `produtos`;

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `descricao` varchar(255) DEFAULT '',
  `observacao` varchar(255) DEFAULT NULL,
  `valor` decimal(8,2) NOT NULL,
  `valor_promocional` decimal(8,2) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `imagem` longtext,
  `adicional` varchar(255) DEFAULT NULL,
  `sabores` varchar(255) DEFAULT NULL,
  `status_produto` int(11) DEFAULT NULL,
  `dias_disponiveis` char(20) DEFAULT NULL,
  `vendas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_p_categoria` (`categoria`),
  CONSTRAINT `produto_p_categoria` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela produtoSabor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `produtoSabor`;

CREATE TABLE `produtoSabor` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela rating
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rating`;

CREATE TABLE `rating` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `numero_pedido` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_motoboy` int(11) DEFAULT NULL,
  `avaliacao_pedido` char(11) DEFAULT NULL,
  `avaliacao_motoboy` char(11) DEFAULT NULL,
  `observacao` text,
  `data_compra` datetime DEFAULT NULL,
  `data_votacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump da tabela usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `telefone` varchar(20) DEFAULT '',
  `senha` varchar(255) DEFAULT '',
  `nivel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;

INSERT INTO `usuarios` (`id`, `nome`, `email`, `telefone`, `senha`, `nivel`)
VALUES
	(0,'Visitante','','','',3),
	(1,'Administrador','contato@automatiza.app','(11) 98030-9212','$2a$08$NDY3NTczNDY3NWYyMmU3Ne1jK5y05w.z4uTQfkJ/AyviU54qCWpiq',0);

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

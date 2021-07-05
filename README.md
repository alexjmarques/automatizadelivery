# automatizaApd
Sistema de pedidos para delivery e pedidos local, gerenciado por atendentes

git clone https://github.com/alexjmarques/automatizaApd.git tmp && mv tmp/.git . && rm -fr tmp && git reset --hard
git config credential.helper store
git pull


#Criar ligação entre as tabelas
ALTER TABLE cartCarrinhoAdicional
ADD CONSTRAINT carrinho_p_adicional
FOREIGN KEY (`id_carrinho`) REFERENCES `cartCarrinho`(`id`)


#Truncate
SET FOREIGN_KEY_CHECKS = 0; 
TRUNCATE table `cartCarrinho`; 
SET FOREIGN_KEY_CHECKS = 1;


#Instalações
/var/www/apd.automatiza.app/public_html
/var/www/temakicapao.portaldospedidos.com.br/public_html
/var/www/temakicampolimpo.automatiza.app/public_html
/var/www/restaurantedataty.automatiza.app/public_html
/var/www/senhorespeto.automatiza.app/public_html
/var/www/elshaday.automatiza.app/public_html
/var/www/3irmaos.automatiza.app/public_html
/var/www/studiorubim.automatiza.app/public_html

#COMMIT
cd /var/www/apd.automatiza.app/public_html
git pull
cd /var/www/temakicapao.portaldospedidos.com.br/public_html
git pull
cd /var/www/temakicampolimpo.automatiza.app/public_html
git pull
cd /var/www/restaurantedataty.automatiza.app/public_html
git pull
cd /var/www/senhorespeto.automatiza.app/public_html
git pull
cd /var/www/studiorubim.automatiza.app/public_html
git pull
cd /var/www/elshaday.automatiza.app/public_html
git pull

#Dados Servidor

nano app/config/config.php

define('DB_HOST', '159.65.220.187');
define('DB_USER', 'root');
define('DB_PASS', '02W@9889forev');
define('DB_NAME', '{NOME DO BANCO}');
define('DB_PORT', '9889');

#Permissão de Upload 
sudo chmod -R 755 /var/www/{NOME DA EMPRESA}.automatiza.app/public_htm/public/uploads/



//usuarios_empresa
SELECT MAX(id) FROM usuarios_empresa;
SELECT nextval('usuarios_empresa_id_seq1');
SELECT setval('usuarios_empresa_id_seq1', (SELECT MAX(id) FROM usuarios_empresa)+1);


//usuarios
SELECT MAX(id) FROM usuarios;
SELECT nextval('usuarios_pkey');

SELECT setval('apd_assinatura_id_seq', (SELECT MAX(id) FROM apd_assinatura)+1);
SELECT setval('apd_credit_card_id_seq', (SELECT MAX(id) FROM apd_credit_card)+1);
SELECT setval('apd_end_credit_card_id_seq', (SELECT MAX(id) FROM apd_end_credit_card)+1);
SELECT setval('apd_planos_id_seq', (SELECT MAX(id) FROM apd_planos)+1);
SELECT setval('aux_categoria_id_seq', (SELECT MAX(id) FROM aux_categoria)+1);
SELECT setval('aux_categoria_sub_id_seq', (SELECT MAX(id) FROM aux_categoria_sub)+1);
SELECT setval('aux_dias_id_seq', (SELECT MAX(id) FROM aux_dias)+1);
SELECT setval('aux_moeda_id_seq', (SELECT MAX(id) FROM aux_moeda)+1);
SELECT setval('aux_pagamento_id_seq', (SELECT MAX(id) FROM aux_pagamento)+1);
SELECT setval('aux_print_id_seq', (SELECT MAX(id) FROM aux_print)+1);
SELECT setval('aux_status_id_seq', (SELECT MAX(id) FROM aux_status)+1);
SELECT setval('aux_tipo_id_seq', (SELECT MAX(id) FROM aux_tipo_delivery)+1);
SELECT setval('avaliacao_id_seq1', (SELECT MAX(id) FROM avaliacao)+1);
SELECT setval('carrinho_id_seq1', (SELECT MAX(id) FROM carrinho)+1);
SELECT setval('carrinho_adicional_id_seq1', (SELECT MAX(id) FROM carrinho_adicional)+1);
SELECT setval('carrinho_cpf_nota_id_seq', (SELECT MAX(id) FROM carrinho_cpf_nota)+1);
SELECT setval('carrinho_entregas_id_seq1', (SELECT MAX(id) FROM carrinho_entregas)+1);
SELECT setval('carrinho_pedido_pagamento_id_seq1', (SELECT MAX(id) FROM carrinho_pedido_pagamento)+1);
SELECT setval('carrinho_pedidos_id_seq1', (SELECT MAX(id) FROM carrinho_pedidos)+1);
SELECT setval('categoria_tipo_adicional_id_seq', (SELECT MAX(id) FROM categoria_tipo_adicional)+1);
SELECT setval('categorias_id_seq', (SELECT MAX(id) FROM categorias)+1);
SELECT setval('contato_id_seq', (SELECT MAX(id) FROM contato)+1);
SELECT setval('cupom_desconto_id_seq', (SELECT MAX(id) FROM cupom_desconto)+1);
SELECT setval('cupom_desconto_utilizacoes_id_seq', (SELECT MAX(id) FROM cupom_desconto_utilizacoes)+1);
SELECT setval('empresa_caixa_id_seq', (SELECT MAX(id) FROM empresa_caixa)+1);
SELECT setval('empresa_dados_id_seq', (SELECT MAX(id) FROM empresa_dados)+1);
SELECT setval('empresa_enderecos_id_seq1', (SELECT MAX(id) FROM empresa_enderecos)+1);
SELECT setval('empresa_frete_id_seq', (SELECT MAX(id) FROM empresa_frete)+1);
SELECT setval('empresa_funcionamento_id_seq', (SELECT MAX(id) FROM empresa_funcionamento)+1);
SELECT setval('empresa_marketplaces_id_seq', (SELECT MAX(id) FROM empresa_marketplaces)+1);
SELECT setval('enderecos_id_seq', (SELECT MAX(id) FROM enderecos)+1);
SELECT setval('favoritos_id_seq', (SELECT MAX(id) FROM favoritos)+1);
SELECT setval('ifood_pedidos_id_seq', (SELECT MAX(id) FROM ifood_pedidos)+1);
SELECT setval('motoboy_id_seq', (SELECT MAX(id) FROM motoboy)+1);
SELECT setval('paginas_id_seq', (SELECT MAX(id) FROM paginas)+1);
SELECT setval('produto_adicional_id_seq', (SELECT MAX(id) FROM produto_adicional)+1);
SELECT setval('produto_sabor_id_seq', (SELECT MAX(id) FROM produto_sabor)+1);
SELECT setval('produtos_id_seq', (SELECT MAX(id) FROM produtos)+1);
SELECT setval('usuarios_id_seq', (SELECT MAX(id) FROM usuarios)+1);
SELECT setval('usuarios_empresa_id_seq1', (SELECT MAX(id) FROM usuarios_empresa)+1);

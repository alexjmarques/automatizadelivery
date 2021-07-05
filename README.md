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




SELECT MAX(id) FROM usuarios;
SELECT nextval('carrinho_id_seq1');

SELECT setval('usuarios_id_seq', (SELECT MAX(id) FROM usuarios)+1);
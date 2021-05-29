<?php
cd /var/www/apd.automatiza.app/public_html
git pull
cd /var/www/temakicapao.portaldospedidos.com.br/public_html
git pull
cd /var/www/temakicampolimpo.automatiza.app/public_html
git pull
cd /var/www/doceriacassialopes.automatiza.app/public_html
git pull
cd /var/www/restaurantedataty.automatiza.app/public_html
git pull
cd /var/www/senhorespeto.automatiza.app/public_html
git pull
cd /var/www/duhburgers.automatiza.app/public_html
git pull
cd /var/www/cantinhodadende.automatiza.app/public_html
git pull
cd /var/www/studiorubim.automatiza.app/public_html
git pull

sudo chmod -R 777 /var/www/temakicampolimpo.automatiza.app/public_html/public/uploads/
sudo chmod -R 777 /var/www/doceriacassialopes.automatiza.app/public_html/public/uploads/
sudo chmod -R 777 /var/www/restaurantedataty.automatiza.app/public_html/public/uploads/
sudo chmod -R 777 /var/www/senhorespeto.automatiza.app/public_html/public/uploads/
sudo chmod -R 777 /var/www/duhburgers.automatiza.app/public_html/public/uploads/
sudo chmod -R 777 /var/www/cantinhodadende.automatiza.app/public_html/public/uploads/


define('DB_HOST', '159.65.220.187');
define('DB_USER', 'root');
define('DB_PASS', '02W@9889forev');
define('DB_NAME', 'adp_automatiza');
define('DB_PORT', '9889');




git clone https://github.com/alexjmarques/automatizaApd.git tmp && mv tmp/.git . && rm -fr tmp && git reset --hard
git config credential.helper store
git pull

sudo mkdir -p public_html
sudo chown -R $USER:$USER public_html



Log Erro 
sudo su 
echo > /var/log/apache2/error.log

nano /var/log/apache2/error.log

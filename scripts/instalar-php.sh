#!/bin/bash

set -e

echo "Instalando PHP..."
sudo apt update
sudo apt install php libapache2-mod-php php-cli php-mysql -y
sudo systemctl restart apache2

echo "PHP instalado correctamente."
php -v

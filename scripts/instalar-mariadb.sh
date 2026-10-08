#!/bin/bash

set -e

echo "Instalando MariaDB..."
sudo apt update
sudo apt install mariadb-server mariadb-client -y
sudo systemctl enable mariadb
sudo systemctl start mariadb

echo "MariaDB instalado correctamente."
mariadb --version

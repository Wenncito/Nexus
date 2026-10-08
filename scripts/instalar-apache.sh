#!/bin/bash

set -e

echo "Instalando Apache..."
sudo apt update
sudo apt install apache2 -y
sudo systemctl enable apache2
sudo systemctl start apache2

echo "Apache instalado correctamente."
apache2 -v

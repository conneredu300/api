#!/bin/bash;

apt-get update && sudo apt-get upgrade;
sudo apt-get install apache2 -y;
sudo apt-add-repository ppa:ondrej/php;
sudo apt-get update;
sudo apt-get install php7.1;
sudo apt-get install mysql-server php7.1-mysql;
sudo service apache2 restart;
sudo service mysql restart;

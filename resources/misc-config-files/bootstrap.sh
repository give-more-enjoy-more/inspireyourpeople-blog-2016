#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PASSWORD='root'

# Update / upgrade
sudo apt-get update
sudo apt-get -y upgrade

# Install apache 2.x, php 5.x, and cURL
sudo apt-get install -y apache2
sudo apt-get install -y php5
sudo apt-get install php5-curl

# Extra processes to insall specific to ghost
#sudo apt-get -y install python-software-properties python g++ make
#sudo add-apt-repository ppa:chris-lea/node.js
#sudo apt-get update
#sudo apt-get -y install nodejs

# Install Composer & Swift Mailer
sudo curl -sS https://getcomposer.org/installer | php
php composer.phar require swiftmailer/swiftmailer @stable

# Install mysql and give password to installer
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
sudo apt-get -y install mysql-server
sudo apt-get install php5-mysql

# Install phpmyadmin and give password(s) to installer (for simplicity I'm using the same password for mysql and phpmyadmin)
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
sudo apt-get -y install phpmyadmin

# Set timezone
echo "America/New_York" | tee /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

# Drops the test database from mysql
echo "DROP DATABASE IF EXISTS test" | mysql -uroot -proot

# Set Apache  Server name
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Enable mod_rewrite
sudo a2enmod rewrite

# Restart apache
service apache2 restart
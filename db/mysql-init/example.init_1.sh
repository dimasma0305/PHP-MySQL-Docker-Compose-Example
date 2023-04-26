#!/bin/bash

## Start MySQL
# /etc/init.d/mysql start

## Create the database
# mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE DATABASE mydatabase;"

## Create a user and grant permissions
# mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE USER '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';"
# mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "GRANT ALL PRIVILEGES ON mydatabase.* TO '$MYSQL_USER'@'%';"

## Stop MySQL
# /etc/init.d/mysql stop
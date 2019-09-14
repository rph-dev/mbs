#!/usr/bin/env bash

echo "create network"
docker network create --driver bridge mbs_web_net

echo "create volume db"
docker volume create --driver local mbs_mariadb

./start.sh

echo "composer install"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && composer install"
echo "create .env & generate key"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && cp .env.example .env && php artisan key:generate"

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
echo "create files upload path &"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && mkdir ./public/storage"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && chmod -R 777 ./public/storage"
echo "chmod laravel path"
git config core.fileMode false
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && chmod -R 755 ./ && chmod -R 777 ./storage && chmod -R 775 ./bootstrap/cache"

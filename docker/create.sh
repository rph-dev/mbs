#!/usr/bin/env bash

echo "create network"
docker network create --driver bridge mbs_web_net

echo "create volume db"
docker volume create --driver local mbs_mariadb

./start.sh

sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && cp .env.example .env && php artisan key:generate" \

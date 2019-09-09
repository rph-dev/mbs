#!/usr/bin/env bash

echo "create network"
docker network create --driver bridge mbs_web_net

echo "create volume db"
docker volume create --driver local mbs_mariadb

echo "create container mariadb"
docker run \
--name mbs-mariadb \
--restart unless-stopped \
--network mbs_web_net \
-p 3306:3306 \
-e MYSQL_ROOT_PASSWORD=root \
-e TZ=Asia/Bangkok \
-v mbs_mariadb:/var/lib/mysql \
-d mariadb:10.3

echo "create container php-fpm"
docker run \
--name mbs-php-fpm \
--workdir /var/www \
--restart unless-stopped \
--network mbs_web_net \
-v /Users/x15/Documents/dev/htdocs/rph-mbs/public:/var/www/mbs-web \
-v /Users/x15/Documents/dev/RPH/rph-docker-for-github/php-fpm/php-ini-overrides.ini:/usr/local/etc/php/conf.d/99-overrides.ini:ro \
-d kongvut/php-laravel

echo "create container webserver"
docker run \
--name mbs-webserver \
-v /Users/x15/Documents/dev/htdocs/rph-mbs/public:/var/www/mbs-web \
-v /Users/x15/Documents/dev/RPH/rph-docker-for-github/nginx/site/mbs.web.conf:/etc/nginx/conf.d/mbs.web.conf:ro \
-p 8088:8000 \
-e TZ=Asia/Bangkok \
--network mbs_web_net \
--restart unless-stopped \
--workdir /var/www \
-d nginx

sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && cp .env.example .env && php artisan key:generate" \

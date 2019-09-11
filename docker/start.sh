#!/usr/bin/env bash

echo "create container mariadb"
docker rm -f mbs-mariadb
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
docker rm -f mbs-php-fpm
docker run \
--name mbs-php-fpm \
--workdir /var/www \
--restart unless-stopped \
--network mbs_web_net \
-v /path/mbs:/var/www/mbs-web \
-v /path/mbs/docker/php-fpm/php-ini-overrides.ini:/usr/local/etc/php/conf.d/99-overrides.ini:ro \
-d kongvut/php-laravel

echo "create container webserver"
docker rm -f mbs-webserver
docker run \
--name mbs-webserver \
-v /path/mbs:/var/www/mbs-web \
-v /path/mbs/docker/nginx/site/mbs.web.conf:/etc/nginx/conf.d/mbs.web.conf:ro \
-p 8088:8000 \
-e TZ=Asia/Bangkok \
--network mbs_web_net \
--restart unless-stopped \
--workdir /var/www \
-d nginx

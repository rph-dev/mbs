#!/usr/bin/env bash

./stop.sh

docker rm -f mbs-mariadb mbs-php-fpm mbs-webserver
echo "remove container complete"

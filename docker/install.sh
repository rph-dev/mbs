#!/usr/bin/env bash

docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && mkdir -m 775 ./public/storage && chmod -R 777 ./storage && chmod -R 775 ./bootstrap/cache"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan migrate && php artisan db:seed"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan clear && php artisan cache:clear && php artisan config:clear"
docker restart mbs-php-fpm

./start.sh

#!/usr/bin/env bash

git pull
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && mkdir -m 775 ./public/storage && chmod -R 775 ./storage && chmod -R 775 ./bootstrap/cache"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan migrate && php artisan db:seed"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan clear && php artisan cache:clear && php artisan view:cache && php artisan optimize"
docker restart mbs-php-fpm

./start.sh

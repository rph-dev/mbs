#!/usr/bin/env bash

git pull \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && mkdir -m 775 ./public/storage && chmod -R 775 ./storage && chmod -R 775 ./bootstrap/cache" \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan clear" \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && composer install --optimize-autoloader --no-dev" \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan migrate" \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan clear && php artisan cache:clear && php artisan view:cache && php artisan optimize" \
sudo docker restart mbs-php-fpm

./start.sh

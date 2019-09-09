#!/usr/bin/env bash

sudo docker exec -it -d mbs-php-fpm sh -c "php /var/www/mbs-web/artisan down"

git pull \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan clear" \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && composer install --optimize-autoloader --no-dev" \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan migrate" \
sudo docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan clear && php artisan cache:clear && php artisan view:cache && php artisan optimize" \
sudo docker restart mbs-php-fpm

sudo docker exec -it -d mbs-php-fpm sh -c "php /var/www/mbs-web/artisan up"

#!/usr/bin/env bash

echo "create mbs_web db"
while ! docker exec mbs-mariadb mysqladmin --user=root --password=root --host "127.0.0.1" ping --silent &> /dev/null ; do
    echo "Waiting for database connection..."
    sleep 5
done
docker exec -it mbs-mariadb sh -c "mysql -uroot -proot -e 'CREATE DATABASE mbs_web CHARACTER SET \"utf8mb4\" COLLATE \"utf8mb4_unicode_ci\"'"
docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan migrate && php artisan db:seed"

docker exec -it mbs-php-fpm sh -c "cd /var/www/mbs-web/ && php artisan clear && php artisan cache:clear && php artisan config:clear"
docker restart mbs-php-fpm

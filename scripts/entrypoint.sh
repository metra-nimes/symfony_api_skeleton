#!/bin/bash

set -e

APP_ENV=${1:-'dev'}

sleep 30
composer install
php bin/console doctrine:migrations:migrate --no-interaction
#yarn install
#printf "start encore dev server\n"
#yarn dev-server > logs/encore.log 2>&1 &
php bin/console doctrine:fixtures:load --no-interaction
chown -R www-data:www-data var/cache
chown -R www-data:www-data var/log
php-fpm
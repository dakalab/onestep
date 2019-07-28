#!/bin/bash
composer install

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate

mlock="/app/migrate.lock"
if [ ! -f $mlock ]; then
    touch $mlock
    php artisan migrate --seed --force
fi

php artisan storage:link

chmod -R 0777 storage

#!/bin/bash

sleep 10
php artisan storage:link
php artisan migrate:fresh
php artisan db:seed
php-fpm

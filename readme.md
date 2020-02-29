# Laravel Studio

Just Laravel boilerplate with some alterations to support local package development.

Usage:
```
docker-compose up
docker exec laravel-studio-php-fpm composer install
docker exec laravel-studio-php-fpm php artisan migrate
```
# Laravel Studio

Just Laravel boilerplate with some alterations to support local package development.

## Usage

1) Copy `src/.env.example` to `src/.env`

2) Run:
```bash
docker-compose up
docker exec laravel-studio-php-fpm composer install
docker exec laravel-studio-php-fpm php artisan key:generate
docker exec laravel-studio-php-fpm php artisan migrate
```
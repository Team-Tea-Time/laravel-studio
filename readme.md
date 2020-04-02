# Laravel Studio

Just Laravel boilerplate with some alterations to support local package development.

## Usage

1) Clone:
```
git clone git@github.com:Team-Tea-Time/laravel-studio.git
```

2) Clone/place your package(s) into a `laravel-packages` directory adjacent to (not inside) this repo

3) Copy `src/.env.example` to `src/.env`

4) Modify the `autoload` section of `composer.json` to specify your package namespace(s)/path(s)

5) Run `docker-compose up` and any other commands you may need to run in the container for your package(s):
```bash
docker-compose up
docker-compose exec php-fpm composer install
docker-compose exec php-fpm php artisan key:generate
docker-compose exec php-fpm php artisan migrate
```

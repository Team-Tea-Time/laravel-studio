FROM php:7.3.6-fpm

COPY src/composer.* /var/www/laravel-studio/

WORKDIR /var/www/laravel-studio

# System dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    wkhtmltopdf \
    xvfb

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require hirak/prestissimo

# PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd
RUN pecl install xdebug && docker-php-ext-enable xdebug

# PHP config
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY docker/php-fpm/conf.d/99-overrides.ini $PHP_INI_DIR/conf.d/

# App user/directory/perms/dependencies
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY src /var/www/laravel-studio
COPY --chown=www:www src /var/www/laravel-studio
USER www

RUN composer install
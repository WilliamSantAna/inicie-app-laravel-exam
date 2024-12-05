FROM php:8.2-apache

RUN apt-get update && apt-get install -y apache2-utils libpng-dev libjpeg-dev libfreetype6-dev \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev procps \
    zip unzip curl git net-tools nano && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

RUN git config --global --add safe.directory /var/www/html

RUN a2enmod rewrite && \
    a2enmod proxy && \
    a2enmod proxy_http

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer update

RUN alias ll='ls -tlha'

EXPOSE 80

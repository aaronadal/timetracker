FROM php:8.4-fpm

WORKDIR /app

# @see https://github.com/mlocati/docker-php-extension-installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt update && apt install unzip

RUN install-php-extensions \
    pdo_mysql \
    zip \
;

CMD ["php-fpm"]

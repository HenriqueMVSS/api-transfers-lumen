# FROM phpdockerio/php:8.2-fpm
FROM php:8.1.9-fpm-alpine3.16
# lumen packages
RUN docker-php-ext-install mysqli pdo_mysql
RUN apk update \
    && apk add --no-cache gmp-dev \
    && docker-php-ext-install gmp
# memcached
WORKDIR /application
# RUN docker-php-ext-install mysqli pdo_mysql
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
RUN composer install

COPY . .

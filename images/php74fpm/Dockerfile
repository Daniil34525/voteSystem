FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev
RUN apt-get install -y curl git zip

RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 votesystem-data && groupmod -g 1000 votesystem-data

USER "1000:1000"

WORKDIR /var/votesystem

RUN php yii migrate --migrationPath=@yii/rbac/migrations --interactive = 0
RUN php yii migrate --interactive = 0

ENTRYPOINT [ "php-fpm" ]
# use a multi-stage build for dependencies
FROM composer:2 as composer
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --ignore-platform-reqs --no-interaction --prefer-dist

FROM craftcms/nginx:8.2

USER root
RUN apk add --no-cache postgresql-client git
COPY .docker/default.conf /etc/nginx/conf.d/default.conf
USER www-data

COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=composer /app/vendor/ ./vendor/
COPY --from=composer /usr/bin/composer /usr/bin/composer

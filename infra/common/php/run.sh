#!/usr/bin/env bash

set -e

echo "Service app_php starts"

# workdir
cd /codebase

# fix permissions
if [ -d "./var" ]; then
    chown -R www-data:www-data ./var
fi

# install composer && allow composer install in parallel
if [ ! -f "/usr/local/bin/composer" ]; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer \
        && composer global require hirak/prestissimo 0.3.8
fi

# composer install
if [ -f "composer.json" ]; then
    composer --no-ansi --no-interaction --prefer-dist install \
        && composer clearcache
fi

# setup logs
mkdir -p /var/log/php && \
    touch /var/log/php/php.log && \
    chmod -R 777 /var/log/php
tail -f /var/log/php/php.log >/proc/1/fd/1 &

echo "Service app_php runs"

exec "$@"

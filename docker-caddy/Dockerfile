FROM caddy:2-builder AS builder

RUN xcaddy build --with github.com/baldinof/caddy-supervisor

FROM php:8.3-fpm-alpine

COPY --from=builder /usr/bin/caddy /usr/bin/caddy

RUN apk add git zip patch
COPY docker-caddy/Caddyfile /etc/caddy/Caddyfile
COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
# Install default PHP Extensions
RUN install-php-extensions \
    bcmath \
    mysqli \
    intl \
    ldap \
    gd \
    soap \
    tidy \
    xsl \
    zip \
    exif \
    gmp \
    memcached \
    apcu \
    @composer


ENV DOCUMENT_ROOT /var/www/html
COPY . $DOCUMENT_ROOT
WORKDIR $DOCUMENT_ROOT
RUN rm -rf docker*
RUN mkdir -p /var/www/html/public/assets
RUN git config --global --add safe.directory /var/www/html
# Buildkit is not supported yet
# RUN --mount=type=cache,target=/var/cache/composer /usr/local/bin/composer install --no-dev --prefer-dist --no-interaction --no-progress
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader
RUN composer vendor-expose copy
RUN chown -R www-data:www-data /var/www/html

RUN echo 'date.timezone = UTC' > "$PHP_INI_DIR/conf.d/timezone.ini"
RUN { \
        echo 'log_errors = On'; \
        echo 'error_log = /dev/stderr'; \
    } > "$PHP_INI_DIR/conf.d/errors.ini"
RUN { \
    echo 'expose_php = Off'; \
    echo 'error_reporting = E_ALL'; \
    echo 'display_errors = Off'; \
    echo 'display_startup_errors  = Off'; \
    echo 'short_open_tag = Off'; \
    echo 'upload_max_filesize = 8M'; \
    echo 'open_basedir = "/var/log:/var/www:/tmp:$PHP_INI_DIR:/usr/local/lib/php:/usr/local/etc:/usr/local/bin/composer"'; \
    echo 'memory_limit = 2G'; \
} >> $PHP_INI_DIR/conf.d/production.ini

COPY docker-caddy/startup.sh /usr/local/bin/startup
RUN chmod a+rx /usr/local/bin/startup
CMD ["startup"]

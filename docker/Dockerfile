FROM php:8.2-apache-bookworm
ARG SS_DATABASE_SERVER=${SS_DATABASE_SERVER}
ENV SS_DATABASE_SERVER=${SS_DATABASE_SERVER}
ARG SS_DATABASE_NAME=${SS_DATABASE_NAME}
ENV SS_DATABASE_NAME=${SS_DATABASE_NAME}
ARG SS_DATABASE_USERNAME=${SS_DATABASE_USERNAME}
ENV SS_DATABASE_USERNAME=${SS_DATABASE_USERNAME}
ARG SS_DATABASE_PASSWORD=${SS_DATABASE_PASSWORD}
ENV SS_DATABASE_PASSWORD=${SS_DATABASE_PASSWORD}

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions
RUN DEBIAN_FRONTEND=noninteractive apt-get update
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y unzip git curl apt-transport-https lsb-release ca-certificates

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
        gmp

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set error handling
RUN echo 'date.timezone = Pacific/Auckland' > "$PHP_INI_DIR/conf.d/timezone.ini" && \
    { \
        echo 'log_errors = On'; \
        echo 'error_log = /dev/stderr'; \
    } > "$PHP_INI_DIR/conf.d/errors.ini"

COPY ./docker/default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite expires remoteip headers

ENV DOCUMENT_ROOT /var/www/html
COPY . $DOCUMENT_ROOT
WORKDIR $DOCUMENT_ROOT
RUN mkdir -p /var/www/html/public/assets
RUN mkdir -p /var/www/html/public/_graphql
RUN /usr/local/bin/composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

RUN DEBIAN_FRONTEND=noninteractive apt-get purge -y git unzip


# Hacky approach to ensuring apache has access to it's root folder
RUN sed -i 's|set -e|set -e\n\n/var/www/html/vendor/bin/sake dev/build flush=all\n\ncomposer vendor-expose copy\n\n\nchown -R www-data:www-data /var/www/html\n |' /usr/local/bin/docker-php-entrypoint

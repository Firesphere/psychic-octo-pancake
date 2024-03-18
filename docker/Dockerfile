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
RUN echo ${RELEASE}
RUN apt-get update
RUN DEBIAN_NONINTERACTIVE=1 apt-get install -y unzip git curl apt-transport-https lsb-release ca-certificates

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
        opcache \
        memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://silverstripe.github.io/sspak/install | php -- /usr/local/bin

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN set -eux; \
	docker-php-ext-enable opcache; \
	{ \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=2'; \
		echo 'opcache.fast_shutdown=1'; \
	} > "$PHP_INI_DIR/conf.d/opcache-recommended.ini"

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
RUN chown 33:33 $DOCUMENT_ROOT
RUN /usr/local/bin/composer install --no-dev --prefer-dist --no-interaction
RUN /usr/local/bin/composer vendor-expose copy

# Build a GQL schema cache
RUN chown -R 33:33 $DOCUMENT_ROOT

RUN apt purge -y git unzip

# Hacky approach to ensuring apache has access to it's root folder
RUN sed -i 's|set -e|set -e\n\n/var/www/html/vendor/bin/sake dev/build flush=all\n\ncomposer vendor-expose copy\n\n\nchown -R www-data:www-data /var/www/html\n |' /usr/local/bin/docker-php-entrypoint
USER www-data

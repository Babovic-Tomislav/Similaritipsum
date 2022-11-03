
FROM composer:2 as composer
FROM php:8.1-fpm-alpine as base

ARG USER_UID
ARG USER_GID

# Recreate www-data user with user id matching the host
RUN deluser --remove-home www-data && \
    addgroup -S -g ${USER_GID} www-data && \
    adduser -u ${USER_UID} -D -S -G www-data www-data

# Necessary tools
RUN apk add --update --no-cache ${PHPIZE_DEPS} git curl
RUN apk add --update --no-cache gmp-dev
RUN docker-php-ext-install gmp
# ZIP module
RUN apk add --no-cache libzip-dev && docker-php-ext-configure zip && docker-php-ext-install zip

# Imagick module
RUN apk add --no-cache libgomp imagemagick imagemagick-dev && \
	pecl install -o -f imagick && \
	docker-php-ext-enable imagick

# Symfony CLI tool
RUN apk add --no-cache bash && \
	curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash && \
	apk add symfony-cli && \
	apk del bash

# XDebug from PECL
RUN pecl install xdebug-3.1.5

# Necessary build deps not longer needed
RUN apk del --no-cache ${PHPIZE_DEPS} \
    && docker-php-source delete

# Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# XDebug wrapper
COPY ./artifacts/xdebug /usr/local/bin/xdebug
RUN chmod +x /usr/local/bin/xdebug

# Clean up image
RUN rm -rf /tmp/* /var/cache

RUN apk add nodejs npm
#WORKDIR is /var/www/html
COPY . /var/www/html/

USER www-data


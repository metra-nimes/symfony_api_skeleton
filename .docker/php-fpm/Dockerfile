ARG PHP_VERSION="7.4"

FROM composer:latest as composer

FROM php:${PHP_VERSION}-fpm-alpine as base

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

LABEL maintainer="metra.nimes@gmail.com"

WORKDIR "/app"

ENV TZ=Europe/Moscow

RUN apk update \
 && apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    jpeg-dev zlib-dev libpng-dev postgresql-dev libzip-dev curl-dev oniguruma-dev libxml2-dev libressl-dev rabbitmq-c-dev\
    g++ make autoconf \
    tzdata \
    bash \
 && docker-php-source extract \
     && pecl install xdebug redis opcache amqp\
     && docker-php-ext-enable xdebug redis opcache amqp\
     && docker-php-source delete \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 &&  docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
 && docker-php-ext-install \
    gd \
    pgsql \
    zip \
    curl \
    intl \
    mbstring \
    xml \
    xmlrpc \
    pdo pdo_pgsql \
 && docker-php-ext-enable \
    gd \
    pgsql \
    zip \
    curl \
    intl \
    mbstring \
    xml \
    xmlrpc \
 && ln -s /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
 && apk del \
 		autoconf \
 		binutils \
 		db \
 		g++ \
 		gcc \
 		gmp \
 		isl \
 		libatomic \
 		libbz2 \
 		libc-dev \
 		libffi \
 		libgcc \
 		libgomp \
 		libldap \
 		libsasl \
 		libstdc++ \
 		m4 \
 		mpc1 \
 		musl-dev \
 		perl \
 		pkgconf \
 		pkgconfig \
 		sqlite-libs \
 		zlib-dev \
 	&& rm -rf \
 	    /tmp/* \
 	    /var/cache/apk/* \
 	    /var/lib/apt/lists/*

RUN apk update \
 && apk add --no-cache \
    nodejs-current \
    yarn \
 && rm -rf \
  	    /tmp/* \
  	    /var/cache/apk/* \
  	    /var/lib/apt/lists/*

COPY .docker/php-fpm/conf/docker-php-ext-opcache.ini /usr/local/etc/php/conf.d
COPY .docker/php-fpm/conf/php-ini-overrides.ini /usr/local/etc/php/conf.d

FROM base as dev

RUN mkdir -p var/log
RUN mkdir -p var/cache
RUN chown -R www-data:www-data ./var/log
RUN chown -R www-data:www-data ./var/cache

ENTRYPOINT exec ./scripts/entrypoint.sh dev
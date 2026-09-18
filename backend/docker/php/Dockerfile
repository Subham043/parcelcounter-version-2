FROM php:8.3-cli-alpine

# System dependencies
RUN apk add --no-cache \
    bash \
    git \
    curl \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    linux-headers \
    supervisor \
    supercronic \
    autoconf \
    g++ \
    make \
    nodejs \
    npm

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    intl \
    zip \
    pcntl \
    gd \
    opcache

RUN pecl install openswoole \
    && docker-php-ext-enable openswoole

# OPCache config
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=30000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=1" >> /usr/local/etc/php/conf.d/opcache.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# 
COPY docker/php/supervisord/supervisord.conf /etc/supervisord.conf
COPY docker/php/schedule/crontab /etc/crontab

# CMD ["php-fpm"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

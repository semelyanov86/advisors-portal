FROM php:8.0.3-apache

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0 \
    PHP_OPCACHE_MAX_ACCELERATED_FILES=10000 \
    PHP_OPCACHE_MEMORY_CONSUMPTION=128

COPY docker/composer-installer.sh /usr/local/bin/composer-installer

RUN apt-get -yqq update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip
RUN apt-get -yqq install exiftool
RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

RUN docker-php-ext-install pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug opcache \
    && a2enmod rewrite \
    && apt-get -yqq install --no-install-recommends unzip \
    && chmod +x /usr/local/bin/composer-installer \
    && composer-installer \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http

WORKDIR /tmp
ADD composer.json composer.lock /tmp/
RUN mkdir -p database/seeds \
    && mkdir -p database/factories \
    && composer install --no-interaction --no-plugins --no-scripts --prefer-dist \
    && rm -rf composer.json composer.lock database/ vendor/

COPY . /var/www/html
WORKDIR /var/www/html
COPY docker/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY docker/config/php/conf.d/*.ini /usr/local/etc/php/conf.d/
COPY docker/start.sh /usr/local/bin/start
COPY docker/config/php/php.ini /usr/local/etc/php/php.ini

RUN chown -R www-data:www-data /var/www/html \
    && chmod +x /usr/local/bin/start

CMD ["/usr/local/bin/start"]

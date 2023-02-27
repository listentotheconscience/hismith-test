FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    zlib1g-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpq-dev \
    libmagickwand-dev \
    supervisor \
    ghostscript \
    netcat \
    && pecl install imagick redis xdebug \
    && docker-php-ext-enable imagick redis xdebug \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure pgsql \
    && docker-php-ext-install -j$(nproc) gd soap iconv pdo pdo_pgsql pgsql zip mbstring exif pcntl \
    && docker-php-source delete

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY .docker/entrypoint /entrypoint
COPY .docker/entrypoint-horizon /entrypoint-horizon
COPY .docker/horizon.conf /etc/supervisor
COPY .docker/supervisord.conf /etc/supervisor

RUN chmod +x /entrypoint
RUN chmod +x /entrypoint-horizon
ENTRYPOINT [ "/entrypoint" ]

EXPOSE 9000
CMD ["/usr/bin/supervisord"]

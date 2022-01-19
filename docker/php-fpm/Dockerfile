FROM php:8.0.11-fpm-alpine

RUN apk --update add wget \
    curl \
    git \
    build-base \
    libmemcached \
    libmcrypt-dev \
    libxml2-dev \
    zlib \
    autoconf \
    cyrus-sasl \
    libgsasl \
    supervisor \
    oniguruma-dev \
    procps \
    libpq \
    openssl \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    composer \
    libpq \
    postgresql-dev \
    postgresql-client

RUN docker-php-ext-install mysqli pdo pdo_mysql pcntl bcmath exif pdo_pgsql pgsql

RUN pecl channel-update pecl.php.net && pecl install mcrypt-1.0.4

#Install GD package:
RUN apk add --update --no-cache freetype-dev libjpeg libjpeg-turbo-dev libwebp-dev jpeg-dev libpng-dev; \
    docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg; \
    docker-php-ext-install -j$(nproc) gd

#Install ImageMagick package:
RUN set -eux; \
    apk add --update --no-cache imagemagick imagemagick-dev libtool; \
    pecl install imagick; \
    docker-php-ext-enable imagick; \
    php -m | grep -q 'imagick';

# Install ZipArchive:
RUN set -eux; \
    apk --update add libzip-dev && \
    docker-php-ext-configure zip; \
    # Install the zip extension
    docker-php-ext-install zip

# Install PhpRedis package:
RUN printf "\n" | pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Install wkhtmltopdf package:
RUN set -eux; \
    apk --update add libxrender libx11 libxtst fontconfig freetype wkhtmltopdf;

RUN composer self-update --2

WORKDIR /var/www/

CMD ["php-fpm"]

EXPOSE 9000
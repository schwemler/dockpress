
FROM php:7.2-apache

RUN apt-get update && apt-get upgrade -y

RUN apt-get update -y && apt-get install -y \
    curl \
    sendmail \
    build-essential \
    libssl-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev \
    libfreetype6-dev \
    zlib1g-dev

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

#RUN chmod -R o+w src/
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

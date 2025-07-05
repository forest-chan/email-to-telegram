FROM php:8.2-fpm

WORKDIR /var/www/html

COPY . /var/www/html
COPY ./etc/crontab /etc/cron.d/crontab

RUN apt-get update  \
    && apt-get install -y \
    libkrb5-dev \
    libc-client2007e \
    libc-client2007e-dev \
    libssl-dev \
    wget \
    unzip \
    git \
    libpq-dev \
    cron \
    && docker-php-ext-install pdo_pgsql pgsql \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-interaction \
    && chown -R www-data:www-data /var/www/html \
    && chmod 0644 /etc/cron.d/crontab \
    && crontab /etc/cron.d/crontab \

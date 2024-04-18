FROM  php8.2:11

# utils
ENV ACCEPT_EULA=Y
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && \
    apt-get dist-upgrade -y && \
    apt-get install -y \
        gnupg \
        g++ \
        procps \
        openssl \
        git \
        unzip \
        zlib1g-dev \
        libzip-dev \
        libfreetype6-dev \
        libpng-dev \
        libjpeg-dev \
        libicu-dev  \
        libonig-dev \
        libxslt1-dev \
        acl \
        supervisor \
        libodbc1 \
        odbcinst1debian2 \
        unixodbc \
        unixodbc-dev \
        mssql-tools \
        msodbcsql17 \
        libmemcached-dev \
        zlib1g-dev \
        libpq-dev \
        libpng-dev && \
    docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        pdo_mysql \
        sockets && \
    pecl install \
        sqlsrv \
        pdo_sqlsrv \
        memcached \
        opcache \
        redis && \
    docker-php-ext-enable \
        sqlsrv \
        pdo_sqlsrv \
        memcached \
        opcache \
        pdo_mysql \
        redis \
        sockets && \
    wget https://getcomposer.org/download/2.1.8/composer.phar -O /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && \
    wget https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -O /usr/local/bin/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions amqp


# utils
RUN chmod uog+w /tmp/

# Install PHP extension installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/


WORKDIR /var/www/html/
ADD . /var/www/html/

ADD .env /var/www/html/.env

RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

RUN composer install
RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod expires
RUN  rm /etc/apache2/sites-available/000-default.conf \
    && rm /etc/apache2/sites-enabled/000-default.conf

RUN php artisan key:generate \
    && php artisan storage:link

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
#CMD ["supervisord", "-c", "/etc/supervisor/conf.d/worker.conf"]





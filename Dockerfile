FROM richarvey/nginx-php-fpm:latest

LABEL maintainer="Hugo Zang"

ADD . /var/www/html

RUN apk update && \
    apk add nodejs && \
    EXPECTED_COMPOSER_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig) && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '${EXPECTED_COMPOSER_SIGNATURE}') { echo 'Composer.phar Installer verified'; } else { echo 'Composer.phar Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"
    # pip install -U pip && \
    # pip install -U certbot 
    # mkdir -p /etc/letsencrypt/webrootauth && \
    # apk del gcc musl-dev linux-headers libffi-dev augeas-dev python-dev make autoconf

RUN composer update
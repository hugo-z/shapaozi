FROM richarvey/nginx-php-fpm:latest

LABEL maintainer="Hugo Zang"

ADD . /var/www/html

<<<<<<< HEAD


=======
>>>>>>> 1f5a9a93fae034a8238d6debdf2e58317409140d
RUN apk update && \
    apk add nodejs && \
    EXPECTED_COMPOSER_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig) && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '${EXPECTED_COMPOSER_SIGNATURE}') { echo 'Composer.phar Installer verified'; } else { echo 'Composer.phar Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"
<<<<<<< HEAD
    
=======
>>>>>>> 1f5a9a93fae034a8238d6debdf2e58317409140d
    # pip install -U pip && \
    # pip install -U certbot 
    # mkdir -p /etc/letsencrypt/webrootauth && \
    # apk del gcc musl-dev linux-headers libffi-dev augeas-dev python-dev make autoconf

<<<<<<< HEAD
RUN composer update && \
    php artisan vendor:publish --provider="JeroenNoten\LaravelAdminLte\ServiceProvider" --tag=assets --force && \
    docker cp ./public/vendor/bootstrap-switch-master traefik_shapaozi_1:/var/www/html/public/vendor && \
    docker cp ./public/vendor/adminlte/dist/img traefik_shapaozi_1:/var/www/html/public/vendor/adminlte/dist \
=======
RUN composer update
>>>>>>> 1f5a9a93fae034a8238d6debdf2e58317409140d

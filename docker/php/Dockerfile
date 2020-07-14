FROM alpine:3.12

RUN apk add --update --no-cache \
    coreutils=8.32-r0 \
    php7-fpm=7.3.20-r0 \
    php7-pecl-apcu=5.1.18-r0 \
    php7-ctype=7.3.20-r0 \
    php7-curl=7.3.20-r0 \
    php7-dom=7.3.20-r0 \
    php7-gd=7.3.20-r0 \
    php7-iconv=7.3.20-r0 \
    php7-pecl-imagick=3.4.4-r3 \
    php7-json=7.3.20-r0 \
    php7-intl=7.3.20-r0 \
    php7-pecl-mcrypt=1.0.3-r0 \
    php7-fileinfo=7.3.20-r0 \
    php7-mbstring=7.3.20-r0 \
    php7-opcache=7.3.20-r0 \
    php7-openssl=7.3.20-r0 \
    php7-pdo=7.3.20-r0 \
    php7-pdo_mysql=7.3.20-r0 \
    php7-mysqli=7.3.20-r0 \
    php7-xml=7.3.20-r0 \
    php7-zip=7.3.20-r0 \
    php7-phar=7.3.20-r0 \
    php7-tokenizer=7.3.20-r0 \
    php7-session=7.3.20-r0 \
    php7-simplexml=7.3.20-r0 \
    php7-pecl-xdebug=2.9.6-r0 \
    php7-xmlwriter=7.3.20-r0 \
    make=4.3-r0 \
    curl=7.69.1-r0

RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY www.conf /etc/php7/php-fpm.d/
COPY dev.sh /opt/jobs/

CMD ["php-fpm7", "-F"]

WORKDIR /var/www/news
EXPOSE 9000

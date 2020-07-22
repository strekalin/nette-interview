FROM alpine:edge

RUN apk add --update --no-cache \
    coreutils \
    php7-fpm \
    php7-pecl-apcu \
    php7-ctype \
    php7-curl \
    php7-dom \
    php7-gd \
    php7-iconv \
    php7-pecl-imagick \
    php7-json \
    php7-intl \
    php7-pecl-mcrypt \
    php7-fileinfo \
    php7-mbstring \
    php7-opcache \
    php7-openssl \
    php7-pdo \
    php7-pdo_mysql \
    php7-mysqli \
    php7-xml \
    php7-zip \
    php7-phar \
    php7-tokenizer \
    php7-session \
    php7-simplexml \
    php7-pecl-xdebug \
    php7-xmlwriter \
    make \
    curl \
	&& \
	echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY www.conf /etc/php7/php-fpm.d/
COPY dev.sh /opt/jobs/

CMD ["php-fpm7", "-F"]

WORKDIR /var/www/jobs
EXPOSE 9000

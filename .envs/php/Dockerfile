FROM php:8-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/app

WORKDIR /var/www/app

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

COPY php/php.ini /usr/local/etc/php/php.ini

COPY php/php-fpm.conf /usr/local/etc/php-fpm.conf

COPY php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN docker-php-ext-install pdo pdo_mysql

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/5.3.4.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

# Install supervisor
RUN apk add supervisor \
 && rm -rf /var/cache/apk/*

COPY php/php-worker.conf /etc/supervisor/conf.d/php-worker.conf

# Setup crontab
# Create the log file to be able to run tail
RUN touch /var/log/cron.log
RUN echo "* * * * * php /var/www/app/artisan schedule:run >> /var/log/cron.log 2>&1" >> /etc/crontab

# Give execution rights on the cron job
RUN chmod 0644 /etc/crontab

# Apply cron job
RUN /usr/bin/crontab /etc/crontab

COPY php/*.sh /scripts/
RUN chmod a+x /scripts/*.sh

# Set user to running image
USER laravel

EXPOSE 9000

ENTRYPOINT ["/scripts/entrypoint.sh"]

CMD ["/scripts/command.sh"]

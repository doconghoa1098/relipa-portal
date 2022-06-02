#!/bin/sh

# Copy development environment file if not existing
if [[ ! -f /var/www/app/.env && -f /var/www/app/.env.example ]]; then
  cp /var/www/app/.env.example /var/www/app/.env
fi

# Generate application key if it not set
APP_KEY=$(cat .env | sed -n 's/^APP_KEY=/ /p')
if [[ -z "${APP_KEY// }" ]]; then
  php artisan key:generate
fi

vendorDir=/var/www/app/vendor
# Install composer if it not existing
if [[ ! -d $vendorDir ]]; then
  composer install
fi

#vendorOwner=$(stat -c '%U' $vendorDir)
#if [ "$vendorOwer" != "php-fpm" ]; then
#  # Change owner of $vendorDir directory to user php-fpm
#  sudo chown -R php-fpm:php-fpm $vendorDir
#fi

standardPath=/var/www/app/vendor/squizlabs/php_codesniffer/src/Standards/VnextCS
if [ ! -d "$standardPath" ]; then
  # Copy php code sniff to vendor
  cp -i -r .envs/phpcs/VnextCS/ $standardPath
fi

# Discovery new packages and generate manifest
composer dump-autoload

# Start generate JWT secret
#if [ "$(cat ./.env | grep "JWT_SECRET")" == "JWT_SECRET=" ]; then
#    echo "----- GENERATING JWT SECRET KEY -----"
#
#    clientSecret=$(php artisan jwt:secret)
#
#    sed -i "s/JWT_SECRET=.*/JWT_SECRET=$clientSecret/g" .env
#
#    echo "----- JWT SECRET KEY GENERATED -----"
#fi

# Clear and cache config
php artisan config:cache

# Starting cron
/usr/sbin/crond -b -l 8 /var/log/cron.log

# Starting Supervisor to start the queue process
supervisord --configuration /etc/supervisor/conf.d/php-worker.conf

exec "$@"

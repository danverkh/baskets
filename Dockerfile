FROM php:8.2.3-fpm

RUN apt-get update && apt-get install -y

# install composer
RUN php -r "copy('https://getcomposer.org/installer', './composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; } echo PHP_EOL;"
RUN ls -la
RUN php ./composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

COPY ./ /var/www/html

WORKDIR /var/www/html
RUN composer install
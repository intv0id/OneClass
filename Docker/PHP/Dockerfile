FROM php:5.6-apache
 
# Install PDO MySQL driver
# See https://github.com/docker-library/php/issues/62
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo pdo_mysql
 
# Workaround for write permission on write to MacOS X volumes
# See https://github.com/boot2docker/boot2docker/pull/534
RUN usermod -u 1000 www-data
 
# Enable Apache mod_rewrite
RUN a2enmod rewrite
FROM php:7.4-apache

RUN apt update && apt install -y git

RUN curl -sSL https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions -o - | sh -s \
    gd bcmath intl pdo_mysql soap xsl zip sockets sodium

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY magento/ ./

RUN composer install

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite && service apache2 restart

EXPOSE 80/tcp
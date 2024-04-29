FROM php:8.2-apache

RUN apt update && apt install -y \
        nodejs \
        npm \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
        vim \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

# create document root, fix permissions for www-data user and change owner to www-data 
WORKDIR /var/www/html
#COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf 
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN composer install --no-interaction --no-plugins --no-scripts => run manually after create container

RUN composer global require "laravel/installer" && composer global require "phpunit/phpunit"  
ENV PATH $PATH:/home/laravel/.composer/vendor/bin

COPY composer.json ./
COPY composer.lock ./
RUN composer install --no-interaction --no-scripts --no-autoloader


COPY . /var/www/html   

RUN composer dump-autoload --optimize

COPY  .env.example .env
RUN mkdir apache
RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite
EXPOSE 80
COPY start.sh /var/www/html/start.sh
RUN chmod +x /var/www/html/start.sh
ENTRYPOINT ["/var/www/html/start.sh"]
#CMD apachectl -DFOREGROUND

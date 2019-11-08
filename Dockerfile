FROM leandreaci/php:7.3
WORKDIR /var/www/html
COPY . .
RUN composer install

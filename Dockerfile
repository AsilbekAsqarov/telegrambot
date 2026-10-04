
FROM php:8.3-apache

WORKDIR /var/www/html

COPY G.php /var/www/html/index.php

EXPOSE 80

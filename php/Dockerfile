FROM php:8.2-apache

# Instalação das extensões PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# diretório de trabalho padrão
WORKDIR /var/www/html

# porta utilizada
EXPOSE 80
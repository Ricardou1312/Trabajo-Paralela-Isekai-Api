# Isekai API
## Requisitos

Dependencias Necesarias:

- PHP >= 8.1
- Composer
- PostgreSQL
- Laravel 

## Instalación php 

sudo apt install -y php php-cli php-common php-mbstring php-xml php-curl php-pgsql php-bcmath php-zip unzip curl git

## Instalacion Composer

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer

## Instalacion de dependencias de laravel 

composer install

## Comandos necesarios para asegurar que se ejecute el servidor en local
php artisan optimize:clear
php artisan config:cache
php artisan key:generate

## Comando para iniciar el servidor en local
php artisan serve

luego en cualquier navegador localhost:8000 para ver como funciona la pagina, se agrego un tipo de "Landing Page" para que tener un acceso mas directo hacia las URLs 

##Notas Adicionales 
a veces hay problemas con la cache para resolver esto
sudo chmod -R 775 storage/ bootstrap/cache/


FROM composer

WORKDIR /app

COPY composer.json /app
COPY main.php /app
COPY .env /app

RUN composer install

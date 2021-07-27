#!/bin/bash

git clone https://github.com/resultakak/php-challenge.git
cd php-challenge
cp example.env .env
docker-compose up -d --build
docker-compose exec api composer install;
docker-compose exec worker composer install;
docker-compose exec mock composer install;
docker-compose exec api vendor/bin/phinx seed:run;
docker-compose exec mock vendor/bin/phinx seed:run;

#!/bin/bash

docker-compose up -d --build
docker-compose exec api composer install;
docker-compose exec worker composer install;
docker-compose exec mock composer install;
docker-compose exec mock vendor/bin/phinx seed:run;

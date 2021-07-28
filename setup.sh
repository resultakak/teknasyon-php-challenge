#!/bin/bash

# curl -s https://raw.githubusercontent.com/resultakak/php-challenge/develop/setup.sh | bash

git clone https://github.com/resultakak/php-challenge.git

cd php-challenge

cp example.env .env

docker-compose up -d --build

docker-compose exec api make setup;

docker-compose exec mock make setup;

docker-compose exec worker make setup;

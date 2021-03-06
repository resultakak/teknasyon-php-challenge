#!/bin/bash

cp example.env .env
docker build -t resultakak/php:mavi ./build/php
docker-compose up -d --build
docker-compose exec worker make setup;
docker-compose exec mock make setup;
docker-compose exec api make setup;

#!/bin/bash

cp example.env .env
docker build -t resultakak/php:latest ./build/php
docker-compose up -d --build
docker-compose exec api make setup;
docker-compose exec mock make setup;
docker-compose exec worker make setup;

Install
===

## Prerequisites

### Requirements

* PHP `>= 7.4.21`
* Phalcon `>= 4.1.0`
* Git `>= 2.32.0`
* Docker `20.10.7`
* Docker Compose `1.29.2`

### Add to hosts file:

```shell
127.0.0.1	api.local
127.0.0.1	mock.local
```

## Install

```shell
curl -s https://raw.githubusercontent.com/resultakak/php-challenge/develop/install.sh | bash
```

or

```shell
git clone https://github.com/resultakak/php-challenge.git
cd php-challenge
cp example.env .env
docker build -t resultakak/php:mavi ./build/php
docker-compose up -d --build
docker-compose exec worker make setup
docker-compose exec mock make setup
docker-compose exec api make setup

```

## Uninstall

```shell

curl -s https://raw.githubusercontent.com/resultakak/php-challenge/develop/remove.sh | bash

```

or

```shell

docker-compose down
docker system prune -a --volumes
rm ./src/api/logs/*.log
rm ./src/api/composer.lock
rm -rf ./src/api/vendor
rm ./src/mock/logs/*.log
rm ./src/mock/composer.lock
rm -rf ./src/mock/vendor
rm ./src/worker/*.log
rm ./src/worker/storage/logs/*.log
rm -rf ./src/worker/vendor
rm ./src/worker/composer.lock
rm -rf ./build/mysql/data/

```

---
### [Index](index)

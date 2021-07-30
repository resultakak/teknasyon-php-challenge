Mobile Application Subscription Management
===

Mobile applications are able to make in-app-purchase purchases, verification and current subscription control using this API.

See [Documentation](https://resul.me/php-challenge/).

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6f0afcfa224d41a09047f7857af08e7e)](https://app.codacy.com/gh/resultakak/php-challenge?utm_source=github.com&utm_medium=referral&utm_content=resultakak/php-challenge&utm_campaign=Badge_Grade_Settings)

## Prerequisites

### Requirements

* PHP `>= 7.4.21`
* Phalcon `>= 4.1.0`
* Git `>= 2.32.0`
* Docker `20.10.7`
* Docker Compose `1.29.2`

> Docker Total Size (6 Images) 1.12 GB

### Add to hosts file:

```shell
127.0.0.1	api.local
127.0.0.1	mock.local
127.0.0.1	worker.local
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
docker-compose up -d --build
docker-compose exec api make setup
docker-compose exec mock make setup
docker-compose exec worker make setup
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
```

## Links

* [Documentation](https://resul.me/php-challenge/)
* [Mobile Application Subscription Managment API (Readme)](https://github.com/resultakak/php-challenge/tree/develop/src/api#readme)
* [Mock API (Readme)](https://github.com/resultakak/php-challenge/tree/develop/src/mock#readme)


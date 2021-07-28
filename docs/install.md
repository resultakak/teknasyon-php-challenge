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


---
### [Index](index)

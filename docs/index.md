Welcome
===

Mobile applications are able to make in-app-purchase purchases, verification and current subscription control using this API.

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6f0afcfa224d41a09047f7857af08e7e)](https://app.codacy.com/gh/resultakak/php-challenge?utm_source=github.com&utm_medium=referral&utm_content=resultakak/php-challenge&utm_campaign=Badge_Grade_Settings)

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

## Index

* [Mobile Application Subscription Managment API](api)
* [Mock API](mock)

## Postman Collections

* [Mobile Application Subscription Managment API (with Tests)](Rest_API.postman_collection.json)
* [Mock API (with Tests)](Mock_API.postman_collection.json)

## SQL Structure

* [SQL File](https://github.com/resultakak/php-challenge/blob/develop/sql/db.sql)

## Folder Structure

```
app
├── build
├── docs
├── logs
├── sql
├── src
│   └── api                     ── Phalcon
│   ├── mock                    ── Phalcon
│   └── worker                  ── Laravel
├── docker-compose.yml
├── example.env
├── install.sh
├── Makefile
├── README.md
└── setup.md                    
```


start:
	docker-compose up -d --build

stop:
	docker-compose down

restart:
	docker-compose down; docker-compose up --build --remove-orphans

setup: composer-install

composer-install: start
	docker-compose exec api composer install;
	docker-compose exec worker composer install;
	docker-compose exec mock composer install;

mysql:
	docker-compose exec db mysql -h 127.0.0.1 -u root -p

redis-monitor:
	docker-compose exec redis redis-cli monitor

api-bash:
	docker-compose exec api bash

remove: stop
	rm -rf ./build/mysql/data \
        ./build/mysql/docker \
        ./src/api/vendor \
        ./src/api/composer.lock \
        ./src/worker/vendor \
        ./src/worker/composer.lock


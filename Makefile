
setup:
	bash setup.sh

start:
	docker-compose up -d --build

stop:
	docker-compose down

restart:
	docker-compose down; docker-compose up --build --remove-orphans

logs:
	docker-compose logs -f

mysql:
	docker-compose exec db mysql -h 127.0.0.1 -u root -p

redis-monitor:
	docker-compose exec redis redis-cli monitor

api-bash:
	docker-compose exec api bash

mock-bash:
	docker-compose exec mock bash

remove: stop
	rm -rf ./build/mysql/data \
        ./build/mysql/docker \
        ./src/api/vendor \
        ./src/api/composer.lock \
        ./src/worker/vendor \
        ./src/worker/composer.lock

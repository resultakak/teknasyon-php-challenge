
start:
	docker-compose up

stop:
	docker-compose down

restart:
	docker-compose down; docker-compose up --build --remove-orphans

mysql:
	docker-compose exec db mysql -h 127.0.0.1 -u root -p

redis-monitor:
	docker-compose exec redis redis-cli monitor


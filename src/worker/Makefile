
setup: install migrate seed


install:
	composer install

prod-install:
	composer install --optimize-autoloader --no-dev

migrate:
	vendor/bin/phinx migrate

seed:
	vendor/bin/phinx seed:run

phinx-init:
	phinx init

upd-sec:
	composer update --dry-run roave/security-advisories

clean:
	rm -rf vendor && rm composer.lock

phpstan:
	vendor/bin/phpstan analyse src/ tests/ --level 7

phpcs:
	vendor/bin/phpcs --standard=PSR2 ./src

phpmd:
	vendor/bin/phpmd src/ text codesize,unusedcode,naming,cleancode

phpunit:
	vendor/bin/phpunit tests/

phpall: phpmd phpcs phpstan phpunit

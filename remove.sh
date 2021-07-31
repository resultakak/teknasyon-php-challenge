#!/bin/bash

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
rm -rf ./log/nginx/*.log
rm -rf ./build/mysql/data/

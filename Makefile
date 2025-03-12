start: docker-start

stop: docker-stop

install: composer-install


docker-build:
	docker build -t timetracker-server -f ./docker/nginx.Dockerfile .
	docker build -t timetracker-api -f ./docker/php.Dockerfile .
	docker build -t timetracker-app -f ./docker/php.Dockerfile .

docker-start:
	docker-compose up -d

docker-stop:
	docker-compose down


bash-backend:
	docker exec -it timetracker.api bash

bash-frontend:
	docker exec -it timetracker.app bash


cache-clear:
	docker exec -it timetracker.api composer run cache-clear


composer-install:
	docker exec -it timetracker.api composer install

composer-update:
	docker exec -it timetracker.api composer update


test-backend-static:
	docker exec -it timetracker.api composer run psalm-clean
	docker exec -it timetracker.api composer run phpstan-clean

test-backend-unit:
	docker exec -it timetracker.api composer run unit

test-backend: test-backend-static test-backend-unit

test: test-backend

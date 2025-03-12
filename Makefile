start: docker-start

stop: docker-stop

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

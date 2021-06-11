up: docker-up
down: docker-down
migrate: docker-migrate
fresh: docker-migrate-fresh
seed: docker-migrate-seed
restart: down up
test: api-test
setup: docker-app-setup

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

api-test:
	docker-compose run --rm app composer test

composer-install:
	docker-compose run --rm app composer install

docker-migrate:
	docker-compose run --rm app composer pa migrate

docker-migrate-seed:
	docker-compose run --rm app composer pa migrate
	docker-compose run --rm app composer pa db:seed

docker-migrate-fresh:
	docker-compose run --rm app composer pa migrate:fresh --seed

docker-app-setup:
	docker-compose run --rm app composer pa migrate:fresh
	docker-compose run --rm app composer pa db:seed
	docker-compose run --rm app composer pa key:generate
	docker-compose run --rm app composer pa storage:link

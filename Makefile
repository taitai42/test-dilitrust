#Makefile

all:
		docker run --rm -v $(shell pwd):/app composer install
		docker-compose up -d

migrations:
		docker-compose exec app php artisan migrate --seed --force


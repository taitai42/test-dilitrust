#Makefile

all:
		docker run --rm -v $(pwd):/app composer install
		docker-compose up -d
		docker-compose exec app php artisan migrate --seed --force


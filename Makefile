#Makefile

all:
		composer install
		cd laradock && docker-compose up -d nginx mysql phpmyadmin redis workspace
		docker exec -it laradock_workspace_1 php artisan config:clear && php artisan cache:clear && php artisan migrate --force --seed


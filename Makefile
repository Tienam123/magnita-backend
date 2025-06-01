APP_CONTAINER := magnita-new-app

# Run docker-compose
up:
	cd .docker && docker compose up -d

# Build docker-compose
build:
	cd .docker && docker compose up -d --build

# Stop docker-compose
down:
	cd .docker && docker compose up down

# Зайти в контейнер
shell:
	docker exec -it $(APP_CONTAINER) bash

# Artisan commands: make artisan migrate
.PHONY: artisan
artisan:
	docker exec -it $(APP_CONTAINER) php artisan $(filter-out $@,$(MAKECMDGOALS))

# Composer commands: make composer install
composer:
	docker exec -it $(APP_CONTAINER) composer $(filter-out $@,$(MAKECMDGOALS))

# PHP Unit tests
test:
	docker exec -it $(APP_CONTAINER) php artisan test

# Upgrade dependencies
update:
	docker exec -it $(APP_CONTAINER) composer update

# Clear cache
clear:
	docker exec -it $(APP_CONTAINER) php artisan config:clear && \
	docker exec -it $(APP_CONTAINER) php artisan cache:clear && \
	docker exec -it $(APP_CONTAINER) php artisan view:clear && \
	docker exec -it $(APP_CONTAINER) php artisan route:clear

# Перезапуск контейнера Laravel
restart:
	docker compose restart $(APP_CONTAINER)

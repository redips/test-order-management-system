.PHONY: help build up down restart logs shell composer-install db-migrate db-reset test lint lint-fix

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

build: ## Build Docker containers
	docker-compose build

up: ## Start Docker containers
	docker-compose up -d

down: ## Stop Docker containers
	docker-compose down

restart: ## Restart Docker containers
	docker-compose restart

logs: ## Show Docker logs
	docker-compose logs -f

shell: ## Access PHP container shell
	docker-compose exec php bash

composer-install: ## Install Composer dependencies
	docker-compose exec php composer install

db-migrate: ## Run database migrations
	docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

db-reset: ## Reset database with fixtures
	docker-compose exec php php bin/console doctrine:database:drop --force --if-exists
	docker-compose exec php php bin/console doctrine:database:create
	docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
	docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction

test: ## Run tests
	docker-compose exec php composer test

lint: ## Run code linter (dry-run)
	docker-compose exec php composer lint

lint-fix: ## Fix code style issues
	docker-compose exec php composer lint:fix

cache-clear: ## Clear Symfony cache
	docker-compose exec php php bin/console cache:clear

setup: build up composer-install db-migrate ## Complete setup (build, start, install, migrate)

setup-with-data: setup db-reset ## Complete setup with sample data

clean: ## Remove all containers and volumes
	docker-compose down -v

status: ## Show container status
	docker-compose ps

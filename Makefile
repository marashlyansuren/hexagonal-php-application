up:
	docker-compose up -d
stop:
	docker-compose stop
down:
	docker-compose down
install:
	docker exec -it hexagonal-php-app-container composer install --no-interaction
diff:
	docker exec -it hexagonal-php-app-container php ./bin/console doctrine:migrations:diff --no-interaction
migrate:
	docker exec -it hexagonal-php-app-container php ./bin/console doctrine:migrations:migrate --no-interaction
cache-clear:
	docker exec -it hexagonal-php-app-container php bin/console cache:clear
cache-warmup:
	docker exec -it hexagonal-php-app-container php bin/console cache:warmup
doc:
	docker run -p 8089:8080  -d -e SWAGGER_JSON=/api.yaml -v `pwd`/public/api.yaml:/api.yaml swaggerapi/swagger-ui
stan:
	docker exec -it hexagonal-php-app-container ./vendor/bin/phpstan analyse -l 8 src
phpcs:
	docker exec -it hexagonal-php-app-container ./vendor/bin/phpcs -n src -s
fix:
	docker exec -it hexagonal-php-app-container ./vendor/bin/phpcbf src
phpmd:
	docker exec -it hexagonal-php-app-container ./vendor/bin/phpmd ./src json cleancode, codesize, controversial, design, naming, unusedcode
test:
	docker exec -it hexagonal-php-app-container php vendor/bin/codecept run
coverage:
	docker exec -it hexagonal-php-app-container php -dxdebug.mode=coverage vendor/bin/codecept run --coverage
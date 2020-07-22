# nette-interview

# Build and ececute via docker-compose on dev enviroment
```bash
$ docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml build
$ docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml up
```
Webpage will be accessible via url http://127.0.0.1:8080/

# Database migrations (will be executed automatically on dev enviroment)
```bash
$ docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml exec php-fpm ./bin/console migrations:migrate --no-interaction
```
# Cron job for parsing data from external source (will be executed automatically on dev enviroment)
```bash
$ docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml exec php-fpm ./bin/console app:job:parse
```
# Php unit tests
```bash
$ docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml exec php-fpm composer phpunit
```
# phpstan
```bash
$ docker-compose -f docker-compose.yaml -f docker-compose.dev.yaml exec php-fpm composer phpstan
```

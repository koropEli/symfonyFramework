# Symfony Project 'Firmware Platformer'

## Instructions on How to Run the Application

- Run `docker compose build --no-cache` to build fresh images
- Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project

- Run `docker exec -it symfonyFramework-php-1 php bin/console doctrine:fixtures:load` to load fixtures 
- That run some request in Postman.

Login: `admin@cdv.com` and Password: `admin`

### To stop and delete the Docker containers
+ Run `docker compose stop` to stop Docker containers.
+ Run `docker compose up -d` to resume stopped containers.
+ Run `docker compose down --remove-orphans` to stop and delete the Docker containers.

## Description and Features


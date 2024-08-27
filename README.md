

## Installation Postgresql :

    sudo apt install postgresql
    sudo -i -u postgres
    
    psql
    CREATE ROLE <nom_utilisateur> LOGIN;
    ALTER ROLE <nom_utilisateur> CREATEDB;
    CREATE DATABASE <nom_base_de_donnee> OWNER <nom_utilisateur>;
    ALTER ROLE <nom_utilisateur> WITH ENCRYPTED PASSWORD 'mon_mot_de_passe';
    \q (pour quitter)

## Creation projet Laravel :

    composer create-project laravel/laravel Crafted-By_API

## Creation des tables :

    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=crafted_by
    DB_USERNAME=nicolas
    DB_PASSWORD=password

### Migration :

    php artisan migrate (+ :fresh pour raz)

### Seeding :

    php artisan db:seed --class=DatabaseSeeder

## Swagger :

    composer require zircote/swagger-php

Pour accéder à la documentation :

    http://localhost:8000/api/documentation#/

Puis, pour chaque route, ajouter les annotations aux méthodes telle que :

    /**
    * @OA\Get(
    *     path="/users",
    *     summary="Get a list of users",
    *     tags={"Users"},
    *     @OA\Response(response=200, description="Successful operation"),
    *     @OA\Response(response=400, description="Invalid request")
    * )
    */

# DOCKER

## Container Database

### RAW

On as besoin d'une image docker postgres : 

    docker pull postgres:latest

Ensuite on lance le container avec les bon arguments :

    docker run --name Crafted-By_DB -e POSTGRES_PASSWORD=password -e POSTGRES_USER=nicolas -p 5432:5432 -d postgres   

Creer la db pour le projet dans le container :

    docker exec -it Crafted-By_DB bash

(pour vérifier les container : 
    
    docker ps
)

    psql -h localhost -U nicolas

    CREATE DATABASE crafted_by

(pour vérifier la création de la db :

    \l

    :q
)

### docker-compose.yml

    db:
        container_name: crafted_by_db
        image: postgres:latest
        ports:
            - 5432:5432
        volumes:
            - ./Crafted-By_DB:/var/lib/postgresql
        environment:
            - POSTGRES_PASSWORD=password
            - POSTGRES_USER=nicolas
            - POSTGRES_DB=crafted_by

Pour finir, on peut lancer les migrations artisan puis les seeder.

## CONTAINER BACK-END + NGINX


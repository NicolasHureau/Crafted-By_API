

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

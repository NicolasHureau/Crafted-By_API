

installation Postgresql :

sudo apt install postgresql
sudo -i -u postgres

psql
CREATE ROLE <nom_utilisateur> LOGIN;
ALTER ROLE <nom_utilisateur> CREATEDB;
CREATE DATABASE <nom_base_de_donnee> OWNER <nom_utilisateur>;
ALTER ROLE <nom_utilisateur> WITH ENCRYPTED PASSWORD 'mon_mot_de_passe';
\q (pour quitter)

creation projet Laravel :

composer create-project laravel/laravel Crafted-By_API

creation des tables :

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crafted_by
DB_USERNAME=nicolas
DB_PASSWORD=password

php artisan migrate (+ :fresh pour raz)

php artisan db:seed --class=DatabaseSeeder





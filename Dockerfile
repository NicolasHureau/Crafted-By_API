FROM php:8.2-fpm

# Copier les fichiers de votre application dans le répertoire approprié
COPY --chown=www-data:www-data . /var/www/html/

# Installation de Nginx et Supervisor
RUN apt-get update && apt-get install -y nginx supervisor htop libpq-dev

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_pgsql pdo

# Installer les dépendances PHP
RUN composer install --optimize-autoloader

COPY supervisord.conf /etc/supervisor/conf.d/
COPY nginx.conf /etc/nginx/sites-available/default

# Exposer le port 80 (par défaut pour nginx)
EXPOSE 80

CMD ["/usr/bin/supervisord"]

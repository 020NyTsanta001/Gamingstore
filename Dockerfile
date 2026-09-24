
# ---- Étape 1 : build des assets front avec Vite ----
FROM node:20-alpine AS node-build
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- Étape 2 : image finale PHP + Nginx + PHP-FPM ----
FROM richarvey/nginx-php-fpm:php82

# Variables Laravel utiles à l'image (voir doc de l'image de base)
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Copie du code source
COPY . /var/www/html

# Copie des assets déjà compilés (build/) depuis l'étape node
COPY --from=node-build /app/public/build /var/www/html/public/build

WORKDIR /var/www/html

# Installation des dépendances PHP en production
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Permissions Laravel classiques
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Render fournit un $PORT dynamique, l'image richarvey l'écoute automatiquement
EXPOSE 80

# Script de démarrage : migrations puis lancement nginx+php-fpm (géré par l'image de base)
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force --isolated; /start.sh

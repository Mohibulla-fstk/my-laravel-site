# Stage 1: Frontend Build (Vite)
FROM node:18 AS frontend

WORKDIR /app

# Copy package.json and install dependencies
COPY package*.json ./
RUN npm install

# Copy app source code
COPY . .

# Copy .env if you need environment variables for Vite
COPY .env .env

# Build frontend
RUN npm run build

# Stage 2: Backend (Laravel + PHP + Composer)
FROM php:8.2-fpm

# Install system dependencies & Postgres driver
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy Laravel app code
COPY . .

# Copy built frontend from Stage 1
COPY --from=frontend /app/public/dist ./public/dist

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel cache clear
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

EXPOSE 9000

CMD ["php-fpm"]

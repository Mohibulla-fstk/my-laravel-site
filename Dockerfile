# Base PHP FPM image
FROM php:8.2-fpm

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    npm \
    nodejs \
    default-mysql-client \
    && apt-get clean

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pdo mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate APP key
RUN php artisan key:generate

# Install Node dependencies & build assets
RUN npm install && npm run build

# Expose port
EXPOSE 8000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000

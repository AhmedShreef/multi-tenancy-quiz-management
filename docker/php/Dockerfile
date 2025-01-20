# Use a PHP 8.1 FPM
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    supervisor \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Copy Laravel project files to the container
COPY . /var/www/

# Set the working directory to the Laravel project root
WORKDIR /var/www

# Copy the .env.example to .env
RUN cp .env.example .env

# Copy the .env.example to .env
RUN rm composer.lock

# Install Composer and dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev

# Set permissions for Laravel storage directory
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy Supervisor configuration
COPY docker/supervisor/queue-worker.conf /etc/supervisor/conf.d/

CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]

# Base Image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    supervisor \
    && pecl install redis \
    && docker-php-ext-install pdo_mysql zip gd opcache \
    && docker-php-ext-enable opcache redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js & NPM
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copy Laravel project
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

#COPY ./docker/supervisor /etc/supervisor/conf.d/


# Expose port
EXPOSE 8082


#CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]


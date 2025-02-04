# Laravel için PHP 8.2 resmi imajını kullanıyoruz
FROM php:8.2-fpm

# Node.js 18.x ve temel bağımlılıklar
RUN apt-get update && apt-get install -y \
    curl \
    gnupg \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# PHP extension'ları ve diğer bağımlılıklar
RUN apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer kurulumu
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Çalışma dizini
WORKDIR /var/www

# Sadece gerekli dosyaları kopyala
COPY package*.json .
COPY composer.json composer.lock ./
COPY database/ database/
COPY resources/ resources/
COPY routes/ routes/
COPY app/ app/
COPY config/ config/
COPY public/ public/

# Gerekli izinler
RUN chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 storage bootstrap/cache

# Bağımlılıkları kur
RUN composer install --no-interaction --optimize-autoloader \
    && npm install && npm run build

# Gerekli dizinleri oluşturma
RUN mkdir -p /var/www/storage/app/private/scribe

# Start of Selection
RUN set -x && \
    echo "Dosya izinleri ayarlanıyor..." && \
    chown -R www-data:www-data /var/www && \
    echo "chown komutu tamamlandı" && \
    find /var/www -type d -exec chmod 775 {} \; && \
    echo "Dizin izinleri ayarlandı" && \
    find /var/www -type f -exec chmod 664 {} \; && \
    echo "Dosya izinleri ayarlandı" && \
    chmod -R 775 /var/www/storage && \
    echo "Storage izinleri ayarlandı" && \
    chmod -R 775 /var/www/bootstrap/cache && \
    echo "Cache izinleri ayarlandı" && \
    chmod -R 775 /var/www/storage/framework/views && \
    echo "Views izinleri ayarlandı" && \
    chmod -R 775 /var/www/public && \
    echo "Public dizin izinleri ayarlandı"
# Laravel uygulamasını başlatma ve loglama


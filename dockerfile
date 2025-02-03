# Laravel için PHP 8.2 resmi imajını kullanıyoruz
FROM php:8.2-fpm


# Çalışma dizinini belirleyelim
WORKDIR /var/www

# Gerekli bağımlılıkları yükleyelim
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    cron \
    ntp \
    && service cron start && \
    ntpd -gq && \
    ntpd && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd 
# Composer'ı yükleyelim
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel proje dosyalarını kopyalayalım
COPY . .


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


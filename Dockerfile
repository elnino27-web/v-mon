FROM php:8.2-apache

# Menginstal dependensi sistem
RUN apt-get update && apt-get install -y git zip unzip libzip-dev && docker-php-ext-install zip pdo pdo_mysql

# Mengaktifkan mod_rewrite Apache (wajib untuk Laravel)
RUN a2enmod rewrite

# Mengubah arah root dokumen server ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Menginstal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Menyalin seluruh kode proyek Anda
COPY . /var/www/html

# Mengunduh paket Laravel
RUN composer install --no-dev --optimize-autoloader

# Memberi izin tulis pada folder penting
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

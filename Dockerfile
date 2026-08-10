FROM php:8.2-apache

# Install ekstensi PostgreSQL untuk PHP
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Mengaktifkan mod_rewrite Apache (berguna untuk routing)
RUN a2enmod rewrite

# Salin semua file proyek ke dalam folder server Apache
COPY . /var/www/html/

# Expose port 80
EXPOSE 80

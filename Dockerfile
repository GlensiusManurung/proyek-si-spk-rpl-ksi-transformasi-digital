FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install gd pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Install Node & build Vite assets
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install && \
    npm run build

# Verifikasi manifest Vite terbuat
RUN ls public/build/ && cat public/build/.vite/manifest.json | head -30

# Laravel permission setup (JANGAN key:generate di sini)
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Jalankan semua saat container start, pakai Railway env vars
CMD php artisan key:generate --force && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan storage:link 2>/dev/null || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}

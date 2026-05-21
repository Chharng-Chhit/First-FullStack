# ============================================================
# Stage 1 – Composer dependencies
# ============================================================
FROM composer:2.8 AS composer-build

WORKDIR /app

# Copy only the manifest files first for better layer caching
COPY composer.json composer.lock ./

# Install production dependencies (no dev packages)
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

# Copy application source & generate the optimised autoloader
COPY . .
RUN composer dump-autoload --optimize --no-dev


# ============================================================
# Stage 2 – Node / Vite build
# ============================================================
FROM node:20-alpine AS node-build

WORKDIR /app

COPY package*.json ./
RUN npm ci --ignore-scripts

# Copy source needed for Vite
COPY . .
RUN npm run build


# ============================================================
# Stage 3 – Final PHP-FPM image
# ============================================================
FROM php:8.4-fpm-alpine AS production

# LABEL maintainer="Your Name <you@example.com>"
# LABEL description="Laravel 13 API – PHP 8.4 FPM"

# ── System dependencies ──────────────────────────────────────
RUN apk add --no-cache \
    bash \
    curl \
    git \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    mysql-client \
    nginx \
    supervisor

# ── PHP extensions ───────────────────────────────────────────
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    opcache

# ── PHP production settings ──────────────────────────────────
COPY docker/php/php.ini         /usr/local/etc/php/conf.d/custom.ini
COPY docker/php/opcache.ini     /usr/local/etc/php/conf.d/opcache.ini

# ── Nginx config ─────────────────────────────────────────────
COPY docker/nginx/default.conf  /etc/nginx/http.d/default.conf

# ── Supervisor config ────────────────────────────────────────
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# ── Application ───────────────────────────────────────────────
WORKDIR /var/www/html

# Copy vendor from composer stage
COPY --from=composer-build /app/vendor ./vendor

# Copy compiled front-end assets from node stage
COPY --from=node-build /app/public ./public

# Copy the rest of the application
COPY . .

# ── Permissions ───────────────────────────────────────────────
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ── Entrypoint ────────────────────────────────────────────────
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

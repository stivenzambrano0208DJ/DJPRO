# =============================================================================
# DJPRO Platform - Production Dockerfile
# Custom PHP 8.x MVC app served by Apache + mod_rewrite (DocumentRoot = public/)
# Single-stage: the project has no build step (no composer / npm), PHPMailer is
# vendored in app/PHPMailer, so a multi-stage build would add no value here.
# =============================================================================
FROM php:8.2-apache

# --- System deps + PHP extensions (production only, cleaned afterwards) -------
# Required by the app:
# - pdo_mysql: database layer uses PDO with MySQL/MariaDB.
# - mbstring + intl: PHPMailer handles UTF-8 addresses/names better with them.
# PHP's json, session, openssl, fileinfo and filter extensions are bundled in
# this official image and remain enabled by default.
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        libicu-dev \
        libonig-dev \
        ca-certificates; \
    docker-php-ext-install -j"$(nproc)" \
        intl \
        mbstring \
        pdo_mysql; \
    a2enmod rewrite; \
    rm -rf /var/lib/apt/lists/*

# --- Production PHP configuration --------------------------------------------
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# --- Apache: DocumentRoot -> public/, non-privileged port, non-root friendly --
# Listen on 8080 (unprivileged) and send logs to stdout/stderr so the whole
# server can run as the www-data user. Dokploy's reverse proxy routes to 8080.
RUN set -eux; \
    sed -i 's!Listen 80!Listen 8080!' /etc/apache2/ports.conf; \
    printf '%s\n' \
      'ServerName localhost' \
      'PidFile /tmp/apache2.pid' \
      '<VirtualHost *:8080>' \
      '    DocumentRoot /var/www/html/public' \
      '    <Directory /var/www/html/public>' \
      '        Options -Indexes +FollowSymLinks' \
      '        AllowOverride All' \
      '        Require all granted' \
      '    </Directory>' \
      '    ErrorLog /dev/stderr' \
      '    CustomLog /dev/stdout combined' \
      '</VirtualHost>' \
      > /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# --- Application code (only what production needs; see .dockerignore) ---------
COPY --chown=www-data:www-data app/ ./app/
COPY --chown=www-data:www-data config/ ./config/
COPY --chown=www-data:www-data public/ ./public/

# --- Writable runtime dirs ----------------------------------------------------
# logs is used by config/database.php and uploads is used by app/Controllers/Djs.php.
RUN set -eux; \
    mkdir -p \
        /var/www/html/logs \
        /var/www/html/public/assets/uploads \
        /var/run/apache2 \
        /var/lock/apache2 \
        /var/log/apache2; \
    chown -R www-data:www-data \
        /var/www/html/logs \
        /var/www/html/public/assets/uploads \
        /var/run/apache2 \
        /var/lock/apache2 \
        /var/log/apache2

# --- Drop privileges ---------------------------------------------------------
USER www-data

EXPOSE 8080

CMD ["apache2-foreground"]

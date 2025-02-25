FROM php:8.2-apache

# Set working directory to the repository root
WORKDIR /var/www/html

# Install dependencies for PostgreSQL extension, zip/unzip (needed for Composer), and enable pgsql
RUN apt-get update && apt-get install -y libpq-dev zip unzip \
    && docker-php-ext-install pgsql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the entire repository into the container
COPY . .

# Explicitly copy chat_ai_hf.php from the includes folder to the document root
RUN if [ -f /var/www/html/includes/chat_ai_hf.php ]; then cp /var/www/html/includes/chat_ai_hf.php /var/www/html/chat_ai_hf.php; fi

# Run Composer install to generate the vendor directory
RUN composer install --no-dev --prefer-dist

EXPOSE 80

CMD ["apache2-foreground"]

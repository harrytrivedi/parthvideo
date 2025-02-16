FROM php:8.2-apache

# Set working directory to the repository root
WORKDIR /var/www/html

# Install dependencies for PostgreSQL extension and enable it
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql

# Copy the entire repository into the container (including .htaccess)
COPY . .

EXPOSE 80

CMD ["apache2-foreground"]

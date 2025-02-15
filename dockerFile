FROM php:8.2-apache

# Set the working directory
WORKDIR /var/www/html

# Copy composer files and install dependencies (if applicable)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist

# Copy the rest of the application code
COPY . .

EXPOSE 80

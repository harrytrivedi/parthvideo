FROM php:8.2-apache

# Set the working directory
WORKDIR /var/www/html

# Copy the rest of the application code
COPY . .

EXPOSE 80

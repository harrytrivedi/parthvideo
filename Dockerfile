FROM php:8.2-apache

# Set working directory to the repository root
WORKDIR /var/www/html

# Copy the entire repository into the container (including .htaccess)
COPY . .

EXPOSE 80

CMD ["apache2-foreground"]

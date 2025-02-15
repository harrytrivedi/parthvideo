FROM php:8.2-apache

# Set the working directory to Apache's document root
WORKDIR /var/www/html

# Copy only the contents of the "user" folder into the document root
COPY user/ .

# Expose port 80
EXPOSE 80

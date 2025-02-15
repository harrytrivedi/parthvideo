FROM php:8.2-apache

# Set the working directory to Apache's document root.
WORKDIR /var/www/html

# Copy the entire repository into the container.
COPY . .

# Copy the contents of the "user" directory (including index.php) into the document root.
# This ensures that index.php is at /var/www/html/index.php.
RUN cp -r user/* .

# Expose port 80.
EXPOSE 80

FROM php:8.2-apache

# Set working directory to the repository root
WORKDIR /var/www/html

# Copy the entire repository into the container
COPY . .

# Configure Apache to use user/index.php as the default index page
RUN echo "DirectoryIndex user/index.php" > /etc/apache2/conf-available/custom-index.conf \
    && a2enconf custom-index \
    && service apache2 reload

EXPOSE 80

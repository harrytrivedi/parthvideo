FROM php:8.2-apache

# Set the working directory to the repository root
WORKDIR /var/www/html

# Copy the entire repository into the container
COPY . .

# Create a custom Apache configuration to use user/index.php as the DirectoryIndex,
# then enable that configuration.
RUN echo "DirectoryIndex user/index.php" > /etc/apache2/conf-available/custom-index.conf \
    && a2enconf custom-index

EXPOSE 80

CMD ["apache2-foreground"]

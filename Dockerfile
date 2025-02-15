FROM php:8.2-apache

# Set working directory to the repository root
WORKDIR /var/www/html

# Copy the entire repository into the container
COPY . .

# Update Apache's default site configuration to set DocumentRoot to /var/www/html/user
RUN sed -ri 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/user#g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]

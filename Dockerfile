FROM php:8.2-apache

WORKDIR /var/www/html

# Copy the entire repository
COPY . .

# Update Apache's DocumentRoot to /var/www/html/user
RUN sed -ri 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/user#g' /etc/apache2/sites-available/000-default.conf

# Create an Apache alias configuration file using a heredoc
RUN cat <<'EOF' > /etc/apache2/conf-available/extra-alias.conf
Alias /css /var/www/html/css
<Directory "/var/www/html/css">
    Options Indexes FollowSymLinks
    AllowOverride None
    Require all granted
</Directory>

Alias /js /var/www/html/js
<Directory "/var/www/html/js">
    Options Indexes FollowSymLinks
    AllowOverride None
    Require all granted
</Directory>
EOF

# Enable the alias configuration
RUN a2enconf extra-alias

EXPOSE 80

CMD ["apache2-foreground"]

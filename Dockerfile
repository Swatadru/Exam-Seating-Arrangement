# Use official PHP image with Apache
FROM php:8.1-apache

# Install Extensions (pdo_sqlite for the portable architecture)
RUN apt-get update && apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite \
    && docker-php-ext-enable pdo_sqlite

# Update ports.conf to handle custom PORT if provided by Render
# (Though Render defaults to 80 for Docker, this is good practice)
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf

# Set environment variable for port (default to 80)
ENV PORT=80

# Copy project files to Apache web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Fix permissions for the web server
RUN chown -R www-data:www-data /var/www/html/ && chmod -R 755 /var/www/html/

# Expose port (Render dynamic port)
EXPOSE 80


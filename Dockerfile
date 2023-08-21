# Use the official PHP image as the base image
FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev

# Install Composer (PHP package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the Laravel application files to the container
COPY . /var/www/html

# Install Laravel dependencies
RUN composer install

# Expose the port that the Laravel development server will listen on
EXPOSE 8000

# Start the Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

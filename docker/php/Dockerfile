FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

RUN apt-get update -y

# Install system dependencies
RUN apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-configure zip

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd simplexml xml

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Get NodeJs 16
RUN curl -sL https://deb.nodesource.com/setup_16.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install -y nodejs
RUN rm nodesource_setup.sh

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user

# Set working directory
WORKDIR /var/www/html

USER $user

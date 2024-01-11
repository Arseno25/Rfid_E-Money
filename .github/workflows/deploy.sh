#!/bin/sh

# Change to the project directory. 
cd ~/dashboard-rfid

# Pull the latest changes from the git repository
git pull origin development

# Install/update composer dependencies
composer install --no-interaction

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear

# Clear and cache routes
php artisan route:cache

# Clear and cache config
php artisan config:cache

# Clear and cache views
php artisan view:cache
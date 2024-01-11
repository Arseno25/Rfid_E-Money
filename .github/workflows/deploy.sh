#!/bin/sh

# Change to the project directory. 
cd ~/dashboard-rfid

# Pull the latest changes from the git repository
git pull origin development

# Install/update composer dependencies
composer install 

# Run database migrations
php artisan migrate

# Optimize
php artisan optimize:clear
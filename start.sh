#!/bin/bash
echo "Checking if application key has been generated..."
if [ ! -f "app/config/app.key" ]; then php artisan key:generate; fi
echo "Application key has been generated."
php artisan migrate
echo "Checking if storage symbolic link has been created..."
if [ ! -d "public/storage" ]; then php artisan storage:link; fi
echo "Storage symbolic link has been created."
echo "Checking if seed data has been populated..."
if [ ! -f "database/seeds/DatabaseSeeder.php" ]; then php artisan db:seed; fi
echo "Seed data has been populated."

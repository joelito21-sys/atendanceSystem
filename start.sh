#!/bin/bash
set -e

# Run Laravel setup on every container start
php artisan config:clear
php artisan migrate --force
php artisan storage:link --force || true
php artisan optimize

# Start Apache
exec apache2-foreground

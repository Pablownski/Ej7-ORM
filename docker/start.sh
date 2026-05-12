#!/bin/bash
set -e

echo "==> Preparing environment..."
cp -n .env.example .env 2>/dev/null || true

echo "==> Generating application key..."
php artisan key:generate --force

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Seeding database (this may take a few minutes for 10k+ records)..."
php artisan db:seed --force

echo "==> Starting Laravel development server..."
exec php artisan serve --host=0.0.0.0 --port=8000
